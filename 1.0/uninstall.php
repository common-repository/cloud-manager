<?php

if( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();
	
global $wpdb;
cloud_rimuoviopzioni();
cloud_disinstalla( $wpdb->prefix );

function cloud_rimuoviopzioni(){
	$opzioni = get_option( 'cloud_impostazioni' );

	if( $opzioni != false ) {
	
		$visualizza = $opzioni['id_visualizza']; // Pagina visualizza
		$inserisci  = $opzioni['id_inserisci']; // Pagina Inserisci
		$commenti  = $opzioni['id_commenti']; // Pagina Inserisci
		$presentazione  = $opzioni['id_presentazione']; // Pagina presentazione
		
		// Eliminazione pagine
		if( $visualizza ) wp_delete_post( $visualizza );
		if( $inserisci ) wp_delete_post( $inserisci );
		if( $commenti ) wp_delete_post( $commenti );
		if( $presentazione ) wp_delete_post( $presentazione );
		
		// Eliminazione di tutte le opzioni
		delete_option( 'cloud_impostazioni'); 
	}
}

function cloud_disinstalla( $prefix ) {
	global $wpdb;

    $file_query = "SELECT * FROM " . $prefix . "cloudfiles";
    $array_files = $wpdb->get_results( $wpdb->prepare( $file_query ), ARRAY_A );
	
    if ( !empty( $array_files ) ) {
		// Estrazione valori
        foreach ( $array_files as $curr_file ) {
			$link_file = $curr_file['dir_file'];
			if ($link_file != "") unlink($link_file);
        }
    }
	
	$wpdb->query( $wpdb->prepare( 'DROP TABLE ' . $prefix .	'cloudfiles' ) );
	$wpdb->query( $wpdb->prepare( 'DROP TABLE ' . $prefix .	'cloudcommenti' ) );
}
	
?>