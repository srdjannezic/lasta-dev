<?php
/* 
Template Name: Kontakt  
 */

get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                        the_content(); endwhile; endif; ?>
    <div class="wrap">
        <div id="primary" class="content-area pt-0">        
            <div class="container p-0">
                <?php
            $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            ?>
                <!-- Jumbotron -->
                <div class="jumbotron-fluid p-0" style="background-image: url('<?php echo $feat_image; ?>');background-repeat: no-repeat;background-size: cover;">
                    <div class="text-white text-center rgba-stylish-strong py-5">
                        <div class="py-5">
                            <h1 class="card-title h1 my-4 py-2 page-title" style="display: table;background: #083f88a8;color: #fff !important;padding: 0 20px;">
                                <?php the_title(); ?>
                            </h1>
                        </div>
                    </div>
                </div>
                <!-- Jumbotron -->
            </div>
            <div class="container pt-5">
            <div class="row">
                <div class="col-lg-6 kontakt-info p-0" data-aos="fade-up">
                    <div class="col-lg-12 col-sm-6 pb-4">
                        <h3>CALL CENTAR</h3>
                        <h4><a class="text-red" href="tel:0800334334">0800 334 334</a></h4><p>(Besplatan poziv)</p>
                        <h4><a href="tel:+381113348555">+381 11 3348 555</a></h4>
                        <h4><a href="tel:+381113348556">+381 11 3348 556</a></h4>
                        <h4><a href="tel:+381113348 557">+381 11 3348 557</a></h4>
                    </div>
                    <div class="col-lg-12 col-sm-6 pb-4">
                    <h3>LASTA Služba za vanlinijski prevoz</h3>
                        <h4><a href="tel:+381113402454">+381 11 3402 454</a></h4>
                        <h4><a href="tel:+381113402360">+381 11 3402 360</a></h4>
                        <h4><a href="mailto:vls.sluzba@lasta.rs">vls.sluzba@lasta.rs</a></h4>
                        <h4 class="py-2">
                            <span class="pr-2"><img src="http://lasta.titandizajn.com/wp-content/uploads/2020/01/building.jpg"></span>
                            <a href="https://www.google.com/maps/place/SP+Lasta+-+Terminal+za+turisti%C4%8Dke+autobuse/@44.7713521,20.5153119,17z/data=!3m1!4b1!4m8!1m2!2m1!1sAutoput+Beograd-Ni%C5%A1+4!3m4!1s0x475a71dc05c2a9e5:0x4369a1f6c5006bd3!8m2!3d44.7713483!4d20.5175006" target="_blank">Autoput Beograd-Niš 4</a>
                        </h4>
                    </div>
                    <div class="col-lg-12 col-sm-6 pb-4">
                        <h3>DIREKCIJA SP LASTA a.d.</h3>
                        <h4><a href="tel:+381113402300">+381 11 3402 300</a></h4>
                        <h4 class="py-2">
                            <span class="pr-2"><img src="http://lasta.titandizajn.com/wp-content/uploads/2020/01/building.jpg"></span>
                            <a href="https://www.google.com/maps/place/SP+Lasta+-+Terminal+za+turisti%C4%8Dke+autobuse/@44.7713521,20.5153119,17z/data=!3m1!4b1!4m8!1m2!2m1!1sAutoput+Beograd-Ni%C5%A1+4!3m4!1s0x475a71dc05c2a9e5:0x4369a1f6c5006bd3!8m2!3d44.7713483!4d20.5175006" target="_blank">Autoput Beograd-Niš 4</a>
                        </h4>
                    </div>
                    <div class="col-lg-12 pb-4">
                        <h3>MARKETING</h3>
                        <h4><a href="mailto:office@lasta.rs">office@lasta.rs</a></h4>                        
                    </div>                    
                </div>                
                <div class="col-lg-6 kontakt-forma p-0" data-aos="fade-up">
                    <div class="col-lg-12">
                <?php
                    if (function_exists("add_formcraft_form")) {
                    add_formcraft_form("[fc id='1'][/fc]");
                    }
                    ?>
                    </div>
                </div>
            </div>    
        </div>
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-12 kontakt-stanice pb-4">
                    <h3>AUTOBUSKE STANICE</h3>
                </div>
                <div class="col-lg-12 kontakt-adrese">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">POSLOVNICA</th>
                            <th scope="col">ADRESA</th>
                            <th scope="col">TELEFON</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th scope="row">Terminus Banovo Brdo</th>
                            <td>Požeška bb</td>
                            <td><a href="tel:+381116544050">+381 11 65 44 050</a></td>
                            </tr>
                            <tr>
                            <th scope="row">Terminus Šumice</th>
                            <td>Vojislava Ilića 102</td>
                            <td><a href="tel:+381112890372">+381 11 2890 372</a></td>
                            </tr>
                            <tr>
                            <th scope="row">AS Sopot</th>
                            <td>Milisava Vlajića 18</td>
                            <td><a href="tel:+381118251447">+381 11 82 51 447</a></td>
                            </tr>
                            <tr>
                            <th scope="row">AS Barajevo</a></th>
                            <td>Svetosavska 63</td>
                            <td><a href="tel:+381118300346">+381 11 83 00 346</a></td>
                            </tr>
                            <tr>
                            <th scope="row">AS Mladenovac</th>
                            <td>Janka Katića br. 1</td>
                            <td><a href="tel:+381118231455">+381 11 82 31 455</a></td>
                            </tr>
                            <tr>
                            <th scope="row">AS Obrenovac</th>
                            <td>Kralja Aleksandra Prvog br 20</td>
                            <td><a href="tel:+381118721284">+381 11 87 21 284</a></td>
                            </tr>
                            <tr>
                            <th scope="row">AS Lazarevac</th>
                            <td>Ulica kralja Petra Prvog br.2</td>
                            <td><a href="tel:+381118123066">+381 11 81 23 066</a></td>
                            </tr>
                            <tr>
                            <th scope="row">AS Smederevo</th>
                            <td>Omladinska br. 2</td>
                            <td><a href="tel:+381264622245">+381 26 4622 245</a></td>
                            </tr>
                            <tr>
                            <th scope="row">AS Smederevska Palanka</th>
                            <td>Olge Milošević 36</td>
                            <td><a href="tel:+38126317199">+381 26 317 199</a></td>
                            </tr>
                            <tr>
                            <th scope="row">AS Lajkovac</th>
                            <td>Vojvode Mišića bb</td>
                            <td><a href="tel:+381143431331">+381 14 34 31 331</a></td>
                            </tr>
                            <tr>
                            <th scope="row">AS Valjevo</th>
                            <td>Klanička br. 8</td>
                            <td><a href="tel:+38114221482">+381 14 221 482</a></td>
                            </tr>
                            <tr>
                            <th scope="row">AS Inđija</th>
                            <td>Sonje Marinkovic bb</td>
                            <td><a href="tel:+38122561409">+381 22 561 409</a></td>
                            </tr>
                            <tr>
                            <th scope="row">AS Stara Pazova</th>
                            <td>Ćirila i Metodija br. 22</td>
                            <td><a href="tel:+38122311617">+381 22 311 617</a></td>
                            </tr>
                            <tr>
                            <th scope="row">AS Prokuplje</th>
                            <td>Vasilija Đurovića Žarkog bb</td>
                            <td><a href="tel:+38127321864">+381 27 321 864</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- #primary -->
</div><!-- .wrap -->
<?php
get_footer();