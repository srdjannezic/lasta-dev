<?php
/* 
Template Name: Home
 */

get_header(); ?>

        <div class="wrap">
            <div id="primary" class="content-area">
                <div id="hero-block" class="container-fluid p-0 hero-block">
                    <!-- Jumbotron -->
                    <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                    <div class="jumbotron-fluid py-6 d-flex flex-row justify-content-center align-items-start" style="background-image: url('<?php echo $feat_image ?>');background-repeat: no-repeat;background-size: cover;min-height:500px;">
                        <?php get_template_part( 'template-parts/line-search', 'none' ); ?>
                    </div><!-- Jumbotron -->                    
                </div><!-- Hero block -->
                <div id="home-offer" class="container px-lg-0 pt-4 pb-0 px-1">
                    <div class="row align-items-center no-gutters">
                        <div class="col-lg-12 py-lg-3 text-center section-title">
                            <h2 class="decorated"><span>SPECIJALNE PONUDE</span></h2>
                        </div>
                    </div>
                    <div class="row align-items-center no-gutters pb-4 pb-lg-0">                                
                        <div class="col-md-6 col-lg-3 px-2" data-aos="fade-up">   
                            <div class="card rounded-0 border-0 mb-3 mb-lg-0">
                                <div class="card-header rounded-0 text-center" style="background: #cacaca;">
                                    <a href="<?php echo home_url() . '/prijava-za-newsletter/' ?>">
                                        <h5>NEWSLETTER</h5>
                                    </a>
                                </div>
                                <div class="card-body rounded-0 d-flex flex-column justify-content-between" style="background: #cacaca;min-height:190px;">
                                <p class="card-text text-dark">Budite uvek u toku sa najboljim ponudama:</p>
                                <img class="card-img" style="max-width:109px;" src="/wp-content/uploads/2020/02/BUSIC.png">
                                    <a href="<?php echo home_url() . '/prijava-za-newsletter/' ?>" class="btn btn-primary align-self-end">Prijavi se</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 px-2" data-aos="fade-up">   
                            <div class="card rounded-0 border-0 mb-3 mb-lg-0">
                                <div class="card-header rounded-0 text-center">
                                    <a href="<?php echo home_url() . '/delatnosti/vanlinijski-saobracaj/' ?>">
                                        <h5>IZNAJMITE VOZILO</h5>
                                    </a>
                                </div>
                                <div class="card-body rounded-0 d-flex flex-column justify-content-between" style="background: url('/wp-content/uploads/2020/02/iznaj.jpg');min-height:190px;background-size:cover;">
                                <h5 class="card-text text-white">Želite solo vozilo samo za Vas?</h5>
                                <p class="card-text text-white mb-0">Mi pružamo maksimalnu pouzdanost i garanciju kvaliteta prilikom iznajmljivanja vozila iz našeg savremenog voznog parka.</p>
                                    <a href="<?php echo home_url() . '/delatnosti/vanlinijski-saobracaj/' ?>" class="btn btn-danger align-self-start">Pošalji upit</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 px-2" data-aos="fade-up">   
                            <div class="card rounded-0 border-0 mb-3 mb-lg-0">
                                <div class="card-header rounded-0 text-center">
                                    <a href="<?php echo home_url() . '/first-minute-na-medjunarodnim-linijama/' ?>">
                                        <h5>FIRST MINUTE NA MEĐUNARODNIM LINIJAMA</h5>
                                    </a>
                                </div>
                                <a href="<?php echo home_url() . '/first-minute-na-medjunarodnim-linijama/' ?>">
                                    <div class="card-body rounded-0 d-flex flex-column" style="background: url('/wp-content/uploads/2020/03/vaucer15.png');min-height:190px;background-size:cover;">                                    
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 px-2" data-aos="fade-up">   
                            <div class="card rounded-0 border-0 mb-3 mb-lg-0">
                                <div class="card-header rounded-0 text-center">
                                    <a href="<?php echo home_url() . '/popusti-na-sezonskim-linijama-za-crnu-goru/' ?>">
                                        <h5>POPUSTI NA SEZONSKIM LINIJAMA ZA CRNU GORU</h5>
                                    </a>
                                </div>
                                <a href="<?php echo home_url() . '/popusti-na-sezonskim-linijama-za-crnu-goru/' ?>">
                                <div class="card-body rounded-0 d-flex flex-column" style="background: url('/wp-content/uploads/2020/03/vaucer30.png');min-height:190px;background-size:cover;">
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div><!-- container -->
                
                <?php get_template_part( 'template-parts/aktuelno-home', 'none' ); ?>

                <?php get_template_part( 'template-parts/fleet-slider', 'none' ); ?>                
                
                <?php get_template_part( 'template-parts/home-about', 'none' ); ?>
                
                
            </div><!-- content-area -->
	    </div><!-- wrap -->
<?php
get_footer();