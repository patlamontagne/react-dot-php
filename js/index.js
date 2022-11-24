import { createRoot } from 'react-dom/client';
import { createPhpReact } from './phpReact';

createPhpReact({
    resolve: (name) => require(`./components/${name}`),
    setup({ el, Component, props }) {
        const root = createRoot(el);
        root.render(<Component {...props} />);
    },
});
