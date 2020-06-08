<?php
/**
 * The template for displaying all vozni park single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
<?php

 //Get terms for post
 global $post;
 $terms = wp_get_post_terms( $post->ID, 'tip_autobusa');
 
 if ( $terms != null ){
     foreach( $terms as $term ) {
     $term_link = get_term_link( $term, 'tip_autobusa' );
     }
 }?>
    <div class="wrap">
	    <div id="primary" class="content-area">
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post(); ?>
            <div class="container bus-single py-5">
                <div class="row">
                    <div class="col-lg-7 bus-slider">
                    <?php 
                        $images = get_field('galerija');
                        if( $images ): ?>
                            <div id="slider" class="flexslider">
                                <ul class="slides">
                                    <?php foreach( $images as $image ): ?>
                                        <li>
                                            <img class="" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                                            <p><?php echo esc_html($image['caption']); ?></p>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div id="carousel" class="flexslider">
                                <ul class="slides">
                                    <?php foreach( $images as $image ): ?>
                                        <li>
                                            <img class="" src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="Thumbnail of <?php echo esc_url($image['alt']); ?>" />
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-5 bus-description" data-aos="fade-up">
                        <div class="row px-4">
                            <div class="col-lg-12 px-0 pb-4 pt-2">
                                <h1><?php the_title(); ?></h1>
                                <h4><?php the_field('proizvodjac'); ?></h4>                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4>Tip autobusa</h4>
                                    <h5>                                    
                                        <?php echo $term->name ; unset($term); // Get rid of the other data stored in the object, since it's not needed?>
                                    </h5><br>
                                    <h4>Kapacitet</h4>
                                    <h5>
                                    <span class="cap-icon"></span>
                                        <?php the_field('kapacitet'); ?>
                                    </h5>
                                </div>
                                <div class="col-lg-12 pt-4">
                                    <h4>Dodatna oprema</h4>
                                    <?php
                                    // Load field settings and values.
                                    $field = get_field_object('oprema');
                                    $opreme = $field['value'];

                                    // Display labels.
                                    if( $opreme ): ?>                                
                                        <?php foreach( $opreme as $oprema ): ?>
                                            <h5>
                                                <span class="icon-<?php echo $oprema['value']; ?>"></span>
                                                <?php echo $oprema['label']; ?></h5>
                                        <?php endforeach; ?>                                
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>                        
                    </div>                
                    <?php endwhile;   //End of the loop. ?>
                </div><!-- row -->         
            </div><!-- container -->         
            <div class="container bus-related px-2">
                <div class="row no-gutters">
                    <div class="col-lg-12 text-center pb-4">
                        <h2 class="decorated"><span>SLIČNI AUTOBUSI</span></h2>              
                    </div>
                <?php
                    //get the taxonomy terms of custom post type
                    $customTaxonomyTerms = wp_get_object_terms( $post->ID, 'tip_autobusa', array('fields' => 'ids') );

                    //query arguments
                    $args = array(
                        'post_type' => 'vozni_park',
                        'post_status' => 'publish',
                        'posts_per_page' => 4,
                        'orderby' => 'rand',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'tip_autobusa',
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
                    <div class="col-lg-3 col-md-6 p-2 bus-item" data-aos="fade-up">
                        <div class="bus-image">
                            <a href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) {the_post_thumbnail();} ?></a>
                        </div>
                        <div class="bus-desc p-4 d-flex flex-column">
                            <H3><a href="<?php the_permalink(); ?>"><?php  the_title(); ?></a></H3>
                            <H4><?php the_field('proizvodjac'); ?></H4>                            
                            <?php
                            global $post;
                            $terms = wp_get_post_terms( $post->ID, 'tip_autobusa');                
                            if ( $terms != null ){
                                foreach( $terms as $term ) {
                                $term_link = get_term_link( $term, 'tip_autobusa' );
                                }
                            } ?>
                            <h5 class="my-auto text-red py-1">
                                <?php echo $term->name ; unset($term); // Get rid of the other data stored in the object, since it's not needed?>                            
                            </h5>
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
                            <a class="btn btn-primary mt-auto" href="<?php the_permalink(); ?>" role="button">Detaljnije</a>
                        </div>
                    </div>
                            <?php  }
                                }                                
                                else{echo '<h4 class="text-center w-100">NEMA SLIČNIH AUTOBUSA</h4>';
                                }
                                //restore original post data
                                wp_reset_postdata(); ?>                        
                </div><!-- row -->
            </div><!-- container -->
        </div><!-- content-area -->
    </div><!-- wrap -->     
<?php
get_footer();