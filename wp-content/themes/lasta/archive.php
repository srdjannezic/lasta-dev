<?php
/* 
Template Name: Archives
*/
get_header(); ?>
 
 <div class="wrap">
    <div id="primary" class="content-area">
        <div class="container py-5">
            <div class="col-lg-12 mb-4">
                <h2 class="decorated"><span>ARHIVA VESTI</span></h2>
            </div>
        
        <?php 
            // the query
            $wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>-1)); ?>
            
            <?php if ( $wpb_all_query->have_posts() ) : ?>
            
            
            
                <!-- the loop -->
                <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
                <div class="col-lg-12">
                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <p class="datum mb-0"><?php the_date(); ?></p>
                    <div class="cat-list">
                    <p class="datum">U kategoriji:</p>
                        <?php the_category(); ?>
                    </div>
                </div>
                <?php endwhile; ?>
                <!-- end of the loop -->
            
           
            
                <?php wp_reset_postdata(); ?>
            
            <?php else : ?>
                <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
            <?php endif; ?>
        </div><!-- container --> 
    </div><!-- #content -->
</div><!-- #primary -->
 
<?php
get_footer();  