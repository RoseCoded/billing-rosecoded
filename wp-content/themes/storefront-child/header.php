<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<link rel="stylesheet" href="https://www.rosecoded.com/plugins/bootstrap/css/bootstrap.min.css" media='screen'>
<link rel="stylesheet" href="/wp-content/themes/storefront-child/ionicons.min.css" >
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php do_action( 'storefront_before_site' ); ?>

<div id="page" class="hfeed site">
	<?php do_action( 'storefront_before_header' ); ?>
	<header class="navigation">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<nav class="navbar">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="/">
							<img src="/wp-content/themes/storefront-child/logo.png" alt="Rose Coded | IT Cooperative" width="150px" class="img-responsive">
							</a>
						</div>
						<div class="collapse navbar-collapse" id="navigation">
							<ul class="nav navbar-nav navbar-right">
								<li><a href="/">Home</a></li>
								<li><a href="/about">About</a></li>
								<li><a href="/project">Projects</a></li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">More <span class="ion-ios-arrow-down"></span></a>
									<ul class="dropdown-menu">
									<li><a href="/techsupport">Tech Support</a></li>
									</ul>
								</li>
								<li><a href="/contact">Contact</a></li>
							</ul>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</header>
	<!-- <section class="top-banner" style="background-image: url('https://www.rosecoded.com/images/feature-bg.jpg');"> -->
	<section class="top-banner">
		<div class="container">
			<div class="row">
			<div class="col-md-12">
				<div class="block">
					<h1 class="entry-title"><?php echo woocommerce_page_title(); ?></h1>
				</div>
			</div>
			</div>
		</div>
	</section>
	<?php
	/**
	 * Functions hooked in to storefront_before_content
	 *
	 * @hooked storefront_header_widget_region - 10
	 * @hooked woocommerce_breadcrumb - 10
	 */
	do_action( 'storefront_before_content' );
	?>

	<div id="content" class="site-content container" tabindex="-1">
		<div class="row">
		<?php
		do_action( 'storefront_content_top' );
