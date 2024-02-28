<?php

// Path: theme/timber/locations.php
add_filter('timber/locations', function ($paths) {
    $theme_directory = get_stylesheet_directory();

    // Assigning each path to its respective key
    $paths['helper'] = [$theme_directory . '/helpers'];
    $paths['admin'] = [$theme_directory . '/admin'];

    return $paths;
});
