<?php 

function get_params_object() {
    // Merge GET and POST parameters
    $requestParams = array_merge($_GET, $_POST);

    $attributes = [];
    foreach ($requestParams as $key => $value) {
        // If the parameter is not 'email', keep it as is
        $attributes[$key] = sanitize_text_field($value);
    }

    return $attributes;
}

add_filter('timber/context', function ($context) {
    $context['params'] = get_params_object();
    return $context;
});