<div class="wrap">
	<h2>Brisanje podataka</h2>
	<?php if(isset($_POST['lasta_confirm_clear'])) {
		
		$wpdb->query("DELETE FROM lb1706wp_lasta_grad");
		$wpdb->query("DELETE FROM lb1706wp_lasta_linija");
		$wpdb->query("DELETE FROM lb1706wp_lasta_polazak");
		$wpdb->query("DELETE FROM lb1706wp_lasta_stajaliste");
		$wpdb->query("DELETE FROM lb1706wp_lasta_termin");

		echo "Svi podaci o linijama su izbrisani iz baze.";
		
	} else { ?>		
		
		<form method="POST" action="admin.php?page=lasta-clear">
			<input type='hidden' name='lasta_confirm_clear' value='1' />
			Da li ste sigurni da zelite da izbrisete sve podatke o linijama iz baze?
			<br /><br />
			<input class="button-primary" type="submit" value="Izbrisi sve podatke" />
		</form>
		
	<?php } ?>
</div>