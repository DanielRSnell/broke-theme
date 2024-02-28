<?php
/**
 * @package WordPress
 * @subpackage broketheme
 * @since broketheme 1.2.0
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

Timber\Timber::init();
Timber::$dirname = ['views', 'blocks'];
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
        foreach (glob(dirname(__FILE__) . "/blocks/*/context.php") as $file) {
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
                'caption',
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
        // Dequeue WordPress styles and jQuery script
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style');
        wp_dequeue_script('jquery');

        $mixPublicPath = get_template_directory() . '/assets/build';

        // Enqueue your theme's stylesheet
        wp_enqueue_style('style', get_template_directory_uri() . '/assets/build' . $this->mix("/app.css", $mixPublicPath));

        // Enqueue your theme's main JavaScript file
        wp_enqueue_script('app', get_template_directory_uri() . '/assets/build' . $this->mix("/app.js", $mixPublicPath), array(), '', true);

        // Add filter to add 'defer' attribute to 'app' script tag
        add_filter('script_loader_tag', array($this, 'add_defer_attribute'), 10, 3);
    }

    /**
     * Adds 'defer' attribute to specific scripts.
     *
     * @param string $tag The `<script>` tag for the enqueued script.
     * @param string $handle The script's registered handle.
     * @param string $src The script's source URL.
     * @return string Modified script HTML string.
     */
    public function add_defer_attribute($tag, $handle, $src)
    {
        // Add defer attribute to the 'app' script
        if ($handle === 'app') {
            $tag = '<script src="' . esc_url($src) . '" defer></script>';
        }
        return $tag;
    }

    public function block_categories_all($categories)
    {
        return array_merge([['slug' => 'custom', 'title' => __('Custom')]], $categories);
    }

    public function acf_register_blocks()
    {
        $blocks = [];

        foreach (new DirectoryIterator(dirname(__FILE__) . '/blocks') as $dir) {
            if ($dir->isDot()) {
                continue;
            }

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
            'core/columns',
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

function my_admin_theme_style()
{
    wp_enqueue_style('my-admin-theme', get_template_directory_uri() . '/admin/_style.css');
}
add_action('admin_enqueue_scripts', 'my_admin_theme_style');

use League\CommonMark\Extension\FrontMatter\Data\SymfonyYamlFrontMatterParser;
use League\CommonMark\Extension\FrontMatter\FrontMatterParser;

add_action('rest_api_init', function () {
    register_rest_route('broke/v1', '/fields', array(
        'methods' => 'GET',
        'callback' => 'parse_markdown_fields',
        'args' => array(
            'file_name' => array(
                'required' => true,
                'validate_callback' => function ($param, $request, $key) {
                    return is_string($param);
                },
            ),
        ),
    ));
});

function parse_markdown_fields($request)
{
    $file_name = $request['file_name'];
    $file_path = get_stylesheet_directory() . "/blocks/$file_name/fields.md";

    if (file_exists($file_path)) {
        $markdownContent = file_get_contents($file_path);

        // Initialize the parser with Symfony YAML front matter parsing.
        $frontMatterParser = new FrontMatterParser(new SymfonyYamlFrontMatterParser());

        // Parse the content.
        $document = $frontMatterParser->parse($markdownContent);
        $frontMatter = $document->getFrontMatter(); // This will contain the parsed YAML front matter.
        $markdown = $document->getContent(); // This will contain the Markdown content without the front matter.

        return new WP_REST_Response([
            'frontMatter' => $frontMatter,
            'markdown' => $markdown,
        ], 200);
    } else {
        return new WP_Error('file_not_found', 'The requested file could not be found.', array('status' => 404, 'file_name' => $file_path));
    }
}

class ACF_Fields_From_Markdown
{
    public function __construct()
    {
        add_action('init', [$this, 'register_fields_from_markdown']);
    }

    public function register_fields_from_markdown()
    {
        // Bail if ACF isn't active
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        $directory = get_template_directory() . '/blocks/';
        $this->scan_directory($directory);
    }

    private function scan_directory($directory)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }

            if ($file->getFilename() === 'filters.php') {
                require_once $file->getPathname();
            }

            if ($file->getFilename() === 'fields.md') {
                $this->parse_and_register_fields($file->getPathname());
            }
        }
    }

    private function parse_and_register_fields($file_path)
    {
        $content = file_get_contents($file_path);
        $frontMatterParser = new FrontMatterParser(new SymfonyYamlFrontMatterParser());
        $document = $frontMatterParser->parse($content);
        $frontMatter = $document->getFrontMatter();

        if (isset($frontMatter['field_groups']) && is_array($frontMatter['field_groups'])) {
            foreach ($frontMatter['field_groups'] as $group) {
                acf_add_local_field_group($group);
            }
        }
    }
}

new ACF_Fields_From_Markdown();

function prism_enqueue_gutenberg_assets()
{
    // Enqueue Prism.js CSS
    wp_enqueue_style(
        'prismjs-okaidia-theme',
        'https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/themes/prism-okaidia.min.css',
        array(), // No dependencies
        '1.24.1' // Version number
    );

    // Enqueue Prism.js core library
    wp_enqueue_script(
        'prismjs-core',
        'https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/prism.min.js',
        array(), // No dependencies
        '1.24.1', // Version number
        true// Load in footer
    );

    // Optionally, include additional languages (e.g., JSON)
    wp_enqueue_script(
        'prismjs-json',
        'https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-json.min.js',
        array('prismjs-core'), // Dependency on the core Prism.js script
        '1.24.1', // Version number
        true// Load in footer
    );
}

add_action('enqueue_block_editor_assets', 'prism_enqueue_gutenberg_assets');

add_action('rest_api_init', function () {
    register_rest_route('broke/v1', '/field_types', array(
        'methods' => 'GET',
        'callback' => 'get_acf_field_types',
        'permission_callback' => '__return_true', // Allows public access to this endpoint.
    ));
});

function get_acf_field_types()
{
    if (function_exists('acf_get_field_types')) {
        // Fetching all registered ACF field types.
        $field_types = acf_get_field_types();
        $field_types_keys = array_keys($field_types);

        // Returning the list of field type keys.
        return new WP_REST_Response($field_types, 200);
    }

    // Return an error if ACF is not active/available.
    return new WP_Error('acf_not_found', 'ACF not available', array('status' => 404));
}
