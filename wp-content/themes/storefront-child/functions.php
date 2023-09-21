<?php

/**
 * Storefront automatically loads the core CSS even if using a child theme as it is more efficient
 * than @importing it in the child theme style.css file.
 *
 * Uncomment the line below if you'd like to disable the Storefront Core CSS.
 *
 * If you don't plan to dequeue the Storefront Core CSS you can remove the subsequent line and as well
 * as the sf_child_theme_dequeue_style() function declaration.
 */
$roots_includes = array(
    '/includes/time-keeping.php'
  );
  
  foreach($roots_includes as $file){
    if(!$filepath = locate_template($file)) {
      trigger_error("Error locating `$file` for inclusion!", E_USER_ERROR);
    }
  
    require_once $filepath;
  }
  unset($file, $filepath);
//add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );

/**
 * Dequeue the Storefront Parent theme core CSS
 */
function sf_child_theme_dequeue_style() {
    wp_dequeue_style( 'storefront-style' );
    wp_dequeue_style( 'storefront-woocommerce-style' );
}

/**
 * Note: DO NOT! alter or remove the code above this text and only add your custom PHP functions below this text.
 */

/**
 * Display the theme credit
 *
 * @since  1.0.0
 * @return void
 */
function storefront_credit() {
	$links_output = '';

	if ( apply_filters( 'storefront_credit_link', true ) ) {
		if ( storefront_is_woocommerce_activated() ) {
			$links_output .= '<a href="https://woocommerce.com" target="_blank" title="' . esc_attr__( 'WooCommerce - The Best eCommerce Platform for WordPress', 'storefront' ) . '" rel="noreferrer">' . esc_html__( 'Built with Storefront &amp; WooCommerce', 'storefront' ) . '</a>.';
		} else {
			$links_output .= '<a href="https://woocommerce.com/storefront/" target="_blank" title="' . esc_attr__( 'Storefront -  The perfect platform for your next WooCommerce project.', 'storefront' ) . '" rel="noreferrer">' . esc_html__( 'Built with Storefront', 'storefront' ) . '</a>.';
		}
	}

	if ( apply_filters( 'storefront_privacy_policy_link', true ) && function_exists( 'the_privacy_policy_link' ) ) {
		$separator    = '<span role="separator" aria-hidden="true"></span>';
		$links_output = get_the_privacy_policy_link( '', ( ! empty( $links_output ) ? $separator : '' ) ) . $links_output;
	}

	$links_output = apply_filters( 'storefront_credit_links_output', $links_output );
	?>
	<div class="site-info">
		<div class="footer-manu">
			<ul>
				<li>
					<a href="https://rosecoded.com/about">About</a>
				</li>
				<li>
					<a href="https://rosecoded.com/project">Projects</a>
				</li>
				<li>
					<a href="https://rosecoded.com/contact">Contact</a>
				</li>
			</ul>
		</div>
		<p class="copyright">Copyright &copy; <?php echo gmdate( 'Y' ); ?> Rose Coded LLC. All Rights Reserved.</p>
	</div><!-- .site-info -->
	<?php
}
/**
 * Display the page header without the featured image
 *
 * @since 1.0.0
 */
function storefront_homepage_header() {
	edit_post_link( __( 'Edit this section', 'storefront' ), '', '', '', 'button storefront-hero__button-edit' );
	?>
	<?php
}
/**
 * Display the page header
 *
 * @since 1.0.0
 */
function storefront_page_header() {
	if ( is_front_page() && is_page_template( 'template-fullwidth.php' ) ) {
		return;
	}

	?>
	<?php
}
/**
 * Display the post header with a link to the single post
 *
 * @since 1.0.0
 */
function storefront_post_header() {
	?>
	<?php
}

// Remove image from product pages
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

// Remove sale badge from product page
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

// Remove product thumbnail from the cart page
add_filter( 'woocommerce_cart_item_thumbnail', '__return_empty_string' );

// Remove product images from the shop loop
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

// Remove sale badges from the shop loop
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );


/**
 * Change the breadcrumb separator
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_delimiter', 20 );
function wcc_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter']   = '<span class="breadcrumb-separator"> / </span>';
	$defaults['wrap_before'] = '<div class="storefront-breadcrumb"><div class="container"><nav class="woocommerce-breadcrumb row" aria-label="' . esc_attr__( 'breadcrumbs', 'storefront' ) . '">';
	$defaults['wrap_after']  = '</nav></div></div>';
	return $defaults;
}
//Remove default shop pagination
/**
 * Single Product Pagination
 *
 * @since 2.3.0
 */
function storefront_single_product_pagination() {
	if ( class_exists( 'Storefront_Product_Pagination' ) || true !== get_theme_mod( 'storefront_product_pagination' ) ) {
		return;
	}

	// Show only products in the same category?
	$in_same_term   = apply_filters( 'storefront_single_product_pagination_same_category', true );
	$excluded_terms = apply_filters( 'storefront_single_product_pagination_excluded_terms', '' );
	$taxonomy       = apply_filters( 'storefront_single_product_pagination_taxonomy', 'product_cat' );

	$previous_product = storefront_get_previous_product( $in_same_term, $excluded_terms, $taxonomy );
	$next_product     = storefront_get_next_product( $in_same_term, $excluded_terms, $taxonomy );

	if ( ! $previous_product && ! $next_product ) {
		return;
	}

	?>
	
	<!-- .storefront-product-pagination -->
	<?php
}

//Admin CSS
add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '
  <style>
	#wpcontent, #wpfooter {
		padding-right: 20px;
	}
  </style>';
}
