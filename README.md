# Disable Media Pages

[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/joppuyo/disable-media-pages/build.yml?branch=master&logo=github)](https://github.com/joppuyo/disable-media-pages/actions?query=workflow%3ABuild)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/joppuyo/disable-media-pages/test.yml?branch=master&label=tests&logo=github)](https://github.com/joppuyo/disable-media-pages/actions?query=workflow%3ATest)
[![WordPress Plugin Version](https://img.shields.io/wordpress/plugin/v/disable-media-pages?logo=wordpress)](https://wordpress.org/plugins/disable-media-pages/)
[![WordPress Plugin Active Installs](https://img.shields.io/wordpress/plugin/installs/disable-media-pages?logo=wordpress)](https://wordpress.org/plugins/disable-media-pages/)
[![WordPress Plugin Rating](https://img.shields.io/wordpress/plugin/stars/disable-media-pages?logo=wordpress)](https://wordpress.org/plugins/disable-media-pages/)
[![WordPress Plugin Required PHP Version](https://img.shields.io/wordpress/plugin/required-php/disable-media-pages)](https://wordpress.org/plugins/disable-media-pages/)
[![WordPress Plugin: Required WP Version](https://img.shields.io/wordpress/plugin/wp-version/disable-media-pages?label=required&logo=wordpress)](https://wordpress.org/plugins/disable-media-pages/)
[![WordPress Plugin: Tested WP Version](https://img.shields.io/badge/dynamic/json?label=tested&logo=wordpress&prefix=v&color=green&query=%24.tested&url=https%3A%2F%2Fapi.wordpress.org%2Fplugins%2Finfo%2F1.0%2Fdisable-media-pages.json)](https://wordpress.org/plugins/disable-media-pages/)
[![codecov](https://codecov.io/gh/joppuyo/disable-media-pages/branch/master/graph/badge.svg?token=OKOGFRYYJ5)](https://codecov.io/gh/joppuyo/disable-media-pages)
[![Active Development](https://img.shields.io/badge/Maintenance%20Level-Actively%20Developed-brightgreen.svg)](https://gist.github.com/cheerfulstoic/d107229326a01ff0f333a1d3476e068d)

Completely disable "attachment" pages created by WordPress.

By default, WordPress creates a page for each of your attachments. This is can be undesirable because of two reasons:

### Search engine optimization

Attachment pages don't have any content, except an image, so they provide little value and can negatively affect your SEO because they are so-called [thin content](https://developers.google.com/search/docs/advanced/guidelines/thin-content). Even worse, attachment pages may in some cases rank higher than your actual content pages which leads to a poor user experience.

### Reserved slugs

Attachment pages can accidentally reserve slugs on your site. Let's say you upload an image named **contact.jpeg**, an attachment page `https://example.com/contact` is automatically created. If you then try to create a page named **Contact**, the URL for that page will be `https://example.com/contact-2` which isn't that great.

## How it works

This plugin works by automatically setting all attachment slugs to an unique id, so they won't conflict with your pages. If an attachment page is accessed, the plugin will return a 404 status code and display the "page not found" template.

You can also mangle any existing attachment slugs so they won't cause any issues in the future.

## WP CLI support

The plugin supports WP CLI.

### Mangle existing attachment slugs

```
wp disable-media-pages mangle
```

### Restore attachment slugs

```
wp disable-media-pages restore
```


## Note for WordPress 6.4

WordPress 6.4 includes [a new feature](https://make.wordpress.org/core/2023/10/16/changes-to-attachment-pages/) that allows you to disable attachment pages. However, this feature redirects attachment pages to the file URL instead of returning a 404 error. To completely disable attachment pages, you should use this plugin instead. The WP 6.4 feature also does not fix the issue where attachment pages reserve slugs for pages.

Also, there is no user interface to enable or disable media pages, they are automatically disabled for new sites but remain enabled for existing sites.

Because of these issues, I recommend you to use this plugin instead of the built-in feature. The plugin will be updated in the foreseeable future, at least until attachment pages are completely removed from WordPress core and older WordPress versions are no longer in use.

## Requirements

* WordPress 5.2 or later
* PHP 7.1 or later

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

Yes, this functionality is available in version 1.1.0. The attachment slug restoration tool allows you to restore the attachment slugs back to ones based on the attachment title.

## Thanks

Special thanks to Greg Schoppe for [his research](https://gschoppe.com/wordpress/disable-attachment-pages/) and inspiration that helped a lot with developing this plugin.

## Support the plugin

Maintaining a WordPress plugin is a lot of work. If you like the plugin, please consider rating it on [WordPress.org](https://wordpress.org/support/plugin/disable-media-pages/reviews/#new-post). You can also support me on [GitHub sponsors](https://github.com/sponsors/joppuyo). Thank you!

If you are interested, you can also check out my other WordPress plugins:

* [Disable Customizer](https://wordpress.org/plugins/customizer-disabler/)
* [Disable Drop Cap](https://wordpress.org/plugins/disable-drop-cap/)
* [ACF Image Aspect Ratio Crop](https://wordpress.org/plugins/acf-image-aspect-ratio-crop/)
