<?php 
global $wpdb;

if(isset($_GET['linija_id'])) {
	if(isset($_GET['linija_edit'])){
		edit_linija($_GET['linija_id']);
	}
	elseif(isset($_GET['obrisi'])){
		obrisi($_GET['linija_id']);
	}
	else{
		display_linija($_GET['linija_id']);
	}
} 
else { 
$q = $wpdb->get_results("SELECT * FROM lb1706wp_lasta_linija ORDER BY `broj`, `opis`");
	?>
	
	<form method="GET" action="admin.php">
		<input type='hidden' name='page' value='lasta-view' />
		Izaberite liniju: <select name="linija_id">	
		<?php

		foreach($q as $row) { ?>
			<option value="<?php echo $row->id; ?>"><?php echo $row->broj, " - ", $row->opis; ?></option>
		<?php } ?>
		
		</select><br />
		<input type="submit" value="Prikazi" />
		<input type="submit" name="obrisi" value="Obrisi" />
	</form>
	
<?php } ?>