<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Renders the form HTML via shortcode [paws_relocate_form].
 *
 * @return string Form HTML.
 */
function pr_render_form_shortcode() {
    ob_start(); 
    ?>
    <div id="pr-multi-step-form-container">
        <form id="pr-multi-step-form" method="post" novalidate> <?php ?>

            <?php wp_nonce_field( 'pr_form_nonce', 'pr_nonce_field' ); ?>

            <div class="pr-step-indicators">
                <div class="pr-indicator active"><span><?php esc_html_e('STEP 1', 'paws-relocate'); ?></span><?php esc_html_e('Pet Information', 'paws-relocate'); ?></div>
                <div class="pr-indicator"><span><?php esc_html_e('STEP 2', 'paws-relocate'); ?></span><?php esc_html_e('Location Information', 'paws-relocate'); ?></div>
                <div class="pr-indicator"><span><?php esc_html_e('STEP 3', 'paws-relocate'); ?></span><?php esc_html_e('Additional Service', 'paws-relocate'); ?></div>
            </div>

            <div class="pr-form-status" role="alert">
                </div>

            <div class="pr-form-step active" id="pr-step-1">
                <fieldset class="pr-fieldset-main">
                    <legend class="pr-screen-reader-text"><?php esc_html_e( 'Pet Selection', 'paws-relocate' ); ?></legend>
                     <p class="pr-form-row pr-form-row-full">
                        <label for="pr-number-of-pets"><?php esc_html_e( 'Number of Pet', 'paws-relocate' ); ?> <span class="required">*</span></label>
                        <select id="pr-number-of-pets" name="number_of_pets" required>
                            <option value="1">01</option>
                            <option value="2">02</option>
                            <option value="3">03</option>
                            <option value="4">04</option>
                            <option value="5">05</option>
                            </select>
                         <small><?php esc_html_e( 'Note: This version supports details for one pet. Multi-pet forms require further customization.', 'paws-relocate' ); ?></small>
                    </p>
                </fieldset>

                <fieldset class="pr-fieldset-petinfo">
                    <legend><?php esc_html_e( 'Pet Information (01)', 'paws-relocate' ); ?></legend> <?php ?>

                    <div class="pr-form-grid pr-grid-three-col"> <?php ?>
                        <p class="pr-form-row">
                            <label for="pr-pet-type"><?php esc_html_e( 'Type of Pet', 'paws-relocate' ); ?> <span class="required">*</span></label>
                            <input type="text" id="pr-pet-type" name="pet_type" placeholder="<?php esc_attr_e( 'Type here', 'paws-relocate' ); ?>" required>
                        </p>
                        <p class="pr-form-row">
                            <label for="pr-breed"><?php esc_html_e( 'Breed', 'paws-relocate' ); ?> <span class="required">*</span></label>
                            <select id="pr-breed" name="breed" required>
                                <option value=""><?php esc_html_e( 'Not Selected', 'paws-relocate' ); ?></option>
                                <option value="Labrador"><?php esc_html_e( 'Labrador Retriever', 'paws-relocate' ); ?></option>
                                <option value="German Shepherd"><?php esc_html_e( 'German Shepherd', 'paws-relocate' ); ?></option>
                                <option value="Domestic Shorthair"><?php esc_html_e( 'Domestic Shorthair (Cat)', 'paws-relocate' ); ?></option>
                                <option value="Other"><?php esc_html_e( 'Other', 'paws-relocate' ); ?></option>
                                </select>
                        </p>
                        <p class="pr-form-row">
                            <label for="pr-age"><?php esc_html_e( 'Age', 'paws-relocate' ); ?> <span class="required">*</span></label>
                            <select id="pr-age" name="age" required>
                                <option value=""><?php esc_html_e( 'Select Age', 'paws-relocate' ); ?></option>
                                <option value="<1 year"><?php esc_html_e( '< 1 year', 'paws-relocate' ); ?></option>
                                <option value="1 year">1 <?php esc_html_e( 'year', 'paws-relocate' ); ?></option>
                                <option value="2 years">2 <?php esc_html_e( 'years', 'paws-relocate' ); ?></option>
                                <option value="10+ years">10+ <?php esc_html_e( 'years', 'paws-relocate' ); ?></option>
                            </select>
                        </p>
                         <p class="pr-form-row">
                            <label for="pr-weight"><?php esc_html_e( 'Weight', 'paws-relocate' ); ?> <span class="required">*</span></label>
                            <select id="pr-weight" name="weight" required>
                                <option value=""><?php esc_html_e( 'Select Weight', 'paws-relocate' ); ?></option>
                                <option value="<5 KG">&lt; 5 KG</option>
                                <option value="5-10 KG">5-10 KG</option>
                                <option value="11-15 KG">11-15 KG</option>
                                <option value="40+ KG">&gt; 40 KG</option>
                            </select>
                        </p>
                        <p class="pr-form-row">
                            <label for="pr-spayed-neutered"><?php esc_html_e( 'Spaying/Neutering Status', 'paws-relocate' ); ?> <span class="required">*</span></label>
                            <select id="pr-spayed-neutered" name="spayed_neutered" required>
                                <option value="Yes"><?php esc_html_e( 'Yes', 'paws-relocate' ); ?></option>
                                <option value="No"><?php esc_html_e( 'No', 'paws-relocate' ); ?></option>
                            </select>
                        </p>
                        <p class="pr-form-row">
                            <label for="pr-vaccination-status"><?php esc_html_e( 'Vaccination Report', 'paws-relocate' ); ?> <span class="required">*</span></label>
                            <select id="pr-vaccination-status" name="vaccination_status" required>
                                <option value=""><?php esc_html_e( 'Select Status', 'paws-relocate' ); ?></option>
                                <option value="Up-to-date"><?php esc_html_e( 'Up-to-date', 'paws-relocate' ); ?></option>
                                <option value="Needs Update"><?php esc_html_e( 'Needs Update', 'paws-relocate' ); ?></option>
                                <option value="Provide Later"><?php esc_html_e( 'Will Provide Later', 'paws-relocate' ); ?></option>
                                <option value="Not Applicable"><?php esc_html_e( 'Not Applicable', 'paws-relocate' ); ?></option>
                            </select>
                        </p>
                    </div> <p class="pr-form-row pr-form-row-full">
                        <label for="pr-health"><?php esc_html_e( 'Health Condition', 'paws-relocate' ); ?> <span class="required">*</span></label>
                        <textarea id="pr-health" name="health_condition" rows="3" placeholder="<?php esc_attr_e( 'List any known health conditions or allergies.', 'paws-relocate' ); ?>" required></textarea>
                    </p>
                    <p class="pr-form-row pr-form-row-full">
                        <label for="pr-medicine"><?php esc_html_e( 'Any Specific Medicine', 'paws-relocate' ); ?></label>
                        <textarea id="pr-medicine" name="specific_medicine" rows="3" placeholder="<?php esc_attr_e( 'List any medications the pet needs.', 'paws-relocate' ); ?>"></textarea>
                    </p>
                     <p class="pr-form-row pr-form-row-full">
                        <label for="pr-training"><?php esc_html_e( 'Behaviour Training', 'paws-relocate' ); ?></label>
                        <textarea id="pr-training" name="behaviour_training" rows="3" placeholder="<?php esc_attr_e( 'Mention any specific behaviour notes (e.g., anxiety, training commands).', 'paws-relocate' ); ?>"></textarea>
                    </p>

                    <p class="pr-form-row pr-form-row-full pr-radio-group">
                        <label><?php esc_html_e( 'Health Certificate', 'paws-relocate' ); ?> <span class="required">*</span></label>
                        <span class="pr-radio-option">
                            <input type="radio" id="pr-cert-issued" name="health_certificate_status" value="Issued" required>
                            <label for="pr-cert-issued"><?php esc_html_e( 'Issued', 'paws-relocate' ); ?></label>
                        </span>
                        <span class="pr-radio-option">
                            <input type="radio" id="pr-cert-pending" name="health_certificate_status" value="Pending">
                            <label for="pr-cert-pending"><?php esc_html_e( 'Pending', 'paws-relocate' ); ?></label>
                        </span>
                    </p>

                    <div class="pr-add-pet-placeholder">
                         <a href="#" id="pr-add-pet-btn" class="pr-add-pet-button" style="display: none;">+ <?php esc_html_e( 'Add Another Pet Information', 'paws-relocate' ); ?></a>
                         </div>

                </fieldset>
                <div class="pr-navigation-buttons">
                    <button type="button" class="pr-prev-btn" disabled>&laquo; <?php esc_html_e( 'Previous', 'paws-relocate' ); ?></button>
                    <button type="button" class="pr-next-btn"><?php esc_html_e( 'Next', 'paws-relocate' ); ?> &raquo;</button>
                </div>
            </div><div class="pr-form-step" id="pr-step-2">
                 <fieldset class="pr-fieldset-main">
                     <legend class="pr-screen-reader-text"><?php esc_html_e( 'Location Details', 'paws-relocate' ); ?></legend>

                    <p class="pr-form-row pr-form-row-full pr-radio-group">
                        <label><?php esc_html_e( 'Relocation Type', 'paws-relocate' ); ?> <span class="required">*</span></label>
                        <span class="pr-radio-option">
                            <input type="radio" id="pr-relocation-domestic" name="relocation_type" value="Domestic" required checked>
                            <label for="pr-relocation-domestic"><?php esc_html_e( 'Domestic', 'paws-relocate' ); ?></label>
                        </span>
                        <span class="pr-radio-option">
                            <input type="radio" id="pr-relocation-international" name="relocation_type" value="International">
                            <label for="pr-relocation-international"><?php esc_html_e( 'International', 'paws-relocate' ); ?></label>
                        </span>
                    </p>

                    <div class="pr-location-section">
                        <h3><?php esc_html_e( 'Departure Location', 'paws-relocate' ); ?></h3>
                        <p class="pr-form-row pr-form-row-full">
                            <label for="pr-departure-address"><?php esc_html_e( 'Address Line', 'paws-relocate' ); ?> <span class="required">*</span></label>
                            <textarea id="pr-departure-address" name="departure_address" rows="3" placeholder="<?php esc_attr_e( 'Full departure address', 'paws-relocate' ); ?>" required></textarea>
                        </p>
                        <div class="pr-form-grid pr-grid-two-col">
                             <p class="pr-form-row">
                                <label for="pr-departure-city"><?php esc_html_e( 'City', 'paws-relocate' ); ?> <span class="required">*</span></label>
                                <select id="pr-departure-city" name="departure_city" required>
                                    <option value=""><?php esc_html_e( 'Select Your City', 'paws-relocate' ); ?></option>
                                    <option value="Dubai">Dubai</option>
                                    <option value="Abu Dhabi">Abu Dhabi</option>
                                     </select>
                            </p>
                            <p class="pr-form-row">
                                <label for="pr-departure-country"><?php esc_html_e( 'Country', 'paws-relocate' ); ?> <span class="required">*</span></label>
                                <select id="pr-departure-country" name="departure_country" required>
                                    <option value=""><?php esc_html_e( 'Select Country', 'paws-relocate' ); ?></option>
                                    <option value="UAE">United Arab Emirates</option>
                                    <option value="USA">United States</option>
                                    </select>
                            </p>
                             <p class="pr-form-row">
                                <label for="pr-travel-date"><?php esc_html_e( 'Travel Date', 'paws-relocate' ); ?> <span class="required">*</span></label>
                                <input type="date" id="pr-travel-date" name="travel_date" required class="pr-input-date" placeholder="YYYY-MM-DD">
                             </p>
                             <p class="pr-form-row">
                                <label for="pr-same-flight"><?php esc_html_e( 'Are You Travelling In The Same Flight?', 'paws-relocate' ); ?> <span class="required">*</span></label>
                                <select id="pr-same-flight" name="same_flight" required>
                                    <option value="Yes"><?php esc_html_e( 'Yes', 'paws-relocate' ); ?></option>
                                    <option value="No"><?php esc_html_e( 'No', 'paws-relocate' ); ?></option>
                                </select>
                            </p>
                        </div><p class="pr-form-row pr-form-row-full pr-conditional-field" id="pr-flight-info-wrapper"> <?php // Wrapper for JS show/hide ?>
                            <label for="pr-departure-flight-info"><?php esc_html_e( 'Your Flight Information', 'paws-relocate' ); ?> <span class="required" id="pr-flight-info-required">*</span></label> <?php // Required asterisk controlled by JS ?>
                            <textarea id="pr-departure-flight-info" name="departure_flight_info" rows="3" placeholder="<?php esc_attr_e( 'e.g., Airline, Flight Number, Time', 'paws-relocate' ); ?>" required></textarea> <?php // Required attribute handled by JS ?>
                        </p>
                    </div><div class="pr-location-section">
                        <h3><?php esc_html_e( 'Arrival Location', 'paws-relocate' ); ?></h3>
                         <p class="pr-form-row pr-form-row-full">
                            <label for="pr-arrival-address"><?php esc_html_e( 'Address Line', 'paws-relocate' ); ?> <span class="required">*</span></label>
                            <textarea id="pr-arrival-address" name="arrival_address" rows="3" placeholder="<?php esc_attr_e( 'Full arrival address', 'paws-relocate' ); ?>" required></textarea>
                        </p>
                        <div class="pr-form-grid pr-grid-two-col">
                             <p class="pr-form-row">
                                <label for="pr-arrival-city"><?php esc_html_e( 'City', 'paws-relocate' ); ?> <span class="required">*</span></label>
                                <select id="pr-arrival-city" name="arrival_city" required>
                                     <option value=""><?php esc_html_e( 'Select Your City', 'paws-relocate' ); ?></option>
                                     <option value="Dubai">Dubai</option>
                                     <option value="London">London</option>
                                     </select>
                            </p>
                            <p class="pr-form-row">
                                <label for="pr-arrival-country"><?php esc_html_e( 'Country', 'paws-relocate' ); ?> <span class="required">*</span></label>
                                <select id="pr-arrival-country" name="arrival_country" required>
                                     <option value=""><?php esc_html_e( 'Select Country', 'paws-relocate' ); ?></option>
                                     <option value="UAE">United Arab Emirates</option>
                                     <option value="UK">United Kingdom</option>
                                     </select>
                            </p>
                        </div><p class="pr-form-row pr-form-row-full">
                            <label for="pr-emergency-contact"><?php esc_html_e( 'Emergency Contact Arrival Country (Optional)', 'paws-relocate' ); ?></label>
                            <input type="tel" id="pr-emergency-contact" name="emergency_contact" placeholder="<?php esc_attr_e( 'Enter Arrival Country Contact number', 'paws-relocate' ); ?>" pattern="[0-9\+\-\(\)\s]*">
                        </p>
                    </div></fieldset>
                <div class="pr-navigation-buttons">
                    <button type="button" class="pr-prev-btn">&laquo; <?php esc_html_e( 'Previous', 'paws-relocate' ); ?></button>
                    <button type="button" class="pr-next-btn"><?php esc_html_e( 'Next', 'paws-relocate' ); ?> &raquo;</button>
                </div>
            </div><div class="pr-form-step" id="pr-step-3">
                <fieldset class="pr-fieldset-main">
                     <legend class="pr-screen-reader-text"><?php esc_html_e( 'Additional Services & Information', 'paws-relocate' ); ?></legend>

                    <?php  ?>

                    <p class="pr-form-row pr-form-row-full pr-radio-group">
                        <label><?php esc_html_e( 'Pet Grooming Required Before Relocation?', 'paws-relocate' ); ?> <span class="required">*</span></label>
                         <span class="pr-radio-option">
                            <input type="radio" id="pr-grooming-yes" name="grooming_required" value="Yes" required>
                            <label for="pr-grooming-yes"><?php esc_html_e( 'Yes', 'paws-relocate' ); ?></label>
                        </span>
                        <span class="pr-radio-option">
                            <input type="radio" id="pr-grooming-no" name="grooming_required" value="No" checked> <?php ?>
                            <label for="pr-grooming-no"><?php esc_html_e( 'No', 'paws-relocate' ); ?></label>
                        </span>
                    </p>

                    <div class="pr-additional-info-section">
                        <h3><?php esc_html_e( 'Post Arrival Support', 'paws-relocate' ); ?></h3>
                        <div class="pr-form-grid pr-grid-two-col">
                             <p class="pr-form-row">
                                <label for="pr-checkup"><?php esc_html_e( 'Pet check up', 'paws-relocate' ); ?> <span class="required">*</span></label>
                                <select id="pr-checkup" name="post_arrival_checkup" required>
                                     <option value=""><?php esc_html_e( 'Select Option', 'paws-relocate' ); ?></option>
                                     <option value="Required"><?php esc_html_e( 'Required - Please Arrange', 'paws-relocate' ); ?></option>
                                     <option value="Not Required"><?php esc_html_e( 'Not Required', 'paws-relocate' ); ?></option>
                                     <option value="Arrange Myself"><?php esc_html_e( 'Will Arrange Myself', 'paws-relocate' ); ?></option>
                                </select>
                            </p>
                            <p class="pr-form-row">
                                <label for="pr-microchipped"><?php esc_html_e( 'Is your pet microchipped?', 'paws-relocate' ); ?> <span class="required">*</span></label>
                                <select id="pr-microchipped" name="is_microchipped" required>
                                     <option value=""><?php esc_html_e( 'Select Option', 'paws-relocate' ); ?></option>
                                     <option value="Yes"><?php esc_html_e( 'Yes', 'paws-relocate' ); ?></option>
                                     <option value="No"><?php esc_html_e( 'No', 'paws-relocate' ); ?></option>
                                </select>
                            </p>
                             <p class="pr-form-row">
                                <label for="pr-vacc-uptodate"><?php esc_html_e( 'Is your pet up to date with vaccinations?', 'paws-relocate' ); ?> <span class="required">*</span></label>
                                <select id="pr-vacc-uptodate" name="vaccinations_up_to_date" required>
                                     <option value=""><?php esc_html_e( 'Select Option', 'paws-relocate' ); ?></option>
                                     <option value="Yes"><?php esc_html_e( 'Yes', 'paws-relocate' ); ?></option>
                                     <option value="No"><?php esc_html_e( 'No', 'paws-relocate' ); ?></option>
                                     <option value="Unsure"><?php esc_html_e( 'Unsure', 'paws-relocate' ); ?></option>
                                </select>
                            </p>
                            <p class="pr-form-row">
                                <label for="pr-has-issues"><?php esc_html_e( 'Does your pet have any health issues?', 'paws-relocate' ); ?> <span class="required">*</span></label>
                                <select id="pr-has-issues" name="has_health_issues" required>
                                    <option value=""><?php esc_html_e( 'Select Option', 'paws-relocate' ); ?></option>
                                    <option value="Yes"><?php esc_html_e( 'Yes (Details in Step 1)', 'paws-relocate' ); ?></option>
                                    <option value="No"><?php esc_html_e( 'No', 'paws-relocate' ); ?></option>
                                </select>
                            </p>
                             <p class="pr-form-row">
                                <label for="pr-has-crate"><?php esc_html_e( 'Do you have an IATA approved travel crate?', 'paws-relocate' ); ?> <span class="required">*</span></label>
                                <select id="pr-has-crate" name="has_iata_crate" required>
                                     <option value=""><?php esc_html_e( 'Select Option', 'paws-relocate' ); ?></option>
                                     <option value="Yes"><?php esc_html_e( 'Yes', 'paws-relocate' ); ?></option>
                                     <option value="No"><?php esc_html_e( 'No', 'paws-relocate' ); ?></option>
                                     <option value="Need Assistance"><?php esc_html_e( 'No, Need Assistance', 'paws-relocate' ); ?></option>
                                </select>
                            </p>
                             <p class="pr-form-row pr-form-row-full">
                                <label for="pr-additional-notes"><?php _e( 'Additional Notes/Services (Optional)', 'paws-relocate' ); ?></label>
                                <textarea id="pr-additional-notes" name="additional_services" rows="4" placeholder="<?php esc_attr_e( 'Enter any other requests or information here.', 'paws-relocate' ); ?>"></textarea>
                            </p>
                        </div></div></fieldset>
                 <div class="pr-navigation-buttons">
                    <button type="button" class="pr-prev-btn">&laquo; <?php esc_html_e( 'Previous', 'paws-relocate' ); ?></button>
                    <button type="submit" class="pr-submit-btn"><?php esc_html_e( 'Submit', 'paws-relocate' ); ?></button> <?php // Changed from Next to Submit ?>
                </div>
            </div></form>
    </div> <?php
    return ob_get_clean();
}
?>