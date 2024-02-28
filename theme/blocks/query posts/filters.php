<?php

add_filter('acf/load_field/name=post_type', 'populate_post_types');

function populate_post_types($field)
{
    // Get all public post types
    $post_types = get_post_types(['public' => true], 'objects');

    // Initialize an array to store our choices
    $choices = [];

    // Loop through the post types and add them as choices
    foreach ($post_types as $post_type) {
        // Use the post type name as the key and label as the choice value
        $choices[$post_type->name] = $post_type->labels->singular_name;
    }

    // Assign the dynamically generated choices to the field
    $field['choices'] = $choices;

    // Return the modified field
    return $field;
}
