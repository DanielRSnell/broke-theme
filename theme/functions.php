<?php
/**
 * @package WordPress
 * @subpackage broketheme
 * @since broketheme 1.2.0
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

Timber\Timber::init();
Timber::$dirname = [ 'views', 'blocks' ];
Timber::$autoescape = false;

require get_stylesheet_directory() . '/timber/controller.php';
require get_stylesheet_directory() . '/timber/component-preview.php';
require get_stylesheet_directory() . '/admin/controller.php';

class broketheme extends Timber\Site
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('after_setup_theme', [$this, 'theme_supports']);
        add_filter('timber/context', [$this, 'add_to_context']);
        add_filter('timber/twig', [$this, 'add_to_twig']);
        add_action('block_categories_all', [$this, 'block_categories_all']);
        add_action('acf/init', [$this, 'acf_register_blocks']);
        //add_filter('allowed_block_types', [$this, 'allowed_block_types']);
        add_action('enqueue_block_editor_assets', [$this, 'enqueue_block_editor_assets']);

        parent::__construct();
    }

    public function add_to_context($context)
    {
        $context['site'] = $this;
        $context['menu'] = Timber::get_menu();

        // Require block functions files
        foreach (glob(dirname(__FILE__) . "/blocks/*/functions.php") as $file) {
            require_once $file;
        }

        return $context;
    }

    public function add_to_twig($twig)
    {
        return $twig;
    }

    public function theme_supports()
    {
        add_theme_support('automatic-feed-links');
        add_theme_support(
            'html5',
            [
                'comment-form',
                'comment-list',
                'gallery',
                'caption'
            ]
        );
        add_theme_support('menus');
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
        add_theme_support('editor-styles');
        add_editor_style('assets/build/editor-style.css');
    }

    public function enqueue_scripts()
    {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style');
        wp_dequeue_script('jquery');

        $mixPublicPath = get_template_directory() . '/assets/build';

        wp_enqueue_style('style', get_template_directory_uri() . '/assets/build' . $this->mix("/app.css", $mixPublicPath));
        wp_enqueue_script('app', get_template_directory_uri() . '/assets/build' . $this->mix("/app.js", $mixPublicPath), array(), '', true);
    }

    public function block_categories_all($categories)
    {
        return array_merge([['slug' => 'custom', 'title' => __('Custom')]], $categories);
    }

    public function acf_register_blocks()
    {
        $blocks = [];

        foreach (new DirectoryIterator(dirname(__FILE__) . '/blocks') as $dir) {
            if ($dir->isDot()) continue;

            if (file_exists($dir->getPathname() . '/block.json')) {
                $blocks[] = $dir->getPathname();
            }
        }

        asort($blocks);

        foreach ($blocks as $block) {
            register_block_type($block);
        }
    }

    public function allowed_block_types()
    {
        $allowed_blocks = [
            'core/columns'
        ];

        foreach (new DirectoryIterator(dirname(__FILE__) . '/blocks') as $dir) {
            $allowed_blocks[] = 'acf/' . $dir;
        }

        return $allowed_blocks;
    }

    public function enqueue_block_editor_assets()
    {
        //wp_enqueue_style('prefix-editor-font', '//fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap');
        wp_enqueue_script('app', get_template_directory_uri() . '/assets/build/app.js');
    }

    public function mix($path, $manifestDirectory = '')
    {
        static $manifest;

        if (!$manifest) {
            if (!file_exists($manifestPath = $manifestDirectory . '/mix-manifest.json')) {
                throw new Exception('The Mix manifest does not exist.');
            }
            $manifest = json_decode(file_get_contents($manifestPath), true);
        }

        if (strpos($path, '/') !== 0) {
            $path = "/{$path}";
        }

        if (!array_key_exists($path, $manifest)) {
            throw new Exception(
                "Unable to locate Mix file: {$path}. Please check your webpack.mix.js output paths and try again."
            );
        }

        return $manifest[$path];
    }
}

new broketheme();

function acf_block_render_callback($block, $content) {
    $context = Timber::context();
    $context['post'] = Timber::get_post();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $template = $block['path'] . '/index.twig';

    Timber::render($template, $context);
}

// Remove ACF block wrapper div
function acf_should_wrap_innerblocks($wrap, $name) {
    // if ( $name == 'acf/test-block' ) {
    //     return true;
    // }
    return false;
}

add_filter('acf/blocks/wrap_frontend_innerblocks', 'acf_should_wrap_innerblocks', 10, 2);

// Define the post types to disable the block editor.
$disabled_block_editor_post_types = ['page']; // Add 'post', 'custom_post_type', etc., as needed.

// Define the post types to completely disable the editor.
$disabled_editor_post_types = ['page']; // Separate array for complete disabling.

// Hook into the 'use_block_editor_for_post_type' filter to disable the block editor for specific post types.
add_filter('use_block_editor_for_post_type', 'disable_block_editor_for_specific_post_types', 10, 2);

function disable_block_editor_for_specific_post_types($use_block_editor, $post_type) {
    global $disabled_block_editor_post_types;

    return in_array($post_type, $disabled_block_editor_post_types) ? false : $use_block_editor;
}

// Remove unwanted meta boxes for specified post types in the admin.
add_action('admin_init', 'remove_unwanted_meta_boxes');

function remove_unwanted_meta_boxes() {
    global $disabled_block_editor_post_types, $pagenow;

    // Check if we're on the post edit screen and the current post type is in our list.
    if ('post.php' === $pagenow || 'post-new.php' === $pagenow) {
        $current_post_type = get_post_type(get_the_ID());
        if (in_array($current_post_type, $disabled_block_editor_post_types)) {
            remove_meta_box('postcustom', null, 'normal'); // Custom Fields meta box
            remove_meta_box('slugdiv', null, 'normal'); // Slug meta box
            remove_meta_box('commentstatusdiv', null, 'normal'); // Discussion meta box
            remove_meta_box('commentsdiv', null, 'normal'); // Comments meta box
            remove_meta_box('revisionsdiv', null, 'normal'); // Revisions meta box
        }
    }
}

// Hook into the 'init' action to remove editor support from specified post types.
add_action('init', 'remove_editor_from_specific_post_types');

function remove_editor_from_specific_post_types() {
    global $disabled_editor_post_types;

    foreach ($disabled_editor_post_types as $post_type) {
        remove_post_type_support($post_type, 'editor');
    }
}