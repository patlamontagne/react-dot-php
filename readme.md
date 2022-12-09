# PHP adapter for React-dot

Dots are separated backend driven React components.

What does it mean? It means you can add multiple single react components on your front-end and send them initial props right from your backend.

`react-dot` is intended for projects where you can't leverage inertiajs' SPA approach, or for existing server-side rendered projects where you just need to easily add some react interactivity without resorting to rebuilding the whole thing in react.

### Javascript library

Use the JS library on your front-end to dynamically render dot components.
https://github.com/patlamontagne/react-dot

## Installing

```sh
composer require patlamontagne/react-dot-php
```

## Rendering a dot 

Each `Dot::render` will generate distinct react root that the JS library will use to initialize your components.

```php
use ReactDot\Dot;

// will echo the component directly
Dot::render('Layout/NavigationBar', ['mode' => 'dark']);

// accepts functions
Dot::render('Layout/NavigationBar', [
    'mode' => 'dark',
    // lazy
    'auth' => function() {
        if ($user = user()) {
            return [
                'user' => $user,
            ];
        }
    },
]);

// get the resulting string
echo Dot::build('Layout/NavigationBar', ['mode' => 'dark']);
```

## Share props to all dots

Shared props will be sent to all dot components on the page.

```php
// share a key/value prop
Dot::share('mode', 'dark');

// also accepts functions...
Dot::share('auth', function() {
    if ($user = user()) {
        return [
            'user' => $user,
        ];
    }
});

// ...and arrays
Dot::share([
    'title' => 'Welcome',
    // lazy
    'auth' => function() {
        if ($user = user()) {
            return [
                'user' => $user,
            ];
        }
    },
]);

```
