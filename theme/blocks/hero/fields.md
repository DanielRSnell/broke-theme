---
field_groups:
  - key: group_hero
    title: hero Fields
    fields:
      - key: field_header
        label: "Header"
        name: "header"
        type: "text"
      - key: field_subheader
        label: "Subheader"
        name: "subheader"
        type: "text"
      - key: field_logos
        label: "Logos"
        name: "logos"
        type: "repeater"
    location:
      - - param: block
          operator: "=="
          value: acf/hero
---
