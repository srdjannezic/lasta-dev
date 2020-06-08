<?php
/* 
Template Name: Aktuelno
 */

get_header(); ?>

        <div class="wrap">
                <div id="primary" class="content-area">
                    <div class="container py-4" style="overflow-x: hidden;">
                        <div class="row no-gutters">
                            <div class="col-lg-12 text-center pb-2 pt-2" data-aos="fade">
                                <h2 class="decorated"><span>NAJNOVIJE AKTUELNOSTI</span></h2>    
                            </div>
                            <!-- Left side column -->
                            <div class="col-lg-6 aktuelno-left p-1 row justify-content-between no-gutters" data-aos="fade-right">
                                <?php $the_query_turizam = new WP_Query( array(
                                        'post_type' => 'aktuelno',
                                        'tax_query' => array(
                                            array (
                                                'taxonomy' => 'kategorija_aktuelnosti',
                                                'field' => 'slug',
                                                'terms' => 'turizam',
                                            )
                                        ),
                                    ) );
                                    
                                while ( $the_query_turizam->have_posts() ) :
                                    $the_query_turizam->the_post(); ?>
                                <!-- Card -->
                                <div class="card rounded-0">

                                <!-- Card image -->
                                <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                                <a href="<?php the_permalink(); ?>">
                                    <img class="card-img-top rounded-0" src="<?php echo $feat_image; ?>">                                    
                                </a>    
                                <!-- Card content -->
                                <div class="card-body d-flex flex-column p-3">

                                    <!-- Title -->
                                    <h2 class="card-title mb-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <p class="datum text-uppercase mb-0"><?php echo get_the_date('M j. Y.'); ?></p>
                                    <?php
                                    global $post;
                                    $terms = wp_get_post_terms( $post->ID, 'kategorija_aktuelnosti');                
                                    if ( $terms != null ){
                                        foreach( $terms as $term ) {
                                        $term_link = get_term_link( $term, 'kategorija_aktuelnosti' );
                                        }
                                    } ?>
                                    <h5 class="my-auto text-red">
                                        <?php echo $term->name ; unset($term); // Get rid of the other data stored in the object, since it's not needed?>
                                    </h5>
                                    <!-- Text -->
                                    <div class="card-text"><?php the_excerpt(); ?></div>
                                    <!-- Button -->
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary mt-auto">Opširnije</a>

                                </div>

                                </div>
                                <!-- Card -->
                                <?php endwhile; 
                                wp_reset_postdata(); ?>
                            </div> <!-- aktuelno left -->
                            <!-- Right side column -->
                            <div class="col-lg-6 aktuelno-right p-1 row justify-content-between no-gutters">
                                
                                <?php $the_query_sredina = new WP_Query( array(
                                        'post_type' => 'aktuelno',
                                        'tax_query' => array(
                                            array (
                                                'taxonomy' => 'kategorija_aktuelnosti',
                                                'field' => 'slug',
                                                'terms' => 'zivotna-sredina',
                                            )
                                        ),
                                    ) );
                                    
                                while ( $the_query_sredina->have_posts() ) :
                                    $the_query_sredina->the_post(); ?>
                                <div class="col-lg-12 px-0 pb-2 d-flex" data-aos="fade-left" data-aos-delay="300">
                                    <!-- Card -->
                                    <div class="card img-left flex-lg-row rounded-0">

                                        <!-- Card image -->
                                        <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                                        <a href="<?php the_permalink(); ?>" class="col-lg-6 p-0">
                                            <img class="card-img-top rounded-0" src="<?php echo $feat_image; ?>">                                    
                                        </a>    
                                        <!-- Card content -->
                                        <div class="card-body d-flex flex-column p-3">

                                            <!-- Title -->
                                            <h4 class="card-title mb-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                            <p class="datum text-uppercase mb-0"><?php echo get_the_date('M j. Y.'); ?></p>
                                            <?php
                                            global $post;
                                            $terms = wp_get_post_terms( $post->ID, 'kategorija_aktuelnosti');                
                                            if ( $terms != null ){
                                                foreach( $terms as $term ) {
                                                $term_link = get_term_link( $term, 'kategorija_aktuelnosti' );
                                                }
                                            } ?>
                                            <h5 class="my-auto text-red">
                                                <?php echo $term->name ; unset($term); // Get rid of the other data stored in the object, since it's not needed?>
                                            </h5>
                                            <!-- Text -->
                                            <p class="card-text"><?php if (wp_is_mobile()) {the_excerpt();} ?></p>
                                            <!-- Button -->
                                            <a href="<?php the_permalink(); ?>" class="btn btn-primary mt-auto">Opširnije</a>

                                        </div>

                                    </div>
                                    <!-- Card -->                                     
                                </div>
                                <?php endwhile; wp_reset_postdata(); ?> 
                                <?php $the_query_ponude = new WP_Query( array(
                                        'post_type' => 'aktuelno',
                                        'tax_query' => array(
                                            array (
                                                'taxonomy' => 'kategorija_aktuelnosti',
                                                'field' => 'slug',
                                                'terms' => 'ponude',
                                            )
                                        ),
                                    ) );
                                    
                                while ( $the_query_ponude->have_posts() ) :
                                    $the_query_ponude->the_post(); ?>
                                <div class="col-lg-12 px-0 pb-2 d-flex" data-aos="fade-left" data-aos-delay="500">    
                                    <!-- Card -->
                                    <div class="card img-right flex-lg-row-reverse rounded-0">

                                        <!-- Card image -->
                                        <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                                        <a href="<?php the_permalink(); ?>" class="col-lg-6 p-0">
                                            <img class="card-img-top rounded-0" src="<?php echo $feat_image; ?>">                                    
                                        </a>    
                                        <!-- Card content -->
                                        <div class="card-body d-flex flex-column p-3">

                                            <!-- Title -->
                                            <h4 class="card-title mb-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                            <p class="datum text-uppercase mb-0"><?php echo get_the_date('M j. Y.'); ?></p>
                                            <?php
                                            global $post;
                                            $terms = wp_get_post_terms( $post->ID, 'kategorija_aktuelnosti');                
                                            if ( $terms != null ){
                                                foreach( $terms as $term ) {
                                                $term_link = get_term_link( $term, 'kategorija_aktuelnosti' );
                                                }
                                            } ?>
                                            <h5 class="my-auto text-red">
                                                <?php echo $term->name ; unset($term); // Get rid of the other data stored in the object, since it's not needed?>
                                            </h5>
                                            <!-- Text -->
                                            <p class="card-text"><?php if (wp_is_mobile()) {the_excerpt();} ?></p>
                                            <!-- Button -->
                                            <a href="<?php the_permalink(); ?>" class="btn btn-primary mt-auto">Opširnije</a>

                                        </div>

                                    </div>
                                    <!-- Card -->
                                    
                                </div>
                                <?php endwhile; 
                                    wp_reset_postdata(); ?>
                              <?php $the_query_obavestenja = new WP_Query( array(
                                        'post_type' => 'aktuelno',
                                        'tax_query' => array(
                                            array (
                                                'taxonomy' => 'kategorija_aktuelnosti',
                                                'field' => 'slug',
                                                'terms' => 'obavestenja',
                                            )
                                        ),
                                    ) );
                                    
                                while ( $the_query_obavestenja->have_posts() ) :
                                    $the_query_obavestenja->the_post(); ?>
                                <div class="col-lg-12 px-0 d-flex" data-aos="fade-left" data-aos-delay="700">
                                    <!-- Card -->
                                    <div class="card img-left flex-lg-row rounded-0">

                                        <!-- Card image -->
                                        <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                                        <a href="<?php the_permalink(); ?>" class="col-lg-6 p-0">
                                            <img class="card-img-top rounded-0" src="<?php echo $feat_image; ?>">                                    
                                        </a>    
                                        <!-- Card content -->
                                        <div class="card-body d-flex flex-column p-3">

                                            <!-- Title -->
                                            <h4 class="card-title mb-0"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                            <p class="datum text-uppercase mb-0"><?php echo get_the_date('M j. Y.'); ?></p>
                                            <?php
                                            global $post;
                                            $terms = wp_get_post_terms( $post->ID, 'kategorija_aktuelnosti');                
                                            if ( $terms != null ){
                                                foreach( $terms as $term ) {
                                                $term_link = get_term_link( $term, 'kategorija_aktuelnosti' );
                                                }
                                            } ?>
                                            <h5 class="my-auto text-red">
                                                <?php echo $term->name ; unset($term); // Get rid of the other data stored in the object, since it's not needed?>
                                            </h5>
                                            <!-- Text -->
                                            <p class="card-text"><?php if (wp_is_mobile()) {the_excerpt();} ?></p>
                                            <!-- Button -->
                                            <a href="<?php the_permalink(); ?>" class="btn btn-primary mt-auto">Opširnije</a>

                                        </div>

                                    </div>
                                    <!-- Card -->
                                    
                                </div> 
                                <?php endwhile; 
                                    wp_reset_postdata(); ?>
                            </div><!-- aktuelno-right -->
                        </div> <!-- row -->
                    </div> <!-- container -->
                    <div class="container bus-related px-0" data-aos="fade">
                <div class="row px-2 no-gutters">
                    <div class="col-lg-12 text-center pb-2 pt-2">
                        <h2 class="decorated"><span>OSTALE AKTUELNOSTI</span></h2>
                    </div>
                    <?php
 
                        $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
                        $query_args = array(
                        'post_type' => 'aktuelno',
                        'posts_per_page' => 4,
                        //'offset' => 1,
                        'paged' => $paged
                        );

                        $the_query = new WP_Query( $query_args );
                        ?>

                        <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); // run the loop ?>
                        <div class="col-lg-3 col-md-6 p-2 bus-item" data-aos="fade-up">
                            <div class="bus-image">
                                <a href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) {the_post_thumbnail();} ?></a>
                            </div>
                            <div class="bus-desc p-3">
                                <h3 class="mb-0"><a href="<?php the_permalink(); ?>"><?php  the_title(); ?></a></h3>
                                <p class="text-uppercase mb-0 datum"><?php the_date(); ?></p>
                                <?php
                                global $post;
                                $terms = wp_get_post_terms( $post->ID, 'kategorija_aktuelnosti');                
                                if ( $terms != null ){
                                    foreach( $terms as $term ) {
                                    $term_link = get_term_link( $term, 'kategorija_aktuelnosti' );
                                    }
                                } ?>
                                <h5 class="py-auto text-red">
                                    <?php echo $term->name ; unset($term); // Get rid of the other data stored in the object, since it's not needed?>
                                </h5>
                                <?php the_excerpt(); ?>
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
                        <?php endwhile; ?>

                        <?php if ($the_query->max_num_pages > 1) { // check if the max number of pages is greater than 1  ?>
                        <div class="col-lg-12 text-center py-4">
                            <button class="loadmore2 btn btn-danger">Učitaj još...</button>
                        </div>
                        <?php } ?>

                        <?php else: ?>
                        <article>
                        <h1>Sorry...</h1>
                        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                        </article>
                        <?php endif; ?>
                        <script>
                            var posts_myajax = '<?php echo serialize( $the_query->query_vars ) ?>',
                            current_page_myajax = 1,
                            max_page_myajax = <?php echo $the_query->max_num_pages ?>
                        </script>
                        <script src="<?php echo site_url(); ?>/wp-content/themes/lasta/js/myloadmore.js"></script>
                    </div>
                </div><!-- row -->
            </div><!-- container -->
                </div><!-- content-area -->
        </div><!-- wrap -->
<?php
get_footer();