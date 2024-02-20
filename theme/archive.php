<?php
/**
 * @package WordPress
 * @subpackage broketheme
 * @since broketheme 1.2.0
 */

$templates = array('archive.twig', 'index.twig');

$context = Timber::context();

$context['title'] = 'Archive';
if (is_day()) {
    $context['title'] = 'Archive: ' . get_the_date('D M Y');
} elseif (is_month()) {
    $context['title'] = 'Archive: ' . get_the_date('M Y');
} elseif (is_year()) {
    $context['title'] = 'Archive: ' . get_the_date('Y');
} elseif (is_tag()) {
    $context['title'] = single_tag_title('', false);
    $archive_id = get_queried_object_id(); // Get the current tag ID
} elseif (is_category()) {
    $context['title'] = single_cat_title('', false);
    array_unshift($templates, 'archive-' . get_query_var('cat') . '.twig');
    $archive_id = get_queried_object_id(); // Get the current category ID
} elseif (is_post_type_archive()) {
    $context['title'] = post_type_archive_title('', false);
    array_unshift($templates, 'archive-' . get_post_type() . '.twig');
    // For custom post type archives, you might need a different approach to get related custom fields
}

$context['posts'] = Timber::get_posts();

if (isset($archive_id)) { // Make sure $archive_id is set
    // Replace 'components' with your actual custom field name
    $context['components'] = get_field('components', 'term_' . $archive_id);
} else {
    // Handle the case for custom post type archives or other scenarios
}

$context['state'] = $context;

Timber::render($templates, $context);
