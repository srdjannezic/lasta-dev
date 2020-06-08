<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

		
    </div><!-- #content -->
    <a href="#" class="topbutton"></a>
		<footer id="footer" class="site-footer" role="contentinfo">
            <div class="container footer-top">
                <div class="row">
                    <div class="col d-flex flex-column py-4">
                        <?php dynamic_sidebar( 'sidebar-2' ); ?>
                    </div>
                    <div class="col d-flex flex-column py-4">
                        <?php dynamic_sidebar( 'sidebar-3' ); ?>
                    </div>
                    <div class="col d-flex flex-column py-4">
                        <?php dynamic_sidebar( 'sidebar-4' ); ?>
                    </div>
                    <div class="col d-flex flex-column py-4">
                        <?php dynamic_sidebar( 'sidebar-6' ); ?>
                    </div>
                    <div class="col d-flex flex-column justify-content-between py-4">
                        <?php dynamic_sidebar( 'sidebar-7' ); ?>
                    </div>
                </div><!-- .wrap -->                
            </div>
            <div class="footer-btm">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <p class="copy text-white d-inline-block mb-0">&copy; <?php echo date('Y'); ?> SP Lasta. Sva prava zadržana.</p>
                            <p class="copy text-white d-inline-block"> Izrada sajta <a class="text-white" href="https://titandizajn.com/" title="Titan dizajn">Titan Dizajn</a></p>
                        </div>
                    </div>
                </div>
            </div>
		</footer><!-- footer -->
	</div><!-- site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
