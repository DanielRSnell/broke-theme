---
field_groups:
  - key: group_unique_id
    title: "Comprehensive ACF Fields Example"
    fields:
      - key: field_accordion_text
        label: "Text Fields"
        name: ""
        type: "accordion"
        "open": 0

      - key: field_text
        label: "Text Field"
        name: "text_field"
        type: "text"
      - key: field_textarea
        label: "Textarea Field"
        name: "textarea_field"
        type: "textarea"
      - key: field_wysiwyg
        label: "WYSIWYG Field"
        name: "wysiwyg_field"
        type: "wysiwyg"

      - key: field_accordion_choice
        label: "Choice Fields"
        name: ""
        type: "accordion"
        "open": 0

      - key: field_select
        label: "Select Field"
        name: "select_field"
        type: "select"
      - key: field_checkbox
        label: "Checkbox Field"
        name: "checkbox_field"
        type: "checkbox"
      - key: field_radio
        label: "Radio Button Field"
        name: "radio_field"
        type: "radio"

      - key: field_accordion_media
        label: "Media Fields"
        name: ""
        type: "accordion"
        "open": 0

      - key: field_image
        label: "Image Field"
        name: "image_field"
        type: "image"
      - key: field_file
        label: "File Field"
        name: "file_field"
        type: "file"
      - key: field_gallery
        label: "Gallery Field"
        name: "gallery_field"
        type: "gallery"

      - key: field_accordion_advanced
        label: "Advanced Fields"
        name: ""
        type: "accordion"
        "open": 0

      - key: field_repeater
        label: "Repeater Field"
        name: "repeater_field"
        type: "repeater"
        sub_fields:
          - key: field_sub_text
            label: "Sub Text Field"
            name: "sub_text_field"
            type: "text"
          - key: field_sub_image
            label: "Sub Image Field"
            name: "sub_image_field"
            type: "image"
      - key: field_flexible_content
        label: "Flexible Content"
        name: "flexible_content"
        type: "flexible_content"
        layouts:
          - key: layout_1
            name: "layout_1"
            label: "Layout 1"
            display: "row"
            sub_fields:
              - key: field_layout_1_text
                label: "Layout 1 Text Field"
                name: "layout_1_text_field"
                type: "text"
          - key: field_layout_2
            name: "layout_2"
            label: "Layout 2"
            display: "row"
            sub_fields:
              - key: field_layout_2_image
                label: "Layout 2 Image"
                name: "layout_2_image"
                type: "image"
    location:
      - - param: "block"
          operator: "=="
          value: "acf/query-posts"
---
