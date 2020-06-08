<?php
/* 
Template Name: Gradsko prigradski
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area pt-0">
        
        <div id="gradski-search" class="container-fluid p-0">
        <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
            <!-- Jumbotron -->                    
            <div class="jumbotron-fluid" style="background-image: url('<?php echo $feat_image ?>');background-repeat: no-repeat;background-size: cover;min-height:500px;">
                <?php get_template_part( 'template-parts/gradski-search', 'none' ); ?>
            </div><!-- Jumbotron -->
            <div id="gradski-results" class="container">                
                <div class="col-lg-12">
                    <?php echo facetwp_display( 'template', 'gradsko_prigradske' ) ?>
                </div>
            </div>
        </div><!-- #gradski-search -->       
    </div><!-- #primary -->
</div><!-- .wrap -->
<?php
get_footer();