<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Function called on plugin activation.
 */
function pr_activate_plugin() {
    pr_create_custom_table();
}


function pr_create_custom_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . PR_TABLE_NAME;
    $charset_collate = $wpdb->get_charset_collate();

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        submission_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,

        -- Step 1: Pet Information
        number_of_pets tinyint(2) DEFAULT 1 NOT NULL,
        pet_type varchar(100) DEFAULT '' NOT NULL,
        breed varchar(100) DEFAULT '' NOT NULL,
        age varchar(50) DEFAULT '' NOT NULL,
        weight varchar(50) DEFAULT '' NOT NULL,
        spayed_neutered varchar(50) DEFAULT '' NOT NULL,
        vaccination_status varchar(100) DEFAULT '' NOT NULL,
        health_condition text DEFAULT '' NOT NULL,
        specific_medicine text DEFAULT '' NOT NULL,
        behaviour_training text DEFAULT '' NOT NULL,
        health_certificate_status varchar(50) DEFAULT '' NOT NULL, 

        -- Step 2: Location Information
        relocation_type varchar(50) DEFAULT '' NOT NULL,
        departure_address text DEFAULT '' NOT NULL,
        departure_city varchar(100) DEFAULT '' NOT NULL,
        departure_country varchar(100) DEFAULT '' NOT NULL,
        travel_date date DEFAULT '0000-00-00' NOT NULL,
        same_flight varchar(10) DEFAULT '' NOT NULL,
        departure_flight_info text DEFAULT '' NOT NULL,
        arrival_address text DEFAULT '' NOT NULL,
        arrival_city varchar(100) DEFAULT '' NOT NULL,
        arrival_country varchar(100) DEFAULT '' NOT NULL,
        emergency_contact varchar(100) DEFAULT '' NOT NULL,

        -- Step 3: Additional Services
        grooming_required varchar(10) DEFAULT '' NOT NULL,           -
        post_arrival_checkup varchar(100) DEFAULT '' NOT NULL,     
        is_microchipped varchar(10) DEFAULT '' NOT NULL,           
        vaccinations_up_to_date varchar(10) DEFAULT '' NOT NULL,   
        has_health_issues varchar(10) DEFAULT '' NOT NULL,         
        has_iata_crate varchar(50) DEFAULT '' NOT NULL,            
        additional_services text DEFAULT '' NOT NULL,              

        PRIMARY KEY  (id)
    ) $charset_collate;";

    dbDelta( $sql );
    update_option( 'pr_version', PR_VERSION );
}
?>