# Disable Media Pages

Disable "attachment" pages for WordPress media.

By default WordPress creates a page for each of your attachments. This is bad because:

1. These are pages that don't have any content, except an image, so they don't provide any value and can negatively affect your SEO.
2. They can accidentally reserve slugs on your site. Let's say you upload an image named `contact.jpeg`, a page like `https://example.com/contact` is automatically created. If you then try to create a page named Contact, the URL will be `https://example.com/contact-2`.

## How it works

This plugin works by automatically setting all attachment slugs to an UUID v4, so they won't conflict with your pages. It will also automatically set 404 status if a media page is accessed.

You can also mangle any existing attachment slugs so they won't cause any issues in the future.