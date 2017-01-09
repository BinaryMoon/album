<?php
/**
 * Actions and Filters That Customize WordPress
 *
 * Set up the theme and provide helper functions. These functions are attached
 * to action and filter hooks in WordPress to change core functionality.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Album
 * @subpackage WordPress
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

/**
 * Enqueue scripts, styles, and fonts.
 *
 * Also sets javascript properties that need to access PHP.
 * Fonts are created with {@see album_fonts}.
 *
 * @global array $wp_scripts
 */
function album_enqueue() {

	// Styles.
	wp_enqueue_style( 'album-style', get_stylesheet_uri(), null, '1.15' );

	// Fonts.
	$fonts_url = album_fonts();

	if ( $fonts_url ) {
		wp_enqueue_style( 'album-fonts', $fonts_url, array(), null );
	}

	// Javascript.
	// Always loaded in customizer for cases where widgets are added to an empty sidebar.
	if ( is_active_sidebar( 'sidebar-2' ) || is_page_template( 'templates/portfolio-page.php' ) || is_customize_preview() ) {
		wp_enqueue_script( 'masonry' );
	}

	wp_enqueue_script( 'album-script-main', get_theme_file_uri( '/assets/scripts/global.js' ), array( 'jquery' ), '1.2', false );

	if ( album_has_featured_posts() ) {
		wp_enqueue_script( 'album-script-slider', get_theme_file_uri( '/assets/scripts/jquery.slider.js' ), array( 'jquery' ), '1.5.1', false );
	}

	// Localized Javascript strings and provide access to common properties.
	wp_localize_script(
		'album-script-main',
		'album_site_settings',
		array(
			// Translation strings.
			'i18n' => array(
				'slide_next' => esc_html__( 'Next Slide', 'album' ),
				'slide_prev' => esc_html__( 'Previous Slide', 'album' ),
				/* translators: # is the slide number, it will be replaced with 1/ 2/ 3 etc */
				'slide_number' => esc_html__( 'Slide #', 'album' ),
				'slide_controls_label' => esc_html__( 'Slider Buttons', 'album' ),
				'menu' => esc_html__( 'Menu', 'album' ),
			),
			// Slider settings.
			'slider' => array(
				'autoplay' => ( get_theme_mod( 'album_autoplay_slider', true ) ) ? 1 : 0,
			),
			// Properties that are usable through javascript.
			'is' => array(
				'home' => is_front_page(),
				'single' => is_single(),
				'archive' => is_archive(),
			),
		)
	);

	// Comments Javascript.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

add_action( 'wp_enqueue_scripts', 'album_enqueue' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * The theme is responsive so the width is likely to be narrower than the value
 * set.
 * Uses Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function album_content_width() {

	$width = 900;

	// If using 'full width' template.
	if ( is_page_template( 'templates/full-width-page.php' ) ) {

		$width = 780;

	}

	$GLOBALS['content_width'] = apply_filters( 'album_content_width', $width );

}

add_action( 'after_setup_theme', 'album_content_width', 0 );


/**
 * Get url for embedding Google fonts.
 *
 * Output can be filtered with 'album_fonts' filter.
 *
 * @return string|boolean Font url or false if there are no fonts.
 */
function album_fonts() {

	$fonts = array();

	/* translators: If there are characters in your language that are not supported by Roboto Mono, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== esc_html_x( 'on', 'Roboto Mono: on or off', 'album' ) ) {
		$fonts['roboto-mono'] = 'Roboto Mono:400,700';
	}

	/* translators: If there are characters in your language that are not supported by Roboto, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== esc_html_x( 'on', 'Roboto: on or off', 'album' ) ) {
		$fonts['roboto'] = 'Roboto:100,400,700';
	}

	// Filter fonts. Allows them to be disabled/ added to.
	$fonts = apply_filters( 'album_fonts', $fonts );

	if ( $fonts ) {
		// Build font embed query string.
		$query_args = array(
			'family' => rawurlencode( implode( '|', $fonts ) ),
			'subset' => rawurlencode( 'latin,latin-ext' ),
		);

		return add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return false;

}


/**
 * Add preconnect for Google Fonts.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed.
 * @return array URLs to print for resource hints.
 */
function album_resource_hints( $urls, $relation_type ) {

	if ( wp_style_is( 'album-fonts', 'queue' ) && 'preconnect' === $relation_type ) {

		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);

	}

	return $urls;

}

add_filter( 'wp_resource_hints', 'album_resource_hints', 10, 2 );


/**
 * Set up all the theme properties and extras.
 *
 * Also adds fonts to editor styles {@see album_fonts}.
 */
function album_after_setup_theme() {

	load_theme_textdomain( 'album', get_template_directory() . '/languages' );

	// Title Tag.
	add_theme_support( 'title-tag' );

	// Feed me.
	add_theme_support( 'automatic-feed-links' );

	// Post thumbnails.
	add_theme_support( 'post-thumbnails' );

	// Attachment (image.php) page links.
	add_image_size( 'album-attachment', 250, 250, true );

	// Ideal header image size.
	add_image_size( 'album-header', 1500, 500, true );

	// Archive/ homepage thumbnails.
	add_image_size( 'album-archive', 900, 600, true );

	// Archive/ homepage thumbnails.
	add_image_size( 'album-archive-project', 600, 9999 );

	// Image for slider and post/ page headers. This needs to be big because it
	// will is fixed position with size set to cover, which means it will be
	// sized to fill the users monitor.
	add_image_size( 'album-post-cover', 1500, 900, true );

	// Add selective refresh to widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Attachment page size.
	add_image_size( 'album-attachment-fullsize', 1200, 9999 );

	// Custom background.
	add_theme_support(
		'custom-background',
		apply_filters(
			'album_custom_background',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// HTML5 FTW.
	add_theme_support(
		'html5',
		array(
			'comment-list',
			'comment-form',
			'gallery',
			'caption',
		)
	);

	// Post Formats.
	add_theme_support(
		'post-formats',
		array(
			'quote',
			'video',
			'image',
			'gallery',
			'audio',
		)
	);

	// Custom Logo.
	add_theme_support(
		'custom-logo',
		array(
			'height' => 500,
			'width' => 500,
			'flex-height' => true,
			'flex-width' => true,
		)
	);

	// Menus.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Header Top', 'album' ),
		)
	);

	// Editor Style.
	if ( $fonts_url = album_fonts() ) {
		add_editor_style( $fonts_url );
	}

	add_editor_style( 'assets/css/editor-styles.css' );

}

add_action( 'after_setup_theme', 'album_after_setup_theme' );


/**
 * Intitiate sidebars
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 */
function album_widgets_init() {

	// Sidebar.
	register_sidebar(
		array(
			'name' => esc_html__( 'Sidebar Widgets', 'album' ),
			'id' => 'sidebar-1',
			'description' => esc_html__( 'Widgets that display on the side of your website', 'album' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'after_widget' => '</div></section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);

	// Footer Widgets.
	register_sidebar(
		array(
			'name' => esc_html__( 'Footer Widgets', 'album' ),
			'id' => 'sidebar-2',
			'description' => esc_html__( 'Widgets that display at the bottom of your website. They are arranged in 4 columns and lined up automatically to make the best use of the space available.', 'album' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'after_widget' => '</div></section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);

}

add_action( 'widgets_init', 'album_widgets_init' );


/**
 * Set a custom excerpt length.
 *
 * The WordPress default excerpt length is 55.
 *
 * @param int $length length of excerpt.
 * @return int
 */
function album_excerpt_length( $length ) {

	return 60;

}

add_filter( 'excerpt_length', 'album_excerpt_length', 999 );


/**
 * Fallback for navigation menu
 *
 * @param array $params list of menu parameters.
 * @return string
 */
function album_nav_menu( $params ) {

	$echo = $params['echo'];

	$params['echo'] = false;
	$html = wp_page_menu( $params );

	if ( $params['container'] ) {

		$container_start = '<' . esc_attr( $params['container'] ) . ' id="' . esc_attr( $params['container_id'] ) . '" class="' . esc_attr( $params['container_class'] ) . '">';
		$container_end = '</' . esc_attr( $params['container'] ) . '>';

		$html = str_replace( '<div class="' . esc_attr( $params['menu_class'] ) . '">', $container_start, $html );
		$html = str_replace( '</div>', $container_end, $html );

	}

	/**
	 * Apply standard WordPress filter so that html can still be modified by
	 * plugins.
	 */
	apply_filters( 'wp_nav_menu', $html, $params );

	if ( $echo ) {
		echo $html; // WPCS: XSS OK.
	}

	return $html;

}


/**
 * Add additional body classes to body_class function call.
 *
 * Checks to see if theme has featured posts using {@see album_has_featured_posts}.
 *
 * @param array $classes Array of body classes.
 * @return array
 */
function album_body_class( $classes ) {

	if ( is_multi_author() ) {
		$classes[] = 'multi-author-true';
	} else {
		$classes[] = 'multi-author-false';
	}

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'themes-sidebar1-active';
	}

	if ( is_active_sidebar( 'sidebar-2' ) ) {
		$classes[] = 'themes-sidebar2-active';
	}

	if ( album_has_featured_posts() ) {
		$classes[] = 'themes-has-featured-posts';
	}

	if ( display_header_text() ) {
		$classes[] = 'has-site-title';
	}

	if ( get_header_image() ) {
		$classes[] = 'has-custom-header';
	}

	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;

}

add_filter( 'body_class', 'album_body_class' );


/**
 * Add additional post classes to post_class function call.
 *
 * @link https://core.trac.wordpress.org/ticket/28482
 * @param array $classes Array of post classes.
 * @return array
 */
function album_post_class( $classes ) {

	if ( $image = get_the_post_thumbnail( get_the_ID() ) ) {

		$classes[] = 'post-has-thumbnail';

	} else {

		$classes[] = 'post-no-thumbnail';

	}

	/**
	 * Removes hentry class from the array of post classes.
	 * Currently, having the class on pages is not correct use of hentry.
	 * hentry requires more properties than pages typically have.
	 * Core is not likely to remove class because of backward compatibility.
	 */
	if ( 'page' === get_post_type() ) {

		$classes = array_diff( $classes, array( 'hentry' ) );

	}

	/**
	 * Remove this if you need to add text contrast to images
	if ( isset( $image[0] ) ) {

		$tone = album_image_tone( $image[0] );

		if ( $tone ) {
			$classes[] = $tone;
		}
	}
	 */

	return $classes;

}

add_filter( 'post_class', 'album_post_class' );


/**
 * Add post terms (categories and tags) to the_content.
 *
 * Using this through the_content filter places it before the related posts,
 * social sharing, and other Jetpack content, which gives it more context.
 *
 * @param string $content The original post content.
 * @return string The modified post content.
 */
function album_post_terms( $content = '' ) {

	// Ignore if on archive pages.
	if ( ! is_single() ) {
		return $content;
	}

	// Make sure it only happens on blog posts.
	if ( 'post' !== get_post_type( get_the_ID() ) ) {
		return $content;
	}

	$terms = '';

	// Add Categories.
	$terms .= '<p class="taxonomy tax-categories">' . get_the_category_list( esc_html_x( ', ', 'Category/ Tag list separator (includes a space after the comma)', 'album' ) ) . '</p>';

	// Add Tags.
	if ( get_the_tags( get_the_ID() ) ) {
		$terms .= '<p class="taxonomy tax-tags">' . get_the_tag_list( '', esc_html_x( ', ', 'Category/ Tag list separator (includes a space after the comma)', 'album' ), '' ) . '</p>';
	}

	// Output everything.
	$content .= '<div class="taxonomies">' . $terms . '</div>';

	return $content;

}

add_filter( 'the_content', 'album_post_terms' );


/**
 * Wrap post content with a standard div that can be styled in any way.
 *
 * This means the content can be customized without affecting other things that
 * get appended/ prepended to the_content such as Jetpack related posts.
 *
 * @param string $content The content to be wrapped.
 * @return string Modified content with html wrapper.
 */
function album_wrapper_content( $content ) {

	if ( ! is_singular() ) {

		return $content;

	}

	if ( empty( $content ) ) {

		return $content;

	}

	// Includes some new line characters so that paragraphs tags are properly applied to all paragraphs.
	return '<div class="the-content">' . "\n\n" . $content . "\n\n" . '</div>';

}

add_filter( 'the_content', 'album_wrapper_content', 9 );


/**
 * Add a span around the title prefix so that the prefix can be hidden with CSS
 * if desired.
 *
 * @param string $title Archive title.
 * @return string Archive title with inserted span around prefix.
 */
function album_wrap_the_archive_title( $title ) {

	// Skip if the site isn't LTR, this is visual, not functional.
	// Should try to work out an elegant solution that works for both directions.
	if ( is_rtl() ) {
		return $title;
	}

	// Split the title into parts so we can wrap them with spans.
	$title_parts = explode( ': ', $title, 2 );

	// Glue it back together again.
	if ( ! empty( $title_parts[1] ) ) {
		$title = '<span>' . esc_html( $title_parts[0] ) . ': </span>' . wp_kses( $title_parts[1], array( 'span' => array( 'class' => array() ) ) );
	}

	return $title;

}

add_filter( 'get_the_archive_title', 'album_wrap_the_archive_title' );


/**
 * Add a span to the category and tag listings.
 *
 * Gives them consistent html for simpler CSS styles.
 *
 * @param string $cat_list HTML containing list of categories/ tags.
 * @return string
 */
function album_category_list_span( $cat_list ) {

	$cat_list = str_replace( 'tag">', 'tag"><span>', $cat_list );
	$cat_list = str_replace( '</a>', '</span></a>', $cat_list );

	return $cat_list;

}

add_filter( 'the_category', 'album_category_list_span' );
add_filter( 'the_tags', 'album_category_list_span' );


/**
 * Standardize menu classes.
 *
 * Reduces inconsistencies in menu classes.
 * These occur when using pages/ categories as the menu fallback.
 * This allows the css styles to be simpler since we only have to accomadate one
 * menu class.
 *
 * @param string $menu_html Page menu in a html list.
 * @return string
 */
function album_change_menu( $menu_html = '' ) {

	$menu_html = str_replace( 'page_item_has_children', 'menu-item-has-children', $menu_html );

	return $menu_html;

}

add_filter( 'wp_page_menu','album_change_menu' );


/**
 * Change the colour of the Google url bar to match the background colour of the
 * site.
 *
 * This helps to improve branding and personalisation.
 *
 * @link https://developers.google.com/web/updates/2014/11/Support-for-theme-color-in-Chrome-39-for-Android
 */
function album_theme_colour() {

	// Use the user defined background colour.
	$colour = get_background_color();

	if ( ! empty( $colour ) ) {
?>
		<meta name="theme-color" content="#<?php echo esc_attr( $colour ); ?>">
<?php
	}

}

add_filter( 'wp_head', 'album_theme_colour' );


/**
 * Standardize wp_link_pages html so that it matches that used in
 * the_posts_pagination.
 *
 * This allows simpler styling, and consistent CSS.
 *
 * @param  string $html Link html.
 * @return string       Modified html.
 */
function album_link_pages_link( $html ) {

	$html = str_replace( '<a ', '<a class="page-numbers" ', $html );

	// No link so must be the current page.
	if ( false === strpos( $html, '<a ' ) ) {

		$html = '<span class="page-numbers current">' . $html . '</span>';

	}

	return $html;

}

add_filter( 'wp_link_pages_link', 'album_link_pages_link' );


/**
 * Include svg symbols so that they can be 'used' with the {@see album_svg}
 * function.
 *
 * This uses `wp_footer` to place the svgs at the bottom of the page, which now
 * works in all major browsers.
 */
function album_include_svg_icons() {

	// Define SVG sprite file.
	$svg_icons = get_template_directory() . '/assets/svg/svg.svg';

	// If it exists, include it.
	if ( file_exists( $svg_icons ) ) {

		// The '.svg-defs' class is hidden so that the reusable svgs are not
		// visible.
		echo '<span class="svg-defs">';
		require_once( $svg_icons );
		echo '</span>';

	}

}

add_action( 'wp_footer', 'album_include_svg_icons' );


/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function album_pingback_header() {

	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '">';
	}

}

add_action( 'wp_head', 'album_pingback_header' );


/**
 * Add search at the end of the menu.
 *
 * @param  string $html The existing menu html.
 * @param  object $args The menu parameters from the original menu object.
 * @return string
 */
function album_nav_menu_html( $html, $args ) {

	// Only display this in the top menu.
	if ( 'menu-1' !== $args->theme_location ) {
		return $html;
	}

	// Item to search for.
	$search = '</ul>';

	// Search button to add to end of menu.
	$replace = '<li class="search"><button type="button">' . album_svg( 'search', false ) . '</button></li>';

	// Location of end of menu.
	// Note: this is strRpos - so searches from the end of the string to find
	// the last item.
	$pos = strrpos( $html, $search );

	// Make sure end of menu is found.
	if ( false !== $pos ) {
		// Insert Item.
		$html = substr_replace( $html, $replace, $pos, strlen( $search ) );
	}

	return $html;

}

add_filter( 'wp_nav_menu', 'album_nav_menu_html', 10, 2 );
