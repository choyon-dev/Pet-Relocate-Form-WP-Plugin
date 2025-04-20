# Paws Relocate - Pet Relocation For Wordpress Plugin

**Version:** 1.0.0  
**Author:** [Choyon](https://github.com/choyon-dev)  
**License:** GPL v2 or later  

## Description

The **Paws Relocate** plugin is a WordPress plugin designed to facilitate pet relocation services. It provides a multi-step form for collecting detailed information about pets, their relocation requirements, and additional services. The plugin also includes an admin dashboard for managing submissions and email notifications for new form entries.

---

## Features

- **Multi-Step Form**: A user-friendly, multi-step form for collecting pet relocation details.
- **Admin Dashboard**: View submissions directly from the WordPress admin panel.
- **Email Notifications**: Sends email notifications to the admin upon form submission.
- **Custom Database Table**: Stores form submissions in a custom database table.
- **AJAX Submission**: Ensures smooth form submission without page reloads.
- **Validation**: Client-side and server-side validation for all form fields.
- **Localization**: Fully translatable with support for multiple languages.

---

## Installation

1. Download the plugin files and place them in the `wp-content/plugins/paws-relocate` directory.
2. Activate the plugin through the WordPress admin dashboard under **Plugins**.
3. Upon activation, the plugin will create a custom database table for storing submissions.

---

## Shortcode

Use the following shortcode to display the multi-step form on any page or post:

```plaintext
[paws_relocate_form]
```

---

## Admin Dashboard

The plugin adds a new menu item in the WordPress admin panel:

- **Paws Relocate**: View and manage all form submissions.

---

## Email Notifications

The plugin sends an email notification to the admin email address configured in WordPress settings whenever a new form submission is received. The email includes all the details submitted in the form.

---

## File Structure

```
paws-relocate/
├── assets/
│   ├── css/
│   │   └── plugin-styles.css       # Styles for the multi-step form
│   ├── js/
│   │   └── plugin-scripts.js       # JavaScript for form functionality
├── includes/
│   ├── activation.php              # Handles plugin activation and database table creation
│   ├── admin-page.php              # Admin dashboard for viewing submissions
│   ├── ajax-handler.php            # Handles AJAX form submissions
│   ├── email.php                   # Sends email notifications
│   ├── shortcode.php               # Renders the form via shortcode
├── paws-relocate.php               # Main plugin file
```

---

## Development

### Constants

The plugin defines the following constants:

- `PR_PLUGIN_PATH`: Absolute path to the plugin directory.
- `PR_PLUGIN_URL`: URL to the plugin directory.
- `PR_VERSION`: Plugin version.
- `PR_TABLE_NAME`: Name of the custom database table (`paws_relocate_submissions`).

### Hooks

- **Activation Hook**: `register_activation_hook()` to create the custom database table.
- **Shortcode**: `add_shortcode()` to render the form.
- **AJAX Actions**: `wp_ajax_pr_submit_form` and `wp_ajax_nopriv_pr_submit_form` for handling form submissions.
- **Admin Menu**: `add_action('admin_menu')` to add the admin dashboard.

---

## Localization

The plugin is fully translatable. Use the `paws-relocate` text domain for translations. Place `.mo` and `.po` files in the `/languages` directory.

---

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher

---

## License

This plugin is licensed under the [GPL v2 or later](https://www.gnu.org/licenses/gpl-2.0.html).

---

## Support

For issues or feature requests, please contact the author via [GitHub](https://github.com/choyon-dev).
