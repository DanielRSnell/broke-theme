<?php 

function get_post_content_by_slug($slug, $context = null) {
    // Set up the arguments for the WP_Query
    $args = array(
        'name'        => $slug,
        'post_type'   => 'component',
        'post_status' => 'publish',
        'numberposts' => 1
    );

    // Fetch the post using the arguments
    $posts = get_posts($args);

    // Check if a post was found
    if($posts) {
        // Assuming we always get one post due to 'numberposts' => 1
        $post = array_shift($posts);

        // Apply the content filters to render the content properly
        $content_rendered = do_blocks($post->post_content);
        
        // If context is passed, render the content with it
        if ($context !== null && class_exists('Timber')) {
            $content_rendered = Timber::compile_string($content_rendered, $context);
        }

        // Return the rendered content
        return $content_rendered;
    } else {
        // Return a message or false if no post was found
        return false;
    }
}


add_filter('timber/twig/functions', function ($functions) {
    // Add the custom function
    $functions['renderBlock'] = [
        'callable' => 'get_post_content_by_slug',
    ];
    return $functions;
});