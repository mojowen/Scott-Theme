## Scott's Website Them

It's pretty simple stuff - under 1,000 lines of code. [See it in action](http://scottduncombe.com)

### Project Management

Uses a custom content type (`Projects`) to track projects. Projects should have a thumbnail and can contain galleries and other stuff like youtube videos.

Projects are pretty cool they:

 * Be displayed on the front page and will use CSS animation for hover / opening effects
 * Will rewrite the url using `history.pushState` so the open browser is at the projet's current url. Will rewrite it back to `/` when the project is closed.
 * Any `/project/` links will open using the homepage's HTML and will 'open' to that project. Homepage will work as normal.

Check out `functions.php` and `/stuff/site.js` for more details.

### Better Galleries

I think the default galleries kind of suck - so on project page it rewrites them so there's a main image and clicking the thumbnails replace the main image. On small screens this doens't work as well - so it will just display larger thumbnails and clicking on them just opens the image in a new tab.

All of this is in `/stuff/site.js`


### Styles

Styles are all stored in LESS, uses javascript compilation by default but will switch to Style.css if you change config.json. You'll need to compile your LESS styles into CSS first.
