<?php

	$translations = taxoclean_get_translations();

	add_menu_page(
		"Taxoclean",
		"Taxoclean",
		"edit_posts",
		"taxoclean_l",
		"taxoclean_l",
		"dashicons-welcome-view-site"
	);

	add_submenu_page(
		"taxoclean_l",
		"Taxoclean : ".sanitize_text_field($translations["lookalikes"]), // texte de la balise <title>
		sanitize_text_field($translations["lookalikes"]),  // titre de l'option de menu
		"edit_posts", // droits requis pour voir l'option de menu
		"taxoclean_l", // slug
		"taxoclean_l" // fonction de rappel pour créer la page,
	);

	add_submenu_page(
		"taxoclean_l",
		"Taxoclean : ".sanitize_text_field($translations["orphans"]), // texte de la balise <title>
		sanitize_text_field($translations["orphans"]),  // titre de l'option de menu
		"edit_posts", // droits requis pour voir l'option de menu
		"taxoclean_o", // slug
		"taxoclean_o" // fonction de rappel pour créer la page,
	);

	add_submenu_page(
		"taxoclean_l",
		"Taxoclean : ".sanitize_text_field($translations["settings"]), // texte de la balise <title>
		sanitize_text_field($translations["settings"]),  // titre de l'option de menu
		"edit_posts", // droits requis pour voir l'option de menu
		"taxoclean_s", // slug
		"taxoclean_s" // fonction de rappel pour créer la page,
	);

	add_submenu_page(
		"taxoclean_l",
		"Taxoclean : ".sanitize_text_field($translations["ignores"]), // texte de la balise <title>
		sanitize_text_field($translations["ignores"]),  // titre de l'option de menu
		"edit_posts", // droits requis pour voir l'option de menu
		"taxoclean_l_ignores", // slug
		"taxoclean_l_ignores" // fonction de rappel pour créer la page,
	);

	add_submenu_page(
		"taxoclean_l",
		"Taxoclean : ".sanitize_text_field($translations["about"]), // texte de la balise <title>
		sanitize_text_field($translations["about"]),  // titre de l'option de menu
		"edit_posts", // droits requis pour voir l'option de menu
		"taxoclean_a", // slug
		"taxoclean_a" // fonction de rappel pour créer la page,
	);