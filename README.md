# Disable Media Pages

[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/joppuyo/disable-media-pages/Build?logo=github)](https://github.com/joppuyo/disable-media-pages/actions?query=workflow%3ABuild)
[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/joppuyo/disable-media-pages/Test?label=tests&logo=github)](https://github.com/joppuyo/disable-media-pages/actions?query=workflow%3ATest)
[![WordPress Plugin Version](https://img.shields.io/wordpress/plugin/v/disable-media-pages?logo=wordpress)](https://wordpress.org/plugins/disable-media-pages/)
[![WordPress Plugin Active Installs](https://img.shields.io/wordpress/plugin/installs/disable-media-pages?logo=wordpress)](https://wordpress.org/plugins/disable-media-pages/)
[![WordPress Plugin Rating](https://img.shields.io/wordpress/plugin/stars/disable-media-pages?logo=wordpress)](https://wordpress.org/plugins/disable-media-pages/)
[![WordPress Plugin Required PHP Version](https://img.shields.io/wordpress/plugin/required-php/disable-media-pages)](https://wordpress.org/plugins/disable-media-pages/)
[![WordPress Plugin: Required WP Version](https://img.shields.io/wordpress/plugin/wp-version/disable-media-pages?label=required&logo=wordpress)](https://wordpress.org/plugins/disable-media-pages/)
[![WordPress Plugin: Tested WP Version](https://img.shields.io/wordpress/plugin/tested/disable-media-pages?label=tested&logo=wordpress)](https://wordpress.org/plugins/disable-media-pages/)
[![codecov](https://codecov.io/gh/joppuyo/disable-media-pages/branch/master/graph/badge.svg?token=OKOGFRYYJ5)](https://codecov.io/gh/joppuyo/disable-media-pages)
[![Active Development](https://img.shields.io/badge/Maintenance%20Level-Actively%20Developed-brightgreen.svg)](https://gist.github.com/cheerfulstoic/d107229326a01ff0f333a1d3476e068d)

Completely disable "attachment" pages created by WordPress.

By default, WordPress creates a page for each of your attachments. This is can be undesirable because of two reasons:

### Search engine optimization

Attachment pages don't have any content, except an image, so they provide little value and can negatively affect your SEO.

### Reserved slugs

Attachment pages can accidentally reserve slugs on your site. Let's say you upload an image named `contact.jpeg`, an attachment page `https://example.com/contact` is automatically created. If you then try to create a page named **Contact**, the URL for that page will be `https://example.com/contact-2` which isn't that great.

## How it works

This plugin works by automatically setting all attachment slugs to an unique id, so they won't conflict with your pages. If an attachment page is accessed, the plugin will return a 404 status code and display the "page not found" template.

You can also mangle any existing attachment slugs so they won't cause any issues in the future.

## Requirements

* WordPress 5.0 or later
* PHP 7.0 or later

## Installation

* Download latest version on [wordpress.org](https://wordpress.org/plugins/disable-media-pages/)
* Upload the zip through the WordPress admin panel or unzip it and copy it into your wp-content/plugins directory
* Activate the plugin on your plugins page in the WordPress admin panel

## Frequently Asked Questions

### How to mangle existing attachment slugs?

Go to the **Settings** ▸ **Disable Media Pages** ▸ **Mangle existing slugs**. This will show you a wizard to mangle existing attachment slugs.

### Why not just use Yoast SEO? It has a feature to redirect attachment pages to parent

First of all, not everyone uses Yoast SEO. More importantly, while Yoast SEO can fix the duplicate content issue, it does not help with issue of media files reserving slugs for pages.

### What if I want to redirect attachment pages to parent page instead?

Instead of displaying a 404 HTTP error, some people recommend you to redirect attachment pages to the parent page instead. I think this can be a good short-term solution if the attachment pages have been indexed by Google and you want to preserve SEO ranking for these URLs. There's a plenty of plugins on the plugin directory that let you to do that. In my opinion returning the 404 error is the correct long-term solution and if you are launching a new site, it's best to simply disable these pages so they won't ever end up in Google index.

### What kind of unique id is used?

The unique id is an UUIDv4, without dashes.

### Can I restore the attachment page slugs after mangling?

Yes, this functionality is available in version 1.1.0. The attachment slug restoration tools allows you to restore the attachments back to slugs based on the title of the attachment.

## Thanks

Special thanks to Greg Schoppe for [his research](https://gschoppe.com/wordpress/disable-attachment-pages/) and inspiration that helped a lot with developing this plugin.

## Support the plugin

Maintaining a WordPress plugin is a lot of work. If you like the plugin, please consider rating it on [WordPress.org](https://wordpress.org/support/plugin/disable-media-pages/reviews/#new-post). You can also support me on [GitHub sponsors](https://github.com/sponsors/joppuyo). Thank you!

If you are interested, you can also check out my other WordPress plugins:

* [Disable Customizer](https://wordpress.org/plugins/customizer-disabler/)
* [Disable Drop Cap](https://wordpress.org/plugins/disable-drop-cap/)
* [ACF Image Aspect Ratio Crop](https://wordpress.org/plugins/acf-image-aspect-ratio-crop/)
