<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<script type="text/javascript">
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
</script>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<div id="page" class="site">
		<header id="masthead" class="site-header" role="banner">
			<nav class="navbar navbar-expand-md navbar-light bg-white px-0 pb-0">
				<div class="container p-0">
					<!-- custom calls to options stored in Admin section "Theme Options" to display the logo or not -->
					<a class="navbar-brand pl-3 pl-lg-0" id="logo" href="<?php echo site_url(); ?>"><img src="/wp-content/uploads/2020/01/logo.png" alt="Lasta Logo" class="img-responsive logo"/></a>
					<!-- custom calls to options stored in Admin section "Theme Options" to display the logo or not -->
					<button class="navbar-toggler first-button pr-3" type="button" data-toggle="collapse" data-target="#bootstrap-nav-collapse" aria-controls="jd-bootstrap-nav-collapse" aria-expanded="false" aria-label="Toggle navigation">
					<div class="animated-icon1"><span></span><span></span><span></span></div>
					</button>
					<!-- Mobile Burger Animation-->
					<script type="text/javascript">
					jQuery(document).ready(function () {

						jQuery('.first-button').on('click', function () {
						jQuery('.animated-icon1').toggleClass('open');
						});					
						});
					</script>				

					<!-- Collect the nav links from WordPress -->
					<div class="collapse navbar-collapse pl-4" id="bootstrap-nav-collapse">         
						<?php 

					$args = array(
						'theme_location' => 'mega_menu', // primary_menu or mega-menu
						'depth' => 0,
						'container' => '',
						'menu_class'  => 'navbar-nav mr-auto',
						'walker'  => new BootstrapNavMenuWalker()
						);
					wp_nav_menu($args);
					?>
					</div><!-- ./collapse -->
				</div><!-- /.container -->
			</nav>
			<?php the_breadcrumb(); ?>
		</header><!-- #masthead -->
		<div class="site-content-contain">
			<div id="content" class="site-content pt-0">
