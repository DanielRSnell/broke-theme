<?php

function get_breakpoint($breakpoint) {
    // Define the breakpoints and their corresponding pixel values
    $breakpoints = [
        'xs' => '320px', // Example value, Tailwind CSS is mobile-first so 'xs' is not officially defined
        'sm' => '640px',
        'md' => '768px',
        'lg' => '1024px',
        'xl' => '1280px',
        '2xl' => '1536px',
    ];

    // Check if the breakpoint exists in the array, return the value or default to 'device-width'
    return isset($breakpoints[$breakpoint]) ? $breakpoints[$breakpoint] : 'device-width';
}

add_filter('timber/twig/functions', function ($functions) {
    // Add the custom function to be available in Twig templates
    $functions['breakpoint'] = [
        'name' => 'get_breakpoint',
        'callable' => 'get_breakpoint',
    ];

    return $functions;
});