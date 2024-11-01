<?php

function taxoclean_v($code): bool {

	$url = "https://www.taxoclean.com/?wc-api=serial-numbers-api&request=activate&product_id=12&serial_key=".$code."&instance=".$_SERVER["HTTP_HOST"];
	$response = wp_remote_get( $url );
	$body = wp_remote_retrieve_body( $response );
	$rep = json_decode($body, true);

	if ( isset($rep["data"]) ) {
		if ( $rep["data"]["code"] === "key_activated" || $rep["data"]["code"] === "instance_already_activated" ) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function taxoclean_s(): bool {

	$twig = taxoclean_get_twig();
	taxoclean_change_copyright();

	if (isset($_POST["tc_action"]) && $_POST["tc_action"] == "save") {
		update_option("taxoclean_max_per_page", intval($_POST["taxoclean_max_per_page"]));
		update_option("taxoclean_current_taxo", sanitize_title($_POST["taxoclean_current_taxo"]));
        update_option("taxoclean_orphan_level", intval($_POST["taxoclean_orphan_level"]));
        update_option("taxoclean_lookalike_level", intval($_POST["taxoclean_lookalike_level"]));
		if(isset($_POST["taxoclean_fast_mode"])){
			update_option("taxoclean_fast_mode", intval($_POST["taxoclean_fast_mode"]));
		}
		if (isset($_POST["taxoclean_license"]) && $_POST["taxoclean_license"] != "") {
			$license = strtoupper(sanitize_title($_POST["taxoclean_license"]));
			$check_license = taxoclean_v($license);
			if ($check_license) {
				update_option("taxoclean_license", $license);
			} else {
				update_option("taxoclean_license", "");
			}
		}
	}

	$taxos = get_taxonomies();

	$taxos = array_diff_key(
		$taxos, array_flip([
			"nav_menu",
			"link_category",
			"wp_theme",
			"wp_template_part_area",
			"elementor_library_type",
			"elementor_library_category",
			"wp_theme",
			"post_format",
			"media_tag",
			"elementor_font_type"
		]
	));

	if (get_option("taxoclean_license")) {
		$check_license = taxoclean_v(get_option("taxoclean_license"));
		if (!$check_license) {
			update_option("taxoclean_license", "");
		}
	}

	try {
		$twig->display( 'settings.html.twig', [
			"taxos"           => $taxos,
			"section"         => "s",
			"current_taxo"    => get_option( "taxoclean_current_taxo" ),
			"max_per_page"    => get_option( "taxoclean_max_per_page" ),
			"orphan_level"    => get_option( "taxoclean_orphan_level" ),
			"fast_mode"       => get_option( "taxoclean_fast_mode" ),
			"lookalike_level" => get_option( "taxoclean_lookalike_level" ),
			"license"         => get_option( "taxoclean_license" )
		] );
	} catch ( Exception $e ) {
		echo sanitize_text_field( $e->getMessage() );
	}

	return true;
}