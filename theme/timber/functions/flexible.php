<?php 

add_filter('timber/twig/functions', function ($functions) {
    // Add the custom function
    $functions['component_exist'] = [
        'callable' => 'has_flexible',
    ];

    $functions['component'] = [
        'callable' => 'the_flexible',
    ];
    return $functions;
});