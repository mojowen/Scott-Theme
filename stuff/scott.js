window.onload = function() {

	function considerMobile() {
		return window.innerWidth < 560;
	}
	ScottGrid = function() {
		var openThumbnail = null,
			ignore_popstate = false;

		function close() {
                        var nextSib = openThumbnail.parentElement.nextElementSibling
                        nextSib.style.zIndex = -1
                        setTimeout(function() { nextSib.style.zIndex = null; }, 1010)

			openThumbnail.style.margin = '0';
			openThumbnail.style.width = null;
			openThumbnail.className = 'project';
			openThumbnail.parentElement.style.zIndex = null;
			openThumbnail = null;

			title.text = 'Projects';
			title.textContent = 'Projects';

			try {
				history.pushState({ project: null },'Scott Riker Duncombe :: Projects','/');
				document.title = 'Scott Riker Duncombe :: Projects';
			} catch(e) {}
			try { ga('send', 'pageview', { 'page': '/', 'title': 'Scott Riker Duncombe :: Projects' }); } catch(e) {}
		}
		function open(thumbnail) {
			openThumbnail = thumbnail;
			openThumbnail.className += ' open';
			openThumbnail.parentElement.style.zIndex = 100;

			sizeOpen();

			var next = openThumbnail.parentElement.nextElementSibling,
				prev = openThumbnail.parentElement.previousElementSibling,
				nextElem = openThumbnail.getElementsByClassName('next')[0],
				prevElem = openThumbnail.getElementsByClassName('prev')[0],
				closeElem = openThumbnail.getElementsByClassName('close')[0];

			// Binding elements
			if( next !== null ) {
				nextElem.onclick = function() { closeAndOpen( next.getElementsByClassName('project')[0] ); return false;}
			} else {
				nextElem.style.display = 'none';
			}
			if( prev !== null ) {
				prevElem.onclick = function() { closeAndOpen( prev.getElementsByClassName('project')[0] ); return false;}
			} else {
				prevElem.style.display = 'none';
			}
			closeElem.onclick = function() { close();  return false; }

			if( thumbnail.getAttribute('data-slug').replace(/\//g,'') !== document.location.href.replace(/\//g,'') ) {
				// Setting up push
				var the_path = thumbnail.getAttribute('data-slug').replace( document.location.protocol+'//'+document.location.host,''),
					the_title = thumbnail.getAttribute('data-title');

				title.text = the_title;
				title.textContent = the_title;
				try {
					history.pushState({ path: the_path },'Scott Riker Duncombe :: '+the_title,the_path);
					document.title = 'Scott Riker Duncombe :: '+the_title;
				} catch(e) {}
				try { ga('send', 'pageview', { 'page': the_path, 'title': 'Scott Riker Duncombe :: '+the_title }); } catch(e) {}
			}
		}
		function openAndIgnore(thumbnail) {
			ignore_popstate = true;
			open( thumbnail );
			setTimeout(function(){ ignore_popstate = false;},1000);
		}
		function closeAndOpen(thumbnail) {
			if( openThumbnail !== null ) {
				close();
				openAndIgnore(thumbnail);
			} else {
				open(thumbnail);
			}
		}
		function sizeOpen() {

			var screen_width = window.innerWidth,
				left_margin = openThumbnail.parentElement.offsetLeft,
				content_offset = content.offsetWidth;


			switch(true) {
				case( screen_width >= 900 ):
					left_margin = -1 * ( left_margin - 76 );
					content_offset = content_offset;
					break;
				case( screen_width < 900 && ! considerMobile() ):
					left_margin = -1 * ( left_margin - 70 );
					content_offset = 530 + 70;
					break;
				case( considerMobile() ):
					left_margin = -1 * ( left_margin - 30 );
					content_offset = content_offset + 10;
					break;
			}

			openThumbnail.style.marginLeft = left_margin+'px';
			openThumbnail.style.width = content_offset+'px';
			openThumbnail.style.marginTop = -10+'px';
		}

		var thumbnails = document.getElementsByClassName('thumbnail');

		for (var i = thumbnails.length - 1; i >= 0; i--) {
			thumbnails[i].onclick = function() { closeAndOpen(this.parentElement); }
			if( thumbnails[i].parentElement.getAttribute('data-slug').replace(/\//g,'') === document.location.href.replace(/\//g,'')  ) {
				openAndIgnore( thumbnails[i].parentElement);
				window.scrollTo(0, thumbnails[i].parentElement.parentElement.offsetTop - 20 );
			}
		};
		var links = document.getElementsByTagName('a');
		for (var i = links.length - 1; i >= 0; i--) {
			var link = links[i];
			if( link.getAttribute('href') === '/' ) {
				link.onclick = function() {
					if( openThumbnail !== null ) close();
					return false;
				}
			}
		};

		// Can use back button to close a project
		window.addEventListener('popstate', function(e) {
			if( openThumbnail !== null && ! ignore_popstate ) close();
		});
		// If there's a resize we need to resize the open
		window.addEventListener('resize', function(e) {
			if( openThumbnail !== null ) sizeOpen();
		})
	};
	GalleryFix = function() {

		function fixGallery(gallery) {
			var showcase = document.createElement('div'),
				img = document.createElement('img'),
				heading = document.createElement('h1'),
				loading = document.createElement('span'),
				galleryImage = null;

			showcase.className = 'gallery-showcase';
			img.className = 'gallery-main-image';
			heading.className = 'gallery-heading';
			loading.className = 'gallery-loading';
			loading.text = 'Loading...';
			loading.textContent = 'Loading...';

			img.onload = function() {
				img.className = 'gallery-main-image';
				loading.style.display = 'none';
			}
			function setImage(galleryItem,isEvent) {
				if( galleryImage !== null ) galleryImage.className = galleryImage.className.replace(' active','');
				galleryImage = galleryItem.getElementsByClassName('attachment-thumbnail')[0];
				loading.style.display = 'block';
				img.className += ' loading';
				img.src = galleryImage.src.replace(/\-1[0-9]*x1[0-9]*/,'');
				img.onclick = function() { try{ ga('send', 'event', 'open '+img.src, 'clicked'); } catch(e) { }; window.open(img.src); }
				galleryImage.className += ' active';

                                var galleryCaption = galleryItem.querySelector('.gallery-caption')
				heading.textContent = galleryCaption.textContent;

				if( considerMobile() && isEvent ) { try{ ga('send', 'event', 'open '+img.src, 'clicked'); } catch(e) { }; window.open(img.src);  }
				else { try{ ga('send', 'event', 'preview '+img.src, 'clicked'); } catch(e) { }; }
			}

			setImage(gallery);
			showcase.appendChild(img);
			showcase.appendChild(loading);
			showcase.appendChild(heading);
			gallery.insertBefore( showcase, gallery.childNodes[0]);

			function setBinding(galleryItem) {
				galleryItem.onclick = function() { setImage(this,true); return false; };
				galleryItem.getElementsByTagName('a')[0].onclick = function() { return false; }
				galleryItem.getElementsByTagName('img')[0].setAttribute('width',null);
				galleryItem.getElementsByTagName('img')[0].setAttribute('height',null);
			}
			for (var i = gallery.childNodes.length - 1; i >= 0; i--) {
				var child = gallery.childNodes[i];
				if( child.tagName === 'BR' ) gallery.removeChild( child );
				if( typeof child.className !== 'undefined' && child.className.toString().search('gallery-item') !== -1 ) setBinding(child);
			};
		}

		var galleries = document.getElementsByClassName('gallery');
		for (var i = galleries.length - 1; i >= 0; i--) {
			fixGallery( galleries[i] );
		};

	}


	if( typeof gridPage != 'undefined' ) { new ScottGrid(); new GalleryFix(); }
}
