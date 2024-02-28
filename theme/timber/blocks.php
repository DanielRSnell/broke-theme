<?php

function acf_block_render_callback($block, $content, $is_preview = false)
{
    $context = Timber::context();
    $context['post'] = Timber::get_post();
    $context['block'] = $block;
    $context['is_preview'] = $is_preview;
    $context['fields'] = get_fields();
    $context['state'] = $context; // Deubgging
    $template = $block['path'] . '/index.html';

    Timber::render($template, $context);
}

// Remove ACF block wrapper div
function acf_should_wrap_innerblocks($wrap, $name)
{
    // if ( $name == 'acf/test-block' ) {
    //     return true;
    // }
    return false;
}

add_filter('acf/blocks/wrap_frontend_innerblocks', 'acf_should_wrap_innerblocks', 10, 2);

add_filter('block_categories_all', function ($categories, $post) {
    // Adjust the path according to your theme structure if needed
    $categories_json_path = get_stylesheet_directory() . '/blocks/categories.json';

    // Check if the categories.json file exists
    if (file_exists($categories_json_path)) {
        // Get the contents of the JSON file
        $json_content = file_get_contents($categories_json_path);
        // Decode the JSON content to an associative array
        $json_categories = json_decode($json_content, true);

        if (is_array($json_categories)) {
            // Loop through each category in the JSON file and add it to the existing categories
            foreach ($json_categories as $cat) {
                // Ensure the category doesn't already exist to avoid duplicates
                if (!in_array($cat['slug'], array_column($categories, 'slug'))) {
                    $categories[] = array(
                        'title' => $cat['title'],
                        'slug' => $cat['slug'],
                        'icon' => isset($cat['icon']) ? $cat['icon'] : '', // Optional: Include an 'icon' key in your JSON if you want icons
                        'description' => $cat['description'],
                    );
                }
            }
        }
    }

    return $categories;
}, 10, 2);

add_action('rest_api_init', function () {
    register_rest_route('broke/v1', '/block-categories/', array(
        'methods' => 'GET',
        'callback' => 'get_registered_block_categories',
        'permission_callback' => '__return_true', // Make this endpoint publicly accessible
    ));
});

function get_registered_block_categories($request)
{
    // For WordPress 5.8 and above, ensure we provide a context
    // Directly passing a new WP_Block_Editor_Context() for simplicity
    if (function_exists('get_block_categories')) {
        // Assuming $post is not readily available; modify as needed for your use case
        $post = null; // Placeholder, adjust based on actual requirements

        // Manually creating a context if needed; adjust based on your specific needs
        $context = new WP_Block_Editor_Context();
        if (isset($post)) {
            $context->post = $post;
        }

        $block_categories = get_block_categories($context);
    } else {
        // Fallback or alternative method for older versions or other contexts
        $block_categories = [];
    }

    return new WP_REST_Response($block_categories, 200);
}
