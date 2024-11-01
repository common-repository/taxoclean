<?php

function taxoclean_o(): bool {
	taxoclean_change_copyright();

	$twig = taxoclean_get_twig();
    $taxo = get_option("taxoclean_current_taxo");
	$max = get_option("taxoclean_max_per_page");

	$page = 0;
	if (isset($_GET["taxopage"])) {
		$page = intval($_GET["taxopage"]);
	}

	$all_tags = get_terms([
		'taxonomy' => $taxo,
		'hide_empty' => false
	]);

	$orphan_tags = [];

	foreach($all_tags as $v) {
		if ($v->count <= get_option("taxoclean_orphan_level")) {
			$orphan_tags[] = $v;
		}
	}

	$tags = array_slice($orphan_tags, $page * $max, $max);

    $base_url = "";

    if (!empty($tags)) {
        $url = get_term_link($tags[0]->term_id );
        $xp = explode("/", $url);
        array_pop($xp);
        $base_url = implode("/", $xp);
    }

	try {
		$twig->display( 'orphans.html.twig', [
			"all_tags"    => $all_tags,
			"orphan_tags" => $orphan_tags,
			"page"        => $page,
			"max"         => $max,
			"tags"        => $tags,
			"section"     => "o",
			"base_url"    => $base_url,
			"license"     => get_option( "taxoclean_license" ),
			"nonce"       => wp_create_nonce( 'taxoclean_o' )
		] );
	} catch ( Exception $e ) {
		echo sanitize_text_field( $e->getMessage() );
	}
	return true;
}