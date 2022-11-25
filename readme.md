# PHP adaptor for React-dot

# Rendering a dot 

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

# Share props to all dots

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
