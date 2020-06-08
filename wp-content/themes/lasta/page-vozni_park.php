<?php
/* 
Template Name: Vozni park   
 */

get_header(); ?>


<?php // let the queries begin   
if( !isset($_GET['buscat']) || '' == $_GET['buscat']) {
    $buslist = new WP_Query( array(
    'post_type' => 'vozni_park', 
    'posts_per_page' => -1,
    'orderby' => array( 'title' => 'ASC' ),
    'paged' => $paged
    ) ); 
} else { //if select value exists (and isn't 'show all'), the query that compares $_GET value and taxonomy term (name)
    $buscategory = $_GET['buscat']; //get sort value
    $buslist = new WP_Query( array(
    'post_type' => 'vozni_park', 
    'posts_per_page' => -1,
    'orderby' => array( 'title' => 'ASC' ),
    'paged' => $paged,
    'tax_query' => array(
        array(
        'taxonomy' => 'tip_autobusa',
        'field' => 'name',
        'terms' => $buscategory
        ) 
    ) 
    ));
} ?>

    <div class="wrap">
	    <div id="primary" class="content-area">
            <div class="container p-0"> 
        <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                <!-- Jumbotron -->
                <!-- <div class="jumbotron-fluid p-0" style="background-image: url('<?php //echo $feat_image; ?>');background-repeat: no-repeat;background-size: cover;">
                    <div class="text-white text-left rgba-stylish-strong py-5">
                        <div class="py-5">
                            <h1 class="card-title h1 my-4 py-2 page-title" style="display: table;background: #083f88a8;color: #fff !important;padding: 0 20px;">
                                <?php the_title(); ?>
                            </h1>
                        </div>
                    </div>
                </div> -->
                <!-- Jumbotron -->
            </div>    
            <div class="container">                 
                <?php if(have_posts()) : while(have_posts()) : the_post(); ?>           
                <!-- <div class="row pt-4">
                    <div class="col-lg-12 pb-1">
                        <?php //the_content(); ?>
                    </div>
                </div> -->
                    <?php endwhile; 
                    endif; ?>
                <div class="row pt-4">
                    <div class="col-lg-12 pb-1">
                        <h2>TIP AUTOBUSA</h2>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <form action="" method="GET" id="buslist">
                            <div class="form-group">
                                <select name="buscat" id="buscat" onchange="submit();" class="form-control custom-select">
                                <option value="" <?php echo ($_GET['buscat'] == '') ? ' selected="selected"' : ''; ?>>Prikaži sve</option>
                                <?php
                                    $categories = get_categories('taxonomy=tip_autobusa&post_type=vozni_park');
                                    foreach ($categories as $category) : 
                                    echo '<option class="p-3" value="'.$category->name.'"';
                                    echo ($_GET['buscat'] == ''.$category->name.'') ? ' selected="selected"' : '';
                                    echo '>'.$category->name.'</option>';
                                    endforeach; 
                                ?>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>            
            <div class="container">
                <div class="row">                    
                <?php
                    if ($buslist->have_posts()) :
                    while ( $buslist->have_posts() ) : $buslist->the_post(); 
                    ?>                
                    <div class="col-lg-3 col-md-6 p-2 bus-item" data-aos="fade-up">
                        <div class="bus-image">
                            <a href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) {the_post_thumbnail();} ?></a>
                        </div>
                        <div class="bus-desc p-4 d-flex flex-column">
                            <h3 class="mb-0"><a href="<?php the_permalink(); ?>"><?php  the_title(); ?></a></h3>
                            <h4 class="pt-1"><?php the_field('proizvodjac'); ?></h4>
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
                        <?php endwhile; 
                        else : 
                        echo 'Nema autobusa u izabranoj kategoriji.'; 
                        endif; 
                        ?>            
                        <?php wp_reset_query(); ?>            
                </div>
            </div>
        </div><!-- content-area -->
	</div><!-- wrap -->
<?php
get_footer();