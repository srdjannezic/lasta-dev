<?php
/* 
Template Name: Prodajna mesta  
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
                <div class="text-white text-left rgba-stylish-strong py-5">
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
            <div class="row">
                <div class="col-lg-12 about-mesta pt-4">
                     <?php   the_content();
                    endwhile;
                    endif; ?>                   
                </div>
            </div>    
        </div>
        <div class="container" style="overflow-x:hidden;">
            <div class="row">
                <div class="col-lg-12 mesta-select pt-4">
                    <h3 class="text-center">INFORMACIJE I PRODAJNA MESTA</h3>
                    <?php echo facetwp_display( 'facet', 'poslovnice' ) ?>
                </div>
                <div class="col-lg-12 prod-mesta pt-4">
                    <?php echo facetwp_display( 'template', 'lista-poslovnica' ) ?>
                </div>
            </div>    
        </div>            
        <script type="text/javascript">
            jQuery(document).on('facetwp-loaded', function() {
                jQuery('.facetwp-hierarchy_select:first-of-type').addClass('custom-select select-first col-lg-6 mx-4');   
                jQuery('.facetwp-hierarchy_select:last-of-type').addClass('custom-select select-second col-lg-6 mx-4');
                jQuery('.facetwp-facet-poslovnice').addClass('row mx-0');

                // jQuery('.select-first').before('<label>Drzava</label>');
                // jQuery('.select-second').before('<label>Grad</label>');
                });
        </script>
    </div><!-- #primary -->
</div><!-- .wrap -->
<?php
get_footer();