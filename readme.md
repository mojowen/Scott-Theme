# Scott's Website Theme

[See it in action](https://scottduncombe.com).

To install it — move this folder to `wp-content/themes` inside WordPress, then select it under Appearance → Themes.

## Styles

Plain modern CSS in `style.css` — no preprocessors, no build step. Colors and
timing are CSS variables at the top of the file (`--main`, `--muted`, `--ease`, etc.).

Fonts: [Bitter](https://fonts.google.com/specimen/Bitter) loaded from Google Fonts via `functions.php`.

## Projects

Uses a custom content type (`Projects`) to track projects. Projects should have a
thumbnail and can contain galleries and other stuff like YouTube videos.

Projects:

 * Are displayed on the front page. Hovering lifts the tile and fades in a title
   overlay; clicking smoothly expands the card in place.
 * Rewrite the URL using `history.pushState` so the open project has its own URL,
   and rewrite back to `/` when closed.
 * Any `/project/` links open using the homepage's HTML and 'open' to that project.
 * Count as Google Analytics pageviews if GA is active; fails silently otherwise.

## Press

Press clippings live in `stuff/press.json`. Rendered by the **Press** page template
(`page-press.php`) — create a page with slug `press` and choose the "Press" template.

Manage clippings with `scripts/collect_press.py`:

    scripts/collect_press.py add https://example.com/some-article
    scripts/collect_press.py add <url> --quote "Nice quote." --date 2025-03-01
    scripts/collect_press.py list
    scripts/collect_press.py remove <index-or-url>

`add` scrapes the page's `og:title` / `<title>` and `og:site_name` automatically;
flags override what was scraped. Entries are kept sorted newest-first.

## Blog

The **Blog** page template (`page-blog.php`) lists recent posts — create a page
with slug `blog` and choose the "Blog" template. Write posts as normal WordPress
posts; single posts render through `index.php`.
