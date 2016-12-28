<?php
/**
 * Jetpack Compatibility File
 *
 * @package Album
 * @subpackage Jetpack
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @link https://jetpack.com/
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

/**
 * Add theme support for Jetpack plugin features.
 *
 * @link https://jetpack.com/support/infinite-scroll/
 * @link https://jetpack.com/support/featured-content/
 * @link https://jetpack.com/support/custom-content-types/
 * @link https://jetpack.com/support/responsive-videos/
 * @link https://jetpack.com/support/social-menu/
 */
function album_jetpack_init() {

	// Add support for Infinite scroll.
	add_theme_support(
		'infinite-scroll',
		array(
			'container' => 'main-content',
			'footer_widgets' => 'sidebar-2',
			'footer' => 'footer-widgets',
			'posts_per_page' => 16,
			'render' => 'album_infinite_scroll_render',
			'wrapper' => false,
		)
	);

	// Add support for Featured Content.
	add_theme_support(
		'featured-content',
		array(
			'featured_content_filter' => 'album_get_featured_posts',
			'max_posts' => 4,
			'post_types' => array( 'post', 'page', 'jetpack-portfolio' ),
		)
	);

	// Add support for Testimonials.
	add_theme_support( 'jetpack-testimonial' );

	// Add support for Portfolio and Projects.
	add_theme_support( 'jetpack-portfolio' );

	// Add support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add support for Social Menu.
	add_theme_support( 'jetpack-social-menu' );

	// Add support for wordpress.com content options.
	add_theme_support(
		'jetpack-content-options',
		array(
			'blog-display' => 'excerpt',			// The default setting of the theme: 'content', 'excerpt' or array( 'content, 'excerpt', ).
			'author-bio' => true,					// Display or not the author bio: true or false.
			'masonry' => '#main-content',		// A CSS selector matching the elements that triggers a masonry refresh if the theme is using a masonry layout.
			'post-details' => array(
				'stylesheet' => 'album-style',	// Name of the theme's stylesheet.
				'date' => '.posted-on',		// A CSS selector matching the elements that display the post date.
				'categories' => '.tax-categories',	// A CSS selector matching the elements that display the post categories.
				'tags' => '.tax-tags',		// A CSS selector matching the elements that display the post tags.
				'author' => '.byline',			// A CSS selector matching the elements that display the post author.
			),
			'featured-images' => array(
				'archive' => true, // Enable or not the featured image check for archive pages: true or false
				'post' => true, // Enable or not the featured image check for single posts: true or false
				'page' => true, // Enable or not the featured image check for single pages: true or false
				'archive-default' => true, // The default setting of the featured image on archive pages, if it's enabled or not: true or false
				'post-default' => true, // The default setting of the featured image on single posts, if it's enabled or not: true or false
				'page-default' => true, // The default setting of the featured image on single pages, if it's enabled or not: true or false
			),
		)
	);
	/**
	 * Add support for colour contrast checker.
	 * add_theme_support( 'tonesque' );
	 */

}

add_action( 'after_setup_theme', 'album_jetpack_init' );


/**
 * Render infinite scroll content using template parts.
 */
function album_infinite_scroll_render() {

	while ( have_posts() ) {

		the_post();

		get_template_part( 'parts/content', 'format-' . get_post_format() );

	}

}


/**
 * Get featured posts using Jetpack Featured content
 *
 * @return array List of featured posts.
 */
function album_get_featured_posts() {

	return apply_filters( 'album_get_featured_posts', array() );

}


/**
 * Check if Jetpack Featured Content has any featured posts available.
 *
 * @param integer $minimum Minimum number of posts to return. If there's less than this return false.
 * @return boolean True if has featured posts, otherwise false.
 */
  function album_has_featured_posts( $minimum = 1 ) {

	// Only show if on the front page or the blog page.
	if ( ! is_front_page() && ! is_home() ) {
		return false;
	}

	// Disable featured content on the portfolio template.
	if ( is_page_template( 'templates/portfolio-page.php' ) ) {
		return false;
	}

	// Don't show if not on the first page.
	if ( is_paged() ) {
		return false;
 	}

	$minimum = absint( $minimum );
	$featured_posts = apply_filters( 'album_get_featured_posts', array() );

	if ( ! is_array( $featured_posts ) ) {
		return false;
	}

	if ( $minimum > count( $featured_posts ) ) {
		return false;
	}

	return true;

}


/**
 * Change default Jetpack Infinite Scroll settings.
 *
 * @param array $settings Default Infinite Scroll settings.
 * @return array Modified Infinite Scroll settings.
 */
function album_infinite_scroll_js_settings( $settings ) {

	// Change the text that is displayed in the 'More posts' button.
	// Posts is quite specific and doesn't work so well with custom post types.
	$settings['text'] = esc_html__( '&darr; Load More', 'album' );

	return $settings;

}

add_filter( 'infinite_scroll_js_settings', 'album_infinite_scroll_js_settings' );


/**
 * Get Jetpack Testimonials Title.
 */
function album_testimonials_title() {

	$jetpack_options = get_theme_mod( 'jetpack_testimonials' );

	if ( ! empty( $jetpack_options['page-title'] ) ) {
		echo esc_html( $jetpack_options['page-title'] );
	} else {
		esc_html_e( 'Testimonials', 'album' );
	}

}


/**
 * Retrieve and format Jetpack Testimonials description as set in theme Customiser.
 *
 * @param string $before html to display before testimonials description.
 * @param string $after html to display after testimonials description.
 * @return boolean|string Testimonials description, or false if no description exists.
 */
function album_testimonials_description( $before = '', $after = '' ) {

	$jetpack_options = get_theme_mod( 'jetpack_testimonials' );
	$content = '';

	if ( ! empty( $jetpack_options['page-content'] ) ) {
		$content = $jetpack_options['page-content'];
		$content = addslashes( $content );
		$content = wp_filter_post_kses( $content );
		$content = stripslashes( $content );
		$content = wptexturize( $content );
		$content = convert_smilies( $content );
		$content = convert_chars( $content );
	}

	if ( $content ) {
		echo $before . $content . $after; // WPCS: XSS OK.
	}

	return false;

}


/**
 * Get Jetpack Testimonials Image.
 *
 * @return string Testimonials image or empty string if no image set.
 */
function album_testimonials_image() {

	$jetpack_options = get_theme_mod( 'jetpack_testimonials' );
	$image = '';

	if ( '' !== $jetpack_options['featured-image'] ) {

		$image = wp_get_attachment_image( (int) $jetpack_options['featured-image'], 'album-header' );

	}

	return $image;

}


/**
 * Flush rewrite rules for custom post types on theme setup and switch.
 *
 * This is so that Projects, Testimonials, and other Custom Post Types work as
 * expected. Is hooked into `after_switch_theme`.
 */
function album_flush_rewrite_rules() {

	flush_rewrite_rules();

}

add_action( 'after_switch_theme', 'album_flush_rewrite_rules' );


/**
 * Add breadcrumbs to a page.
 *
 * Breadcrumbs will not display on blog posts, but may display on other custom
 * post types.
 */
function album_breadcrumbs() {

	// Check Jetpack Breadcrumbs are available before outputting them.
	if ( function_exists( 'jetpack_breadcrumbs' ) ) {

		jetpack_breadcrumbs();

	}

}


/**
 * Display social links using a custom menu.
 *
 * This is a wrapper for 'jetpack_social_menu' and stops PHP errors if Jetpack
 * is not enabled.
 */
function album_social_links() {

	// Check Jetpack Social Menu is available before trying to display it.
	if ( function_exists( 'jetpack_social_menu' ) ) {

		jetpack_social_menu();

	}

}


/**
 * Remove some of the default Jetpack styles.
 *
 * The styles are taken care of by the default theme styles, so custom styles are not required.
 */
function album_remove_jetpack_stylesheets() {

	// Remove contact form styles.
	wp_dequeue_style( 'grunion.css' );

	// Remove infinite scroll styles.
	wp_dequeue_style( 'the-neverending-homepage' );

	// Remove related posts styles.
	wp_dequeue_style( 'jetpack_related-posts' );

}

add_action( 'wp_enqueue_scripts', 'album_remove_jetpack_stylesheets', 100 );


/**
 * Stop Jetpack from concatenating internal CSS.
 *
 * We dequeue a number of the Jetpack styles so this stops them from being loaded.
 */
add_filter( 'jetpack_implode_frontend_css', '__return_false' );


/**
 * Use the Jetpack Video Embed HTML to make sure the video post types are responsive.
 *
 * Has a simple fallback in case Jetpack is not being used.
 *
 * @param string $html Video html.
 * @return string html wrapper with the video wrapper.
 */
function album_video_wrapper( $html ) {

	// If Jetpack integrated function exists then uses that.
	if ( function_exists( 'jetpack_responsive_videos_embed_html' ) ) {

		return jetpack_responsive_videos_embed_html( $html );

	// If not they use this. It does enough that I we can style the videos with css.
	} else {

		return '<div class="jetpack-video-wrapper">' . $html . '</div>';

	}

}


/**
 * Change the size of the Related Posts thumbnail images.
 *
 * This improves display of the related posts images on larger screens and
 * retina screens. It also makes the responsive styles work more nicely since
 * the images fill the screen better.
 *
 * @param array $thumbnail_size Default thumbnail properties.
 * @return array
 */
function album_related_posts_thumbnail_size( $thumbnail_size ) {

	$thumbnail_size['width'] = 500;
	$thumbnail_size['height'] = 330;

	return $thumbnail_size;

}

add_filter( 'jetpack_relatedposts_filter_thumbnail_size', 'album_related_posts_thumbnail_size' );


/**
 * Get a post class based upon the colours of the specified image.
 *
 * Uses Jetpacks Tonesque - which must be initialised before this function will work.
 * Will return 'foreground-dark' if the text colour should be black, and 'foreground-light'
 * if the text colour should be white.
 *
 * @param array $image Image to check the brightness of.
 * @return array
 */
function album_image_tone( $image ) {

	if ( ! class_exists( 'Tonesque' ) ) {

		return false;

	}

	if ( $image ) {

		// Add a light or dark class depending upon the image.
		$contrast = new Tonesque( $image );
		$contrast->color();
		$black_or_white = $contrast->contrast();

		if ( '0,0,0' === $black_or_white ) {
			$class = 'foreground-dark';
		} else {
			$class = 'foreground-light';
		}
	}

	return $class;

}
