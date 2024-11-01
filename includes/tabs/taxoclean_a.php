<?php

function taxoclean_a(): bool {
	taxoclean_change_copyright();
	$twig = taxoclean_get_twig();

	try {
		$twig->display( 'about.html.twig', [
			"section" => "a",
			"counter" => get_option( "taxoclean_counter" ),
			"license" => get_option( "taxoclean_license" )
		] );
	} catch ( Exception $e ) {
		echo sanitize_text_field($e->getMessage());
	}
	return true;
}