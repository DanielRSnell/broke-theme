<?php 

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_65cf1967c7c63',
	'title' => 'Components',
	'fields' => array(
		array(
			'key' => 'field_65cf1968f07d7',
			'label' => 'Components',
			'name' => 'components',
			'aria-label' => '',
			'type' => 'flexible_content',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'hide_field' => '',
			'hide_label' => '',
			'hide_instructions' => '',
			'hide_required' => '',
			'acfe_flexible_advanced' => 1,
			'acfe_flexible_stylised_button' => 1,
			'acfe_flexible_layouts_templates' => 1,
			'acfe_flexible_layouts_previews' => 1,
			'acfe_flexible_layouts_thumbnails' => 1,
			'acfe_flexible_layouts_settings' => 1,
			'acfe_flexible_layouts_locations' => 0,
			'acfe_flexible_async' => array(
				0 => 'title',
				1 => 'layout',
			),
			'acfe_flexible_add_actions' => array(
				0 => 'title',
				1 => 'toggle',
				2 => 'copy',
				3 => 'lock',
				4 => 'close',
			),
			'acfe_flexible_remove_button' => array(
			),
			'acfe_flexible_layouts_state' => 'user',
			'acfe_flexible_modal_edit' => array(
				'acfe_flexible_modal_edit_enabled' => '0',
				'acfe_flexible_modal_edit_size' => 'large',
			),
			'acfe_flexible_modal' => array(
				'acfe_flexible_modal_enabled' => '1',
				'acfe_flexible_modal_title' => '',
				'acfe_flexible_modal_size' => 'full',
				'acfe_flexible_modal_col' => '4',
				'acfe_flexible_modal_categories' => '1',
			),
			'acfe_flexible_grid' => array(
				'acfe_flexible_grid_enabled' => '0',
				'acfe_flexible_grid_align' => 'center',
				'acfe_flexible_grid_valign' => 'stretch',
				'acfe_flexible_grid_wrap' => false,
			),
			'layouts' => array(
				'layout_65cf196cb082a' => array(
					'key' => 'layout_65cf196cb082a',
					'name' => 'hero-1',
					'label' => 'Hero',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_65cf1982f07d8',
							'label' => 'Title',
							'name' => 'title',
							'aria-label' => '',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'maxlength' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
						),
						array(
							'key' => 'field_65cf1988f07d9',
							'label' => 'Subheader',
							'name' => 'subheader',
							'aria-label' => '',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'maxlength' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
						),
						array(
							'key' => 'field_65cf198ef07da',
							'label' => 'Background',
							'name' => 'background',
							'aria-label' => '',
							'type' => 'image',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'url',
							'library' => 'all',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => '',
							'preview_size' => 'medium',
							'uploader' => '',
							'acfe_thumbnail' => 0,
							'upload_folder' => '',
						),
						array(
							'key' => 'field_65cf199bf07db',
							'label' => 'Logos',
							'name' => 'logos',
							'aria-label' => '',
							'type' => 'gallery',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'url',
							'library' => 'all',
							'min' => '',
							'max' => '',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => '',
							'insert' => 'append',
							'preview_size' => 'medium',
						),
					),
					'min' => '',
					'max' => '',
					'acfe_flexible_category' => array(
						0 => 'Hero',
					),
					'acfe_flexible_render_template' => 'timber/dynamic-render.php',
					'acfe_flexible_render_style' => 'assets/build/app.css',
					'acfe_flexible_render_script' => '',
					'acfe_flexible_settings' => '',
					'acfe_flexible_settings_size' => 'medium',
					'acfe_layout_col' => 'auto',
					'acfe_layout_allowed_col' => '',
					'acfe_flexible_thumbnail' => '42',
					'acfe_layout_locations' => array(
					),
					'acfe_flexible_modal_edit_size' => false,
				),
				'layout_65d0b3aa3cc18' => array(
					'key' => 'layout_65d0b3aa3cc18',
					'name' => 'pricing-table',
					'label' => 'Pricing Table',
					'display' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_65d0b3cb3cc1a',
							'label' => 'Header',
							'name' => 'header',
							'aria-label' => '',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'acfe_settings' => '',
							'acfe_validate' => '',
							'maxlength' => '',
							'acfe_permissions' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
						),
					),
					'min' => '',
					'max' => '',
					'acfe_flexible_category' => array(
						0 => 'Pricing',
					),
					'acfe_flexible_render_template' => 'timber/dynamic-render.php',
					'acfe_flexible_render_style' => '',
					'acfe_flexible_render_script' => '',
					'acfe_flexible_settings' => '',
					'acfe_flexible_settings_size' => 'medium',
					'acfe_layout_col' => 'auto',
					'acfe_layout_allowed_col' => '',
					'acfe_flexible_thumbnail' => '41',
					'acfe_layout_locations' => array(
					),
					'acfe_flexible_modal_edit_size' => false,
				),
			),
			'acfe_settings' => '',
			'instruction_placement' => '',
			'acfe_permissions' => '',
			'min' => '',
			'max' => '',
			'button_label' => 'Add Row',
			'acfe_flexible_hide_empty_message' => false,
			'acfe_flexible_empty_message' => '',
			'acfe_flexible_layouts_placeholder' => false,
			'acfe_flexible_grid_container' => false,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'comments',
		1 => 'discussion',
		2 => 'revisions',
		3 => 'slug',
	),
	'active' => true,
	'description' => '',
	'show_in_rest' => 1,
	'acfe_autosync' => array(
		0 => 'php',
		1 => 'json',
	),
	'acfe_form' => 1,
	'acfe_display_title' => 'Components',
	'acfe_permissions' => '',
	'acfe_meta' => array(
		'65d01edfd86e7' => array(
			'acfe_meta_key' => '',
			'acfe_meta_value' => '',
		),
	),
	'acfe_note' => '',
	'modified' => 1708214987,
));

endif;