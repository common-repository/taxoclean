<?php

	function taxoclean_create_table( $table_name, $create_ddl ): bool {
		global $wpdb;
		$query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );
		if ( $wpdb->get_var( $query ) === $table_name ) {
			return true;
		}
		$wpdb->query( $create_ddl );
		if ( $wpdb->get_var( $query ) === $table_name ) {
			return true;
		}
		return false;
	}

    register_deactivation_hook( __FILE__, function() {
        global $wpdb;
        $tablename = $wpdb->prefix."taxoclean";
        $sql = "DROP TABLE IF EXISTS $tablename";
        $wpdb->query( $sql );
        delete_option( "taxoclean_current_taxo" );
        delete_option( "taxoclean_max_per_page" );
        delete_option( "taxoclean_orphan_level" );
        delete_option( "taxoclean_lookalike_level" );
        delete_option( "taxoclean_license" );
        delete_option( 'taxoclean_fast_mode');
    });


    register_activation_hook(
        __FILE__,
        function() {
            global $wpdb;

            $tablename = $wpdb->prefix."taxoclean_ignore";
            $main_sql_create = "CREATE TABLE `".$tablename."` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `term` varchar(255) NOT NULL,
                `taxonomy` varchar(255) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `id` (`id`,`taxonomy`, `term`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            taxoclean_create_table( $tablename, $main_sql_create );

	        add_option( 'taxoclean_current_taxo', 'post_tag');
	        add_option( 'taxoclean_max_per_page', '100');
	        add_option( 'taxoclean_orphan_level', 1);
	        add_option( 'taxoclean_lookalike_level', 80);
	        add_option( 'taxoclean_license');
	        add_option( 'taxoclean_counter', 0);
	        add_option( 'taxoclean_fast_mode', 0);
        }
    );
