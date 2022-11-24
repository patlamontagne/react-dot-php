import { DynamicComponent } from './DynamicComponent';

export async function createPhpReact({
    className = 'react-component',
    resolve,
    setup,
}) {
    async function injectComponentToElement(el) {
        const initialData = JSON.parse(el.dataset.react);
        const resolveComponent = (name) => Promise.resolve(resolve(name)).then((module) => module.default || module);

        // clean up markup
        el.classList.add(`${className}--rendered`);
        delete el.dataset.react;

        const reactComponent = await resolveComponent(initialData.component).then((initialComponent) => {
            return setup({
                el,
                Component: DynamicComponent,
                props: {
                    initialData,
                    initialComponent,
                    children: el.innerHTML,
                    resolveComponent,
                },
            });
        });

        return reactComponent;
    }

    const elements = [
        ...document.querySelectorAll(
            `.${className}:not(.${className}--rendered)`
        ),
    ];

    return elements.map((el) => injectComponentToElement(el));
}
