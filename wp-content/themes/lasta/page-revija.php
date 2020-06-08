<?php
/* 
Template Name: Revija
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area pt-0">
        <div class="container p-0">
        <?php
                if ( have_posts() ) :
                    /* Start the Loop */
                    while ( have_posts() ) : the_post(); ?>
        <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
            <!-- Jumbotron -->
            <div class="jumbotron-fluid p-0" style="background-image: url('<?php echo $feat_image; ?>');background-repeat: no-repeat;background-size: cover;">
                <div class="text-white text-left rgba-stylish-strong py-5">
                    <div class="py-5">
                        <h1 class="card-title h1 my-4 py-2 page-title" style="display: table;background: #083f88a8;color: #fff !important;padding: 0 20px;">
                            <?php the_title(); ?>
                        </h1>
                    </div>
                </div>
            </div><!-- Jumbotron -->
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 about-us pt-4">
                     <?php   the_content();
                    endwhile;
                    endif; ?>
                </div>
                <div class="col-lg-12 about-us pt-4" id="ekon-tabs" data-aos="fade">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-white rounded-0  border-0 px-4" id="ekon-tab" data-toggle="tab" role="tab" aria-controls="ekon" aria-selected="true">
                            REVIJA LASTA U PDF FORMATU
                            </a>
                        </li>                        
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active px-4 py-3 animated fadeIn faster" id="ekon" role="tabpanel" aria-labelledby="ekon-tab">
                            <?php  $docs_query = new WP_Query( array(
                                        'post_type' => 'dokumenta',
                                        'posts_per_page' => -1,
                                        'tax_query' => array(
                                            array (
                                                'taxonomy' => 'izvestaji',
                                                'field' => 'slug',
                                                'terms' => 'lasta-revija',
                                                
                                            )
                                        ),
                                        
                                    ) ); ?>
                            <?php if ($docs_query->have_posts()) : while ( $docs_query->have_posts() ) : $docs_query->the_post(); ?>
                            <div class="file-download py-2">
                            <a class="text-white" href="<?php the_field('Revija'); ?>" target="_blank">
                                <p class="text-white d-inline"><?php the_title(); ?></p>
                                <img src="http://lasta.titandizajn.com/wp-content/uploads/2020/02/file-expand_Pdf-512.png" class="d-inline">
                            </a>
                            </div>
                            <?php endwhile; endif; wp_reset_postdata(); ?>
                        </div>                        
                    </div>                                    
                </div>
            </div>    
        </div>
    </div><!-- #primary -->
</div><!-- .wrap -->
<?php
get_footer();