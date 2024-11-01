<?php

function taxoclean_l(): bool {
	taxoclean_change_copyright();
    global $wpdb;
	$twig = taxoclean_get_twig();

    $taxo = get_option("taxoclean_current_taxo");

    if (isset($_POST["tc_action"]) && $_POST["tc_action"] == "submit") {
	    taxoclean_counter(true);
        foreach($_POST["tids"] as $post_id => $tmp_tags) {
            $tmp_tags = array_map('intval', explode(",", $tmp_tags));
            wp_set_post_terms($post_id, $tmp_tags, $taxo);
        }
        if ($_POST["update_tag_id"] != "") {
            wp_update_term(intval($_POST["update_tag_id"]), $taxo , [
                'name' => sanitize_text_field($_POST["update_tag_to"])
            ]);
        }

        unset($_POST["tc_action"]);
    }

    if (isset($_POST["tc_action"]) && ($_POST["tc_action"] == "preview") ) {

		/* Sanitize vars */

        $chosen = array_map('sanitize_text_field', array_map('stripslashes', $_POST["chosen"]));
        $target = stripslashes(sanitize_text_field($_POST["target"]));
        $otag = stripslashes(sanitize_text_field($_POST["tag"]));

		/* End sanitize vars */

        $args = [
            "posts_per_page" => -1,
            'post_type' => 'any'
        ];

        $args['tax_query'] = array(
            array(
                'taxonomy' => $taxo,
                'terms' => $chosen,
                'field' => 'name',
                'operator' => 'IN'
            )
        );

        $real_new_tag = get_term_by("name", $target, $taxo);
        $update_tag = false;

        if ($real_new_tag) {
            $new_tag = $real_new_tag;
        } else {
            $old_tag = get_term_by("name", $otag, $taxo);
            $update_tag = [
                "id" => $old_tag->term_id,
                "to" => $target
            ];
            $new_tag = $old_tag;
        }

        $my_query = new WP_Query( $args );

        $data = [];

        foreach($my_query->posts as $p) {
            $new_tags_ids = [];
            $tmp_tags = get_the_tags($p);

            $reassign = false;

            foreach($tmp_tags as $tag){
                if (in_array($tag->name, $chosen) && $tag->name != $new_tag->name) {
                    $reassign = [
                        "from" => $tag->name,
                        "to" => $target
                    ];
                } else {
                    $new_tags_ids[] = $tag->term_id;
                }
            }

            if ($reassign) {
                $new_tags_ids[] = $new_tag->term_id;
                $new_tags_ids = array_unique($new_tags_ids);
                $data[] = [
                    "post_id" => $p->ID,
                    "post_title" => $p->post_title,
	                "post_url" => get_permalink($p),
                    "reassign" => $reassign,
                    "tag_ids" => implode(",", $new_tags_ids)
                ];
            }
        }


	    try {
		    $twig->display( 'lookalike_preview.html.twig', [
			    "data"       => $data,
			    "update_tag" => $update_tag,
			    "section"    => "l",
			    "fast_mode"  => get_option( "taxoclean_fast_mode" ),
			    "license"    => get_option( "taxoclean_license" ),
		    ] );
	    } catch ( Exception $e ) {
		    echo sanitize_text_field($e->getMessage());
	    }

	    return true;
    }

    $lookalike_level = get_option("taxoclean_lookalike_level");
	$max = get_option("taxoclean_max_per_page");

	$page = 0;
	if (isset($_GET["taxopage"])) {
		$page = intval($_GET["taxopage"]);
	}


	$all_tags = get_terms([
		'taxonomy' => $taxo
	]);


	$tags = array_slice($all_tags, ($page * $max) , $max);
	$clone_tags = $all_tags;

	$likes = [];
	$liked = [];
	$counters = [];
    $ignored_terms = [];

    $ignored = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."taxoclean_ignore WHERE taxonomy = '".esc_sql($taxo)."'");
    foreach($ignored as $ig) {
        $ignored_terms[] = $ig->term;
        $liked[$ig->term] = true;
    }

	if (!isset($_POST["tc_action"])) {
		foreach($tags as $tag) {
            $name = $tag->name;
            if (in_array($name, $ignored_terms)) {
                continue;
            }
			$counters[$name] = $tag->count;

			if (!isset($liked[$name])) {
				$lname = strtolower($name);

				foreach($clone_tags as $ctag) {
					$cname = $ctag->name;
					$counters[$cname] = $ctag->count;
					$lcname = strtolower($cname);
					if (!isset($liked[$cname])) {
						$score = 0;

						$length_match = 5;
						if (strlen($lcname) < 5 && strlen($lname) < 5) {
							$length_match = min(strlen($lcname), strlen($lname));
							$length_match = max($length_match, 3);
						}

						if ( substr($lcname, 0 , $length_match) == substr($lname, 0, $length_match)) {
							$score += 20;
						} else {
							if (substr($lcname, strlen($lcname) - $length_match , $length_match) == substr($lname, strlen($lname) - $length_match ,$length_match)) {
								$score += 10;
							}
						}

						similar_text($lcname,$lname,$percent);
						$score += 0.8 * $percent;

						if ($score >= $lookalike_level) {

							if (!isset($likes[$name])) {
								$likes[$name] = [];
							}
							if ($cname != $name) {
								$likes[$name][] = $cname;
								$liked[$cname] = 1;
							}
						}
					}
				}
			}

		}
		$likes = array_filter($likes);
	}

	try {
		$twig->display( 'lookalike.html.twig', [
			"all_tags" => $all_tags,
			"max"      => $max,
			"page"     => $page,
			"likes"    => $likes,
			"counters" => $counters,
			"section"  => "l",
			"license"  => get_option( "taxoclean_license" ),
			"nonce"    => wp_create_nonce( 'taxoclean_l' )
		] );
	} catch ( Exception $e ) {
		echo sanitize_text_field($e->getMessage());
	}
	return true;
}