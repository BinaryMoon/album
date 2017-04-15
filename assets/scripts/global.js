/**
 * The main javascript file for the theme, this makes the magic happen
 *
 * Filename: global.js v1
 *
 * Created by Ben Gillbanks <https://prothemedesign.com/>
 * Available under GPL2 license
 *
 * @package Terminal
 */

/* global terminal_site_settings, wp */

;( function( window, document, $ ) {

	'use strict';

	/**
	 * JS mobile detection.
	 * Is this a touch enabled device or not?
	 *
	 * @return boolean
	 */
	var is_touch_device = function() {

		return ( ( 'ontouchstart' in window ) || ( navigator.MaxTouchPoints > 0 ) || ( navigator.msMaxTouchPoints > 0 ) );

	};

	/**
	 * Smooth scroll to # anchor.
	 *
	 * @param  object e Element.
	 * @return false
	 */
	var scroll_to_hash = function( e ) {

		var $target = $( e.hash );

		if ( $target.length ) {
			var targetOffset = $target.offset().top - parseInt( $( 'html' ).css( 'margin-top' ) );
			$( 'html,body' ).animate( { scrollTop: targetOffset }, 750 );
			focus_element( e.hash );
		}

		return false;

	};

	/**
	 * Set an elements focus.
	 * If required sets a tabindex for elements that can't normally be focused.
	 *
	 * @param  string id ID of object to focus.
	 */
	var focus_element = function( id ) {

		var element = document.getElementById( id.replace( '#', '' ) );

		if ( element ) {

			if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
				element.tabIndex = -1;
			}

			element.focus();
		}

	};

	/**
	 * Set default heights for social media widgets.
	 */
	var social_widget_heights = function() {

		// Twitter.
		$( 'a.twitter-timeline' ).each(
			function() {

				var thisHeight = $( this ).attr( 'height' );
				$( this ).parent().css( 'min-height', thisHeight + 'px' );

			}
		);

		// Facebook.
		$( '.fb-page' ).each(
			function() {

				var $set_height = $( this ).data( 'height' );
				var $show_facepile = $( this ).data( 'show-facepile' );
				var $show_posts = $( this ).data( 'show-posts' ); // AKA stream.
				var $min_height = $set_height; // Set the default 'min-height'.

				// These values are defaults from the FB widget.
				var $no_posts_no_faces = 130;
				var $no_posts = 220;

				if ( $show_posts ) {

					// Showing posts; may also be showing faces and/or cover -
					// the latter doesn't affect the height at all.
					$min_height = $set_height;

				} else if ( $show_facepile ) {

					// Showing facepile with or without cover image - both would
					// be same height.
					// If the user selected height is lower than the no_posts
					// height, we'll use that instead.
					$min_height = ( $set_height < $no_posts ) ? $set_height : $no_posts;

				} else {

					// Either just showing cover, or nothing is selected (both
					// are same height).
					// If the user selected height is lower than the
					// no_posts_no_faces height, we'll use that instead.
					$min_height = ( $set_height < $no_posts_no_faces ) ? $set_height : $no_posts_no_faces;

				}

				// Apply min-height to .fb-page container.
				$( this ).css( 'min-height', $min_height + 'px' );

			}
		);

	};

	/**
	 * Attachment page navigation.
	 */
	var attachment_page_navigation = function() {

		if ( $( 'body' ).hasClass( 'attachment' ) ) {

			$( document ).keydown(
				function( e ) {

					if ( $( 'textarea, input' ).is( ':focus' ) ) {
						return;
					}

					var url = false;

					switch ( e.which ) {

						// Left arrow key (previous attachment).
						case 37:
							url = $( '.image-previous a' ).attr( 'href' );
							break;

						// Right arrow key (next attachment).
						case 39:
							url = $( '.image-next a' ).attr( 'href' );
							break;

					}

					if ( url.length ) {
						window.location = url;
					}

				}
			);

		}

	};

	/**
	 * Setup Masonry layouts.
	 */
	var $grid;
	var masonry_setup = function() {

		// Masonry grid sizer.
		$( '#main-content.content-projects, .sidebar-footer' ).prepend( '<div class="grid-sizer"></div>' );

		// Blog post content.
		$grid = $( '#main-content.content-projects' ).masonry(
			{
				itemSelector: 'article',
				columnWidth: '.grid-sizer',
				gutter: 0,
				isOriginLeft: ! $( 'body' ).is( '.rtl' ),
				percentPosition: true
			}
		);

		// Update again once images have loaded.
		$grid.imagesLoaded(
			function() {

				$grid.masonry( 'layout' );
				$grid.children().addClass( 'post-loaded' );

			}
		);

		// Update on infinite scroll load.
		$( 'body' ).on(
			'post-load',
			function() {

				var $new_articles = $( '#main-content.content-projects' ).children().not( '.post-loaded, .infinite-loader' ).addClass( 'post-loaded' );
				$grid.masonry( 'appended', $new_articles );

				$new_articles.imagesLoaded(
					function () {
						$grid.masonry( 'layout' );
					}
				);

			}
		);

		// Footer widgets.
		$( '.sidebar-footer .widget' ).imagesLoaded(
			function() {

				var $footer_widgets = null;

				$footer_widgets = $( '.sidebar-footer' ).masonry(
					{
						itemSelector: '.widget',
						columnWidth: '.grid-sizer',
						gutter: 0,
						isOriginLeft: ! $( 'body' ).is( '.rtl' ),
						percentPosition: true
					}
				);

				// Reflow widgets after 2 seconds to ensure the correct position
				// due to dynamic widgets like facebook and twitter loading.
				setTimeout(
					function() {
						$footer_widgets.masonry( 'layout' );
					},
					2000
				);

				// Reflow Footer Widgets if changed in the Customizer.
				if ( 'undefined' !== typeof wp && wp.customize && wp.customize.selectiveRefresh ) {

					wp.customize.selectiveRefresh.bind(
						'sidebar-updated',
						function( sidebarPartial ) {
							if ( 'sidebar-2' === sidebarPartial.sidebarId ) {
								$footer_widgets.masonry( 'reloadItems' );
								$footer_widgets.masonry( 'layout' );
							}
						}
					);

				}

			}
		);

	};

	/**
	 * Do all the stuffs.
	 */
	$( document ).ready(
		function() {

			social_widget_heights();

			attachment_page_navigation();

			// Masonry layout.
			$( window ).load(
				function() {

					if ( $.isFunction( $.fn.masonry ) ) {

						masonry_setup();

					}

				}
			);

			// Featured content slides.
			if ( $.isFunction( $.fn.elementalSlides ) ) {

				$( '.showcase' ).elementalSlides(
					{
						'nav_arrows': true,
						'autoplay': parseInt( terminal_site_settings.slider.autoplay )
					}
				);

			}

			// Fade in infinite scroll posts.
			$( '#main-content' ).find( 'article' ).addClass( 'post-static' );

			$( 'body' ).on(
				'post-load',
				function() {

					$( '#main-content' ).find( 'article' ).not( '.post-loaded, .post-static' ).addClass( 'post-loaded' );

				}
			);

			// Menu toggle.
			$( '.menu-toggle' ).on(
				'click',
				function() {

					var $parent = $( this ).parent();
					var $menu = $parent.find( '#nav' );
					var $this = $( this );

					$parent.toggleClass( 'menu-on' );
					$( 'body' ).toggleClass( 'menu-on' );

					// Menu is shown.
					if ( $parent.hasClass( 'menu-on' ) ) {

						$menu.attr( 'aria-expanded', 'true' );
						$this.attr( 'aria-expanded', 'true' );

					// Menu is hidden.
					} else {

						$menu.attr( 'aria-expanded', 'false' );
						$this.attr( 'aria-expanded', 'false' );

					}

				}
			);

			// Fade post cover headers on scroll.
			$( window ).on(
				'scroll',
				function() {

					var new_opacity = 0.4 - $( window ).scrollTop() / 1300;
					// Don't change opacity on every scroll event to help smooth things out.
					if ( new_opacity >= 0 ) {
						$( '.post-cover .post-image' ).css( 'opacity', new_opacity );
					}

				}
			);

			// Display and hide search overlay modal.
			$( 'nav .search-toggle' ).on(
				'click',
				function() {
					var modal = $( '.search-modal' );
					modal.addClass( 'display' );
					modal.find( '.search-field' ).focus();
				}
			);

			$( '.search-modal .close' ).on(
				'click',
				function() {
					var modal = $( '.search-modal' );
					modal.removeClass( 'display' );
				}
			);

			// Dropdown menu touch screen improvements.
			$( '.menu' ).find( 'a' ).on(
				'focus blur',
				function() {

					$( this ).parents().toggleClass( 'focus' );

				}
			);

			// Smooth scroll to element.
			$( '.scroll-to' ).click(
				function() {

					return scroll_to_hash( this );

				}
			);

			$( '.jetpack-projects-page .projects-terms a' ).on(
				'click',
				function( e ) {

					e.preventDefault();

					// Add styles to filter links.
					var $this = $( this );
					var $parent = $this.parent();

					$parent.find( 'a' ).removeClass( 'current-page' );
					$this.addClass( 'current-page' );

					// Get selected tag to filter.
					var tag = $this.data( 'tag' );

					/**
					 * Filter the items.
					 */

					// Grab a list of all items to iterate through.
					var items = $grid.masonry( 'getItemElements' );

					// Items to reveal.
					var reveal_items = [];

					// Items to hide.
					var hide_items = [];

					// Tag to search for.
					var new_tag = 'jetpack-portfolio-type-' + tag;

					// Loop through items.
					$.each(
						items,
						function( i ) {
							// Store item to reference later.
							var item = items[i];

							// Get jquery version of item.
							var $element = $( item );

							// Is it the selected item or should we force it to be displayed.
							if ( $element.hasClass( new_tag ) || 'terminal-show-all' === tag ) {
								// Only display if currently invisble.
								if ( ! $element.is( ':visible' ) ) {
									// Make sure it's positioned with masonry.
									$grid.masonry( 'unignore', item );
									// Add to the reveal list.
									reveal_items.push( item );
								}
							} else {
								// Only hide if currently visible.
								if ( $element.is( ':visible' ) ) {
									// Remove from masonry layout.
									$grid.masonry( 'ignore', item );
									// Add to hide list.
									hide_items.push( item );
								}
							}
						}
					);

					// Hide items not in filter.
					$grid.masonry( 'hideItemElements', hide_items );
					// Display items to be shown.
					$grid.masonry( 'revealItemElements', reveal_items );
					// Do layout again.
					$grid.masonry( 'layout' );

				}
			);


			// Mobile device detection.
			$( 'body' ).addClass( is_touch_device() ? 'device-touch' : 'device-click' );

			// Pre-select password field on password protected post.
			$( '.post-password-form input[type="password"]' ).focus();

			// Add author icon to comment author titles.
			var user_icon = $( '.user-icon-container' ).html();
			$( '.bypostauthor > article .fn' ).append( user_icon );

			// Skip link fix.
			// based on https://github.com/Automattic/_s/blob/master/js/skip-link-focus-fix.js .
			var isWebkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1;
			var isOpera = navigator.userAgent.toLowerCase().indexOf( 'opera' ) > -1;
			var isIe = navigator.userAgent.toLowerCase().indexOf( 'msie' ) > -1;

			if ( ( isWebkit || isOpera || isIe ) && document.getElementById && window.addEventListener ) {
				window.addEventListener(
					'hashchange',
					function() {

						var id = location.hash.substring( 1 );

						if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
							return;
						}

						focus_element( id );

					},
					false
				);
			}
		}
	);

} )( window, document, jQuery );
