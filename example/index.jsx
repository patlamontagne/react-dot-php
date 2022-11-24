import { createRoot } from 'react-dom/client';
import { createPhpReact } from '../js/phpReact';

createPhpReact({
    resolve: (name) => import(`./components/${name}.jsx`),
    setup({ el, Component, props }) {
        const root = createRoot(el);
        root.render(<Component {...props} />);
    },
});
