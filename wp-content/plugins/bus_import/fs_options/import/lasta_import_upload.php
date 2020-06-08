<?php 

if(!isset($_POST['type']))
	die('no type');

if(!isset($_FILES['Filedata']))
	die('no xls file');

if($_FILES['Filedata']['error'] != UPLOAD_ERR_OK)
	die('xls upload error');

$wp_load = "wp-load.php";
while(!file_exists($wp_load)) {
	$wp_load = "../$wp_load";
}
require_once($wp_load);

loadLineDataFromXLS($_FILES['Filedata']['tmp_name']);

function loadLineDataFromXLS($filename) {	
	//var_dump($filename);
	global $wpdb;
	$wpdb->show_errors();

	require_once 'PHPExcel.php';
	require_once 'PHPExcel/IOFactory.php';
	set_time_limit(300);
	mysql_set_charset('utf8');
	
	$objPHPExcel = PHPExcel_IOFactory::load($filename);
	if(!$objPHPExcel) {
		echo 'Greska: neispravan fajl';
		return;
	}
	$objWorksheet = $objPHPExcel->getActiveSheet();

	$highestRow = $objWorksheet->getHighestRow();
	$highestColumn = PHPExcel_Cell::columnIndexFromString($objWorksheet->getHighestColumn());

	if(strlen($objWorksheet->getCell("A1")->getValue()) <= 0) {
		echo 'Greska: prazan id';
		return;
	}
	
	$gradovi_str = trim($objWorksheet->getCell("B1")->getValue());
	
	$gradovi_str = str_replace('', '-', $gradovi_str);
	$gradovi_str = str_replace(chr(226) . chr(128) . chr(147), '-', $gradovi_str);    // bullet
	$gradovi_str = str_replace(chr(149), '-', $gradovi_str);    // bullet
	$gradovi_str = str_replace(chr(150), '-', $gradovi_str);    // endash
	$gradovi_str = str_replace(chr(151), '-', $gradovi_str);   // emdash
	
	$gradovi = explode('-', $gradovi_str);
	foreach($gradovi as $si => $sv)
		$gradovi[$si] = trim(str_replace("(AS)", '', $sv));
	
	$gradovi_reverse = array_reverse($gradovi);
	ksort($gradovi_reverse);	
	
	$opis = implode(' - ', $gradovi);
	$opis_dolazak = implode(' - ', $gradovi_reverse);	
	
	$glavne_stanice = array();
	for ($row = 5; $row <= $highestRow; ++$row) {
		
		$stajaliste_name = trim(str_replace("(AS)", '', $objWorksheet->getCell("A" . $row)->getValue()));
		if($stajaliste_name == "")
			break;
		
		if(mb_strtoupper($stajaliste_name, 'UTF-8') == $stajaliste_name && !in_array($stajaliste_name, $glavne_stanice))
			$glavne_stanice[] = $stajaliste_name;
	}
	if(count($glavne_stanice) == 0)
		$glavne_stanice = $gradovi;
		
	// delete old data
	$lrow = $wpdb->get_row("SELECT `id` FROM lb1706wp_lasta_linija WHERE `broj`='" . trim($objWorksheet->getCell("A1")->getValue()) . "' AND `opis`='$opis'");
	if($lrow) {
		$wpdb->query("DELETE FROM lb1706wp_lasta_termin WHERE `polazak_id` IN (SELECT `id` FROM " . $wpdb->prefix . "lasta_polazak WHERE `linija_id`=" . $lrow->id . ")");
		$wpdb->query("DELETE FROM lb1706wp_lasta_polazak WHERE `linija_id`=" . $lrow->id);
		$wpdb->query("DELETE FROM lb1706wp_lasta_stajaliste WHERE `linija_id`=" . $lrow->id);
		$wpdb->query("DELETE FROM lb1706wp_lasta_linija WHERE `id`=" . $lrow->id);
	}
	
	$wpdb->insert(
		"lb1706wp_lasta_linija",
		array(  
			'broj' => trim($objWorksheet->getCell("A1")->getValue()),
			'tip' => $_POST['type'],
			'opis' => $opis,
			'opis_dolazak' => $opis_dolazak,
			'gradovi' => implode('|', $glavne_stanice),
			'has_dolazak' => 0,
			'broj_stajalista' => 0,
			'info' => trim($objWorksheet->getCell("B2")->getValue()),
			'info_kontakt' => trim($objWorksheet->getCell("B3")->getValue())
		)
	);
	
	$linija_id = $wpdb->insert_id;
	$has_dolazak = 0;
	
	$stajaliste_ids = array();
	for ($row = 5; $row <= $highestRow; ++$row) {
		
		if(trim($objWorksheet->getCell("A" . $row)->getValue()) == "")
			break;
		
		$wpdb->insert(
			"lb1706wp_lasta_stajaliste",
			array (
				'linija_id' => $linija_id,
				'rb' => $row - 4,
				'naziv' => trim(str_replace("(AS)", '', $objWorksheet->getCell("A" . $row)->getValue())),
				'info' => $objWorksheet->getCell("B" . $row)->getValue(),
				'km' => $objWorksheet->getCell("C" . $row)->getValue()
			)
		);
		$stajaliste_ids[] = $wpdb->insert_id;
	}
	$highestRow = $row - 1;
	
	$termini_value_strings = array();
	for ($col = 3; $col <= $highestColumn; ++$col) {
		
		if(trim($objWorksheet->getCellByColumnAndRow($col, 4)->getValue()) == "")
			break;
		
		$dani = $objWorksheet->getCellByColumnAndRow($col, 4)->getValue();
		
		if(strpos($dani, 'd') !== false)
			$has_dolazak = 1;
		
		$wpdb->insert(
		   "lb1706wp_lasta_polazak",
			array( 
				'linija_id' => $linija_id,
				'rb' => $col - 2,
				'dolazak' => (strpos($dani, 'd') === false ? 0 : 1),
				'pon' => (strpos($dani, '1') === false ? 0 : 1),
				'uto' => (strpos($dani, '2') === false ? 0 : 1),
				'sre' => (strpos($dani, '3') === false ? 0 : 1),
				'cet' => (strpos($dani, '4') === false ? 0 : 1),
				'pet' => (strpos($dani, '5') === false ? 0 : 1),
				'sub' => (strpos($dani, '6') === false ? 0 : 1),
				'ned' => (strpos($dani, '7') === false ? 0 : 1),
				'praznik' => (strpos($dani, 'p') === false ? 0 : 1),
			)						
		);
		$polazak_id = $wpdb->insert_id;		
		
		for ($row = 5; $row <= $highestRow; ++$row) {
		
			$cell = $objWorksheet->getCellByColumnAndRow($col, $row);
			$cell_value = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'hh:mm');

			$termini_value_strings[] = "($polazak_id, {$stajaliste_ids[$row  - 5]}, '$cell_value')";
			
			/*
			$wpdb->insert(				
				array( 
					'polazak_id' => $polazak_id,
					'stajaliste_id' => $stajaliste_ids[$row  - 5],
					'vreme' => $cell_value
				)
			);
			*/
		}
	}
	
	$wpdb->query("INSERT INTO lb1706wp_lasta_termin(`polazak_id`, `stajaliste_id`, `vreme`) VALUES" . implode(',', $termini_value_strings));
	
	foreach($glavne_stanice as $grad) {
		$grad_linije = array();
		$grad_row = $wpdb->get_row("SELECT * FROM lb1706wp_lasta_grad WHERE `naziv`='$grad'");
		if(!$grad_row) {
			$wpdb->insert(
				"lb1706wp_lasta_grad",
				array( 
					'naziv' => $grad,
					'linije' => '',
					'domaci' => false,
					'medjunarodni' => false,
					'sezonski' => false,
				)
			);
			$grad_id = $wpdb->insert_id;
		}
		else {
			$grad_id = $grad_row->id;
			$grad_linije = explode(',', $grad_row->linije);
		}
		
		if(!in_array($linija_id, $grad_linije))
			$grad_linije[] = $linija_id;
			
		sort($grad_linije);
		
		$wpdb->update( 
			"lb1706wp_lasta_grad", 
			array( 
				'linije' => implode(',', $grad_linije),
				strtolower($_POST['type']) => true,
			), 
			array('id' => $grad_id)
		);
	}
	
	$wpdb->update( 
		"lb1706wp_lasta_linija", 
		array(
			'has_dolazak' => $has_dolazak,
			'broj_stajalista' => count($stajaliste_ids),
		), 
		array('id' => $linija_id)
	);
	
	echo 'OK';
}

/*
prvi broj oznacava broj linije 
posle toga sledi ime linije

ostali parametri su:

km - kilometri

o - oznacava odlazne linije
d - oznacava dolazne (povratne) linije
1234... - oznacava dane kada linija saobraca i uvek ide u kombinaciji sa
jednim od prethodna dva atributa
p - praznik

info linije - je info da recimo u vreme skolski praznika ne radi linija ili
tako nesto sto se ne ponavlja i nemoguce ga je isprogramirati
info kontak - je kontakt u autobusu za inostranstvo
info stanice je opis u medjunarodnoj tabeli za stanice - gradove




*/
