---
field_groups:
  - key: group_query_posts
    title: "Query Posts Fields"
    fields:
      - key: query_posts_accordion_query
        label: "Query Parameters"
        name: ""
        type: "accordion"
        open: 1

      - key: query_posts_post_type
        label: "Post Type"
        name: "post_type"
        type: "select"
        choices:
          post: "Post"
          page: "Page"
          custom: "Custom Post Type"

      - key: query_posts_categories
        label: "Categories"
        name: "categories"
        type: "taxonomy"
        taxonomy: "category"
        field_type: "multi_select"
        allow_null: 1
        add_term: 1
        save_terms: 1
        load_terms: 1
        return_format: "id"

      - key: query_posts_tags
        label: "Tags"
        name: "tags"
        type: "taxonomy"
        taxonomy: "post_tag"
        field_type: "multi_select"
        allow_null: 1
        add_term: 1
        save_terms: 1
        load_terms: 1
        return_format: "id"

      - key: query_posts_orderby
        label: "Order By"
        name: "orderby"
        type: "select"
        choices:
          none: "None"
          ID: "ID"
          title: "Title"
          date: "Date"
          rand: "Random"

      - key: query_posts_order
        label: "Order"
        name: "order"
        type: "select"
        choices:
          ASC: "Ascending"
          DESC: "Descending"

      - key: query_posts_posts_per_page
        label: "Posts Per Page"
        name: "posts_per_page"
        type: "number"
        default_value: 10

      - key: query_posts_include_ids
        label: "Include Posts"
        name: "include_ids"
        type: "text"
        instructions: "Enter post IDs to include, separated by commas."

      - key: query_posts_exclude_ids
        label: "Exclude Posts"
        name: "exclude_ids"
        type: "text"
        instructions: "Enter post IDs to exclude, separated by commas."

    location:
      - - param: "block"
          operator: "=="
          value: "acf/query-posts"
---
