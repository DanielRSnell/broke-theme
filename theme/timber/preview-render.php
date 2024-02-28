<?php

/*
 * Hero Layout Render Template.
 *
 * @array   $layout      Layout settings (without values)
 * @array   $field       Flexible content field settings
 * @bool    $is_preview  True in Administration
 */

global $post;

$context = [];

// Core Preview Context
$context['ID'] = $post->ID;
$context['type'] = $post->post_type;
$context['guid'] = $post->guid;

$group = $field['name'];
$name = $layout['name'];
// Fetch all ACF fields for the current post
$all_fields = get_fields();

// Check if the group (Flexible Content field) exists and is not empty
if (isset($all_fields[$group]) && !empty($all_fields[$group])) {
    // Loop through each layout in the Flexible Content field
    foreach ($all_fields[$group] as $layout) {
        // Check if this layout's name matches the target layout name
        if ($layout['acf_fc_layout'] === $name) {
            // Set this layout to the 'layout' context
            $context['layout'] = $layout;
            break; // Stop the loop after finding the matching layout
        }
    }
}

// If no matching layout is found, you might want to handle that case here (e.g., setting a default value or handling an error)

// Get ACF Fields
// $context['post'] = Timber::get_post($post->ID); // Fetch the current post
$context['group'] = $group; // Assuming $group is defined earlier
$context['name'] = $name; // Assuming $name is defined earlier
$context['file'] = $file; // Assuming $file is defined earlier
$context['is_preview'] = $is_preview; // Assuming $is_preview is defined earlier
$context['debug'] = get_field('debug', $post->ID); // Fetch the custom field value

// Since you're attempting to use `$context` within itself, this might not work as expected.
// If you meant to keep a reference of the entire context, consider cloning or otherwise managing state outside this assignment.
$context['state'] = $context; // This line might need revision based on your intent.

// Check if 'debug' field is not false
if ($context['debug']) {
    // 'debug' field is true or has a value, render the Twig template
    Timber::render('@helper/prism.html', $context);
} else {
    // 'debug' field is false, echo the message
    Timber::render('@component/preview-render.twig', $context);
}
