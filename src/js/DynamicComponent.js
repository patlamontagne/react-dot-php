import { createElement } from 'react';
import { createRoot } from 'react-dom/client';

function DynamicComponent(iprops) {
    const { initialValues, initialChildren, resolveComponent } = iprops;

    if (!initialValues.component || initialValues.component === '') {
        throw new Error('Missing component name');
    }

    const current = {
        component: resolveComponent(initialValues.component),
        props: initialValues.props,
        children: () => <div dangerouslySetInnerHTML={{ __html: initialChildren }} />,
        key: Date.now(),
    };

    const renderChildren = ({ Component, props, key }) => {
        const child = createElement(Component, { key, ...props });

        if (typeof Component.layout === 'function') {
            return Component.layout(child);
        }

        if (Array.isArray(Component.layout)) {
            return Component.layout
                .concat(child)
                .reverse()
                .reduce((children, Layout) => createElement(Layout, { children }));
        }

        return child;
    };

    const Component = createElement(
        current.component,
        current.props,
        renderChildren({ Component: current.children, key: current.key }),
    );

    return Component;
}

/**
 * Renders the dynamic components
 */
export const render = () => {
    const elements = [
        ...document.querySelectorAll('.react-component:not(.react-component--rendered)'),
    ];

    const dynamicRender = (element) => {
        const initialValues = JSON.parse(element.dataset.component);
        element.classList.add('react-component--rendered');
        delete element.dataset.component; // clean up markup

        return createRoot(element).render(
            <DynamicComponent
                initialValues={initialValues}
                initialChildren={element.innerHTML}
                resolveComponent={(name) => require(`../components/${name}`).default}
            />,
        );
    };

    elements.map(dynamicRender);
};

