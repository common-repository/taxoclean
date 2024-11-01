<?php

	use Twig\Environment;
	use Twig\Loader\FilesystemLoader;

	if (!function_exists("taxoclean_counter")) {
		function taxoclean_counter($increment = false) {
			$counter = get_option("taxoclean_counter");
				$counter++;
				update_option("taxoclean_counter", $counter);

			return true;
		}
	}

	if (!function_exists("taxoclean_change_copyright")) {
		function taxoclean_change_copyright() {
			add_action("admin_footer_text", function() {
				$translations = taxoclean_get_translations();
				return "<img src='https://www.taxoclean.com/updater/logo.php?d=".sanitize_url($_SERVER["SERVER_NAME"])."' style='height:30px;'> <span style='font-size:25px'>".wp_kses($translations["footer"], [])."</span>";
			});
		}
	}

	if (!function_exists("taxoclean_get_twig")) {
		function taxoclean_get_twig() {
			$taxoclean_twig_loader = new FilesystemLoader( __DIR__ . '/../templates' );
			$env = new Environment( $taxoclean_twig_loader, [
				"debug" => false
			]);
			$env->addGlobal("dir", plugin_dir_url( __FILE__ ) ."..");
			$env->addGlobal("_t", taxoclean_get_translations());
			return $env;
		}
	}


