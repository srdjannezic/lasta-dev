<?php

if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
	include("lasta_import_install.php");
}

if(is_admin()) {
	wp_enqueue_script('swfupload');
	wp_enqueue_script('swfupload-queue');
}

add_action( 'admin_menu', 'lasta_import_pages');
function lasta_import_pages() {
	add_menu_page('Import XLS', 'Lasta Linije', 'manage_import_xsl', 'lasta-import', 'lasta_import');	
	add_submenu_page('lasta-import', 'Pregled po polascima', 'Pregled po polascima', 'manage_import_xsl', 'lasta-view', 'lasta_view');	
	add_submenu_page('lasta-import', 'Brisanje podataka', 'Brisanje podataka', 'manage_import_xsl', 'lasta-clear', 'lasta_clear');	
}

function lasta_import() {
	global $wpdb;
	include("lasta_import_main.php");
}

function lasta_import_upload() {
	global $wpdb;
	include("lasta_import_upload.php");
}

function lasta_view() {
	global $wpdb;
	include("lasta_import_view.php");
}

function lasta_clear() {
	global $wpdb;
	include("lasta_import_clear.php");
}

function edit_linija($linija_id) {
	global $wpdb;

	
	$lrow = $wpdb->get_row("SELECT * FROM lb1706wp_lasta_linija WHERE `id`=" . $linija_id);
	//$lrow = mysql_fetch_array($q);
	
	$stajaliste_rows = array();
	$sq = $wpdb->get_results("SELECT * FROM lb1706wp_lasta_stajaliste WHERE `linija_id`=" . $linija_id . " ORDER BY `rb` ASC");
	foreach($sq as $srow)
		$stajaliste_rows[] = $srow;
	
	$polazak_rows = array();
	$pq = $wpdb->get_results("SELECT * FROM lb1706wp_lasta_polazak WHERE `linija_id`=" . $linija_id . " ORDER BY `rb` ASC");
	foreach($pq as $prow)
		$polazak_rows[] = $prow;

	?>
	<h3>Izmena informacija za liniju <?php echo (isset($lrow ->opis)) ? $lrow ->opis : '';?> (<?= $linija_id ?>)</h3>
	<form action="/wp-admin/admin-post.php" method="post" name="new_vehicle" enctype="multipart/form-data">
            <table class = "widefat" style="width:600px">
                <tr>
                   <th scope = "row" width = "150px">Broj: </th>
                   <td>
                        <input type="text" name="broj" value="<?php echo (isset($lrow ->broj)) ? $lrow ->broj : '';?>">
                   </td>
                </tr>
                <tr>
                   <th scope = "row" width = "150px">Tip: </th>
                   <td>
                        <input type="text" name="tip" value="<?php echo (isset($lrow ->tip)) ? $lrow ->tip : '';?>">
                   </td>
                </tr>
                <tr>
                   <th scope = "row" width = "150px">Opis: </th>
                   <td>
                        <textarea name="opis" rows="5" cols="30"><?php echo (isset($lrow ->opis)) ? $lrow ->opis : '';?></textarea>
                   </td>
                </tr>
                <tr>
                   <th scope = "row" width = "150px">Opis dolazka: </th>
                   <td>
                        <textarea name="opis_dolazak" rows="5" cols="30"><?php echo (isset($lrow ->opis_dolazak)) ? $lrow ->opis_dolazak : '';?></textarea>
                   </td>
                </tr>
                <tr>
                   <th scope = "row" width = "150px">Broj Stajalista: </th>
                   <td>
                        <input type="text" name="broj_stajalista" value="<?php echo (isset($lrow ->broj_stajalista)) ? $lrow ->broj_stajalista : '';?>">
                   </td>
                </tr>
                <tr>
                   <th scope = "row" width = "150px">Info Linije: </th>
                   <td>
                        <textarea name="info" rows="5" cols="30"><?php echo (isset($lrow ->info)) ? $lrow ->info : '';?></textarea>
                   </td>
                </tr>
                <tr>
                   <th scope = "row" width = "150px">Info Kontakt: </th>
                   <td>
                        <textarea name="info_kontakt" rows="5" cols="30"><?php echo (isset($lrow ->info_kontakt)) ? $lrow ->info_kontakt : '';?></textarea>
                   </td>
                </tr>
                <tr>
                   <th scope = "row" width = "150px">Gradovi: </th>
                   <td>
                        <textarea name="gradovi" rows="10" cols="60"><?php echo (isset($lrow ->gradovi)) ? $lrow ->gradovi : '';?></textarea>
                   </td>
                </tr>
                <tr>
                   <th scope = "row" width = "150px">Polasci: </th>
                   <td>
                   		<tr>
	 						<?php foreach($polazak_rows as $prow) { 
								
								?>	
								<td>
								<input type="hidden" name="rb[]" value="<?php echo $prow->rb ?>">
								Dolazak: <br/><input type="text" name="dolazak[]" value="<?php echo $prow->dolazak; ?>" /><br/>
								Ponedeljak: <br/><input type="text" name="ponedeljak[]" value="<?php echo $prow->pon; ?>" /><br/>
								Utorak: <br/><input type="text" name="utorak[]" value="<?php echo $prow->uto; ?>" /><br/>
								Sreda: <br/><input type="text" name="sreda[]" value="<?php echo $prow->sre; ?>" /><br/>
								Cetvrtak: <br/><input type="text" name="cetvrtak[]" value="<?php echo $prow->cet; ?>" /><br/>
								Petak: <br/><input type="text" name="petak[]" value="<?php echo $prow->pet; ?>" /><br/>
								Subota: <br/><input type="text" name="subota[]" value="<?php echo $prow->sub; ?>" /><br/>
								Nedelja: <br/><input type="text" name="nedelja[]" value="<?php echo $prow->ned; ?>" /><br/>
								Praznik: <br/><input type="text" name="praznik[]" value="<?php echo $prow->praznik; ?>" /><br/>
								</td>
								
							
							<?php } ?>
						</tr>
                   </td>
                </tr>
                <tr>
                   <th scope = "row" width = "150px">Stajalista: </th>
                   <td>
                   		<tr>
	                   		<td><strong>RB</strong></td><td><strong>Stanica</strong></td><td><strong>Info</strong></td><td><strong>km</strong></td>
	 						<?php foreach($polazak_rows as $prow) { ?>
								
							<td><strong><?php echo format_dani($prow); ?></strong></td>
							
							<?php } ?>
						</tr>
						<?php foreach($stajaliste_rows as $srow) { ?>		
						<tr>
							<input type="hidden" name="stajaliste_id[]" value="<?php echo $srow->id ?>" />
							<td><input type="text" name="stajaliste_rb[]" value="<?php echo $srow->rb; ?>" /></td>
							<td><input type="text" name="naziv[]" value="<?php echo $srow->naziv; ?>" /></td>
							<td><input type="text" name="stajaliste_info[]" value="<?php echo $srow->info; ?>" /></td>
							<td><input type="text" name="km[]" value="<?php echo $srow->km; ?>" /></td>
							<?php foreach($polazak_rows as $prow) {
							 ?>	
							<?php $t = $wpdb->get_row("SELECT * FROM lb1706wp_lasta_termin WHERE `stajaliste_id`=" . $srow->id . " AND `polazak_id`=" . $prow->id); ?>
							<?php //$t = mysql_fetch_array($tq); ?>
							<td style="border: 1px solid black; padding: 10px;"><input type="text" name="vreme[<?php echo $t->polazak_id ?>][<?php echo $srow->id ?>]" value="<?php echo $t->vreme; ?>"/></td>
							<input type="hidden" name="polazak_id[]" value="<?php echo $t->polazak_id ?>" >
							<?php } ?>
						</tr>
						<?php } ?>
                   </td>
                </tr>
            </table>
            <input type="hidden" name="action" value="new_edit_linija">
            <input type="hidden" name="linija_id" value="<?= $linija_id ?>">
            <input type="submit" value="Izmeni" />
	</form>
	<?php
}

function obrisi($linija_id){
	global $wpdb;

	$wpdb->query('DELETE FROM lb1706wp_lasta_linija WHERE `id`=' . esc_sql($linija_id));
	$wpdb->query('DELETE FROM lb1706wp_lasta_stajaliste WHERE `linija_id`=' . esc_sql($linija_id));
	$wpdb->query('DELETE FROM lb1706wp_lasta_polazak WHERE `linija_id`=' . esc_sql($linija_id));

	echo "Uspesno ste obrisali podatke za liniju: " . $linija_id;
}

function display_linija($linija_id) {
	global $wpdb;

	
	$lrow = $wpdb->get_row("SELECT * FROM lb1706wp_lasta_linija WHERE `id`=" . $linija_id);
	//$lrow = mysql_fetch_array($q);
	
	$stajaliste_rows = array();
	$sq = $wpdb->get_results("SELECT * FROM lb1706wp_lasta_stajaliste WHERE `linija_id`=" . $linija_id . " ORDER BY `rb` ASC");
	foreach($sq as $srow)
		$stajaliste_rows[] = $srow;
	
	$polazak_rows = array();
	$pq = $wpdb->get_results("SELECT * FROM lb1706wp_lasta_polazak WHERE `linija_id`=" . $linija_id . " ORDER BY `rb` ASC");
	foreach($pq as $prow)
		$polazak_rows[] = $prow;


	//var_dump($polazak_rows);
	echo $lrow->broj, "&nbsp;&nbsp;&nbsp;", $lrow->opis , "<br />";
	echo "<strong>Info linije:</strong>", "&nbsp;&nbsp;", $lrow->info, "<br />";
	echo "<strong>Info kontakt:</strong>", "&nbsp;&nbsp;", $lrow->info_kontakt, "<br />";
	
	?>
	<br />	
	<p><a href="/wp-admin/admin.php?page=lasta-view&linija_id=<?= $linija_id ?>&linija_edit">Promeni Informacije</a></p>	
	<br/>
	<table style="border: 1px solid black;" cellpadding="3" cellspacing="3">
		<tr>
			<td><strong>Stanica</strong></td><td><strong>Info</strong></td><td><strong>km</strong></td>
			<?php foreach($polazak_rows as $prow) { ?>	
			<td><strong><?php echo format_dani($prow); ?></strong></td>
			<?php } ?>
		</tr>			
		<?php foreach($stajaliste_rows as $srow) { ?>		
		<tr>
			<td><?php echo $srow->naziv; ?></td>
			<td><?php echo $srow->info; ?></td>
			<td><?php echo $srow->km; ?></td>
			<?php foreach($polazak_rows as $prow) {
			 ?>	
			<?php $t = $wpdb->get_row("SELECT * FROM lb1706wp_lasta_termin WHERE `stajaliste_id`=" . $srow->id . " AND `polazak_id`=" . $prow->id); ?>
			<?php //$t = mysql_fetch_array($tq); ?>
			<td style="border: 1px solid black; padding: 0px;"><?php echo $t->vreme; ?></td>
			<?php } ?>
		</tr>
		<?php } ?>
	</table>

<?php
}

function format_dani($row) {
	$s = ($row->dolazak == "1" ? "d" : "o");
	$s .= ($row->pon == "1" ? ",1" : "");
	$s .= ($row->uto == "1" ? ",2" : "");
	$s .= ($row->sre == "1" ? ",3" : "");
	$s .= ($row->cet == "1" ? ",4" : "");
	$s .= ($row->pet == "1" ? ",5" : "");
	$s .= ($row->sub == "1" ? ",6" : "");
	$s .= ($row->ned == "1" ? ",7" : "");
	$s .= ($row->praznik == "1" ? ",p" : "");
	return $s;
}

function format_polazak_dani($prows) {
	if(!is_array($prows))
		$prows = array($prows);		
	$d = array();
	foreach($prows as $prow) {
		if($prow->pon) if(!in_array('Ponedeljak', $d)) $d[0] = "Ponedeljak";
		if($prow->uto) if(!in_array('Utorak', $d)) $d[1] = "Utorak";
		if($prow->sre) if(!in_array('Sreda', $d)) $d[2] = "Sreda";
		if($prow->cet) if(!in_array('Cetvrtak', $d)) $d[3] = "Cetvrtak";
		if($prow->pet) if(!in_array('Petak', $d)) $d[4] = "Petak";
		if($prow->sub) if(!in_array('Subota', $d)) $d[5] = "Subota";
		if($prow->ned) if(!in_array('Nedelja', $d)) $d[6] = "Nedelja";
		if($prow->praznik) if(!in_array('Praznik', $d)) $d[7] = "Praznik";
	}
	if(isset($d[0]) && isset($d[1]) && isset($d[2]) && isset($d[3]) && isset($d[4]) && isset($d[5]) && isset($d[6])) {
		if(isset($d[7]))
			return "Svakodnevno, praznikom";
		else
			return "Svakodnevno, osim praznikom";
	}
	ksort($d);
	return implode(', ', $d);
}
