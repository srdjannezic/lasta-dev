<?php
/**
 * Template part for displaying gradski search form
 *
 * @package WordPress
 * @subpackage Lasta
 * @since 1.0
 * @version 1.0
 */



?>


        <div id="gradski-inner" class="container py-4">        
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="text-red nav-item nav-link active rounded-0 px-4" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">GRADSKO PRIGRADSKI SAOBRAĆAJ</a>            
                </div>
            </nav>
            <div class="tab-content bg-d-blue" id="nav-tabContent">
                <div class="tab-pane fade show active px-4 py-4 d-flex flex-column flex-md-row" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <!-- <p class="text-white">PRETRAGA PO BROJU ILI NAZIVU LINIJE</p> -->
                    <?php echo facetwp_display( 'facet', 'gp_grad' ) ?>
                    
                    <?php echo facetwp_display( 'facet', 'gp_linije' ) ?>
                </div>            
            </div>                  
        </div>