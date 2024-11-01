<?php

function taxoclean_l_ignores(): bool {
	taxoclean_change_copyright();
	$twig = taxoclean_get_twig();

    global $wpdb;

    if (isset($_GET["delete"])) {
        $wpdb->delete($wpdb->prefix."taxoclean_ignore", [
            "id" => intval($_GET["delete"])
        ]);
    }

    $taxo = get_option("taxoclean_current_taxo");
    $ignored = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."taxoclean_ignore WHERE taxonomy = '".$taxo."'");

	try {
		$twig->display( 'ignores.html.twig', [
			"section" => "i",
			"license"  => get_option( "taxoclean_license" ),
			"ignored" => $ignored
		] );
	} catch ( Exception $e ) {
		echo sanitize_text_field( $e->getMessage() );
	}

	return true;
}