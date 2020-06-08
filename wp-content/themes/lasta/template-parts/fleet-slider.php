<?php
/**
 * Template part for displaying Fleet Slider
 *
 * @package WordPress
 * @subpackage Lasta
 * @since 1.0
 * @version 1.0
 */

?>

<div id="home-slider" class="container px-lg-5 py-lg-0 py-4" data-aos="fade-in">
    <div class="row align-items-center no-gutters">
        <div class="col-lg-12 text-center section-title">
            <h2 class="decorated"><span>NAŠA FLOTA</span></h2>
        </div>
    </div>
    <div class="row align-items-center no-gutters px-lg-5">
        <div class="col-lg-9 mx-auto py-lg-3 px-lg-5">                        
            <div id="slider" class="flexslider">
                <ul class="slides">
                <?php $wp_query = new WP_Query(array(
                    'post__not_in' => array(191,208,205,203,190,200),
                    'post_type' => 'vozni_park',                    
                    'posts_per_page' => -1,
                    'order' => 'ASC' 
                )); 
                //query_posts( $args );
                // the Loop
                while ($wp_query -> have_posts()) : $wp_query -> the_post(); ?>
                <?php  if ( has_post_thumbnail() ) { ?>                                        
                    <li>
                        <a href="<?php the_permalink(); ?>" title="Detaljnije"><?php the_post_thumbnail('thumbnail','full'); ?></a>
                    </li>
                <?php } ?>
                <?php  endwhile; ?> 
                </ul>
            </div>
            <div id="carousel" class="flexslider pt-1">
                <ul class="slides">
                <?php $wp_query = new WP_Query(array(
                    'post__not_in' => array(191,208,205,203,190,200),
                    'post_type' => 'vozni_park',                    
                    'posts_per_page' => -1,
                    'order' => 'ASC'
                )); 
                //query_posts( $args );
                // the Loop
                while ($wp_query -> have_posts()) : $wp_query -> the_post(); ?>
                <?php  if ( has_post_thumbnail() ) { ?>
                    <li>
                        <?php the_post_thumbnail('thumbnail','full'); ?>
                    </li>
                        <?php } ?>
                    <?php  endwhile; ?>
                </ul>
            </div>
        </div>
    </div>
</div><!-- container -->