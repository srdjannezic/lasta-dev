<?php

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

global $wpdb;
//$wpdb->hide_errors();

$sql = "CREATE TABLE " . $wpdb->prefix . "lasta_linija (
	`id` INT NOT NULL AUTO_INCREMENT ,
	`broj` INT NOT NULL ,
	`tip` TEXT NOT NULL ,
	`opis` TEXT NOT NULL ,
	`opis_dolazak` TEXT NOT NULL ,
	`gradovi` TEXT NOT NULL ,
	`has_dolazak` BOOL NOT NULL ,
	`broj_stajalista` INT NOT NULL ,
	`info` TEXT NOT NULL ,
	`info_kontakt` TEXT NOT NULL ,
	
	PRIMARY KEY (  `id` )
);";
$n1 = dbDelta($sql);

$sql = "CREATE TABLE " . $wpdb->prefix . "lasta_stajaliste (
	`id` INT NOT NULL AUTO_INCREMENT ,
	`linija_id` INT NOT NULL ,
	`rb` INT NOT NULL ,	
	`naziv` TEXT NOT NULL ,
	`info` TEXT NOT NULL ,
	`km` TEXT NOT NULL ,
	
	PRIMARY KEY (  `id` )
);";
$n2 = dbDelta($sql);

$sql = "CREATE TABLE " . $wpdb->prefix . "lasta_polazak (
	`id` INT NOT NULL AUTO_INCREMENT ,
	`linija_id` INT NOT NULL ,
	`rb` INT NOT NULL ,	
	`dolazak` BOOL NOT NULL ,
	`pon` BOOL NOT NULL ,
	`uto` BOOL NOT NULL ,
	`sre` BOOL NOT NULL ,
	`cet` BOOL NOT NULL ,
	`pet` BOOL NOT NULL ,
	`sub` BOOL NOT NULL ,
	`ned` BOOL NOT NULL ,
	`praznik` BOOL NOT NULL ,
	
	PRIMARY KEY (  `id` )
);";
$n3 = dbDelta($sql);

$sql = "CREATE TABLE " . $wpdb->prefix . "lasta_termin (
	`id` INT NOT NULL AUTO_INCREMENT ,
	`polazak_id` INT NOT NULL ,
	`stajaliste_id` INT NOT NULL ,	
	`vreme` TEXT NOT NULL ,
	
	PRIMARY KEY (  `id` )
);";
$n4 = dbDelta($sql);

$sql = "CREATE TABLE " . $wpdb->prefix . "lasta_grad (
	`id` INT NOT NULL AUTO_INCREMENT ,
	`naziv` TEXT NOT NULL ,
	`linije` TEXT NOT NULL ,
	`domaci` BOOL NOT NULL ,
	`medjunarodni` BOOL NOT NULL ,
	`sezonski` BOOL NOT NULL ,
	
	PRIMARY KEY (  `id` )
);";
$n4 = dbDelta($sql);

$wpdb->show_errors();
