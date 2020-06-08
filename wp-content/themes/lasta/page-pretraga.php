<?php
/* 
Template Name: Pretraga
 */



global $wpdb;

					
$datum = time();			
$datum_parts = explode(".", $_GET['date']);
if(count($datum_parts) == 3)
	$datum = mktime(0, 0, 0, $datum_parts[1], $datum_parts[0], $datum_parts[2]);
//var_dump($datum);
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
$tip = $_GET['tip'];

$grad1_row = $wpdb->get_row("SELECT * FROM lb1706wp_lasta_grad WHERE id = $domestic_1");
$grad2_row = $wpdb->get_row("SELECT * FROM lb1706wp_lasta_grad WHERE id = $domestic_2");

//var_dump($grad1_row); 

if($tip == 'Gradski'){
	if(!$grad1_row){

	}

	$linije_ids = explode(',', $grad1_row->linije);
}
else{
	if(!$grad1_row || !$grad2_row) {
		// nepostojeci grad
	}
	$linije_ids = array_intersect(explode(',', $grad1_row->linije), explode(',', $grad2_row->linije));
}


//var_dump($linije_ids);
$polasci_za_prikaz = array();
$i = 0;
$linije = $wpdb->get_results("SELECT * FROM lb1706wp_lasta_linija WHERE `id` IN (" . implode(',', $linije_ids) . ") AND `tip`='".$tip."' ORDER BY broj");
// var_dump("SELECT * FROM lb1706wp_lasta_linija WHERE `id` IN (" . implode(',', $linije_ids) . ") AND `tip`='".$tip."' ORDER BY broj");
//var_dump($grad1_row->linije);

//var_dump($linije);

foreach($linije as $linija_row) {

	$gradovi = explode('|', $linija_row->gradovi);

	if($tip == 'Gradski'){
		$grad1_pos = array_search($grad1_row->naziv, $gradovi);
		if($grad1_pos === false)
			continue;
		$dolazak = false;
		if($dolazak)
			continue;
	}
	else{
		$grad1_pos = array_search($grad1_row->naziv, $gradovi);
		$grad2_pos = array_search($grad2_row->naziv, $gradovi);
		if($grad1_pos === false || $grad2_pos === false)
			continue;
		$dolazak = $grad1_pos > $grad2_pos;
		if($dolazak && !$linija_row->has_dolazak)
			continue;
	}
	$stajalista = $wpdb->get_results("SELECT * FROM lb1706wp_lasta_stajaliste WHERE `linija_id`={$linija_row->id} ORDER BY `rb`");
	$grad1_stajaliste_id = -1;
	$grad2_stajaliste_id = -1;
	$grad1_short_naziv = trim(preg_replace("/\([^\)]*\)/", "", $grad1_row->naziv));
	if($tip != 'Gradski'){
			$grad2_short_naziv = trim(preg_replace("/\([^\)]*\)/", "", $grad2_row->naziv));
	}
	foreach($stajalista as $srow) {
		$stajaliste_short_naziv = trim(preg_replace("/\([^\)]*\)/", "", $srow->naziv));
		if($stajaliste_short_naziv == $grad1_short_naziv)
			$grad1_stajaliste_id = $srow->id;
		if($tip != 'Gradski'){
				if($stajaliste_short_naziv == $grad2_short_naziv)
					$grad2_stajaliste_id = $srow->id;
		}
	}
	if($tip == 'Gradski'){
		$grad2_stajaliste_id = $stajalista[count($stajalista)-1]->id;
	}
	if($tip != 'Gradski'){
		if($grad2_stajaliste_id == -1 && $grad2_stajaliste_id == -1) // bug
			continue;
	}
	if($_GET['date'] != '') {
	$polasci = $wpdb->get_results("SELECT *, 
								   (SELECT `vreme` FROM lb1706wp_lasta_termin 
								   WHERE `polazak_id`=lb1706wp_lasta_polazak.id AND `stajaliste_id`=$grad1_stajaliste_id) AS grad1_vreme,
								   (SELECT `vreme` FROM lb1706wp_lasta_termin 
								   WHERE `polazak_id`=lb1706wp_lasta_polazak.id AND `stajaliste_id`=$grad2_stajaliste_id) AS grad2_vreme											   
								   FROM lb1706wp_lasta_polazak
								   WHERE `linija_id`={$linija_row->id} AND `$polazak_filter_column`=1 
								   AND `dolazak`=" . ($dolazak ? 1 : 0) . " ORDER BY `rb`");
	
	foreach($polasci as $prow) {				
		$vreme_polaska_parts = explode(':', $prow->grad1_vreme);
		if(count($vreme_polaska_parts) < 2)
			continue;
		

		if($vreme_polaska_parts[0] + 0 < $vreme_sat)
			continue;
		
		$polasci_za_prikaz[] = array("linija_row" => $linija_row, "prow" => $prow, "dolazak" => $dolazak);
		//var_dump($polasci_za_prikaz);
	}
	} else {

		$polasci = $wpdb->get_results("SELECT *, 
								   (SELECT `vreme` FROM lb1706wp_lasta_termin 
								   WHERE `polazak_id`=lb1706wp_lasta_polazak.id AND `stajaliste_id`=$grad1_stajaliste_id) AS grad1_vreme,
								   (SELECT `vreme` FROM lb1706wp_lasta_termin 
								   WHERE `polazak_id`=lb1706wp_lasta_polazak.id AND `stajaliste_id`=$grad2_stajaliste_id) AS grad2_vreme											   
								   FROM lb1706wp_lasta_polazak
								   WHERE `linija_id`={$linija_row->id} 
								   AND `dolazak`=" . ($dolazak ? 1 : 0) . " ORDER BY `rb`");
	foreach($polasci as $prow) {
		$vreme_polaska_parts = explode(':', $prow->grad1_vreme);
		if(count($vreme_polaska_parts) < 2)
			continue;
		
		
		if($vreme_polaska_parts[0] + 0 < $vreme_sat)
			continue;
		$polasci_za_prikaz[] = array("linija_row" => $linija_row, "prow" => $prow, "dolazak" => $dolazak);
	}
	}
}
// sort
function cmp_polazak($a, $b) {
	//$ta = strtotime($a['prow']->grad1_vreme);
	//$tb = strtotime($b['prow']->grad1_vreme);
	//if($ta == $tb)
	//	return 0;
	//return $ta > $tb ? 1 : -1;
	return strcmp($a['prow']->grad1_vreme, $b['prow']->grad1_vreme);
}
usort($polasci_za_prikaz, "cmp_polazak");
$count_if_any = 0;

//var_dump($polasci_za_prikaz);
//var_dump($results);

get_header(); 



?>
<!-- <h1><?php echo $grad1_row->naziv, ' - ', $grad2_row->naziv; ?></h1>-->

        <div class="wrap">
            <div id="primary" class="content-area">
                <div id="hero-results" class="container-fluid p-0">
                <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                    <!-- Jumbotron -->                    
                    <div class="jumbotron-fluid py-6 d-flex flex-row justify-content-center align-items-start" style="background-image: url('<?php echo $feat_image ?>');background-repeat: no-repeat;background-size: cover;min-height:500px;">
                        <?php get_template_part( 'template-parts/line-search', 'none' ); ?>
                    </div><!-- Jumbotron -->                    
                </div><!-- #hero-results -->
                <div id="results" class="container px-0">
                    <div class="col bg-blue text-center">
                        <h4 class="text-white py-3"><span class="text-white"><?= $grad1_row->naziv ?></span><span class="text-red"> --- </span><span class="text-white"><?= $grad2_row->naziv ?></span></h4>
                    </div>
                    <div class="col-lg-12 px-0">                        
                        <table class="table table-responsive-sm"  id="tableresults">
                            <thead class="thead bg-d-blue text-white py-2">
                                <tr>
                                    <th class="py-1">Vreme polaska</th>
                                    <th class="py-1">Vreme dolaska</th>
                                    <th class="py-1">Autobuska linija</th>
                                    <th class="py-1">Saobraća Danima</th>
                                </tr>
                            </thead>
                            <?php
			foreach($polasci_za_prikaz as $key=>$pp) {
			
				$linija_row = $pp['linija_row'];
				$prow = $pp['prow'];
				$linija_id = $linija_row->id + 0;
				$polazak_id = $prow->id + 0;
				$dolazak = $pp['dolazak'] ? 1 : 0;
				// $info_linije = $prow->info_linije;

				//var_dump($linija_row);

				//echo $info_linije;
				?>
				<tbody class="bg-white result-info" data-toggle="collapse" href="#collapseInfo<?= $key ?>" role="button" aria-expanded="false" aria-controls="collapseExample">    
				<tr <?php echo ((($i++)%2 == 1) ? 'class="second_tr"' : ''); ?> 
					data-id="<?php echo $linija_row->id; ?>"
					data-polazak_id="<?php echo $prow->id; ?>"
					data-dolazak="<?php echo $pp['dolazak'] ? 1 : 0; ?>">
					<td class="first_col"><?php echo $prow->grad1_vreme; ?> <span style="font-size:13px;">(<?php echo $grad1_row->naziv; ?>)</span></td>
					<td class="bus_tour"><?php echo $prow->grad2_vreme; ?> <span style="font-size:13px;">(<?php echo $grad2_row->naziv; ?>)</span></td>
					<td class="bus_line" ><?php echo (!$pp['dolazak'] ? $linija_row->opis : $linija_row->opis_dolazak); ?></td>
					<td class="bus_tour"><?php echo format_polazak_dani($prow); ?></td>
				</tr>
				</tbody>
				<?php	
				$count_if_any++;			
			

$q = $wpdb->get_results("SELECT * FROM lb1706wp_lasta_linija WHERE `id`=" . $linija_id);
$lrow = $q;

$q = $wpdb->get_results("SELECT * FROM lb1706wp_lasta_polazak WHERE `id`=" . $polazak_id);
$polazak_row = $q;

$dolazak = $polazak_row[0]->dolazak;

$prikazi_info_kolonu = ($lrow[0]->tip == "Medjunarodni");

$stajaliste_rows = array();
$stajaliste_ids = array();
$sq = $wpdb->get_results("SELECT * FROM lb1706wp_lasta_stajaliste WHERE `linija_id`=" . $linija_id . " ORDER BY `rb` " . ($dolazak ? 'DESC' : 'ASC'));
foreach($sq as $srow) {
	//var_dump($srow);
	$stajaliste_rows[] = $srow;
	$stajaliste_ids[] = $srow->id;
}

$linija_km = ($dolazak ? $stajaliste_rows[0]->km : $stajaliste_rows[count($stajaliste_rows) - 1]->km);

$termini = array();
$tq = $wpdb->get_results("SELECT * FROM lb1706wp_lasta_termin WHERE `polazak_id`=$polazak_id
																	 AND `stajaliste_id` IN (" . implode(',', $stajaliste_ids) . ")");
foreach($tq as $trow) {
	$sid = $trow->stajaliste_id;
	$termini[$sid] = $trow->vreme;
} ?>
<tbody id="collapseInfo<?= $key ?>" class="bg-white collapse"><!-- Detaljni prikaz linije u dropdownu -->
    <tr class="bg-d-blue text-white py-2">
        <th class="py-1">Broj stanice</th>
        <th class="py-1">Kilometar</th>
        <th class="py-1">Nazivi stanice</th>
        <th class="py-1">Vreme na stanici</th>
    </tr>
<?php foreach($stajaliste_rows as $srow) { ?>		                   
			<tr <?php echo (($i%2 == 1) ? 'class="second_tr"' : ''); ?>>
				<td class="bus_rbr"><?php echo ($dolazak ? (count($stajaliste_rows) - $srow->rb + 1) : $srow->rb); ?></td>
				<td class="bus_km"><?php echo ($dolazak && is_numeric($srow->km) ? ($linija_km - $srow->km) : $srow->km); ?></td>
				<td class="bus_stop_name">
					<?php echo $srow->naziv; ?>
					<?php if($prikazi_info_kolonu && $srow->info) { ?>
                    <div class="bus_stop_info_hidden"><div><?php echo $srow->info; ?></div></div>
                    <div class="clear"></div>
                    <?php } ?>
                </td>
				<td class="bus_start bus_no_border"><?php echo $termini[$srow->id]; ?></td>
			</tr>

<?php } ?>
			<?php if($linija_row->info != '') : ?>
			<tr class="info-line"><td colspan="4"><?php echo $linija_row->info; ?></td></tr>
			<?php endif; ?>
</tbody>
<?php } ?>
                        </table>

		<?php
		if($count_if_any == 0)
			{
				echo '<div class="col-lg-9 mx-auto text-red" style="margin-top: 5px;"><b>Nema rezultata pretrage za zadate parametre. Molimo pokusajte ponovo sa drugim datumom ili vremenom. Za dodatne informacije o polascima, pozovite telefon 0800 334 334</b></div>';
			}
		?>         
                    </div>
                </div><!-- container -->
            </div><!-- content-area -->
        </div><!-- wrap -->
<?php


get_footer();