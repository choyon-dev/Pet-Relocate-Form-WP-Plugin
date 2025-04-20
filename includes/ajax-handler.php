<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pr_handle_ajax_submission() {
    if ( ! isset( $_POST['pr_nonce_field'] ) || ! wp_verify_nonce( $_POST['pr_nonce_field'], 'pr_form_nonce' ) ) {
        wp_send_json_error( array( 'message' => __( 'Security check failed. Please refresh and try again.', 'paws-relocate' ) ) );
        return;
    }

    $sanitized_data = array();
    $errors = array();

    // --- Step 1 Fields ---
    $sanitized_data['number_of_pets'] = isset( $_POST['number_of_pets'] ) ? absint( $_POST['number_of_pets'] ) : 1;
    $sanitized_data['pet_type'] = isset( $_POST['pet_type'] ) ? sanitize_text_field( wp_unslash($_POST['pet_type']) ) : '';
    $sanitized_data['breed'] = isset( $_POST['breed'] ) ? sanitize_text_field( wp_unslash($_POST['breed']) ) : '';
    $sanitized_data['age'] = isset( $_POST['age'] ) ? sanitize_text_field( wp_unslash($_POST['age']) ) : '';
    $sanitized_data['weight'] = isset( $_POST['weight'] ) ? sanitize_text_field( wp_unslash($_POST['weight']) ) : '';
    $sanitized_data['spayed_neutered'] = isset( $_POST['spayed_neutered'] ) ? sanitize_key( $_POST['spayed_neutered'] ) : ''; // Yes/No

    $sanitized_data['vaccination_status'] = isset( $_POST['vaccination_status'] ) ? sanitize_text_field( wp_unslash($_POST['vaccination_status']) ) : '';
    $sanitized_data['health_condition'] = isset( $_POST['health_condition'] ) ? sanitize_textarea_field( wp_unslash($_POST['health_condition']) ) : '';
    $sanitized_data['specific_medicine'] = isset( $_POST['specific_medicine'] ) ? sanitize_textarea_field( wp_unslash($_POST['specific_medicine']) ) : '';
    $sanitized_data['behaviour_training'] = isset( $_POST['behaviour_training'] ) ? sanitize_textarea_field( wp_unslash($_POST['behaviour_training']) ) : '';
    $sanitized_data['health_certificate_status'] = isset( $_POST['health_certificate_status'] ) ? sanitize_key( $_POST['health_certificate_status'] ) : ''; // Issued/Pending

    // --- Step 2 Fields ---
    $sanitized_data['relocation_type'] = isset( $_POST['relocation_type'] ) ? sanitize_key( $_POST['relocation_type'] ) : ''; // Domestic/International
    $sanitized_data['departure_address'] = isset( $_POST['departure_address'] ) ? sanitize_textarea_field( wp_unslash($_POST['departure_address']) ) : '';
    $sanitized_data['departure_city'] = isset( $_POST['departure_city'] ) ? sanitize_text_field( wp_unslash($_POST['departure_city']) ) : '';
    $sanitized_data['departure_country'] = isset( $_POST['departure_country'] ) ? sanitize_text_field( wp_unslash($_POST['departure_country']) ) : '';
    $sanitized_data['travel_date'] = isset( $_POST['travel_date'] ) ? sanitize_text_field( wp_unslash($_POST['travel_date']) ) : '';
    $sanitized_data['same_flight'] = isset( $_POST['same_flight'] ) ? sanitize_key( $_POST['same_flight'] ) : ''; // Yes/No

    $sanitized_data['departure_flight_info'] = isset( $_POST['departure_flight_info'] ) ? sanitize_textarea_field( wp_unslash($_POST['departure_flight_info']) ) : '';
    $sanitized_data['arrival_address'] = isset( $_POST['arrival_address'] ) ? sanitize_textarea_field( wp_unslash($_POST['arrival_address']) ) : '';
    $sanitized_data['arrival_city'] = isset( $_POST['arrival_city'] ) ? sanitize_text_field( wp_unslash($_POST['arrival_city']) ) : '';
    $sanitized_data['arrival_country'] = isset( $_POST['arrival_country'] ) ? sanitize_text_field( wp_unslash($_POST['arrival_country']) ) : '';
    $sanitized_data['emergency_contact'] = isset( $_POST['emergency_contact'] ) ? preg_replace( '/[^\d\+]/', '', sanitize_text_field(wp_unslash($_POST['emergency_contact'])) ) : '';

    // --- Step 3 Fields ---
    $sanitized_data['grooming_required'] = isset( $_POST['grooming_required'] ) ? sanitize_key( $_POST['grooming_required'] ) : ''; // Yes/No
    $sanitized_data['post_arrival_checkup'] = isset( $_POST['post_arrival_checkup'] ) ? sanitize_text_field( wp_unslash($_POST['post_arrival_checkup']) ) : '';
    $sanitized_data['is_microchipped'] = isset( $_POST['is_microchipped'] ) ? sanitize_key( $_POST['is_microchipped'] ) : ''; // Yes/No
    
    $sanitized_data['vaccinations_up_to_date'] = isset( $_POST['vaccinations_up_to_date'] ) ? sanitize_key( $_POST['vaccinations_up_to_date'] ) : ''; // Yes/No/Unsure
    $sanitized_data['has_health_issues'] = isset( $_POST['has_health_issues'] ) ? sanitize_key( $_POST['has_health_issues'] ) : ''; // Yes/No
    $sanitized_data['has_iata_crate'] = isset( $_POST['has_iata_crate'] ) ? sanitize_text_field( wp_unslash($_POST['has_iata_crate']) ) : ''; // Yes/No/Need Assistance
    $sanitized_data['additional_services'] = isset( $_POST['additional_services'] ) ? sanitize_textarea_field( wp_unslash($_POST['additional_services']) ) : ''; // General notes

    // Step 1
    if ( empty( $sanitized_data['number_of_pets'] ) ) $errors['number_of_pets'] = __( 'Number of Pets is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['pet_type'] ) ) $errors['pet_type'] = __( 'Type of Pet is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['breed'] ) ) $errors['breed'] = __( 'Breed is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['age'] ) ) $errors['age'] = __( 'Age is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['weight'] ) ) $errors['weight'] = __( 'Weight is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['spayed_neutered'] ) ) $errors['spayed_neutered'] = __( 'Spaying/Neutering Status is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['vaccination_status'] ) ) $errors['vaccination_status'] = __( 'Vaccination Report status is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['health_condition'] ) ) $errors['health_condition'] = __( 'Health Condition is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['health_certificate_status'] ) ) $errors['health_certificate_status'] = __( 'Health Certificate status is required.', 'paws-relocate' );
    // Step 2
    if ( empty( $sanitized_data['relocation_type'] ) ) $errors['relocation_type'] = __( 'Relocation Type is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['departure_address'] ) ) $errors['departure_address'] = __( 'Departure Address Line is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['departure_city'] ) ) $errors['departure_city'] = __( 'Departure City is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['departure_country'] ) ) $errors['departure_country'] = __( 'Departure Country is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['travel_date'] ) ) {
        $errors['travel_date'] = __( 'Travel Date is required.', 'paws-relocate' );
    } elseif ( ! preg_match( "/^\d{4}-\d{2}-\d{2}$/", $sanitized_data['travel_date'] ) ) {
         $errors['travel_date'] = __( 'Invalid date format. Please use standerd date formate.', 'paws-relocate' );
    }
    if ( empty( $sanitized_data['same_flight'] ) ) $errors['same_flight'] = __( 'Please specify if you are travelling on the same flight.', 'paws-relocate' );
    if ( $sanitized_data['same_flight'] == 'Yes' && empty( $sanitized_data['departure_flight_info'] ) ) $errors['departure_flight_info'] = __( 'Flight Information is required if travelling on the same flight.', 'paws-relocate' );
    if ( empty( $sanitized_data['arrival_address'] ) ) $errors['arrival_address'] = __( 'Arrival Address Line is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['arrival_city'] ) ) $errors['arrival_city'] = __( 'Arrival City is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['arrival_country'] ) ) $errors['arrival_country'] = __( 'Arrival Country is required.', 'paws-relocate' );
    // Step 3
    if ( empty( $sanitized_data['grooming_required'] ) ) $errors['grooming_required'] = __( 'Please specify if grooming is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['post_arrival_checkup'] ) ) $errors['post_arrival_checkup'] = __( 'Post Arrival Checkup preference is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['is_microchipped'] ) ) $errors['is_microchipped'] = __( 'Please specify if the pet is microchipped.', 'paws-relocate' );
    if ( empty( $sanitized_data['vaccinations_up_to_date'] ) ) $errors['vaccinations_up_to_date'] = __( 'Vaccination up-to-date status is required.', 'paws-relocate' );
    if ( empty( $sanitized_data['has_health_issues'] ) ) $errors['has_health_issues'] = __( 'Please specify if the pet has health issues.', 'paws-relocate' );
    if ( empty( $sanitized_data['has_iata_crate'] ) ) $errors['has_iata_crate'] = __( 'IATA approved crate status is required.', 'paws-relocate' );


    if ( ! empty( $errors ) ) {
        wp_send_json_error( array( 'message' => __( 'Please correct the errors below:', 'paws-relocate' ), 'errors' => $errors ) );
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . PR_TABLE_NAME;

    $data_to_insert = $sanitized_data;
    $data_to_insert['submission_time'] = current_time( 'mysql' ); 
    $formats = array(
        '%d', // number_of_pets
        '%s', // pet_type
        '%s', // breed
        '%s', // age
        '%s', // weight
        '%s', // spayed_neutered
        '%s', // vaccination_status
        '%s', // health_condition
        '%s', // specific_medicine
        '%s', // behaviour_training
        '%s', // health_certificate_status
        '%s', // relocation_type
        '%s', // departure_address
        '%s', // departure_city
        '%s', // departure_country
        '%s', // travel_date
        '%s', // same_flight
        '%s', // departure_flight_info
        '%s', // arrival_address
        '%s', // arrival_city
        '%s', // arrival_country
        '%s', // emergency_contact
        '%s', // grooming_required
        '%s', // post_arrival_checkup
        '%s', // is_microchipped
        '%s', // vaccinations_up_to_date
        '%s', // has_health_issues
        '%s', // has_iata_crate
        '%s', // additional_services
        '%s'  // submission_time
    );

    if(count($data_to_insert) !== count($formats)) {
         error_log("Paws Relocate Insert Error: Data and format counts mismatch.");
         wp_send_json_error( array( 'message' => __( 'Server error: Data preparation failed.', 'paws-relocate' ) ) );
         return;
    }

    $inserted = $wpdb->insert( $table_name, $data_to_insert, $formats );

    if ( false === $inserted ) {
        error_log("Paws Relocate DB Insert Error: " . $wpdb->last_error);
        wp_send_json_error( array( 'message' => __( 'Database error. Could not save submission.', 'paws-relocate' ) ) );
        return;
    }
    pr_send_admin_notification( $data_to_insert );
    wp_send_json_success( array( 'message' => __( 'Form submitted successfully! Thank you.', 'paws-relocate' ) ) );

    wp_die();
}
?>