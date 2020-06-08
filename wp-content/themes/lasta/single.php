<?php
/**
 * Template for displaying single post
 *
 * 
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */


get_header(); ?>

<div class="wrap">
    <div id="primary" class="content-area">
    <?php
            /* Start the Loop */
            while ( have_posts() ) : the_post(); ?>
        <div class="container">        
            <!-- Jumbotron -->
            <div class="jumbotron-fluid p-3 p-sm-0 mt-3">                    
                        <h1 class="card-title h1 my-0 pt-2 page-title">
                            <?php the_title(); ?>
                        </h1>
                        <p class="text-uppercase mb-0 datum"><?php the_date(); ?></p>                        
            </div><!-- Jumbotron -->
            <div class="col px-0 mw-600 py-4">
                    <?php the_content(); ?>
                    

            </div>
        </div> <!-- container -->
        <?php endwhile; ?>
    </div><!-- content-area -->
</div><!-- wrap -->   
    <script>
    jQuery(document).ready(function($){
        $('p').each(function() {
            var $this = $(this);
            if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
                $this.remove();
        });
    });
    </script>
<?php
get_footer();           