<?php 

add_action('template_redirect', 'custom_dynamic_template_redirect');

function custom_dynamic_template_redirect() {
    // Check if the 'component' query parameter is set
    if (isset($_GET['component']) && !empty($_GET['component'])) {
        // Prepare the Timber context
        $context = Timber::context();
        
       // Handling for singular pages (single posts, pages, custom post types)
        if (is_singular()) {
            global $post;
            $context['post'] = Timber::get_post($post->ID);
            
            // Group defaults to 'components' unless 'path' param is defined
            $group = isset($_GET['path']) && !empty($_GET['path']) ? $_GET['path'] : 'components';

            // Name is equal to the 'component' query parameter
            $name = isset($_GET['component']) ? $_GET['component'] : null;

            // Early return or handling if 'name' is not provided
            if (null === $name) {
                // You might want to handle this case, e.g., show an error or use a default
                return; // Or continue with a default 'name'
            }

            $all_fields = get_fields();

            // Check if the group (Flexible Content field) exists and is not empty
            if (isset($all_fields[$group]) && !empty($all_fields[$group])) {
                // Loop through each layout in the Flexible Content field
                foreach ($all_fields[$group] as $layout) {
                    // Check if this layout's name matches the target layout name
                    if (isset($layout['acf_fc_layout']) && $layout['acf_fc_layout'] === $name) {
                        // Set this layout to the 'layout' context
                        $context['layout'] = $layout;
                        break; // Stop the loop after finding the matching layout
                    }
                }
            }
        }


        // Handling for archive pages (categories, tags, custom taxonomy archives, custom post type archives)
        if (is_archive()) {
            // For archives, Timber::get_posts() can be used to fetch and set the posts for the current archive
            $context['posts'] = Timber::get_posts();
            // Additionally, you might want to set the archive title or any other archive-specific context
            $context['title'] = get_the_archive_title();
        }

        // Optionally, add the component value to the context if needed
        $context['component'] = $_GET['component'];

        $context['state'] = $context;

        // Determine the appropriate Twig template to render
        // This could be further customized based on the component or the type of page
        $template = 'component-preview.twig';

        // Render the specific Twig template and stop further processing
        Timber::render($template, $context);

        // Prevent WordPress from continuing to load the default template
        exit;
    }
}