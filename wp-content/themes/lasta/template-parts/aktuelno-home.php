<?php
/**
 * Template part for displaying "Aktuelno section"
 *
 * @package WordPress
 * @subpackage Lasta
 * @since 1.0
 * @version 1.0
 */

?>

<div id="home-news" class="container px-lg-0 py-4 px-1 pb-lg-0">
    <div class="row align-items-center no-gutters">
        <div class="col-lg-12 py-lg-3 text-center section-title">
            <h2 class="decorated"><span>AKTUELNO</span></h2>
        </div>
    </div>
    <div class="row align-items-center no-gutters pb-4">
    <?php $terms = get_terms( 'kategorija_aktuelnosti' );

        foreach( $terms as $term) {
            $args = array(
                'posts_per_page' => 1,
                'post_type' => 'aktuelno',
                'kategorija_aktuelnosti' => $term -> slug,
                'order' => 'ASC'
            );
            $termQuery = new WP_Query( $args );

            while ( $termQuery -> have_posts() ) : $termQuery -> the_post(); ?>
                
        <div class="col-lg-3 col-md-6 px-2" data-aos="fade-up">   
            <div class="card mb-3 rounded-0">
                <div class="card-header rounded-0"><a href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5></a></div>
                <div class="card-body p-0 rounded-0">
                <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                    <a href="<?php the_permalink(); ?>">
                        <img class="img-fluid rounded-0" src="<?php echo $feat_image; ?>" >
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <?php } wp_reset_postdata(); ?>
    </div>
</div><!-- container -->