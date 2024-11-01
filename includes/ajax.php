<?php

	add_action( 'wp_ajax_taxoclean_ignore', function() {
		global $wpdb;
		$taxo = get_option("taxoclean_current_taxo");
		$wpdb->insert("{$wpdb->prefix}taxoclean_ignore", [
			"term" => sanitize_text_field($_POST["term"]),
			"taxonomy" => $taxo
		]);
		wp_send_json(["ok"=>"ok"]);
		wp_die();
	});

	add_action( 'wp_ajax_taxoclean_delete', function() {
		$taxo = get_option("taxoclean_current_taxo");
		wp_delete_term(intval($_POST["id"]), $taxo);
		taxoclean_counter(true);
		wp_send_json(["ok"=>"ok"]);
		wp_die();
	});

	add_action('wp_ajax_taxoclean_delete_bulk', function() {
		$taxo = get_option("taxoclean_current_taxo");
		foreach($_POST["ids"] as $id) {
			taxoclean_counter(true);
			wp_delete_term(intval($id), $taxo);
		}
		wp_send_json(["ok"=>"ok"]);
		wp_die();
	});

	add_action('wp_ajax_taxoclean_replace', function() {
		$taxo = get_option("taxoclean_current_taxo");
		$args = [
			"posts_per_page" => -1,
			"post_type" => "any",
		];

		$args['tax_query'] = array(
			array(
				'taxonomy' => $taxo,
				'terms' => intval($_POST["tagsource"]),
				'field' => 'id',
				'operator' => 'IN'
			)
		);

		$my_query = new WP_Query( $args );

		foreach($my_query->posts as $v) {
			wp_set_post_terms($v->ID, [intval($_POST["tagtarget"])], $taxo, true);
		}
		taxoclean_counter(true);
		wp_delete_term(intval($_POST["tagsource"]), $taxo);
		wp_send_json(["ok"=>"ok"]);
		wp_die();
	});

	add_action('wp_ajax_taxoclean_search', function() {
		$taxo     = get_option( "taxoclean_current_taxo" );
		$all_tags = get_terms( [
			'taxonomy' => $taxo
		] );

		$name  = sanitize_text_field($_POST["tag"]);
		$lname = strtolower( $name );

		$likes = [];

		foreach ( $all_tags as $ctag ) {
			$cname              = $ctag->name;
			$counters[ $cname ] = $ctag->count;
			$lcname             = strtolower( $cname );

			$score = 0;

			if ( $lname != $lcname ) {

				if ( substr( $lcname, 0, 5 ) == substr( $lname, 0, 5 ) ) {
					$score += 20;
				} else {
					if ( substr( $lcname, strlen( $lcname ) - 5, 5 ) == substr( $lname, strlen( $lname ) - 5, 5 ) ) {
						$score += 10;
					}
				}

				similar_text( $lcname, $lname, $percent );
				$score += 0.5 * $percent;

				if ( $score > 0 ) {
					$score += 2 * min( $ctag->count, 10 );
				}

				if ( $score > 15 ) {
					$likes[ $cname ] = $score;
				}


			}
		}

		arsort( $likes );

		$return = [];

		$likes = array_slice( $likes, 0, 10 );
		foreach ( $likes as $key => $value ) {
			$term     = get_term_by( "name", $key, $taxo );
			$return[] = [
				"tag"     => $key,
				"score"   => $value,
				"id"      => $term->term_id,
				"counter" => $term->count
			];
		}

		wp_send_json($return);
		wp_die();
	});


