---
field_groups:
  - key: group_[block_name]
    title: "[block] fields"
    fields:
      - key: [block_name]_accordion_text
        label: "Text Fields"
        name: ""
        type: "accordion"
      - key: [block_name]_text
        label: "Text Field"
        name: "text_field"
        type: "text"
      - key: [block_name]_textarea
        label: "Textarea Field"
        name: "textarea_field"
        type: "textarea"

      - key: [block_name]_accordion_media
        label: "Media Fields"
        name: ""
        type: "accordion"
      - key: [block_name]_image
        label: "Image Field"
        name: "image_field"
        type: "image"
      - key: [block_name]_file
        label: "File Field"
        name: "file_field"
        type: "file"
      - key: [block_name]_gallery
        label: "Gallery Field"
        name: "gallery_field"
        type: "gallery"

      - key: [block_name]_accordion_choice
        label: "Choice Fields"
        name: ""
        type: "accordion"
        open: 0
      - key: [block_name]_select
        label: "Select Field"
        name: "select_field"
        type: "select"
        choices:
          option1: "Option 1"
          option2: "Option 2"
          option3: "Option 3"
      - key: [block_name]_checkbox
        label: "Checkbox Field"
        name: "checkbox_field"
        type: "checkbox"
        choices:
          check1: "Check 1"
          check2: "Check 2"
          check3: "Check 3"
      - key: [block_name]_radio
        label: "Radio Button Field"
        name: "radio_field"
        type: "radio"
        choices:
          radio1: "Radio Option 1"
          radio2: "Radio Option 2"
          radio3: "Radio Option 3"
      - key: [block_name]_toggle
        label: "Toggle Field"
        name: "toggle_field"
        type: "true_false"
        message: "Enable feature"
        ui: 1
        ui_on_text: "Enabled"
        ui_off_text: "Disabled"

      - key: [block_name]_accordion_advanced
        label: "Advanced Fields"
        name: ""
        type: "accordion"
      - key: [block_name]_repeater
        label: "Repeater Field"
        name: "repeater_field"
        type: "repeater"
      - key: [block_name]_group
        label: "Group Field"
        name: "group_field"
        type: "group"
      - key: [block_name]_flexible_content
        label: "Flexible Content"
        name: "flexible_content"
        type: "flexible_content"

      - key: [block_name]_accordion_niche
        label: "Niche Fields"
        name: ""
        type: "accordion"
      - key: [block_name]_oembed
        label: "oEmbed Field"
        name: "oembed_field"
        type: "oembed"
      - key: [block_name]_url
        label: "URL Field"
        name: "url_field"
        type: "url"
    location:
      - - param: "block"
          operator: "=="
          value: "acf/[block-name]"
---
