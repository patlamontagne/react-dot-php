import { createElement } from 'react';

export function DynamicComponent({
    children,
    initialData,
    initialComponent,
}) {
    if (!initialData.component || initialData.component === '') {
        throw new Error('Missing component name');
    }

    const current = {
        component: initialComponent,
        props: initialData.props,
        children: () => <div dangerouslySetInnerHTML={{ __html: children }} />,
        key: Date.now(),
    };

    const renderChildren = ({ Component, key, childrenProps = {} }) => {
        const child = createElement(Component, { key, ...childrenProps });

        if (typeof Component.layout === 'function') {
            return Component.layout(child);
        }

        if (Array.isArray(Component.layout)) {
            return Component.layout
                .concat(child)
                .reverse()
                .reduce((c, Layout) => createElement(Layout, { children: c }));
        }

        return child;
    };

    const Component = createElement(
        current.component,
        current.props,
        renderChildren({ Component: current.children, key: current.key })
    );

    return Component;
}
