<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pr_add_admin_menu_page() {
    add_menu_page(
        __( 'Paws Relocate Submissions', 'paws-relocate' ), 
        __( 'Paws Relocate', 'paws-relocate' ),             
        'manage_options',                                 
        'paws-relocate-submissions',                      
        'pr_render_submissions_page',                     
        'dashicons-pets',                                 
        26                                                
    );
}

function pr_render_submissions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . PR_TABLE_NAME;
    $submissions = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY submission_time DESC", ARRAY_A );

    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Paws Relocate Submissions', 'paws-relocate' ); ?></h1>

        <?php if ( empty( $submissions ) ) : ?>
            <p><?php esc_html_e( 'No submissions yet.', 'paws-relocate' ); ?></p>
        <?php else : ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <?php ?>
                        <th scope="col" style="width: 120px;"><?php esc_html_e( 'Submitted', 'paws-relocate' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Pet Type', 'paws-relocate' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Breed', 'paws-relocate' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Relocation', 'paws-relocate' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Departure City', 'paws-relocate' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Arrival City', 'paws-relocate' ); ?></th>
                        <th scope="col" style="width: 100px;"><?php esc_html_e( 'Travel Date', 'paws-relocate' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Crate?', 'paws-relocate' ); ?></th>
                        <?php ?>
                        <th scope="col">< ?php esc_html_e( 'Actions', 'paws-relocate' ); ?></th> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $submissions as $submission ) : ?>
                        <tr>
                            <td><?php echo esc_html( get_date_from_gmt( $submission['submission_time'], 'Y-m-d H:i' ) ); ?></td>
                            <td><?php echo esc_html( $submission['pet_type'] ); ?></td>
                            <td><?php echo esc_html( $submission['breed'] ); ?></td>
                            <td><?php echo esc_html( $submission['relocation_type'] ); ?></td>
                            <td><?php echo esc_html( $submission['departure_city'] ); ?></td>
                            <td><?php echo esc_html( $submission['arrival_city'] ); ?></td>
                            <td><?php echo esc_html( $submission['travel_date'] ); ?></td>
                            <td><?php echo esc_html( $submission['has_iata_crate'] ); ?></td>
                            <?php ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                     <tr>
                        <?php ?>
                        <th scope="col"><?php esc_html_e( 'Submitted', 'paws-relocate' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Pet Type', 'paws-relocate' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Breed', 'paws-relocate' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Relocation', 'paws-relocate' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Departure City', 'paws-relocate' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Arrival City', 'paws-relocate' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Travel Date', 'paws-relocate' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Crate?', 'paws-relocate' ); ?></th>
                         <?php ?>
                    </tr>
                </tfoot>
            </table>
        <?php endif; ?>
    </div>
    <?php
}
?>