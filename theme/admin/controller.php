<?php 

require_once get_stylesheet_directory() . '/admin/class-tgm-plugin-activation.php'; // Adjust the path as necessary

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );

function my_theme_register_required_plugins() {
    $plugins = array(
        // ACF Pro (ACF Pro must be downloaded separately as it is not available from the WP repository)
        array(
            'name'               => 'Advanced Custom Fields Pro', // The plugin name
            'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name)
            'source'             => 'path/to/advanced-custom-fields-pro.zip', // The plugin source
            'required'           => true, // If false, the plugin is only 'recommended' instead of required
            'external_url'       => 'https://www.advancedcustomfields.com/pro/', // If set, overrides default API URL and points to an external URL
        ),

        // ACF Extended
        array(
            'name'               => 'ACF Extended', // The plugin name
            'slug'               => 'acf-extended', // The plugin slug (typically the folder name)
            'required'           => false, // If false, the plugin is only 'recommended' instead of required
            'external_url'       => 'https://wordpress.org/plugins/acf-extended/', // Optionally provide an external URL to the plugin
        ),
    );

    $config = array(
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );

    tgmpa( $plugins, $config );
}