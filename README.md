![Theme Screenshot](/cover.png)

# Broke Theme :evergreen_tree:

Broke Theme is a sophisticated WordPress theme that leverages a suite of powerful tools including [Timber](https://www.upstatement.com/timber/), [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/), [Laravel Mix](https://github.com/JeffreyWay/laravel-mix), [Tailwind CSS](https://tailwindcss.com/), [HTMX](https://htmx.org/), and [Alpine.js](https://github.com/alpinejs/alpine) to create high-performance websites with editor-friendly interfaces.

## What is WHAT Stack

**WHATT** Stack stands for

[W] WordPress
[H] HTMX
[A] Alpine
[A] ACF Pro
[A] ACF Extended
[T] Tailwind
[T] Timber
[T] Twig

And should be pronounced WHAAATTTT that's WordPress?

## Our Mission

Our goal with Broke is to facilitate the development of high-performance websites that not only deliver on the front-end but also provide a seamless back-end experience for editors. To this end, we've crafted two distinct development paths:

### ACF Flexible Content + Dynamic Rendering

This approach empowers clients with a customizable page builder to edit, manage, and create pages effortlessly. It's designed to offer a seamless and controlled editing experience, making it our recommended choice for most clients.

Benefits include:

- Streamlined interface for non-technical users.
- High degree of customization without the complexities of Gutenberg.

### Block Editor Integration

For those who prefer Gutenberg, Broke allows for the creation of custom blocks via all components, enhancing the block editor's usability and friendliness.

This option is best suited for:

- Creating content blocks for use during the post creation process.
- Enabling a fast, user-friendly Gutenberg experience without relying on it for full-scale page building.

We advocate for using the block editor primarily for posts and long-form content, ensuring consistency across editing experiences. This harmonization is crucial as Gutenberg, even with Full Site Editing (FSE), maintains a distinct layout that might not align with every theme's design philosophy.

This dual approach is made viable through [ACF's Blocks feature](https://www.advancedcustomfields.com/resources/blocks/), blending flexibility with functionality.

## Installation Instructions

To set up the Broke Theme on your WordPress site, follow these steps:

1. **Download and Install Theme:**

   - Either download the theme's ZIP file or clone this repository.
   - Move the downloaded or cloned theme into the `wp-content/themes` directory of your WordPress installation.

2. **Install Dependencies:**

   - Navigate to the theme's directory in your terminal.
   - Execute `composer install` to install PHP dependencies.
   - Run `npm install` to install Node.js dependencies.

3. **Activate Theme:**

   - Go to your WordPress dashboard, navigate to Appearance > Themes.
   - Locate Broke Theme and click "Activate".

4. **Plugin Recommendations:**
   - Upon theme activation, you will receive installation prompts for ACF Pro and ACF Extended through TGM Plugin Activation (TGPM) if they are not already installed.
   - If you have ACF Extended Pro installed, you can safely dismiss the ACF Extended recommendation.

These steps will ensure the Broke Theme is properly installed along with its required plugins and dependencies, ready for your customization and content.

## Development

Broke Theme builds your css and js files using Laravel Mix. This allows you to use the latest Javascript and CSS features.

To build your assets for development, run `npm run development` or `npm run watch` from the theme directory in the terminal.

### Browsersync

To use Browsersync during local development, rename `browsersync.config-sample.js` to `browsersync.config.js` and update the proxy to match your local development URL. Other options can be seen in the [Browsersync documentation](https://browsersync.io/docs/options/).

### Versioning

To assist with long-term caching, file hashing (e.g. `app.js?id=8e5c48eadbfdd5458ec6`) is enabled by default. This is useful for cache-busting purposes.

## Production

When you're ready for production, run `npm run production` from the theme directory in the terminal.

If you're developing locally and moving files to your production environment, only the `theme` and `vendor` directories are needed inside the `Broke Theme` theme directory. The theme directory structure should look like the following:

```
  Broke Theme/
  ├── theme/
  ├── vendor/
```

## Dynamic Layouts and Live Previews

Dynamic layouts enhance the WordPress admin experience by offering live previews within Flexible Content fields, streamlining the editing process. For this functionality, ACF Extended is essential as it enables the live previews.

### Adding New Layouts

To introduce new layouts, utilize the `layouts` directory. Refer to the `/theme/layouts/components` directory for examples on structuring your Flexible Content layouts.

Here's a sample directory structure for a new component:

```
layouts/
├─ components/
│   ├─ hero/
│   │   ├── index.twig
│   │   ├── _scripts.js
│   │   └── _styles.css

```

### Optional Scripts and Styles

The theme primarily uses Tailwind CSS for styling. However, you can add component-specific CSS or JavaScript files as needed. These should be placed directly in the component's directory. Additionally, for an enhanced development workflow, consider using the Broke CLI (upon its release) to manage these component-specific assets.

This approach ensures a modular and flexible development environment, facilitating component reuse and ease of maintenance.

## Blocks

A block is a self-contained page section and includes its own template, script, style, functions and block.json files.

```
  example/
  ├── block.json
  ├── functions.php
  ├── index.twig
  ├── script.js
  ├── style.css
```

To create a new block, create a directory in `theme/blocks`. Add your `index.twig` and `block.json` files and it's ready to be used with the WordPress block editor. You can optionally add style.css, script.js and functions.php files. An example block is provided for reference. Add editable fields by creating a new ACF field group and setting the location rule to your new block. You can now use these fields with your block in the block editor.

### Accessing Fields

You access your block's fields in the index.twig file by using the `fields` variable. The example below shows how to display a block's field. We'll use "heading" as the example ACF field name, but it could be whatever name you give your field.

`{{ fields.heading }}`

Here's an example of how to loop through a repeater field where "features" is the ACF field name and the repeater field has a heading field.

```
{% for feature in fields.features %}
{{ feature.heading }}
{% endfor %}
```

## Directory Structure

`theme/` contains all of the WordPress core templates files.

`theme/acf-json/` contain all of your Advanced Custom Fields json files. These files are automatically created/updated using ACF's Local JSON feature.

`theme/assets/` contain all of your fonts, images, styles and scripts.

`theme/layouts/` contains all of your site's layout components used within the Flexible Content fields or as part of dynamic page templates. Each layout component has its own directory, which can include a Twig template file, optional JavaScript, and CSS files specific to that layout. These components allow for modular page construction and can be reused across different pages or posts, providing a versatile way to manage and present content dynamically.

`theme/blocks/` contain all of your site's blocks. These blocks are available to use on any page via the block editor. Each block has its own template, script and style files.

`theme/patterns/` contains all of your sites's block patterns. Block Patterns are a collection of predefined blocks that you can insert into pages and posts and then customize with your own content.

`theme/views/` contains all of your Twig templates. These pretty much correspond 1 to 1 with the PHP files that respond to the WordPress template hierarchy. At the end of each PHP template, you'll notice a `Timber::render()` function whose first parameter is the Twig file where that data (or `$context`) will be used.

## License

MIT © Daniel Snell
