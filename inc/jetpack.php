<?php
/**
 * Jetpack Compatibility File
 *
 * @package Terminal
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
function terminal_jetpack_init() {

	// Add support for Infinite scroll.
	add_theme_support(
		'infinite-scroll',
		array(
			'container' => 'main-content',
			'footer_widgets' => 'sidebar-2',
			'footer' => 'footer-widgets',
			'posts_per_page' => 16,
			'render' => 'terminal_infinite_scroll_render',
			'wrapper' => false,
		)
	);

	// Add support for Featured Content.
	add_theme_support(
		'featured-content',
		array(
			'featured_content_filter' => 'terminal_get_featured_posts',
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
			// The default setting of the theme: 'content', 'excerpt' or array( 'content, 'excerpt', ).
			'blog-display' => 'excerpt',
			'author-bio' => true,
			'post-details' => array(
				'stylesheet' => 'terminal-style',
				'date' => '.posted-on',
				'categories' => '.tax-categories',
				'tags' => '.tax-tags',
			),
		)
	);

}

add_action( 'after_setup_theme', 'terminal_jetpack_init' );


/**
 * Render infinite scroll content using template parts.
 */
function terminal_infinite_scroll_render() {

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
function terminal_get_featured_posts() {

	return apply_filters( 'terminal_get_featured_posts', array() );

}


/**
 * Check if Jetpack Featured Content has any featured posts available.
 *
 * @param integer $minimum Minimum number of posts to return. If there's less than this return false.
 * @return boolean True if has featured posts, otherwise false.
 */
function terminal_has_featured_posts( $minimum = 1 ) {

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
	$featured_posts = apply_filters( 'terminal_get_featured_posts', array() );

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
function terminal_infinite_scroll_js_settings( $settings ) {

	// Change the text that is displayed in the 'More posts' button.
	// Posts is quite specific and doesn't work so well with custom post types.
	$settings['text'] = esc_html__( '&darr; Load More', 'terminal' );

	return $settings;

}

add_filter( 'infinite_scroll_js_settings', 'terminal_infinite_scroll_js_settings' );


/**
 * Get Jetpack Testimonials Title.
 */
function terminal_testimonials_title() {

	$jetpack_options = get_theme_mod( 'jetpack_testimonials' );

	if ( ! empty( $jetpack_options['page-title'] ) ) {
		echo esc_html( $jetpack_options['page-title'] );
	} else {
		esc_html_e( 'Testimonials', 'terminal' );
	}

}


/**
 * Retrieve and format Jetpack Testimonials description as set in theme Customiser.
 *
 * @param string $before html to display before testimonials description.
 * @param string $after html to display after testimonials description.
 * @return boolean|string Testimonials description, or false if no description exists.
 */
function terminal_testimonials_description( $before = '', $after = '' ) {

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
function terminal_testimonials_image() {

	$jetpack_options = get_theme_mod( 'jetpack_testimonials' );
	$image = '';

	if ( '' !== $jetpack_options['featured-image'] ) {

		$image = wp_get_attachment_image( (int) $jetpack_options['featured-image'], 'terminal-header' );

	}

	return $image;

}


/**
 * Flush rewrite rules for custom post types on theme setup and switch.
 *
 * This is so that Projects, Testimonials, and other Custom Post Types work as
 * expected. Is hooked into `after_switch_theme`.
 */
function terminal_flush_rewrite_rules() {

	flush_rewrite_rules();

}

add_action( 'after_switch_theme', 'terminal_flush_rewrite_rules' );


/**
 * Add breadcrumbs to a page.
 *
 * Breadcrumbs will not display on blog posts, but may display on other custom
 * post types.
 */
function terminal_breadcrumbs() {

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
function terminal_social_links() {

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
function terminal_remove_jetpack_stylesheets() {

	// Remove contact form styles.
	wp_dequeue_style( 'grunion.css' );

	// Remove infinite scroll styles.
	wp_dequeue_style( 'the-neverending-homepage' );

	// Remove related posts styles.
	wp_dequeue_style( 'jetpack_related-posts' );

}

add_action( 'wp_enqueue_scripts', 'terminal_remove_jetpack_stylesheets', 100 );


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
function terminal_video_wrapper( $html ) {

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
function terminal_related_posts_thumbnail_size( $thumbnail_size ) {

	$thumbnail_size['width'] = 400;
	$thumbnail_size['height'] = 300;

	return $thumbnail_size;

}

add_filter( 'jetpack_relatedposts_filter_thumbnail_size', 'terminal_related_posts_thumbnail_size' );


/**
 * The function to display Author Bio in a theme.
 *
 * @return null
 */
function terminal_author_bio() {

	$options = get_theme_support( 'jetpack-content-options' );
	$author_bio = ( ! empty( $options[0]['author-bio'] ) ) ? $options[0]['author-bio'] : null;

	// If the theme doesn't support "jetpack-content-options['author-bio']", don't continue.
	if ( true !== $author_bio ) {
		return;
	}

	// If "jetpack_content_author_bio" is false and we aren't in the customizer, don't continue.
	if ( ! get_option( 'jetpack_content_author_bio', 1 ) ) {
		return;
	}

	// If we aren't on a single post, don't continue.
	if ( ! is_single() ) {
		return;
	}

	// Display the author bio.
	terminal_contributor();

}
