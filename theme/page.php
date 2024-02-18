<?php
/**
 * @package WordPress
 * @subpackage broketheme
 * @since broketheme 1.2.0
 */

$context = Timber::context();

$timber_post     = Timber::get_post();
$context['post'] = $timber_post;
$context['state'] = $context;

Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page.twig' ), $context );