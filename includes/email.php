<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sends an email notification to the admin with Paws Relocate submission details.
 *
 * @param array $data The sanitized data that was inserted into the database.
 */
function pr_send_admin_notification( $data ) {
    $admin_email = get_option( 'admin_email' );
    if ( ! is_email( $admin_email ) ) {
        error_log("Paws Relocate Email Error: Invalid admin email address configured in WordPress settings.");
        return; 
    }

     $subject = sprintf( __( 'New Paws Relocate Form: %s (%s to %s)', 'paws-relocate' ),
        $data['relocation_type'],
        $data['departure_city'],
        $data['arrival_city']
     );

    $message = "<html><body style='font-family: Arial, sans-serif; line-height: 1.6;'>";
    $message .= "<h2 style='color: #17A2B8;'>" . __( 'New Paws Relocate Submission Details:', 'paws-relocate' ) . "</h2>";
    $message .= "<table border='0' cellpadding='8' cellspacing='0' style='border-collapse: collapse; width: 100%; border: 1px solid #ddd;'>";
    $bg_color_alt = "style='background-color: #f8f9fa; border: 1px solid #ddd;'";
    $bg_color_normal = "style='border: 1px solid #ddd;'";
    $row_style = $bg_color_normal;

    // --- General Info ---
    $message .= "<tr><td {$row_style}><strong>" . __( 'Submission Time:', 'paws-relocate' ) . "</strong></td><td {$row_style}>" . esc_html( get_date_from_gmt( $data['submission_time'], 'Y-m-d H:i:s' ) ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}><strong>" . __( 'Number of Pets:', 'paws-relocate' ) . "</strong></td><td {$row_style}>" . esc_html( $data['number_of_pets'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;

    // --- Pet Information ---
    $message .= "<tr><td colspan='2' style='background-color: #e9ecef; padding: 10px; border: 1px solid #ddd;'><strong>" . __( 'Pet Information (Pet 1)', 'paws-relocate' ) . "</strong></td></tr>"; $row_style = $bg_color_normal; // Reset background for new section
    $message .= "<tr><td {$row_style}>" . __( 'Type of Pet:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['pet_type'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Breed:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['breed'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Age:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['age'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Weight:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['weight'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Spayed/Neutered:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['spayed_neutered'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Vaccination Status:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['vaccination_status'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Health Condition:', 'paws-relocate' ) . "</td><td {$row_style}>" . nl2br( esc_html( $data['health_condition'] ) ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Specific Medicine:', 'paws-relocate' ) . "</td><td {$row_style}>" . ( !empty($data['specific_medicine']) ? nl2br( esc_html( $data['specific_medicine'] ) ) : __( 'N/A', 'paws-relocate' ) ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Behaviour Training:', 'paws-relocate' ) . "</td><td {$row_style}>" . ( !empty($data['behaviour_training']) ? nl2br( esc_html( $data['behaviour_training'] ) ) : __( 'N/A', 'paws-relocate' ) ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Health Certificate:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['health_certificate_status'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;

    // --- Location Information ---
    $message .= "<tr><td colspan='2' style='background-color: #e9ecef; padding: 10px; border: 1px solid #ddd;'><strong>" . __( 'Location & Travel Information', 'paws-relocate' ) . "</strong></td></tr>"; $row_style = $bg_color_normal; // Reset background
    $message .= "<tr><td {$row_style}>" . __( 'Relocation Type:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['relocation_type'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Departure Address:', 'paws-relocate' ) . "</td><td {$row_style}>" . nl2br(esc_html( $data['departure_address'] )) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Departure City:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['departure_city'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Departure Country:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['departure_country'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Arrival Address:', 'paws-relocate' ) . "</td><td {$row_style}>" . nl2br(esc_html( $data['arrival_address'] )) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Arrival City:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['arrival_city'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Arrival Country:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['arrival_country'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Travel Date:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['travel_date'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Travelling on Same Flight?:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['same_flight'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Flight Info Provided:', 'paws-relocate' ) . "</td><td {$row_style}>" . (!empty($data['departure_flight_info']) ? nl2br(esc_html( $data['departure_flight_info'] )) : __( 'N/A', 'paws-relocate' )) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Emergency Contact (Arrival):', 'paws-relocate' ) . "</td><td {$row_style}>" . (!empty($data['emergency_contact']) ? esc_html( $data['emergency_contact'] ) : __( 'Not Provided', 'paws-relocate' )) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;

    // --- Additional Services & Info ---
    $message .= "<tr><td colspan='2' style='background-color: #e9ecef; padding: 10px; border: 1px solid #ddd;'><strong>" . __( 'Additional Services & Information', 'paws-relocate' ) . "</strong></td></tr>"; $row_style = $bg_color_normal; // Reset background
    $message .= "<tr><td {$row_style}>" . __( 'Grooming Required:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['grooming_required'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Post Arrival Checkup:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['post_arrival_checkup'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Microchipped:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['is_microchipped'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Vaccinations Up-to-date:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['vaccinations_up_to_date'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Any Health Issues (Yes/No):', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['has_health_issues'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Has IATA Crate:', 'paws-relocate' ) . "</td><td {$row_style}>" . esc_html( $data['has_iata_crate'] ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;
    $message .= "<tr><td {$row_style}>" . __( 'Additional Notes:', 'paws-relocate' ) . "</td><td {$row_style}>" . ( !empty($data['additional_services']) ? nl2br( esc_html( $data['additional_services'] ) ) : __( 'None', 'paws-relocate' ) ) . "</td></tr>"; $row_style = ($row_style == $bg_color_normal) ? $bg_color_alt : $bg_color_normal;


    $message .= "</table>";
    $message .= "<p style='margin-top: 20px; font-size: 0.9em; color: #6c757d;'>" . __( 'This email was sent automatically from the Paws Relocate form on your website.', 'paws-relocate' ) . "</p>";
    $message .= "</body></html>";

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
     );

    // Send the email
    $sent = wp_mail( $admin_email, $subject, $message, $headers );

    // Log error if email sending fails
    if ( ! $sent ) {
        error_log("Paws Relocate Email Error: wp_mail failed to send notification to " . $admin_email);
    }
}
?>