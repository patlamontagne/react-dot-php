<?php

require './vendor/autoload.php';

use Patlamontagne\PhpReact\React;

React::share([
    'cat' => 'chibi',
    'dog' => 'katina',
]);

React::share('food', 'pizza');

React::render('MyComponent', ['foo' => 'bar']);
