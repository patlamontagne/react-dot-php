# React Dot

## Render a component

```php
// will echo the component directly
Dot::render('NavigationBar', ['title' => 'Welcome']);

// accepts functions
Dot::render('NavigationBar', [
    'title' => 'Welcome',
    'user' =>  function() {
        return get_user();
    },
]);

// get the resulting string
echo Dot::build('NavigationBar', ['title' => 'Welcome']);
```

## Share props globally

```php
// share a key/value prop
Dot::share('user', get_user());

// also accepts functions...
Dot::share('user', function() {
    return get_user();
});

// ...and arrays
Dot::share([
    'title' => 'Welcome',
    'user' => function() {
        return get_user();
    },
]);

```
