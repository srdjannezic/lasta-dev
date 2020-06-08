<?php
/**
 * The template for displaying all "Aktuelno" single posts
 **/

get_header(); ?>

    <div class="wrap">
	    <div id="primary" class="content-area">
            <div class="container p-0">
			<?php
                /* Start the Loop */
                while ( have_posts() ) : the_post(); ?>
                <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                <!-- Jumbotron -->
                <div class="jumbotron-fluid p-3 p-sm-0 mt-3">                    
                            <h1 class="card-title h1 my-0 pt-2 page-title" style="">
                                <?php the_title(); ?>
                            </h1>
                            <p class="text-uppercase mb-0 datum"><?php the_date(); ?></p>                        
                </div><!-- Jumbotron -->
            </div><!-- container -->
            <div class="container py-2 py-md-4 px-lg-0">
                <div class="row no-gutters">
                    <div class="col-lg-9 p-0" id="main">
                        <img src="<?php echo $feat_image ?>" class="img-fluid aktuelno-s image-wrapper float-left mb-lg-0 mr-lg-3 mb-3 col-lg-6 px-0"/>
                        <?php the_content(); ?>
                    </div><!-- #main -->
                    <div class="col-lg-3 px-0 px-md-4" id="sidebar">
                        <div class="row px-1">
                        <?php
                            //get the taxonomy terms of custom post type
                            $customTaxonomyTerms = wp_get_object_terms( $post->ID, 'kategorija_aktuelnosti', array('fields' => 'ids') );

                            //query arguments
                            $args = array(
                                'post_type' => 'aktuelno',
                                'post_status' => 'publish',
                                'posts_per_page' => 4,
                                'orderby' => 'rand',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'kategorija_aktuelnosti',
                                        'field' => 'id',
                                        'terms' => $customTaxonomyTerms
                                    )
                                ),
                                'post__not_in' => array ($post->ID),
                            );
                            //the query
                            $relatedPosts = new WP_Query( $args );
                            //loop through query
                            if($relatedPosts->have_posts()){                        
                                while($relatedPosts->have_posts()){ 
                                    $relatedPosts->the_post(); ?>
                        <div class="col-lg-12 p-2 bus-item">
                            <div class="bus-image">
                                <a href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) {the_post_thumbnail();} ?></a>
                            </div>
                            <div class="bus-desc p-4 d-flex flex-column justify-content-between">
                                <h3 class="mb-0"><a href="<?php the_permalink(); ?>"><?php  the_title(); ?></a></h3>
                                <p class="text-uppercase mb-0 datum"><?php the_date(); ?></p>
                                <?php
                                // global $post;
                                // $terms = wp_get_post_terms( $post->ID, 'kategorija_aktuelnosti');                
                                // if ( $terms != null ){
                                //     foreach( $terms as $term ) {
                                //     $term_link = get_term_link( $term, 'kategorija_aktuelnosti' );
                                //     }
                                // } ?>
                                <h5 class="py-auto text-red">
                                    <?php echo $term->name ; unset($term); // Get rid of the other data stored in the object, since it's not needed?>
                                </h5>
                                <h4><?php //the_excerpt(); ?></h4>
                                <!-- <h5>
                                    <span class="cap-icon"></span>
                                    <?php //the_field('kapacitet'); ?>
                                </h5>             -->
                                <?php
                                //$opreme = get_field('oprema');
                                //if( $opreme ): ?>                            
                                <?php //foreach( $opreme as $oprema ): ?>
                                <!-- <h5>
                                    <span class="icon-<?php //echo $oprema['value']; ?>"></span>
                                    <?php //echo $oprema['label']; ?>
                                </h5> -->
                                    <?php //endforeach; ?>
                                <?php //endif; ?>
                                <a class="btn btn-primary" href="<?php the_permalink(); ?>" role="button">Detaljnije</a>
                            </div>
                        </div>
                        <?php  }
                            }                                
                            else { echo '<h4 class="text-center w-100">NEMA AKTUELNOSTI</h4>'; }
                            //restore original post data
                            wp_reset_postdata(); ?>
                        </div>
                    </div>
                </div>
            <?php endwhile;?>
            </div> <!-- container -->            
        </div><!-- content-area -->
    </div><!-- wrap -->   
    
<?php
get_footer();            