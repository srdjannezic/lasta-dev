<?php
/* 
Template Name: Iznajmljivanje vozila
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area pt-0">
        <div class="container p-0">
        <?php
                if ( have_posts() ) :
                    /* Start the Loop */
                    while ( have_posts() ) : the_post(); ?>
        <?php
        $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
        ?>
            <!-- Jumbotron -->
            <div class="jumbotron-fluid p-0" style="background-image: url('<?php echo $feat_image; ?>');background-repeat: no-repeat;background-size: cover;">
                <div class="text-white text-center rgba-stylish-strong py-5">
                    <div class="py-5">
                        <h1 class="card-title h1 my-4 py-2 page-title" style="display: table;background: #083f88a8;color: #fff !important;padding: 0 20px;">
                            <?php the_title(); ?>
                        </h1>
                    </div>
                </div>
            </div>
            <!-- Jumbotron -->
        </div>
        <div class="container">
            <div class="row pt-4">
                <div class="col-lg-12 pb-1">
                    <?php the_content(); ?>
                </div>
            </div>            
        </div>        
        <?php  
            endwhile;                    
            endif; ?>  
    </div><!-- #primary -->
</div><!-- .wrap -->
<?php
get_footer();