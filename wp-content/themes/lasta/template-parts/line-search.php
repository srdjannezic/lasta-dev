<?php
/**
 * Template part for displaying search form
 *
 * @package WordPress
 * @subpackage Lasta
 * @since 1.0
 * @version 1.0
 */



?>

<?php 

$od = '';
$do = '';

$dan = '';
$vreme = 0;
$datum = '';

if(isset($_GET['f'])){
	$datum = time();			
	$datum_parts = explode(".", $_GET['date']);
	if(count($datum_parts) == 3)
		$datum = mktime(0, 0, 0, $datum_parts[1], $datum_parts[0], $datum_parts[2]);
	
	$vreme_sat = 0;
	if(isset($_GET['time']))
		$vreme_sat = $_GET['time'] + 0;
	
	$dani = array('pon', 'uto', 'sre', 'cet', 'pet', 'sub', 'ned');
	
	if(isset($_GET['hld']) && $_GET['hld'] == 1)
		$polazak_filter_column = "praznik";
	else
		$polazak_filter_column = $dani[date('N', $datum) - 1];

	$domestic_1 = $_GET['f'];
	$domestic_2 = $_GET['t'];
	
	$grad1_row = $wpdb->get_row("SELECT * FROM lb1706wp_lasta_grad WHERE id = $domestic_1");
	$grad2_row = $wpdb->get_row("SELECT * FROM lb1706wp_lasta_grad WHERE id = $domestic_2");
	
	if(!$grad1_row || !$grad2_row) {
		// nepostojeci grad
	}

	$od = $grad1_row->naziv;
	$do = $grad2_row->naziv;


}

if(isset($_GET['date'])){
    $datum = $_GET['date'];
}


?>
    
        <!-- TITLE -->
		<!--<h1><?php echo $grad1_row->naziv, ' - ', $grad2_row->naziv; ?></h1>-->

<div id="bus-lines" class="container align-items-center px-sm-0" data-aos="fade">
    <div class="d-flex flex-row justify-content-center align-items-center"> 
        <div class="col-lg-12 px-0">
            <div class="text-white text-left rgba-stylish-strong">
                <div class="">
                    <h2 class="card-title h2 page-title text-left px-4 py-1" style="display: table;background: #2470d5;color: #fff !important;">
                        REDOVI VOŽNJE
                    </h2>
                </div>
            </div>
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php if($_GET['tip'] == 'Domaci' or !isset($_GET['tip'])): ?>active <?php endif; ?> text-white rounded-0 px-4" id="domaci-tab" data-toggle="tab" href="#domaci" role="tab" aria-controls="domaci" aria-selected="true">MEĐUMESNI</a>
                </li>
                <li class="nav-item">
                    <a class="<?php if($_GET['tip'] == 'Medjunarodni'): ?> active <?php endif; ?>nav-link text-white rounded-0 px-4" id="medjunarodni-tab" data-toggle="tab" href="#medjunarodni" role="tab" aria-controls="medjunarodni" aria-selected="false">MEĐUNARODNI</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white rounded-0 px-4" id="gradskop-tab" href="http://lasta.titandizajn.com/gradsko-prigradske-linije/">GRADSKO PRIGRADSKI</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show <?php if($_GET['tip'] == 'Domaci' or !isset($_GET['tip'])): ?>show active <?php endif; ?>" id="domaci" role="tabpanel" aria-labelledby="domaci-tab">
                    <form action="/rezultat-pretrage" method="GET" class="form-inline" autocomplete="off">
                        <div class="form-row w-100 mr-auto">
                            <div class="form-group my-4 w-100 px-4">
                                <div id="form-autocomplete-od-domaci" class="position-relative search-wrapper pr-1">
                                    <input type="search" id="autocomplete-od-domaci" class="form-control selectpicker-domaci rounded-0" placeholder="Od" value="<?php if($_GET['tip'] == 'Domaci' or !isset($_GET['tip'])): ?><?= $od ?><?php endif; ?>">
                                    <input type="button" id="swap-domaci" class="form-control rounded-0 swap">
                                    <div class="ajax-result"></div>
                                    <input type="hidden" name="f" class="way" value="<?= $_GET['f'] ?>" />
                                </div>                                    
                                <div id="form-autocomplete-do-domaci" class="search-wrapper pr-1">    
                                    <input type="search" id="autocomplete-do-domaci" class="form-control selectpicker-domaci rounded-0" placeholder="Do" value="<?php if($_GET['tip'] == 'Domaci' or !isset($_GET['tip'])): ?><?= $do ?><?php endif; ?>">
                                    <div class="ajax-result"></div>
                                    <input type="hidden" name="t" class="way" value="<?= $_GET['t'] ?>" />
                                </div>
                                <input name="date" type="text" id="datepicker-domaci" placeholder="Datum polaska" class="form-control rounded-0 datepicker-bus" readonly="readonly" style="cursor:pointer;" value="<?php if($_GET['tip'] == 'Domaci' or !isset($_GET['tip'])): ?><?= $datum ?><?php endif; ?>">
                                <select name="time" class="form-control browser-default rounded-0 mx-1 px-5" style="cursor:pointer;">
                                    <?php if(isset($_GET['time']) && $_GET['time'] != '') : ?>
                                        <?php if($_GET['tip'] == 'Domaci' or !isset($_GET['tip'])): ?>
                                        <option value="<?= $_GET['time'] ?>"> <?= $_GET['time'] ?> : 00 </option>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                                           <option value=""> CEO DAN </option>                                                                    <option value="1">1 : 00 h</option>                                                                    <option value="2">2 : 00 h</option>                                                                    <option value="3">3 : 00 h</option>                                                                    <option value="4">4 : 00 h</option>                                                                    <option value="5">5 : 00 h</option>                                                                    <option value="6">6 : 00 h</option>                                                                    <option value="7">7 : 00 h</option>                                                                    <option value="8">8 : 00 h</option>                                                                    <option value="9">9 : 00 h</option>                                                                    <option value="10">10 : 00 h</option>                                                                    <option value="11">11 : 00 h</option>                                                                    <option value="12">12 : 00 h</option>                                                                    <option value="13">13 : 00 h</option>                                                                    <option value="14">14 : 00 h</option>                                                                    <option value="15">15 : 00 h</option>                                                                    <option value="16">16 : 00 h</option>                                                                    <option value="17">17 : 00 h</option>                                                                    <option value="18">18 : 00 h</option>                                                                    <option value="19">19 : 00 h</option>                                                                    <option value="20">20 : 00 h</option>                                                                    <option value="21">21 : 00 h</option>                                                                    <option value="22">22 : 00 h</option>                                                                    <option value="23">23 : 00 h</option>                                                                    <option value="24">24 : 00 h</option>                                                        </select>
                                </select>

                                <input type="hidden" value="Domaci" name="tip" class="form-control">
                                
                                
                                <button type="submit" id="submit-button-domaci" class="btn btn-danger form-control my-2 rounded-0">Pretraga</button>
                            </div>                                                   
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade<?php if($_GET['tip'] == 'Medjunarodni'): ?> show active <?php endif; ?>" id="medjunarodni" role="tabpanel" aria-labelledby="medjunarodni-tab">
                    <form action="/rezultat-pretrage" method="GET" class="form-inline" autocomplete="off">
                        <div class="form-row w-100 mr-auto">
                            <div class="form-group my-4 w-100 px-4">
                                <div id="form-autocomplete-od-medjunarodni" class="position-relative search-wrapper pr-1">
                                    <input  type="search" id="autocomplete-od-medjunarodni" class="form-control selectpicker-medjunarodni rounded-0" placeholder="Od" autocomplete="off" value="<?php if($_GET['tip'] == 'Medjunarodni'): ?><?= $od ?><?php endif; ?>">                                    
                                    <div class="ajax-result"></div>
                                    <input type="hidden" name="f" class="way" value="<?= $_GET['f'] ?>" />
                                    <input type="button" id="swap-medjunarodni" class="form-control rounded-0 swap">
                                </div>                                    
                                <div id="form-autocomplete-do-medjunarodni" class="search-wrapper pr-1">    
                                    <input type="search" id="autocomplete-do-medjunarodni" class="form-control selectpicker-medjunarodni rounded-0" placeholder="Do" autocomplete="off" value="<?php if($_GET['tip'] == 'Medjunarodni'): ?><?= $do ?><?php endif; ?>">
                                    <div class="ajax-result"></div>
                                    <input type="hidden" name="t" class="way" value="<?= $_GET['t'] ?>" />
                                </div>
                                <input name="date" type="text" id="datepicker-medjunarodni" placeholder="Datum polaska" class="form-control rounded-0 datepicker-bus" readonly="readonly" value="<?php if($_GET['tip'] == 'Medjunarodni'): ?><?= $datum ?><?php endif; ?>" style="cursor:pointer;">
<select name="time" class="form-control browser-default rounded-0 px-5 mx-1" style="cursor:pointer;">
                                    <?php if(isset($_GET['time']) && $_GET['time'] != '') : ?>
                                        <?php if($_GET['tip'] == 'Medjunarodni'): ?>
                                        <option value="<?= $_GET['time'] ?>"> <?= $_GET['time'] ?> : 00 </option>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                                           <option value=""> CEO DAN </option>                                                                    <option value="1">1 : 00 h</option>                                                                    <option value="2">2 : 00 h</option>                                                                    <option value="3">3 : 00 h</option>                                                                    <option value="4">4 : 00 h</option>                                                                    <option value="5">5 : 00 h</option>                                                                    <option value="6">6 : 00 h</option>                                                                    <option value="7">7 : 00 h</option>                                                                    <option value="8">8 : 00 h</option>                                                                    <option value="9">9 : 00 h</option>                                                                    <option value="10">10 : 00 h</option>                                                                    <option value="11">11 : 00 h</option>                                                                    <option value="12">12 : 00 h</option>                                                                    <option value="13">13 : 00 h</option>                                                                    <option value="14">14 : 00 h</option>                                                                    <option value="15">15 : 00 h</option>                                                                    <option value="16">16 : 00 h</option>                                                                    <option value="17">17 : 00 h</option>                                                                    <option value="18">18 : 00 h</option>                                                                    <option value="19">19 : 00 h</option>                                                                    <option value="20">20 : 00 h</option>                                                                    <option value="21">21 : 00 h</option>                                                                    <option value="22">22 : 00 h</option>                                                                    <option value="23">23 : 00 h</option>                                                                    <option value="24">24 : 00 h</option>                                                        </select>
                                </select>
                                <input type="hidden" value="Medjunarodni" name="tip" class="form-control">
                                <button type="submit" id="submit-button-medjunarodni" class="btn btn-danger form-control my-2 rounded-0">Pretraga</button>
                            </div>
                        </div>
                    </form>
                </div>                
            </div>
        </div>
    </div>                            
</div>

