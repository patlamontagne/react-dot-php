<?php

require '../vendor/autoload.php';

use Patlamontagne\PhpReact\React;

React::share([
    'cat' => 'Chibi',
    'dog' => 'Katina',
]);

React::share('food', 'pizza');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="./dist/assets/index.6ab0872e.js"></script>
    <title>PHP REACT DEMO</title>
</head>

<body>
    <?php
        React::render('Introduction', ['title' => 'About me']);
        $secondComponent = React::build('Introduction', ['title' => 'It\'s still me']);
    ?>

    <?=$secondComponent?>
</body>

</html>