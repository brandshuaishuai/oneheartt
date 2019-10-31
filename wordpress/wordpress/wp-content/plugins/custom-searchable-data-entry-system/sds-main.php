<?php
/*
Plugin Name: Custom Searchable Data Entry System
Plugin URI: http://piqibo.me.pn/custom-searchable-data-entry-system
Description: Fully customizable data entry forms creator. Make your own forms and enter your data (such as your clients details, their name, project, logo, etc) in the form. Your entries are stored in organized tables. You can then search the data from a single search field on front-end which has many capabilities. To have a quick look of the features, take a look at the Welcome page of this plugin.
Author: Ghazale Shirazi
Version: 1.7.1
Text Domain: custom-searchable
Domain Path: /languages
Author URI: https://searchablepro.com

    Copyright 2015  Ghazale Shirazi  (email : searchable.pro@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
require_once( 'sds-session.php' );

/**
 * register settings
 */
function ghazale_sds_register_settings() {
	register_setting( 'ghazale_sds_options', 'ghazale_sds_separate_search' );
}

add_action( 'admin_init', 'ghazale_sds_register_settings' );
/**
 * Welcome Page
 */

function ghazale_sds_welcome_page() {
	?>
    <div style="position: relative">
        <div class="card" style="max-width: 50%; display: inline-block">
            <h2><?php _e( 'Welcome to Custom Searchable Data Entry System', 'custom-searchable-data-entry-system' ); ?></h2>
            <h3><?php _e( 'Making Your First Form', 'custom-searchable-data-entry-system' ); ?></h3>
            <p><?php _e( 'To make a new form, follow these steps', 'custom-searchable-data-entry-system' ); ?>:</p>
            <ol>
                <li><?php _e( 'Click on "Create Form" menu. Name your new form and create it.', 'custom-searchable-data-entry-system' ); ?></li>
                <li><?php _e( 'Click on "Add Fields" menu. Select your newly created form, name your field and choose field type (e.g.: Text Input, Checkbox, DropDown, etc). You can also choose whether you want this field to be "Hidden" or not. (Hidden fields won\'t be shown on user\'s search query)', 'custom-searchable-data-entry-system' ); ?></li>
                <li><?php _e( 'Repeat number 2 and add as much as fields you like. (You can add unlimited number of fields to your form)', 'custom-searchable-data-entry-system' ); ?></li>
                <li><?php _e( 'Your form is ready to use. Click on "Forms" menu. You can see the form that you have made in previous steps. You can also edit or delete any of the form fields.', 'custom-searchable-data-entry-system' ); ?></li>
            </ol>
            <hr>
            <div>
                <h3><?php _e( 'Having Your Search Field on Front-end', 'custom-searchable-data-entry-system' ); ?></h3>
                <p><?php _e( 'The default functionality of the plugin search engine is to search ALL entries. To have the default functionality, just put the shortcode [sds-search] on any post or page and you\'ll have it up an running.', 'custom-searchable-data-entry-system' ); ?></p>
                <p><?php _e( 'If you wish to use a unique search engine for each table, please refer to the <a href="' . get_admin_url() . 'admin.php?page=sds-options_page' . '">Options</a> page for more instructions.', 'custom-searchable-data-entry-system' ); ?></p>
            </div>
            <hr>
            <div>
                <strong><?php _e( 'If you like this plugin and find it helpful, please rate it 5 stars!', 'custom-searchable-data-entry-system' ); ?>
                    <a href="https://wordpress.org/support/view/plugin-reviews/custom-searchable-data-entry-system?rate=5#postform"><img
                                src="<?php echo plugins_url( 'images/5stars.png', __FILE__ ); ?>"></a>
                    <br><?php _e( 'Your donation will be used to protect helpless animals. It is highly appreciated!', 'custom-searchable-data-entry-system' ); ?>
                    <br></p></strong>
                <p><a href="http://www.vafashelter.com/main/en/helping-us/paypal-donation" target="_blank"><img
                                src="<?php echo plugins_url( 'images/btn_donatecc_lg.gif', __FILE__ ); ?>"
                                alt="btn donatecc lg"></a></p></div>
            <hr>
            <h3><?php _e( 'A Quick Look of the Features', 'custom-searchable-data-entry-system' ); ?></h3>
            <ol>
                <li><?php _e( 'You have full control over the creation of your forms, number of fields and the field types.', 'custom-searchable-data-entry-system' ); ?></li>
                <li><?php _e( 'You can create unlimited number of forms.', 'custom-searchable-data-entry-system' ); ?></li>
                <li><?php _e( 'You can have unlimited number of fields in each form.', 'custom-searchable-data-entry-system' ); ?></li>
                <li><?php _e( 'You can have full control over the search query results and can decide which data to be displayed or to be hidden in the user\'s search result.', 'custom-searchable-data-entry-system' ); ?></li>
                <li><?php _e( 'The user can search the form based on ANY of the entries that you have in your backend.', 'custom-searchable-data-entry-system' ) ?></li>
                <h4><?php _e( 'Example:', 'custom-searchable-data-entry-system' ) ?></h4>
                <p><?php _e( 'Let\'s assume these are your entries in the backend:', 'custom-searchable-data-entry-system' ) ?></p>
                <style>
                    table, td, th {
                        border: 1px solid #979797;
                        border-collapse: collapse;
                        padding: 5px;
                    }

                    th {
                        background-color: #404040;
                        color: #FFFFFF;
                    }
                </style>
                <table>
                    <tr>
                        <th>Client Name</th>
                        <th>Client Project</th>
                        <th>Client City</th>
                        <th>Client Reference ID</th>
                    </tr>
                    <tr>
                        <td>David</td>
                        <td>Bridge</td>
                        <td>London</td>
                        <td>746</td>
                    </tr>
                    <tr>
                        <td>Paul</td>
                        <td>Road</td>
                        <td>New York</td>
                        <td>412</td>
                    </tr>
                </table>
                <p><?php _e( 'In this example the user can search based on any of the entries. (It can be Client Name, Client Project, Client City or Client Reference ID)', 'custom-searchable-data-entry-system' ) ?></p>
                <p><?php _e( 'If the user search is "David" the first row will be returned to the user. If the user search is "London", again the first row will be returned. And if the user search is "New York", the second row will be returned to the user. So basically the user is able to search based on any information that you provide.', 'custom-searchable-data-entry-system' ) ?></p>
                <p><?php _e( 'And of course if you make a particular field as "Hidden", those data won\'t be shown to the user.', 'custom-searchable-data-entry-system' ) ?></p>
                <li><?php _e( 'You can have your search form on front-end with a single shortcode. The search results will appear on the same page right below the search form.', 'custom-searchable-data-entry-system' ) ?></li>
                <li><?php _e( 'You can Edit or Delete any of the fields that you don\'t want anymore.', 'custom-searchable-data-entry-system' ) ?></li>
                <li><?php _e( 'You can Update the entries that you already entered/uploaded to the plugin.', 'custom-searchable-data-entry-system' ) ?></li>
                <li><?php _e( 'The search result shows partial matches as well and it is case-insensitive.', 'custom-searchable-data-entry-system' ) ?></li>
                <li><?php _e( 'You can change the hidden fields to be shown or vice versa anytime you wish.', 'custom-searchable-data-entry-system' ) ?></li>
                <li><?php _e( 'You can search ALL the entries with a single search engine OR You can search tables SEPARATELY with their unique search engine.', 'custom-searchable-data-entry-system' ) ?></li>
                <li><?php _e( 'You can also upload the data that is already on your local computer (in CSV format that comes from your Excel file) and have the same features like the tables that you create through plugin. You can add records, edit/delete fields or delete selected inputs.', 'custom-searchable-data-entry-system' ) ?></li>
            </ol>
            <h4><?php _e( 'Additional Note: The "File Upload" field type is intended for image uploads only.', 'custom-searchable-data-entry-system' ) ?></h4>
            <h3><?php _e( 'Entries', 'custom-searchable-data-entry-system' ); ?></h3>
            <p><?php _e( 'Your entries are all being stored on "Entries" page in organized tabs and tables. If you wanted to update/delete any single entry you can do it there as well.', 'custom-searchable-data-entry-system' ); ?></p>
            <p><?php _e( 'You also have the ability to totally delete the selected entries table, or both the entries table and its correspondent form', 'custom-searchable-data-entry-system' ); ?></p>
        </div>
        <div class="card" style="max-width: 40%; display: inline-block; position: absolute; top: 0; right: 24px">
            <h2>Go Pro!</h2>
            <strong>Have all the awesome features from <a href="https://searchablepro.com" target="_blank">Searchable
                    Pro</a></strong>
            <div style="background-color: #dff0d8; border: 1px solid #d0e9c6; color: #3c763d; padding: 8px">
                Have full control over search settings and fine tune the settings of every single field element. Take
                advantage of highly advanced search engine for customised data.
            </div>
            <br>
            <strong>Lots of features available in <a href="https://searchablepro.com" target="_blank">Searchable Pro</a>,
                namely:</strong>
            <div style="background-color: #dff0d8; border: 1px solid #d0e9c6; color: #3c763d; padding: 8px">
                <ul>
                    <li>Advanced settings for customising search engine</li>
                    <li>starFull control of fields that should be searchable and the fields that should not</li>
                    <li>starFull control of what data should be shown in search results and what data should be hidden
                        from user search
                    </li>
                    <li>starFull control of search match pattern. Flexible match or exact match</li>
                    <li>starFull control of multiple data sets. You can have multiple search engines for different data
                        sets and set your settings separately according to your needs
                    </li>
                    <li>starAbility to upload large amount of data set in csv format. Searchable Pro takes care of
                        sorting the data in proper searchable format
                    </li>
                    <li>starSee what your users have searched for. Useful analytics about your user's search in your
                        data sets
                    </li>
                    <li>starAbility to see the amount of data that have been transferred in each endpoint & keep control
                        of your data usage by its special setting
                    </li>
                    <li>starAbility to generate API keys for external developers and make use of Searchable service in
                        any programming language
                    </li>
                    <li>starUsing WordPress? Searchable Pro already offers a ready to use WordPress plugin to start
                        using the service right away on your website.
                    </li>
                </ul>
            </div>
            <h3>Why Searchable Pro?</h3>
            <p>Searchable Pro takes all the burden of searching your customised data on its own secure servers and does
                all the process for you.</p>
            <p>It also provides a free super light official WordPress plugin that goes a long with it. You can have lots
                of settings to fine tune your very own search engine for your customised data.</p>
            <p>Searchable Pro offers the possibility for processing your data remotely and return whatever that is
                relevant according to your settings. This will have the big advantage that your server is absolutely
                free and clean of these processes and you always have data consistency and interruption free service.
                There will be no more data inconsistency because of different server and database settings from your
                provider. Searchable Pro will take care of all these complexities and does the heavy lifting for
                you.</p>
            <p>And the awesome news is... Searchable Pro is free to use during its beta phase!</p>
            <a href="https://searchablepro.com" target="_blank" class="button button-primary button-large">Go Pro &
                Upgrade to Searchable Pro</a>
        </div>
    </div>
	<?php
}

function ghazale_sds_welcome_page_menu() {
	add_menu_page( 'Custom Searchable DES', 'Custom Searchable DES', 'manage_options', 'custom-searchable-data-entry-system', 'ghazale_sds_welcome_page', 'dashicons-search' );
	add_submenu_page( 'custom-searchable-data-entry-system', __( 'Welcome', 'custom-searchable-data-entry-system' ), __( 'Welcome', 'custom-searchable-data-entry-system' ), 'manage_options', 'custom-searchable-data-entry-system', 'ghazale_sds_welcome_page' );
}

add_action( 'admin_menu', 'ghazale_sds_welcome_page_menu' );

/**
 * Create Form Admin Page
 */
function ghazale_sds_create_form() {
	?>
    <div class="card">
        <form action="" method="post" id="ghazale_ds_new_form">
			<?php echo ghazale_sds_message(); ?>
            <h2><?php _e( 'Create New Form', 'custom-searchable-data-entry-system' ); ?></h2>
			<?php _e( 'Form Name', 'custom-searchable-data-entry-system' ); ?>: <input type="text"
                                                                                       name="ghazale_sds_new_form_name"
                                                                                       id="ghazale_sds_new_form_name"
                                                                                       value="<?php if ( isset( $_POST['ghazale_sds_new_form_name'] ) ) {
				                                                                           echo $_POST['ghazale_sds_new_form_name'];
			                                                                           } else {
				                                                                           echo '';
			                                                                           } ?>"/><i> <?php _e( 'Alphanumeric characters only. No spaces.', 'custom-searchable-data-entry-system' ); ?></i>
            <br><br><input class="button button-primary button-large" type="submit" name="ghazale_sds_submit_new_form"
                           value="<?php _e( 'Create Form', 'custom-searchable-data-entry-system' ); ?>">
        </form>
    </div>
	<?php
}

function ghazale_sds_create_form_menu() {
	add_submenu_page( 'custom-searchable-data-entry-system', 'Create Form', 'Create Form', 'manage_options', 'sds-create-form', 'ghazale_sds_create_form' );
}

add_action( 'admin_menu', 'ghazale_sds_create_form_menu' );
/**
 * creates 2 relational tables upon creating a new form
 */
function ghazale_sds_create_tables() {
	if ( isset( $_POST['ghazale_sds_submit_new_form'] ) ) {
		if ( ctype_alnum( trim( $_POST['ghazale_sds_new_form_name'] ) ) ) {
			global $wpdb;
			$table_name = $wpdb->prefix . "ghazale_sds_" . strtolower( trim( $_POST['ghazale_sds_new_form_name'] ) );
			$tables     = $wpdb->get_results( "SHOW TABLES LIKE " . "'" . $table_name . "%'" );
			if ( count( $tables ) == 0 ) {
				$sql_form = "CREATE TABLE " . $table_name . "_fields (id INTEGER(10) UNSIGNED AUTO_INCREMENT, field_name VARCHAR (300) COLLATE utf8_bin, field_type VARCHAR (300) COLLATE ascii_bin, field_ext VARCHAR (300) COLLATE utf8_bin, field_hide VARCHAR (4) COLLATE ascii_bin, PRIMARY KEY (id))";
				$wpdb->query( $sql_form );
				$sql_input = "CREATE TABLE " . $table_name . "_inputs (id INTEGER(10) UNSIGNED AUTO_INCREMENT, field_id INTEGER(10), field_input VARCHAR(3000) COLLATE utf8_bin, PRIMARY KEY (id))";
				$wpdb->query( $sql_input );
				$_SESSION['sds-message'] = esc_html__( 'Form Created Successfully', 'custom-searchable-data-entry-system' );
			} else {
				$_SESSION['sds-message'] = esc_html__( 'That name already exists', 'custom-searchable-data-entry-system' );
			}

		} else {
			$_SESSION['sds-message'] = esc_html__( 'The form name SHOULD be alphanumeric. Please enter a valid name', 'custom-searchable-data-entry-system' );
		}
	}
}

add_action( 'wp_loaded', 'ghazale_sds_create_tables' );

/**
 * admin page for adding fields to the selected form
 */

function ghazale_sds_add_fields() {
	global $wpdb;
	$table_name = $wpdb->prefix . "ghazale_sds_";
	$tables     = $wpdb->get_results( "SHOW TABLES LIKE " . "'" . $table_name . "%_fields'", ARRAY_A );
	?>
    <div class="card">
        <form action="" method="post" id="ghazale_sds_add_fields">
            <div><?php echo ghazale_sds_message(); ?></div>
            <h2><?php _e( 'Add Fields To The Form', 'custom-searchable-data-entry-system' ); ?></h2>
            <p>
                <strong><?php _e( 'Once you\'ve added the fields you can see your form under the (Forms) menu.', 'custom-searchable-data-entry-system' ); ?></strong>
            </p>
            <p>
                <i><?php _e( 'Note: You cannot add fields to the forms that has already received inputs. The forms that have inputs are locked against changes. If you wish to edit or add fields to those forms, you should first delete their correspondent input data.', 'custom-searchable-data-entry-system' ); ?></i>
            </p>
			<?php _e( 'Select Form', 'custom-searchable-data-entry-system' ); ?>: <select
                    name="ghazale_sds_select_form">
                <option value=""> -- <?php _e( 'Select Form', 'custom-searchable-data-entry-system' ); ?> --</option>
				<?php
				foreach ( $tables as $table ) {
					foreach ( $table as $select_table ) {
						$input_table_query        = 'SELECT * FROM ' . str_replace( '_fields', '_inputs', $select_table );
						$input_table_query_result = $wpdb->get_results( $input_table_query, ARRAY_A );
						if ( empty( $input_table_query_result ) ) {
							echo "<option value='" . $select_table . "'";
							if ( isset( $_POST['ghazale_sds_select_form'] ) && $_POST['ghazale_sds_select_form'] == $select_table ) {
								echo " selected";
							}
							echo ">" . ucfirst( str_replace( array(
									$table_name,
									'_fields'
								), '', $select_table ) ) . "</option>";
						}
					}
				}
				?>
            </select><i> <?php _e( 'Select the form to which you want to add the field', 'custom-searchable-data-entry-system' ); ?></i><br><br>
			<?php _e( 'Field Name', 'custom-searchable-data-entry-system' ); ?>: <input type="text"
                                                                                        name="ghazale_sds_field_name"
                                                                                        id="ghazale_sds_field_name"
                                                                                        maxlength="300"
                                                                                        placeholder="Enter Field Name"
                                                                                        value="<?php if ( isset( $_POST['ghazale_ds_field_name'] ) ) {
				                                                                            echo trim( $_POST['ghazale_ds_field_name'] );
			                                                                            } else {
				                                                                            echo '';
			                                                                            } ?>"/><i> <?php _e( 'Example: Name, Email, Address, etc... (Should be Alphanumeric. Can have space and allowed Symbols: @-_.,\/:?\'!;&~())', 'custom-searchable-data-entry-system' ); ?></i><br><br>
			<?php $type_array = array(
				"Text Field",
				"Text Area",
				"Drop Down",
				"Multiple Choice",
				"Email",
				"File Upload",
				"Number",
				"Telephone",
				"URL",
				"Date",
				"CheckBox"
			); ?>
			<?php _e( 'Field Type', 'custom-searchable-data-entry-system' ); ?>: <select name="ghazale_sds_field_type"
                                                                                         class="ghazale_sds_field_type">
                <option value=""> -- <?php _e( 'Select Field Type', 'custom-searchable-data-entry-system' ); ?>--
                </option>
				<?php
				foreach ( $type_array as $type ) {
					echo "<option value='" . $type . "'";
					if ( isset( $_POST['ghazale_sds_field_type'] ) && $_POST['ghazale_sds_field_type'] == $type ) {
						echo " selected";
					}
					echo ">" . $type . "</option>";
				}
				?>
            </select><i> <?php _e( 'Select the field type', 'custom-searchable-data-entry-system' ); ?></i><br><br>
            <strong><p class="file_upload_guide" style="color: #ff5500"></p></strong>
            <span id="ghazale_sds_hide"><input type="checkbox" name="ghazale_sds_hide"
                                               value="Hide" <?php if ( isset( $_POST['ghazale_sds_hide'] ) ) {
					echo 'checked';
				} ?>/> <?php _e( 'Hide This Field From Search Query', 'custom-searchable-data-entry-system' ); ?>
                <br><i> (<?php _e( 'If checked, the field information will not be shown in the search query on front-end. You can change this later by editing this field..', 'custom-searchable-data-entry-system' ); ?>
                    )</i><br><br></span>
            <div class="field_ext">
                <i><?php _e( 'You can have up to 10 values for this field', 'custom-searchable-data-entry-system' ); ?>
                    :</i><br>
				<?php
				for ( $i = 0; $i <= 9; $i ++ ) {
					echo "<input type=\"text\" name=\"field_ext_" . $i . "\" value=\"" . ( isset( $_POST["field_ext_{$i}"] ) ? $_POST["field_ext_{$i}"] : '' ) . "\" /><br>";
				}
				?>
            </div>

            <br><input type="submit" name="ghazale-sds-submit-field-name"
                       value="<?php _e( 'Add Field', 'custom-searchable-data-entry-system' ); ?>">
        </form>
    </div>
	<?php
}

function ghazale_sds_add_fields_admin_menu() {
	$page_suffix = add_submenu_page( 'custom-searchable-data-entry-system', __( 'Add Fields', 'custom-searchable-data-entry-system' ), __( 'Add Fields', 'custom-searchable-data-entry-system' ), 'manage_options', 'sds-add-field', 'ghazale_sds_add_fields' );
	add_action( 'admin_print_scripts-' . $page_suffix, 'ghazale_sds_admin_field_ext' );
}

add_action( 'admin_menu', 'ghazale_sds_add_fields_admin_menu' );
function ghazale_sds_admin_init_field_ext() {
	wp_register_script( 'sds-field-ext', plugins_url( 'js/sds-data-storage.js', __FILE__ ), array( 'jquery' ) );
}

add_action( 'admin_init', 'ghazale_sds_admin_init_field_ext' );

function ghazale_sds_admin_field_ext() {
	wp_enqueue_script( 'sds-field-ext' );
}

function ghazale_sds_allowed_characters( $string ) {
	return ! preg_match( '/[^\w\p{L}\p{N}\p{Pd} @-_.,\/:?!;&~()\'\n\r]/u', $string );
}

/**
 * add fields to the selected form in db
 */
function ghazale_sds_add_fields_to_table() {
	if ( isset( $_POST['ghazale-sds-submit-field-name'] ) ) {
		$output = "";
		for ( $i = 0; $i <= 9; $i ++ ) {
			if ( trim( $_POST["field_ext_{$i}"] != "" ) ) {
				$output .= trim( $_POST["field_ext_{$i}"] ) . " | ";
			}
		}
		if ( ! empty( $_POST['ghazale_sds_select_form'] ) && ghazale_sds_allowed_characters( $_POST['ghazale_sds_field_name'] ) && trim( $_POST['ghazale_sds_field_name'] ) != "" && ! empty( $_POST['ghazale_sds_field_type'] ) ) {
			global $wpdb;
			if ( ! empty( $output ) ) {
				$wpdb->insert( $_POST['ghazale_sds_select_form'], array(
					'field_name' => stripcslashes( trim( $_POST['ghazale_sds_field_name'] ) ),
					'field_type' => $_POST['ghazale_sds_field_type'],
					'field_ext'  => $output,
					'field_hide' => ( isset( $_POST['ghazale_sds_hide'] ) ? $_POST['ghazale_sds_hide'] : '' )
				), array( '%s' ) );
				$_SESSION['sds-message'] = esc_html__( 'Field Added Successfully', 'custom-searchable-data-entry-system' );
			} else {
				$wpdb->insert( $_POST['ghazale_sds_select_form'], array(
					'field_name' => stripcslashes( trim( $_POST['ghazale_sds_field_name'] ) ),
					'field_type' => $_POST['ghazale_sds_field_type'],
					'field_hide' => ( isset( $_POST['ghazale_sds_hide'] ) ? $_POST['ghazale_sds_hide'] : '' )
				), array( '%s' ) );
				$_SESSION['sds-message'] = esc_html__( 'Field Added Successfully', 'custom-searchable-data-entry-system' );
			}
		} else {
			$_SESSION['sds-message'] = esc_html__( 'All fields are required. Please make sure you have filled all fields (Also make sure the entered Field Name is not containing disallowed symbols)', 'custom-searchable-data-entry-system' );
		}
	}
}

add_action( 'init', 'ghazale_sds_add_fields_to_table' );
/**
 * showing the created forms in the backend
 */
function ghazale_sds_created_forms() {
	global $wpdb;
	$table_name = $wpdb->prefix . "ghazale_sds_";
	$sql        = "SHOW TABLES LIKE '" . $table_name . "%_fields'";
	$tables     = $wpdb->get_results( $sql, ARRAY_A );
	echo ghazale_sds_message();
	if ( ! empty( $tables ) ) {
		echo "<div id=\"form_tabs\">";
		echo "<ul>";
		foreach ( $tables as $table ) {
			foreach ( $table as $fields_table ) {
				echo "<li><a href=\"#" . $fields_table . "\">" . ucfirst( str_replace( array(
						$table_name,
						'_fields'
					), '', $fields_table ) ) . "</a></li>";
			}
		}
		echo "</ul>";
		foreach ( $tables as $table ) {
			foreach ( $table as $fields_table ) {
				$sql_fields = "SELECT * FROM " . $fields_table;
				$fields     = $wpdb->get_results( $sql_fields, ARRAY_A );
				echo "<p>" . ghazale_sds_message() . "</p>";
				echo "<p>" . ghazale_sds_update() . "</p>";
				echo "<div id=\"" . $fields_table . "\">";
				echo "<h2>" . ucfirst( str_replace( array( $table_name, '_fields' ), '', $fields_table ) ) . "</h2>";
				if ( $fields ) {
					echo "<p>" . __( "Guide: <strong style='color: #ff5500'>Hidden on front-end search query</strong> means the data for that particular field will not be shown on front-end search query when the user searches the data. You can control which data to be hidden/shown by editing the field.", "custom-searchable-data-entry-system" ) . "</p>";
					echo "<p style='color: #008867'><strong>" . esc_html( 'Form Shortcode' ) . ":</strong> [sds-form form=\"" . str_replace( array(
							$table_name,
							'_fields'
						), '', $fields_table ) . "\"]</p>";
					echo "<form action=\"\" method=\"post\" id=\"ds-form {$fields_table}\" enctype=\"multipart/form-data\">";

					foreach ( $fields as $field ) {
						echo $field['field_name'] . ": " . "<a href='" . get_admin_url() . "admin.php?page=sds-edit-field&sds-edit-field-id=" . $field['id'] . "&sds-edit-field-table=" . $fields_table . "#" . $fields_table . "' >(" . __( 'Edit', 'custom-searchable-data-entry-system' ) . ")</a>" . " | <a href='" . get_admin_url() . "admin.php?page=sds-forms&sds-delete-field-id=" . $field['id'] . "&sds-delete-field-table=" . $fields_table . "#" . $fields_table . "' onclick=\"return confirm('" . __( 'IMPORTANT: The data that you previously entered in this field will be also deleted from the Entries table. Continue? (THIS ACTION CANNOT BE UNDONE)', 'custom-searchable-data-entry-system' ) . "');\">(" . __( 'Delete', 'custom-searchable-data-entry-system' ) . ")</a>";
						if ( $field['field_hide'] == "Hide" ) {
							echo "<i style='color: #979797;'> (" . __( 'Hidden on front-end search query.', 'custom-searchable-data-entry-system' ) . ")</i>";
						}

						switch ( $field['field_type'] ) {
							case "Text Field":
								echo "<br><input type =\"text\" name= \"" . $field['id'] . "\" size=\"30\" maxlength=\"3000\" value=\"" . ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' ) . "\" />" . "<br><br>";
								break;
							case "Email":
								echo "<br><input type=\"email\" name=\"" . $field['id'] . "\" size=\"30\" maxlength=\"200\" value=\"" . ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' ) . "\" />" . "<br><br>";
								break;
							case "Text Area":
								echo "<br><textarea rows=\"4\" cols=\"40\" name=\"" . $field['id'] . "\" maxlength=\"3000\" >" . ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' ) . "</textarea>" . "<br><br>";
								break;
							case "Number":
								echo "<br><input type=\"number\" name=\"" . $field['id'] . "\" size=\"30\" maxlength=\"3000\" value=\"" . ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' ) . "\" />" . "<br><br>";
								break;
							case "Telephone":
								echo "<br><input type=\"tel\" name=\"" . $field['id'] . "\" size=\"30\" maxlength=\"50\" value=\"" . ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' ) . "\"  />" . "<br><br>";
								break;
							case "URL":
								echo "<br><input type=\"url\" name=\"" . $field['id'] . "\" size=\"30\" maxlength=\"100\" value=\"" . ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' ) . "\" placeholder=\"" . __( 'Should Start with http', 'custom-searchable-data-entry-system' ) . "\" />" . "<br><br>";
								break;
							case "Date":
								echo "<br><input type=\"date\" name=\"" . $field['id'] . "\" size=\"30\" value=\"" . ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' ) . "\" />" . "<br><br>";
								break;
							case "CheckBox":
								echo " <input type=\"checkbox\" name=\"" . $field['id'] . "\" value=\"Yes\" ";
								if ( isset( $_POST[ $field['id'] ] ) && $_POST[ $field['id'] ] == "Yes" ) {
									echo " checked";
								}
								echo "/>" . "<br><br>";
								break;
							case "File Upload":
								echo "<br><input type=\"file\" class=\"sds_file\" id=\"sds_reset_upload_field_" . $field['id'] . "\" " . "name=\"sds_file_" . $field['id'] . "\" />" . "<br><br>";
								break;
							case "Drop Down":
								echo "<br><select name=\"" . $field['id'] . "\" >";
								echo "<option value=\"\" >-- " . __( 'Select', 'custom-searchable-data-entry-system' ) . " --</option>";
								$field_options = explode( " | ", $field['field_ext'] );
								foreach ( $field_options as $field_option ) {
									if ( $field_option != "" ) {
										echo "<option value='" . $field_option . "'";
										if ( isset( $_POST[ $field['id'] ] ) && $_POST[ $field['id'] ] == $field_option ) {
											echo " selected";
										}
										echo ">" . $field_option . "</option>";
									}
								}
								echo "</select>" . "<br><br>";
								break;
							case "Multiple Choice":
								echo "<br><select name=\"sds_multiplechoice_" . $field['id'] . "[]\" multiple >";
								$field_options = explode( " | ", $field['field_ext'] );
								foreach ( $field_options as $field_option ) {
									if ( $field_option != "" ) {
										echo "<option value='" . $field_option . "'";
										if ( isset( $_POST[ "sds_multiplechoice_" . $field['id'] ] ) ) {
											foreach ( $_POST[ "sds_multiplechoice_" . $field['id'] ] as $multiple ) {
												if ( $multiple == $field_option ) {
													echo " selected";
												}
											}
										}
										echo ">" . $field_option . "</option>";
									}
								}
								echo "</select>" . "<br>";
								echo "<i>" . __( 'Hold down the Ctrl (windows) / Command (Mac) button to select multiple options', 'custom-searchable-data-entry-system' ) . "</i><br><br>";
								break;
							default:
								break;
						}
					}

					echo "<input type=\"submit\" id=\"submit_ghazale_sds_form\" name=\"submit_" . $fields_table . "\" value=\"";
					echo __( 'Submit', 'custom-searchable-data-entry-system' );
					echo "\" >";

					echo "</form>";
				} else {
					echo "<a href=\"" . get_admin_url() . "admin.php?page=sds-add-field" . "\">" . __( 'Please add fields to this form first.', 'custom-searchable-data-entry-system' ) . "</a><br>" . __( 'Once you added the desired fields, you can start entering your data in the form', 'custom-searchable-data-entry-system' );
				}
				echo "<br><br><p><a href=\"" . get_admin_url() . "admin.php?page=sds-forms&sds-total-del-form-table=" . $fields_table . "\" onclick=\"return confirm('" . __( 'Are you sure? The corresponding data will be removed as well. (THIS ACTION CANNOT BE UNDONE)', 'custom-searchable-data-entry-system' ) . "');\" style=\"color:#ff0000\" >" . __( 'Totally Delete This Form AND Its Corresponding Data.', 'custom-searchable-data-entry-system' ) . "</a></p>";
				echo "</div>";
			}
		}
	} else {
		echo "<div style=\"color:#ffffff ;background-color:#47a447 ; padding: 10px\"><strong>" . __( 'No form(s) to display. Please Create a new form first. Once you create your first form and add fields to it, it will appear on this page in an organized table. You will then be able to enter your data.', 'custom-searchable-data-entry-system' ) . "</strong></div>";
	}
	echo "</div>";

}

function ghazale_sds_created_tables_admin_menu() {
	$page_suffix = add_submenu_page( 'custom-searchable-data-entry-system', __( 'Forms', 'custom-searchable-data-entry-system' ), __( 'Forms', 'custom-searchable-data-entry-system' ), 'manage_options', 'sds-forms', 'ghazale_sds_created_forms' );
	add_action( 'admin_print_scripts-' . $page_suffix, 'ghazale_sds_admin_form_table_tabs' );
}

add_action( 'admin_menu', 'ghazale_sds_created_tables_admin_menu' );

function ghazale_sds_admin_form_table_tabs() {
	wp_enqueue_style( 'sds-tabs-style' );
	wp_enqueue_script( 'sds-tabs-script' );
}

function ghazale_sds_admin_form_table_tabs_register() {
	wp_register_style( 'sds-tabs-style', plugins_url( 'css/jquery-ui.min.css', __FILE__ ) );
	wp_register_script( 'sds-tabs-script', plugins_url( 'js/sds-admin-tabs.js', __FILE__ ), array(
		'jquery',
		'jquery-ui-core',
		'jquery-ui-tabs'
	) );
	$translation_array = array(
		'refresh' => __( 'Refresh the page to restore "Update"/"Delete" links', 'custom-searchable-data-entry-system' )
	);
	wp_localize_script( 'sds-tabs-script', 'sds_object', $translation_array );
}

add_action( 'admin_init', 'ghazale_sds_admin_form_table_tabs_register' );

/**
 * showing the created forms on frontend by shortcode
 */
function ghazale_sds_created_forms_shortcode( $atts ) {
	global $wpdb;
	$table_name = $wpdb->prefix . "ghazale_sds_";
	$sql        = "SHOW TABLES LIKE '" . $table_name . "%_fields'";
	$tables     = $wpdb->get_results( $sql, ARRAY_A );
	if ( ! empty( $tables ) ) {
		$output = "<div id=\"form_tabs\">";
		foreach ( $tables as $table ) {
			foreach ( $table as $fields_table ) {
				shortcode_atts( array(
					'form' => str_replace( array(
						$table_name,
						'_fields'
					), '', $fields_table )
				), $atts );
				if ( str_replace( array( $table_name, '_fields' ), '', $fields_table ) == $atts['form'] ) {
					$sql_fields = "SELECT * FROM " . $fields_table;
					$fields     = $wpdb->get_results( $sql_fields, ARRAY_A );
					$output     .= "<p>" . ghazale_sds_update() . "</p>";
					$output     .= "<div id=\"" . $fields_table . "\">";
					if ( $fields ) {
						$output .= "<form action=\"\" method=\"post\" id=\"ds-form {$fields_table}\" enctype=\"multipart/form-data\">";

						foreach ( $fields as $field ) {
							$output .= $field['field_name'] . ": ";

							switch ( $field['field_type'] ) {
								case "Text Field":
									$output .= "<br><input type =\"text\" name= \"" . $field['id'] . "\" size=\"30\" maxlength=\"3000\" value=\"" . ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' ) . "\" />" . "<br><br>";
									break;
								case "Email":
									$output .= "<br><input type=\"email\" name=\"" . $field['id'] . "\" size=\"30\" maxlength=\"200\" value=\"" . ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' ) . "\" />" . "<br><br>";
									break;
								case "Text Area":
									$output .= "<br><textarea rows=\"4\" cols=\"40\" name=\"" . $field['id'] . "\" maxlength=\"3000\" >" . ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' ) . "</textarea>" . "<br><br>";
									break;
								case "Number":
									$output .= "<br><input type=\"number\" name=\"" . $field['id'] . "\" size=\"30\" maxlength=\"3000\" value=\"" . ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' ) . "\" />" . "<br><br>";
									break;
								case "Telephone":
									$output .= "<br><input type=\"tel\" name=\"" . $field['id'] . "\" size=\"30\" maxlength=\"50\" value=\"" . ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' ) . "\"  />" . "<br><br>";
									break;
								case "URL":
									$output .= "<br><input type=\"url\" name=\"" . $field['id'] . "\" size=\"30\" maxlength=\"100\" value=\"" . ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' ) . "\" placeholder=\"" . __( 'Should Start with http', 'custom-searchable-data-entry-system' ) . "\" />" . "<br><br>";
									break;
								case "Date":
									$output .= "<br><input type=\"date\" name=\"" . $field['id'] . "\" size=\"30\" value=\"" . ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' ) . "\" />" . "<br><br>";
									break;
								case "CheckBox":
									$output .= " <input type=\"checkbox\" name=\"" . $field['id'] . "\" value=\"Yes\" ";
									if ( isset( $_POST[ $field['id'] ] ) && $_POST[ $field['id'] ] == "Yes" ) {
										$output .= " checked";
									}
									$output .= "/>" . "<br><br>";
									break;
								case "File Upload":
									$output .= "<br><input type=\"file\" class=\"sds_file\" id=\"sds_reset_upload_field_" . $field['id'] . "\" " . "name=\"sds_file_" . $field['id'] . "\" />" . "<br><br>";
									break;
								case "Drop Down":
									$output        .= "<br><select name=\"" . $field['id'] . "\" >";
									$output        .= "<option value=\"\" >-- " . __( 'Select', 'custom-searchable-data-entry-system' ) . " --</option>";
									$field_options = explode( " | ", $field['field_ext'] );
									foreach ( $field_options as $field_option ) {
										if ( $field_option != "" ) {
											$output .= "<option value='" . $field_option . "'";
											if ( isset( $_POST[ $field['id'] ] ) && $_POST[ $field['id'] ] == $field_option ) {
												$output .= " selected";
											}
											$output .= ">" . $field_option . "</option>";
										}
									}
									$output .= "</select>" . "<br><br>";
									break;
								case "Multiple Choice":
									$output        .= "<br><select name=\"sds_multiplechoice_" . $field['id'] . "[]\" multiple >";
									$field_options = explode( " | ", $field['field_ext'] );
									foreach ( $field_options as $field_option ) {
										if ( $field_option != "" ) {
											$output .= "<option value='" . $field_option . "'";
											if ( isset( $_POST[ "sds_multiplechoice_" . $field['id'] ] ) ) {
												foreach ( $_POST[ "sds_multiplechoice_" . $field['id'] ] as $multiple ) {
													if ( $multiple == $field_option ) {
														$output .= " selected";
													}
												}
											}
											$output .= ">" . $field_option . "</option>";
										}
									}
									$output .= "</select>" . "<br>";
									$output .= "<i>" . __( 'Hold down the Ctrl (windows) / Command (Mac) button to select multiple options', 'custom-searchable-data-entry-system' ) . "</i><br><br>";
									break;
								default:
									break;
							}
						}

						$output .= "<input type=\"submit\" id=\"submit_ghazale_sds_form\" name=\"frontend_submit_" . $fields_table . "\" value=\"";
						$output .= __( 'Submit', 'custom-searchable-data-entry-system' );
						$output .= "\" >";

						$output .= "</form>";
					} else {
						$output .= __( 'No Fields to Display Yet.', 'custom-searchable-data-entry-system' );
					}
					$output .= "</div>";
				}
			}
		}
		$output .= "</div>";

		return $output;
	}
}

add_shortcode( 'sds-form', 'ghazale_sds_created_forms_shortcode' );
/**
 * delete selected form table
 */
function ghazale_sds_totally_delete_form_table() {
	if ( isset( $_GET['sds-total-del-form-table'] ) && $_GET['page'] == 'sds-forms' ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "ghazale_sds_";
		$sql        = "SHOW TABLES LIKE '" . $table_name . "%_fields'";
		$tables     = $wpdb->get_results( $sql, ARRAY_A );
		foreach ( $tables as $table ) {
			foreach ( $table as $fields_table ) {
				if ( $fields_table == $_GET['sds-total-del-form-table'] ) {
					$wpdb->query( "DROP TABLE IF EXISTS " . $fields_table );
					$_SESSION['sds-message'] = esc_html__( 'Deleted Successfully', 'custom-searchable-data-entry-system' );
				}
			}
		}
		$sql_inputs   = "SHOW TABLES LIKE '" . $table_name . "%_inputs'";
		$input_tables = $wpdb->get_results( $sql_inputs, ARRAY_A );
		$entry_table  = str_replace( "_fields", "_inputs", $_GET['sds-total-del-form-table'] );
		foreach ( $input_tables as $input_table ) {
			foreach ( $input_table as $inputs ) {
				if ( $inputs == $entry_table ) {
					$wpdb->query( "DROP TABLE IF EXISTS " . $inputs );
					$_SESSION['sds-message'] = esc_html__( 'Deleted Successfully', 'custom-searchable-data-entry-system' );
				}
			}
		}
	}
}

add_action( 'init', 'ghazale_sds_totally_delete_form_table' );

/**
 * delete selected field from the form
 */

function ghazale_sds_delete_selected_field() {
	if ( isset( $_GET['sds-delete-field-id'] ) && isset( $_GET['sds-delete-field-table'] ) ) {
		global $wpdb;
		$fields_table_name = $_GET['sds-delete-field-table'];
		$inputs_table_name = str_replace( "_fields", "_inputs", $_GET['sds-delete-field-table'] );
		$field_id          = $_GET['sds-delete-field-id'];
		$wpdb->delete( $fields_table_name, array( 'id' => $field_id ) );
		$wpdb->delete( $inputs_table_name, array( 'field_id' => $field_id ) );
		$_SESSION['sds-message'] = esc_html__( 'Field Deleted Successfully', 'custom-searchable-data-entry-system' );
	}
}

add_action( 'init', 'ghazale_sds_delete_selected_field' );

/**
 * admin page for editing fields
 */

function ghazale_sds_edit_fields() {
	global $wpdb;
	$db_table_name = $wpdb->prefix . "ghazale_sds_";
	$id            = $_GET['sds-edit-field-id'];
	$table         = $_GET['sds-edit-field-table'];
	$sql           = "SELECT * FROM {$table} WHERE id={$id}";
	$field         = $wpdb->get_row( $sql, ARRAY_A );
	?>
    <h2><?php _e( 'Edit Field', 'custom-searchable-data-entry-system' ); ?></h2>
	<?php echo ghazale_sds_message(); ?>
    <form action="" method="post" id="ghazale_sds_edit_field">
        <h4><?php _e( 'Form', 'custom-searchable-data-entry-system' ); ?>: <?php echo ucfirst( str_replace( array(
				$db_table_name,
				"_fields"
			), "", $_GET['sds-edit-field-table'] ) ); ?> </h4>
		<?php _e( 'Field Name', 'custom-searchable-data-entry-system' ); ?> : <input type="text"
                                                                                     name="ghazale_sds_edit_field_name"
                                                                                     id="ghazale_sds_edit_field_name"
                                                                                     value="<?php echo $field['field_name']; ?>"/><i>
            Should be alphanumeric. Can have space and allowed symbols @-_.,\/:?'!;&~()</i><br><br>
		<?php $type_array = array(
			"Text Field",
			"Text Area",
			"Drop Down",
			"Multiple Choice",
			"Email",
			"File Upload",
			"Number",
			"Telephone",
			"URL",
			"Date",
			"CheckBox"
		); ?>
		<?php _e( 'Field Type', 'custom-searchable-data-entry-system' ); ?>: <select name="ghazale_sds_edit_field_type"
                                                                                     class="ghazale_sds_field_type">
            <option value=""> -- <?php _e( 'Select Field Type', 'custom-searchable-data-entry-system' ); ?> --</option>
			<?php
			foreach ( $type_array as $type ) {
				echo "<option value='" . $type . "'";
				if ( $field['field_type'] == $type ) {
					echo " selected";
				}
				echo ">" . $type . "</option>";
			}
			?>
        </select><br><br>
        <span id="ghazale_sds_field_hide"><input type="checkbox" name="ghazale_sds_field_hide_edit"
                                                 value="Hide" <?php if ( $field['field_hide'] == 'Hide' ) {
				echo 'checked';
			} ?>/> <?php _e( 'Hide This Field From Search Query.', 'custom-searchable-data-entry-system' ); ?>
            <i> (<?php _e( 'If checked, the field information will not be shown in the search query on front-end. You can change this later by editing this field.', 'custom-searchable-data-entry-system' ); ?>
                )</i><br><br></span>
        <div class="field_ext">
            <i><?php _e( 'You can have up to 10 values for this field', 'custom-searchable-data-entry-system' ); ?>:</i><br>
			<?php
			$options = explode( " | ", $field['field_ext'] );
			for ( $i = 0; $i <= 9; $i ++ ) {
				echo "<input type=\"text\" name=\"field_ext_edit_" . $i . "\" value=\"" . ( isset( $options[ $i ] ) ? $options[ $i ] : '' ) . "\" /><br>";
			}
			?>
        </div>
        <p><input type="submit" name="ghazale_sds_edit_field"
                  value="<?php _e( 'Update Field', 'custom-searchable-data-entry-system' ); ?>">
            <a href="<?php echo get_admin_url() ?>admin.php?page=sds-forms#<?php echo $_GET['sds-edit-field-table'] ?>"
               style="text-decoration: none"><input type="button"
                                                    value="<?php _e( 'Back to Forms', 'custom-searchable-data-entry-system' ); ?>"></a>
        </p>
    </form>
	<?php
}

function ghazale_sds_edit_fields_admin_menu() {
	$page_suffix = add_submenu_page( null, __( 'Edit Fields', 'custom-searchable-data-entry-system' ), __( 'Edit Fields', 'custom-searchable-data-entry-system' ), 'manage_options', 'sds-edit-field', 'ghazale_sds_edit_fields' );
	add_action( 'admin_print_scripts-' . $page_suffix, 'ghazale_sds_admin_field_ext' );
}

add_action( 'admin_menu', 'ghazale_sds_edit_fields_admin_menu' );

/**
 * updating field name and type in db
 */

function ghazale_sds_update_field() {
	if ( isset( $_POST['ghazale_sds_edit_field'] ) ) {
		$output = "";
		for ( $i = 0; $i <= 9; $i ++ ) {
			if ( ghazale_sds_allowed_characters( $_POST["field_ext_edit_{$i}"] ) && trim( $_POST["field_ext_edit_{$i}"] != "" ) ) {
				$output .= trim( $_POST["field_ext_edit_{$i}"] ) . " | ";
			}
		}
		if ( ghazale_sds_allowed_characters( $_POST['ghazale_sds_edit_field_name'] ) && ! empty( $_POST['ghazale_sds_edit_field_type'] ) ) {
			global $wpdb;
			$id    = $_GET['sds-edit-field-id'];
			$table = $_GET['sds-edit-field-table'];
			$wpdb->update( $table, array(
				'field_name' => ( isset( $_POST['ghazale_sds_edit_field_name'] ) ? trim( $_POST['ghazale_sds_edit_field_name'] ) : '' ),
				'field_type' => ( isset( $_POST['ghazale_sds_edit_field_type'] ) ? $_POST['ghazale_sds_edit_field_type'] : '' ),
				'field_ext'  => $output,
				'field_hide' => ( isset( $_POST['ghazale_sds_field_hide_edit'] ) ? $_POST['ghazale_sds_field_hide_edit'] : '' )
			), array( 'id' => $id ), array( '%s' ) );
			$_SESSION['sds-message'] = esc_html__( 'Updated Successfully', 'custom-searchable-data-entry-system' );

		} else {
			$_SESSION['sds-message'] = esc_html__( 'Please make sure the entered Field Name is not containing disallowed symbols, and also make sure you have selected Field Type', 'custom-searchable-data-entry-system' );
		}
	}
}

add_action( 'init', 'ghazale_sds_update_field' );
/**
 * adding field inputs to input tables
 */
function ghazale_sds_insert_field_inputs() {
	global $wpdb;
	$table_name       = $wpdb->prefix . "ghazale_sds_";
	$tables           = $wpdb->get_results( "SHOW TABLES LIKE " . "'" . $table_name . "%_fields'", ARRAY_A );
	$not_alphanumeric = array();
	if ( ! empty( $tables ) ) {

		foreach ( $tables as $table ) {
			foreach ( $table as $fields_table ) {
				if ( isset( $_POST[ 'submit_' . $fields_table ] ) ) {

					$sql_fields  = "SELECT id,field_name,field_hide,field_type FROM " . $fields_table;
					$fields      = $wpdb->get_results( $sql_fields, ARRAY_A );
					$input_table = str_replace( '_fields', '_inputs', $fields_table );

					foreach ( $fields as $field ) {
						if ( isset( $_POST[ $field['id'] ] ) && ! ghazale_sds_allowed_characters( $_POST[ $field['id'] ] ) ) {
							array_push( $not_alphanumeric, "not alphanumeric" );
						}
					}
					if ( empty( $not_alphanumeric ) ) {
						$new_entry = array();
						foreach ( $fields as $field ) {
							if ( ! empty( $_POST[ 'sds_multiplechoice_' . $field['id'] ] ) ) {
								$multiple_choice = array();
								foreach ( $_POST[ "sds_multiplechoice_" . $field['id'] ] as $multiple ) {
									array_push( $multiple_choice, $multiple );
								}
								$_POST[ $field['id'] ] = implode( " | ", $multiple_choice );
							}
							if ( isset( $_FILES["sds_file_{$field['id']}"] ) && $_FILES["sds_file_{$field['id']}"]['size'] > 0 ) {
								if ( ! function_exists( 'wp_handle_upload' ) ) {
									require_once( ABSPATH . 'wp-admin/includes/file.php' );
								}
								$uploadedfile     = $_FILES["sds_file_{$field['id']}"];
								$upload_overrides = array( 'test_form' => false );
								if ( ! function_exists( 'ghazale_sds_change_upload_dir' ) ) {
									function ghazale_sds_change_upload_dir( $upload ) {
										global $wpdb;
										$table_name = $wpdb->prefix . "ghazale_sds_";
										$tables     = $wpdb->get_results( "SHOW TABLES LIKE " . "'" . $table_name . "%_fields'", ARRAY_A );
										foreach ( $tables as $table ) {
											foreach ( $table as $fields_table ) {
												if ( isset( $_POST[ 'submit_' . $fields_table ] ) ) {
													$new_dir = '/sds-' . str_replace( array(
															$table_name,
															'_fields'
														), '', $fields_table );
												}
											}
										}

										$upload['path']   = str_replace( $upload['subdir'], '', $upload['path'] );
										$upload['url']    = str_replace( $upload['subdir'], '', $upload['url'] );
										$upload['subdir'] = $new_dir;
										$upload['path']   .= $new_dir;
										$upload['url']    .= $new_dir;

										return $upload;
									}
								}
								add_filter( 'upload_dir', 'ghazale_sds_change_upload_dir' );
								$upload   = wp_upload_dir();
								$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
								remove_filter( 'upload_dir', 'ghazale_sds_change_upload_dir' );


								if ( $movefile && ! isset( $movefile['error'] ) ) {
									//                echo "File is valid, and was successfully uploaded.\n";
									//                var_dump($movefile);
									$_POST[ $field['id'] ] = $movefile['url'];
								} else {
									/**
									 * Error generated by _wp_handle_upload()
									 * @see _wp_handle_upload() in wp-admin/includes/file.php
									 */
									$_SESSION['sds-message'] = $movefile['error'];
								}
							}
							$wpdb->insert( $input_table, array(
								'field_id'    => $field['id'],
								'field_input' => ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' )
							), array( '%s' ) );
							$_SESSION["sds-update"] = esc_html__( 'Entry Submitted!', 'custom-searchable-data-entry-system' );

							if ( $field['field_type'] == "Multiple Choice" && ! empty( $_POST[ "sds_multiplechoice_" . $field['id'] ] ) ) {
								$new_entry[ $field['field_name'] ] = implode( " | ", $multiple_choice );
							} elseif ( $field['field_type'] == "File Upload" && ! empty( $movefile ) ) {
								$new_entry[ $field['field_name'] ] = $movefile['url'];
							}

						}


					} elseif ( ! empty( $not_alphanumeric ) ) {
						$_SESSION["sds-error"] = esc_html__( 'Some Symbols are not allowed for security. Please reconsider your entries. Allowed symbols are: @-_.,\/:?\'!;&~()', 'custom-searchable-data-entry-system' );
					}
					wp_redirect( get_permalink() . '#' . $fields_table );
					exit;
				}
				if ( isset( $_POST[ 'frontend_submit_' . $fields_table ] ) ) {

					$sql_fields  = "SELECT id,field_name,field_hide,field_type FROM " . $fields_table;
					$fields      = $wpdb->get_results( $sql_fields, ARRAY_A );
					$input_table = str_replace( '_fields', '_inputs', $fields_table );

					foreach ( $fields as $field ) {
						if ( isset( $_POST[ $field['id'] ] ) && ! ghazale_sds_allowed_characters( $_POST[ $field['id'] ] ) ) {
							array_push( $not_alphanumeric, "not alphanumeric" );
						}
					}
					if ( empty( $not_alphanumeric ) ) {
						$new_entry = array();
						foreach ( $fields as $field ) {
							if ( ! empty( $_POST[ 'sds_multiplechoice_' . $field['id'] ] ) ) {
								$multiple_choice = array();
								foreach ( $_POST[ "sds_multiplechoice_" . $field['id'] ] as $multiple ) {
									array_push( $multiple_choice, $multiple );
								}
								$_POST[ $field['id'] ] = implode( " | ", $multiple_choice );
							}
							if ( isset( $_FILES["sds_file_{$field['id']}"] ) && $_FILES["sds_file_{$field['id']}"]['size'] > 0 ) {
								if ( ! function_exists( 'wp_handle_upload' ) ) {
									require_once( ABSPATH . 'wp-admin/includes/file.php' );
								}
								$uploadedfile     = $_FILES["sds_file_{$field['id']}"];
								$upload_overrides = array( 'test_form' => false );
								if ( ! function_exists( 'ghazale_sds_change_upload_dir' ) ) {
									function ghazale_sds_change_upload_dir( $upload ) {
										global $wpdb;
										$table_name = $wpdb->prefix . "ghazale_sds_";
										$tables     = $wpdb->get_results( "SHOW TABLES LIKE " . "'" . $table_name . "%_fields'", ARRAY_A );
										foreach ( $tables as $table ) {
											foreach ( $table as $fields_table ) {
												if ( isset( $_POST[ 'submit_' . $fields_table ] ) ) {
													$new_dir = '/sds-' . str_replace( array(
															$table_name,
															'_fields'
														), '', $fields_table );
												}
											}
										}

										$upload['path']   = str_replace( $upload['subdir'], '', $upload['path'] );
										$upload['url']    = str_replace( $upload['subdir'], '', $upload['url'] );
										$upload['subdir'] = $new_dir;
										$upload['path']   .= $new_dir;
										$upload['url']    .= $new_dir;

										return $upload;
									}
								}
								add_filter( 'upload_dir', 'ghazale_sds_change_upload_dir' );
								$upload   = wp_upload_dir();
								$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
								remove_filter( 'upload_dir', 'ghazale_sds_change_upload_dir' );


								if ( $movefile && ! isset( $movefile['error'] ) ) {
									//                echo "File is valid, and was successfully uploaded.\n";
									//                var_dump($movefile);
									$_POST[ $field['id'] ] = $movefile['url'];
								} else {
									/**
									 * Error generated by _wp_handle_upload()
									 * @see _wp_handle_upload() in wp-admin/includes/file.php
									 */
									$_SESSION['sds-message'] = $movefile['error'];
								}
							}
							$wpdb->insert( $input_table, array(
								'field_id'    => $field['id'],
								'field_input' => ( isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' )
							), array( '%s' ) );
							$_SESSION["sds-update"] = esc_html__( 'Entry Submitted!', 'custom-searchable-data-entry-system' );

							if ( $field['field_type'] == "Multiple Choice" && ! empty( $_POST[ "sds_multiplechoice_" . $field['id'] ] ) ) {
								$new_entry[ $field['field_name'] ] = implode( " | ", $multiple_choice );
							} elseif ( $field['field_type'] == "File Upload" && ! empty( $movefile ) ) {
								$new_entry[ $field['field_name'] ] = $movefile['url'];
							}

						}


					} elseif ( ! empty( $not_alphanumeric ) ) {
						$_SESSION["sds-error"] = esc_html__( 'Some Symbols are not allowed for security. Please reconsider your entries. Allowed symbols are: @-_.,\/:?\'!;&~()', 'custom-searchable-data-entry-system' );
					}
				}
			}
		}
	}
}

add_action( 'wp_loaded', 'ghazale_sds_insert_field_inputs' );

/**
 * shows form inputs on the backend
 */

function ghazale_sds_form_inputs() {
	global $wpdb;
	$tables       = $wpdb->prefix . "ghazale_sds_";
	$input_tables = $wpdb->get_results( "SHOW TABLES LIKE " . "'" . $tables . "%_inputs'", ARRAY_A );
	$field_tables = $wpdb->get_results( "SHOW TABLES LIKE " . "'" . $tables . "%_fields'", ARRAY_A );

	if ( ! empty( $input_tables ) ) {
		echo ghazale_sds_message();
		echo ghazale_sds_update();
		echo "<div id=\"form_tabs\">";
		echo "<ul>";
		foreach ( $input_tables as $input_table ) {
			foreach ( $input_table as $table ) {
				echo "<li><a href=\"#" . $table . "\">" . ucfirst( str_replace( array(
						$tables,
						"_inputs"
					), "", $table ) ) . " Entries</a></li>";
			}
		}
		echo "</ul>";
		foreach ( $input_tables as $input_table ) {
			foreach ( $input_table as $table ) {
				echo "<div id=\"" . $table . "\">";
				echo "<h3>" . ucfirst( str_replace( array( $tables, "_inputs" ), "", $table ) ) . " Entries</h3>";
				echo "<p><strong>" . esc_html( 'Table Shortcode: ' ) . '</strong>' . esc_html( '[sds-entry table="' ) . str_replace( array(
						$tables,
						'_inputs'
					), '', $table ) . '"]</p>';
				if ( get_option( 'ghazale_sds_separate_search' ) ) {
					echo "<p><strong>" . esc_html( 'Search Engine Shortcode: ' ) . '</strong>' . esc_html( '[sds-search table="' ) . str_replace( array(
							$tables,
							'_inputs'
						), '', $table ) . '"]</p>';
				}
				echo "<p><input type=\"button\" name=\"sds_download_table_csv\" class=\"sds_download_table_csv_" . $table . "\" value=\"" . __( 'Download Table In CSV Format', 'custom-searchable-data-entry-system' ) . "\" /><i>" . __( 'After you downloaded the table, rename the file and put .csv at the end of the file name.', 'custom-searchable-data-entry-system' ) . "</i></p>";
				echo "<h4 class=\"sds_refresh_page\" style=\"color: #f6a828\"></h4>";
				echo "<table class = \"table\" id=\"sds_download_table_csv_" . $table . "\">";
				$inputs_sql = "SELECT * FROM " . $table . " ORDER BY id ASC";
				$inputs     = $wpdb->get_results( $inputs_sql, ARRAY_A );

				foreach ( $field_tables as $field_table ) {
					foreach ( $field_table as $field_table_single ) {
						if ( $field_table_single == str_replace( "_inputs", "_fields", "$table" ) ) {
							$fields_sql = "SELECT id,field_name,field_type FROM " . $field_table_single;
							$fields     = $wpdb->get_results( $fields_sql, ARRAY_A );
							if ( ! empty( $inputs ) ) {
								echo "<thead>";
								echo "<tr>";
								foreach ( $fields as $field ) {
									echo "<th>" . $field['field_name'] . "</th>";
								}
								echo "<th><span class=\"sds_del_link\">" . __( 'Delete', 'custom-searchable-data-entry-system' ) . "</span></th>";
								echo "</tr>";
								echo "</thead>";

								foreach ( $fields as $field ) {
									$first_id = $field['id'];
									break;
								}

								foreach ( $fields as $field ) {
									$last_id = $field['id'];
								}
								echo "<tbody>";
								foreach ( $inputs as $input ) {
									if ( $input['field_id'] == $first_id ) {
										$first_input_id = $input['id'];
										echo "<tr>";
									}
									foreach ( $input as $key => $input_single ) {
										if ( $input_single != "" && $key != 'id' && $key != 'field_id' ) {
											$link_or_img = strlen( $input_single ) - 3;
											$jpeg_img    = strlen( $input_single ) - 4;
											if ( substr( $input_single, 0, 4 ) === "http" && ( substr( $input_single, $link_or_img, 3 ) == "png" || substr( $input_single, $link_or_img, 3 ) == "jpg" || substr( $input_single, $link_or_img, 3 ) == "gif" || substr( $input_single, $link_or_img, 3 ) == "bmp" || substr( $input_single, $jpeg_img, 4 ) == "jpeg" ) ) {
												echo "<td><img src='" . $input_single . "' width=\"100\"><span class=\"sds_update_link\"><a href=\"" . get_admin_url() . "admin.php?page=sds-update-single-entry&update-single-entry-id=" . $input['id'] . "&sds-entry-table=" . $table . "\" style=\"color: #ff5500\"><br>(" . __( 'Update', 'custom-searchable-data-entry-system' ) . ")</a></span></td>";
											} elseif ( substr( $input_single, 0, 4 ) === "http" && ( substr( $input_single, $link_or_img, 3 ) != "png" || substr( $input_single, $link_or_img, 3 ) != "jpg" || substr( $input_single, $link_or_img, 3 ) != "gif" || substr( $input_single, $link_or_img, 3 ) != "bmp" || substr( $input_single, $link_or_img, 4 ) != "jpeg" ) ) {
												echo "<td><a href='" . $input_single . "'>" . $input_single . "</a> <span class=\"sds_update_link\"><a href=\"" . get_admin_url() . "admin.php?page=sds-update-single-entry&update-single-entry-id=" . $input['id'] . "&sds-entry-table=" . $table . "\" style=\"color: #ff5500\"><br>(" . __( 'Update', 'custom-searchable-data-entry-system' ) . ")</a></span></td>";
											} else {
												echo "<td>" . stripslashes( $input_single ) . "<span class=\"sds_update_link\"><a href=\"" . get_admin_url() . "admin.php?page=sds-update-single-entry&update-single-entry-id=" . $input['id'] . "&sds-entry-table=" . $table . "\" style=\"color: #ff5500\">(" . __( 'Update', 'custom-searchable-data-entry-system' ) . ")</a></span></td>";
											}
										} elseif ( $input_single == "" ) {
											echo "<td><span class=\"sds_update_link\"><a href=\"" . get_admin_url() . "admin.php?page=sds-update-single-entry&update-single-entry-id=" . $input['id'] . "&sds-entry-table=" . $table . "\" style=\"color: #ff5500\">(" . __( 'Update', 'custom-searchable-data-entry-system' ) . ")</a></span></td>";
										}

									}

									if ( $input['field_id'] == $last_id ) {
										$last_input_id = $input['id'];
										echo "<td><span class=\"sds_del_link\"><a href=\"" . get_admin_url() . "admin.php?page=sds-form-entries&sds-del-entry-first-entry-id=" . $first_input_id . "&sds-del-entry-last-entry-id=" . $last_input_id . "&sds-del-entry-table-row=" . $table . "#" . $table . "\" onclick=\"return confirm('" . __( 'Are you sure? (THIS ACTION CANNOT BE UNDONE)', 'custom-searchable-data-entry-system' ) . "');\" style=\"color: #ff5500\">" . __( 'Delete Row', 'custom-searchable-data-entry-system' ) . "</a></span></td>";
										echo "</tr>";
									}
								}
								echo "</tbody>";
							} else {
								echo "<h4>" . __( 'There is no input', 'custom-searchable-data-entry-system' ) . "</h4>";
							}
						}
					}
				}
				echo "</table>";
				echo "<p><a href=\"" . get_admin_url() . "admin.php?page=sds-form-entries&sds-del-data-input-table=" . $table . "#" . $table . "\"  onclick=\"return confirm('" . __( 'Are you sure? (THIS ACTION CANNOT BE UNDONE)', 'custom-searchable-data-entry-system' ) . "');\" style=\"color:#ff0000\">" . __( 'Delete All Entries in This Table', 'custom-searchable-data-entry-system' ) . "</a></p>";
				echo "<p><a href=\"" . get_admin_url() . "admin.php?page=sds-form-entries&sds-total-del-input-table-and-corresponding-form=" . $table . "\" onclick=\"return confirm('" . __( 'Are you sure? The corresponding form will be deleted as well. (THIS ACTION CANNOT BE UNDONE)', 'custom-searchable-data-entry-system' ) . "');\" style=\"color:#ff0000\">" . __( 'Totally Delete This Table AND Its Corresponding Form', 'custom-searchable-data-entry-system' ) . "</a></p>";
				echo "</div>";
			}

		}
		echo "</div>";
	} else {
		echo "<div style=\"color:#ffffff ;background-color:#47a447 ; padding: 10px\"> <strong>" . __( 'No inputs to display. Once you had inputs from your form, they will appear on this page in an organized table.', 'custom-searchable-data-entry-system' ) . "</strong></div>";
	}

}

function ghazale_sds_form_inputs_admin_menu() {
	$page_suffix = add_submenu_page( 'custom-searchable-data-entry-system', __( 'Entries', 'custom-searchable-data-entry-system' ), __( 'Entries', 'custom-searchable-data-entry-system' ), 'manage_options', 'sds-form-entries', 'ghazale_sds_form_inputs' );
	add_action( 'admin_print_scripts-' . $page_suffix, 'ghazale_sds_admin_input_table_tabs' );
}

add_action( 'admin_menu', 'ghazale_sds_form_inputs_admin_menu' );
function ghazale_sds_admin_input_table_tabs() {
	wp_enqueue_style( 'sds-tabs-style' );
	wp_enqueue_style( 'ghazale-sds-table-style' );
	wp_enqueue_script( 'sds-tabs-script' );
	wp_enqueue_script( 'sds-jquery-base64' );
	wp_enqueue_script( 'ghazale-sds-table-export' );
}

function ghazale_sds_admin_input_table_page_scripts() {
	wp_register_script( 'ghazale-sds-table-export', plugins_url( 'js/tableExport.js', __FILE__ ), array( 'jquery' ) );
	wp_register_script( 'ghazale-sds-jquery-base64', plugins_url( 'js/jquery.base64.js', __FILE__ ), array( 'jquery' ) );
	wp_register_style( 'ghazale-sds-table-style', plugins_url( 'css/sds-table-style.css', __FILE__ ) );
	wp_register_script( 'sds-jquery-base64', plugins_url( 'js/jquery.base64.js', __FILE__ ), array( 'jquery' ) );
	wp_register_script( 'sds-table-export', plugins_url( 'js/tableExport.js', __FILE__ ), array( 'jquery' ) );
}

add_action( 'admin_init', 'ghazale_sds_admin_input_table_page_scripts' );

function ghazale_sds_enqueue_table_style() {
	wp_enqueue_style( 'ghazale-sds-table-style', plugins_url( 'css/sds-table-style.css', __FILE__ ) );
}

add_action( 'wp_enqueue_scripts', 'ghazale_sds_enqueue_table_style' );

/**
 * show inputted entries by shortcode
 */
function ghazale_sds_show_inputs_on_frontend( $atts ) {
	global $wpdb;
	$tables       = $wpdb->prefix . "ghazale_sds_";
	$input_tables = $wpdb->get_results( "SHOW TABLES LIKE " . "'" . $tables . "%_inputs'", ARRAY_A );
	$field_tables = $wpdb->get_results( "SHOW TABLES LIKE " . "'" . $tables . "%_fields'", ARRAY_A );

	if ( ! empty( $input_tables ) ) {

		foreach ( $input_tables as $input_table ) {
			foreach ( $input_table as $table ) {
				shortcode_atts( array( 'table' => str_replace( array( $tables, '_inputs' ), '', $table ) ), $atts );
				$output = "<div id=\"" . $table . "\">";
				if ( str_replace( array( $tables, '_inputs' ), '', $table ) == $atts['table'] ) {
					$output     .= "<table class = \"table\" id=\"sds_download_table_csv_" . $table . "\">";
					$inputs_sql = "SELECT * FROM " . $table . " ORDER BY id ASC";
					$inputs     = $wpdb->get_results( $inputs_sql, ARRAY_A );

					foreach ( $field_tables as $field_table ) {
						foreach ( $field_table as $field_table_single ) {
							if ( $field_table_single == str_replace( "_inputs", "_fields", "$table" ) ) {
								$fields_sql = "SELECT id,field_name,field_type FROM " . $field_table_single;
								$fields     = $wpdb->get_results( $fields_sql, ARRAY_A );
								if ( ! empty( $inputs ) ) {
									$output .= "<tr>";
									foreach ( $fields as $field ) {
										$output .= "<th>" . $field['field_name'] . "</th>";
									}
									$output .= "</tr>";
									foreach ( $fields as $field ) {
										$first_id = $field['id'];
										break;
									}

									foreach ( $fields as $field ) {
										$last_id = $field['id'];
									}
									foreach ( $inputs as $input ) {
										if ( $input['field_id'] == $first_id ) {
											$output .= "<tr>";
										}
										foreach ( $input as $key => $input_single ) {
											if ( $input_single != "" && $key != 'id' && $key != 'field_id' ) {
												$link_or_img = strlen( $input_single ) - 3;
												$jpeg_img    = strlen( $input_single ) - 4;
												if ( substr( $input_single, 0, 4 ) === "http" && ( substr( $input_single, $link_or_img, 3 ) == "png" || substr( $input_single, $link_or_img, 3 ) == "jpg" || substr( $input_single, $link_or_img, 3 ) == "gif" || substr( $input_single, $link_or_img, 3 ) == "bmp" || substr( $input_single, $jpeg_img, 4 ) == "jpeg" ) ) {
													$output .= "<td><img src='" . $input_single . "' width=\"100\"></td>";
												} elseif ( substr( $input_single, 0, 4 ) === "http" && ( substr( $input_single, $link_or_img, 3 ) != "png" || substr( $input_single, $link_or_img, 3 ) != "jpg" || substr( $input_single, $link_or_img, 3 ) != "gif" || substr( $input_single, $link_or_img, 3 ) != "bmp" || substr( $input_single, $link_or_img, 4 ) != "jpeg" ) ) {
													$output .= "<td><a href='" . $input_single . "'>" . $input_single . "</a></td>";
												} else {
													$output .= "<td>" . stripslashes( $input_single ) . "</td>";
												}
											} elseif ( $input_single == "" ) {
												$output .= "<td></td>";
											}

										}

										if ( $input['field_id'] == $last_id ) {
											$output .= "</tr>";
										}
									}

								} else {
									$output .= "<h4>" . __( 'There is no input', 'custom-searchable-data-entry-system' ) . "</h4>";
								}
							}
						}
					}
					$output .= "</table>";
					$output .= "</div>";

					return $output;
				}
			}

		}
	} else {
		echo "<div style=\"color:#ffffff ;background-color:#47a447 ; padding: 10px\"> <strong>" . __( 'No inputs to display. Once you had inputs from your form, they will appear on this page in an organized table.', 'custom-searchable-data-entry-system' ) . "</strong></div>";
	}

}

add_shortcode( 'sds-entry', 'ghazale_sds_show_inputs_on_frontend' );
/**
 * edit entries admin page
 */
function ghazale_sds_edit_single_entry_page() {
	$entry_table = $_GET['sds-entry-table'];
	$entry_id    = $_GET['update-single-entry-id'];
	global $wpdb;
	$table_prefix       = $wpdb->prefix . "ghazale_sds_";
	$selected_entry_sql = "SELECT field_input FROM " . $entry_table . " WHERE id=" . $entry_id;
	$selected_entry     = $wpdb->get_var( $selected_entry_sql );
	?>
    <h2><?php _e( 'Edit Entry', 'custom-searchable-data-entry-system' ); ?></h2>
    <p>
        <strong><?php _e( 'Table Name: ', 'custom-searchable-data-entry-system' ); ?></strong><?php echo ucfirst( str_replace( array(
				$table_prefix,
				'_inputs'
			), '', $entry_table ) . ' Entries' ); ?></p>
    <p><strong><?php _e( 'ID: ', 'custom-searchable-data-entry-system' ); ?></strong><?php echo $entry_id; ?></p>
    <p><strong><?php _e( 'Change Entry: ', 'custom-searchable-data-entry-system' ); ?></strong>
    <form id="sds-update-single-entry" method="post">
        <input type="text" name="sds-update-single-entry" size="50" value="<?php echo $selected_entry; ?>"></p>
    <p><input type="submit" name="submit-update-single-entry"
              value="<?php _e( 'Update Entry', 'custom-searchable-data-entry-system' ); ?>"><a
                href="<?php echo get_admin_url() . 'admin.php?page=sds-form-entries#' . $entry_table ?>"
                style="text-decoration: none"><input type="button"
                                                     value="<?php _e( 'Cancel', 'custom-searchable-data-entry-system' ); ?>"</a>
    </p>
    </form>
	<?php
}

function ghazale_sds_edit_single_entry_page_menu() {
	add_submenu_page( null, __( 'Update Single Entry', 'custom-searchable-data-entry-system' ), __( 'Update Single Entry', 'custom-searchable-data-entry-system' ), 'manage_options', 'sds-update-single-entry', 'ghazale_sds_edit_single_entry_page' );
}

add_action( 'admin_menu', 'ghazale_sds_edit_single_entry_page_menu' );
/**
 * update single entry in db
 */
function ghazale_sds_update_single_entry() {
	if ( isset( $_POST['submit-update-single-entry'] ) ) {
		$entry_table = $_GET['sds-entry-table'];
		$entry_id    = $_GET['update-single-entry-id'];
		global $wpdb;
		$wpdb->update( $entry_table, array( 'field_input' => $_POST['sds-update-single-entry'] ), array( 'id' => $entry_id ) );
		$_SESSION['sds-update'] = __( 'Entry Updated Successfully', 'custom-searchable-data-entry-system' );
		wp_redirect( get_admin_url() . 'admin.php?page=sds-form-entries#' . $entry_table );
		exit;
	}
}

add_action( 'init', 'ghazale_sds_update_single_entry' );
/**
 * delete selected input table
 */
function ghazale_sds_totally_delete_input_table() {
	if ( isset( $_GET['sds-del-data-input-table'] ) && $_GET['page'] == 'sds-form-entries' ) {
		global $wpdb;
		$tables       = $wpdb->prefix . "ghazale_sds_";
		$input_tables = $wpdb->get_results( "SHOW TABLES LIKE " . "'" . $tables . "%_inputs'", ARRAY_A );
		foreach ( $input_tables as $input_table ) {
			foreach ( $input_table as $table ) {
				if ( $table == $_GET['sds-del-data-input-table'] ) {
					$del_sql = "SELECT id FROM " . $table;
					$rows    = $wpdb->get_results( $del_sql, ARRAY_A );
					foreach ( $rows as $row ) {
						$wpdb->delete( $table, array( 'id' => $row['id'] ) );
					}
					$_SESSION['sds-message'] = '<strong>' . esc_html__( 'Deleted Successfully', 'custom-searchable-data-entry-system' ) . '.</strong> ' . esc_html__( 'Note: If you had file uploads in your inputs, you should manually remove their directory via FTP connection.', 'custom-searchable-data-entry-system' );
				}
			}
		}
	}
}

add_action( 'init', 'ghazale_sds_totally_delete_input_table' );
/**
 * delete input table and its corresponding form table
 */
function ghazale_sds_totally_delete_input_table_and_corresponding_form_table() {
	if ( isset( $_GET['sds-total-del-input-table-and-corresponding-form'] ) ) {
		global $wpdb;
		$tables       = $wpdb->prefix . "ghazale_sds_";
		$input_tables = $wpdb->get_results( "SHOW TABLES LIKE " . "'" . $tables . "%_inputs'", ARRAY_A );
		foreach ( $input_tables as $input_table ) {
			foreach ( $input_table as $table ) {
				if ( $table == $_GET['sds-total-del-input-table-and-corresponding-form'] ) {
					$wpdb->query( "DROP TABLE IF EXISTS " . $table );
					$_SESSION['sds-message'] = '<strong>' . esc_html__( 'Deleted Successfully', 'custom-searchable-data-entry-system' ) . '.</strong> ' . esc_html__( 'Note: If you had file uploads in your inputs, you should manually remove their directory via FTP connection.', 'custom-searchable-data-entry-system' );
				}
			}
		}
		$field_tables = $wpdb->get_results( "SHOW TABLES LIKE " . "'" . $tables . "%_fields'", ARRAY_A );
		$form         = str_replace( "_inputs", "_fields", $_GET['sds-total-del-input-table-and-corresponding-form'] );
		foreach ( $field_tables as $field_table ) {
			foreach ( $field_table as $form_table ) {
				if ( $form_table == $form ) {
					$wpdb->query( "DROP TABLE IF EXISTS " . $form );
					$_SESSION['sds-message'] = '<strong>' . esc_html__( 'Deleted Successfully', 'custom-searchable-data-entry-system' ) . '.</strong> ' . esc_html__( 'Note: If you had file uploads in your inputs, you should manually remove their directory via FTP connection.', 'custom-searchable-data-entry-system' );
				}
			}
		}
	}
}

add_action( 'init', 'ghazale_sds_totally_delete_input_table_and_corresponding_form_table' );
/**
 * delete selected row from entries table
 */
function ghazale_sds_delete_entries_table_row() {

	if ( isset( $_GET['sds-del-entry-first-entry-id'] ) ) {
		global $wpdb;
		$table_name      = $_GET['sds-del-entry-table-row'];
		$entry_row       = 'SELECT id FROM ' . $_GET['sds-del-entry-table-row'] . ' WHERE id >= ' . $_GET['sds-del-entry-first-entry-id'] . ' AND id <= ' . $_GET['sds-del-entry-last-entry-id'];
		$related_entries = $wpdb->get_results( $entry_row, ARRAY_A );

		foreach ( $related_entries as $related_entry ) {
			$wpdb->delete( $table_name, array( 'id' => $related_entry['id'] ) );
			$_SESSION['sds-message'] = __( 'Deleted Successfully', 'custom-searchable-data-entry-system' );
		}
	}
}

add_action( 'init', 'ghazale_sds_delete_entries_table_row' );
/**
 * admin page for uploading CSV file
 */
function ghazale_sds_upload_csv_file_admin_page() {
	?>
    <h3><?php _e( 'Upload CSV File', 'custom-searchable-data-entry-system' ) ?></h3>
    <form id="sds-upload-csv-file" method="post" enctype="multipart/form-data">
        <p><?php echo ghazale_sds_message(); ?></p>
        <h2><?php _e( 'CSV File: *', 'custom-searchable-data-entry-system' ) ?></h2>
        <input type="file" name="sds-upload-csv-file" id="ghazale-sds-upload-csv-file" required="required">
        <hr>
        <p><input class="button button-primary button-large" type="submit" name="sds-submit-upload-csv-file"
                  value="<?php _e( 'Upload File', 'custom-searchable-data-entry-system' ) ?>"></p>
    </form>
    <div class="card" style="max-width: 50%; background-color: #fcf8e3; color: #8a6d3b"><strong>Please Note:</strong> If
        you noticed irregularity in uploaded data (such as empty fields, empty data, etc; then it means that your
        database settings does not allow this operation. <br>If that is the case, you can take advantage of <a
                href="https://searchablepro.com" target="_blank">Searchable Pro</a> service. Searchable Pro will take
        care of it, it can handle file uploads and much more on its own servers and delivers the results on your website remotely. On top of that, it also has lots of settings to fine tune
        the engine to your liking.
    </div>
    <div style="display: inline-block; position: relative">
        <div class="card" style="max-width: 50%">
            <h3><?php _e( 'Important Notes Before Uploading Your File.', 'custom-searchable-data-entry-system' ) ?></h3>
            <strong>
                <p><?php _e( 'Follow these notes carefully to avoid any messed up input to the tables.', 'custom-searchable-data-entry-system' ); ?></p>
            </strong>
            <ol>
                <li><?php _e( 'The file SHOULD be in CSV format.', 'custom-searchable-data-entry-system' ) ?></li>
                <li><?php _e( 'Put the letters : <strong>sds</strong> (Exactly the same letters - All lowercase) at the first row of your file (Which contains the column names). <strong>This is super important.</strong>', 'custom-searchable-data-entry-system' ) ?></li>

                <p><strong><?php _e( 'Example', 'custom-searchable-data-entry-system' ); ?></strong></p>
                <p><?php _e( 'Assume you have an Excel file that contains a table like this:', 'custom-searchable-data-entry-system' ) ?></p>
                <style>
                    table, td, th {
                        border: 1px solid #979797;
                        border-collapse: collapse;
                        padding: 5px;
                    }
                </style>
                <table>
                    <tr>
                        <th>Client Name</th>
                        <th>Client Project</th>
                        <th>Client City</th>
                        <th>Client Reference ID</th>
                    </tr>
                    <tr>
                        <td>David</td>
                        <td>Bridge</td>
                        <td>London</td>
                        <td>746</td>
                    </tr>
                    <tr>
                        <td>Paul</td>
                        <td>Road</td>
                        <td>New York</td>
                        <td>412</td>
                    </tr>
                    <tr>
                        <td>Jane</td>
                        <td>Play Area</td>
                        <td>Boston</td>
                        <td>233</td>
                    </tr>
                </table>
                <p><?php _e( 'The first row of this example file contains the table headers. The structure is probably the same in your own file as well. When you save your Excel file as CSV, make sure you add these three letters: (<strong>sds</strong>) to the beginning of the first row.<strong>(Note that there is No spaces between "sds" and "Clients Name")</strong>. Like below:', 'custom-searchable-data-entry-system' ) ?></p>
                <table>
                    <tr>
                        <th><strong style="color: #ff0000">sds</strong>Client Name</th>
                        <th>Client Project</th>
                        <th>Client City</th>
                        <th>Client Reference ID</th>
                    </tr>
                    <tr>
                        <td>David</td>
                        <td>Bridge</td>
                        <td>London</td>
                        <td>746</td>
                    </tr>
                    <tr>
                        <td>Paul</td>
                        <td>Road</td>
                        <td>New York</td>
                        <td>412</td>
                    </tr>
                    <tr>
                        <td>Jane</td>
                        <td>Play Area</td>
                        <td>Boston</td>
                        <td>233</td>
                    </tr>
                </table>
                <li><?php _e( 'Done! Your data properly get inserted to the database.', 'custom-searchable-data-entry-system' ) ?></li>


            </ol>
            <h4><?php _e( 'Good To Know', 'custom-searchable-data-entry-system' ) ?></h4>
            <ol>
                <li><?php _e( 'Your table header (That contains the column names) can be seen under Forms menu on its own tab. And the column names (Fields Names) can be edited/ deleted  just like the other forms that you create by this plugin. The field types for the uploaded fields are "Text Field" by default, and you can change them as you like.', 'custom-searchable-data-entry-system' ) ?></li>
                <li><?php _e( 'Your main data can be seen under Entries menu on its own tab.', 'custom-searchable-data-entry-system' ) ?></li>
                <li><?php _e( 'Just like other tables, you have full control over showing/hiding your desired fields in user\'s search query', 'custom-searchable-data-entry-system' ) ?></li>
                <li><?php _e( 'There is absolutely no constraint on the number of columns or anything else for your file. So enjoy uploading!' ) ?></li>
            </ol>
            <p>
                <strong><?php _e( 'IMPORTANT NOTE: When you save your file as CSV(Comma Delimited), be careful about the commas(,) that you have in your file. Because when the system reads the file and it faces commas, it thinks the comma means the end of the field or row and it should skip it while in reality it shouldn\'t; consequently it leads to a messed up table. Therefore it is recommended to replace all the commas in your file (by pressing CTRL+F (Windows)/ Command+F(Mac)) with an alternative like dash(-) like below example.' ) ?></strong>
            </p>
            <p><strong>Example: Change John<span style="font-size: 25px; color: #ff0000">,</span>Mary to John <span
                            style="font-size: 25px; color: #ff0000">-</span> Mary</strong></p>
            <h4 style="color: #ff5500"><?php _e( 'Do you reside in a latin country and a Windows user? Or does your computer language is Spanish, Portuguese, or some other latin language? If yes, you may want to read this as well:', 'custom-searchable-data-entry-system' ) ?></h4>
            <p>
				<?php _e( 'Most probably the fields in your CSV file is separated with semicolon (;) instead of comma (,). This will result in unexpected outcome when you upload(or download) CSV file. To avoid this, you may want to change your "Windows Regional Settings" as per below instructions:', 'custom-searchable-data-entry-system' ) ?>
            <ol>
                <li><?php _e( 'Go to your "Region and Language Settings".', 'custom-searchable-data-entry-system' ) ?></li>
                <li><?php _e( 'Click on "Additional Settings".', 'custom-searchable-data-entry-system' ) ?></li>
                <li><?php _e( 'A new window opens. Make sure you\'re viewing the "Formats" tab.', 'custom-searchable-data-entry-system' ) ?></li>
                <li><?php _e( 'Click on "Additional Settings"', 'custom-searchable-data-entry-system' ) ?></li>
                <li><?php _e( 'A new window opens. Change the "List Separator" to comma ","', 'custom-searchable-data-entry-system' ) ?></li>
            </ol>
			<?php _e( 'Optional: to avoid any messed up table, you can also change the "Decimal Symbol" to dot "."', 'custom-searchable-data-entry-system' ) ?>
            <br><?php _e( 'Click "OK" on both windows and you\'re done.', 'custom-searchable-data-entry-system' ) ?>
            </p>
        </div>
        <div class="card" style="max-width: 40%; display: inline-block; position: absolute; top: 0; right: 24px">
            <h2>Go Pro!</h2>
            <strong>Have all the awesome features from <a href="https://searchablepro.com" target="_blank">Searchable
                    Pro</a></strong>
            <div style="background-color: #dff0d8; border: 1px solid #d0e9c6; color: #3c763d; padding: 8px">
                Have full control over search settings and fine tune the settings of every single field element. Take
                advantage of highly advanced search engine for customised data.
            </div>
            <br>
            <strong>Lots of features available in <a href="https://searchablepro.com" target="_blank">Searchable Pro</a>,
                namely:</strong>
            <div style="background-color: #dff0d8; border: 1px solid #d0e9c6; color: #3c763d; padding: 8px">
                <ul>
                    <li>Advanced settings for customising search engine</li>
                    <li>starFull control of fields that should be searchable and the fields that should not</li>
                    <li>starFull control of what data should be shown in search results and what data should be hidden
                        from user search
                    </li>
                    <li>starFull control of search match pattern. Flexible match or exact match</li>
                    <li>starFull control of multiple data sets. You can have multiple search engines for different data
                        sets and set your settings separately according to your needs
                    </li>
                    <li>starAbility to upload large amount of data set in csv format. Searchable Pro takes care of
                        sorting the data in proper searchable format
                    </li>
                    <li>starSee what your users have searched for. Useful analytics about your user's search in your
                        data sets
                    </li>
                    <li>starAbility to see the amount of data that have been transferred in each endpoint & keep control
                        of your data usage by its special setting
                    </li>
                    <li>starAbility to generate API keys for external developers and make use of Searchable service in
                        any programming language
                    </li>
                    <li>starUsing WordPress? Searchable Pro already offers a ready to use WordPress plugin to start
                        using the service right away on your website.
                    </li>
                </ul>
            </div>
            <h3>Why Searchable Pro?</h3>
            <p>Searchable Pro takes all the burden of searching your customised data on its own secure servers and does
                all the process for you.</p>
            <p>It also provides a free super light official WordPress plugin that goes a long with it. You can have lots
                of settings to fine tune your very own search engine for your customised data.</p>
            <p>Searchable Pro offers the possibility for processing your data remotely and return whatever that is
                relevant according to your settings. This will have the big advantage that your server is absolutely
                free and clean of these processes and you always have data consistency and interruption free service.
                There will be no more data inconsistency because of different server and database settings from your
                provider. Searchable Pro will take care of all these complexities and does the heavy lifting for
                you.</p>
            <p>And the awesome news is... Searchable Pro is free to use during its beta phase!</p>
            <a href="https://searchablepro.com" target="_blank" class="button button-primary button-large">Go Pro &
                Upgrade to Searchable Pro</a>
        </div>
    </div>
	<?php

}

function ghazale_sds_upload_csv_file_admin_menu() {
	add_submenu_page( 'custom-searchable-data-entry-system', __( 'Upload CSV File', 'custom-searchable-data-entry-system' ), __( 'Upload CSV File', 'custom-searchable-data-entry-system' ), 'manage_options', 'sds-upload-csv', 'ghazale_sds_upload_csv_file_admin_page' );
}

add_action( 'admin_menu', 'ghazale_sds_upload_csv_file_admin_menu' );
/**
 * upload CSV file to db
 */
function ghazale_sds_insert_csv_file() {
	if ( isset( $_POST['sds-submit-upload-csv-file'] ) ) {

		global $wpdb;
		if ( isset( $_FILES["sds-upload-csv-file"] ) && $_FILES["sds-upload-csv-file"]['size'] > 0 ) {
			if ( ! function_exists( 'wp_handle_upload' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
			}
			$uploadedfile     = $_FILES["sds-upload-csv-file"];
			$upload_overrides = array( 'test_form' => false, 'mimes' => array( 'csv' => 'text/csv' ) );
			if ( ! function_exists( 'ghazale_sds_change_upload_dir' ) ) {
				function ghazale_sds_change_upload_dir( $upload ) {
					$new_dir = '/sds-csv';

					$upload['path']   = str_replace( $upload['subdir'], '', $upload['path'] );
					$upload['url']    = str_replace( $upload['subdir'], '', $upload['url'] );
					$upload['subdir'] = $new_dir;
					$upload['path']   .= $new_dir;
					$upload['url']    .= $new_dir;

					return $upload;
				}
			}
			add_filter( 'upload_dir', 'ghazale_sds_change_upload_dir' );
			$upload   = wp_upload_dir();
			$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
			remove_filter( 'upload_dir', 'ghazale_sds_change_upload_dir' );


			if ( $movefile && ! isset( $movefile['error'] ) ) {
				//                echo "File is valid, and was successfully uploaded.\n";
				//                var_dump($movefile);
				$csv_column_names_loc = $movefile['file'];
				$table_name = $wpdb->prefix . "ghazale_sds_" . mt_rand( 11111, 99999 ) . 'csv';
				$tables     = $wpdb->get_results( "SHOW TABLES LIKE " . "'" . $table_name . "%'" );
				if ( count( $tables ) == 0 ) {
					$sql_form = "CREATE TABLE " . $table_name . "_fields (id INTEGER(10) UNSIGNED AUTO_INCREMENT, field_name VARCHAR (300) COLLATE utf8_bin, field_type VARCHAR (300) COLLATE ascii_bin, field_ext VARCHAR (300) COLLATE utf8_bin, field_hide VARCHAR (4) COLLATE ascii_bin, PRIMARY KEY (id))";
					$wpdb->query( $sql_form );
					$sql_input = "CREATE TABLE " . $table_name . "_inputs (id INTEGER(10) UNSIGNED AUTO_INCREMENT, field_id INTEGER(10), field_input VARCHAR(3000) COLLATE utf8_bin, PRIMARY KEY (id))";
					$wpdb->query( $sql_input );
					//$_SESSION['sds-message'] = esc_html__('Form Created Successfully','custom-searchable-data-entry-system');
				} else {
					$_SESSION['sds-message'] = esc_html__( 'An error occur. Please try again. This error will not happen next time! ', 'custom-searchable-data-entry-system' );
				}
				//   create temporary table
				if ( $wpdb->get_var( "SHOW TABLES LIKE 'temp'" ) == null ) {
					$wpdb->query( 'CREATE TEMPORARY TABLE temp (field_name VARCHAR (300) COLLATE utf8_bin)' );
				}
				//$local_infile_on = "SET GLOBAL local_infile = 'ON'";
				//$wpdb->query($local_infile_on);

				$upload_fields_sql = "LOAD DATA LOCAL INFILE '" . $csv_column_names_loc . "' INTO TABLE temp CHARACTER SET UTF8 LINES STARTING BY 'sds'";
				$true              = $wpdb->query( $upload_fields_sql );
				$temp_table        = "SELECT * FROM temp";
				$temp_table_query  = $wpdb->get_var( $temp_table );
				$fields            = explode( ',', $temp_table_query );

				if ( $fields ) {
					foreach ( $fields as $field ) {
						$wpdb->insert( $table_name . '_fields', array(
							'field_name' => $field,
							'field_type' => 'Text Field'
						) );
					}
				}

				//   create temporary table
				if ( $wpdb->get_var( "SHOW TABLES LIKE 'temp_input'" ) == null ) {
					$wpdb->query( 'CREATE TEMPORARY TABLE temp_input (field_input VARCHAR (300) COLLATE utf8_bin)' );
				}

				$upload_data_sql_input = "LOAD DATA LOCAL INFILE  '" . $csv_column_names_loc . "' INTO TABLE temp_input CHARACTER SET UTF8 LINES TERMINATED BY '\n' IGNORE 1 LINES";
				$wpdb->query( $upload_data_sql_input );
				$temp_table_input       = "SELECT * FROM temp_input";
				$temp_table_input_query = $wpdb->get_results( $temp_table_input, ARRAY_A );
				$inputs_array           = array();
				foreach ( $temp_table_input_query as $inputs ) {
					array_push( $inputs_array, $inputs['field_input'] );
				}
				$inputs_implode  = implode( ',', $inputs_array );
				$inputs_tmp      = explode( ',', $inputs_implode );
				$field_ids_array = array();
				$field_ids_sql   = 'SELECT id FROM ' . $table_name . '_fields';
				$field_ids_query = $wpdb->get_results( $field_ids_sql, ARRAY_A );
				foreach ( $field_ids_query as $field_ids ) {
					array_push( $field_ids_array, $field_ids['id'] );
				}
				$iteration_number       = ( count( $inputs_tmp ) ) / ( count( $field_ids_array ) );
				$field_ids_array_object = new ArrayObject( $field_ids_array );
				$copy_result            = array();
				for ( $i = 1; $i <= $iteration_number; $i ++ ) {
					$copy_array  = $field_ids_array_object->getArrayCopy();
					$copy_result = array_merge( $copy_result, $copy_array );
				}

				foreach ( $inputs_tmp as $index => $final_input ) {

					$wpdb->insert( $table_name . '_inputs', array(
						'field_id'    => $copy_result[ $index ],
						'field_input' => $final_input
					) );

				}
				$_SESSION["sds-message"] = __( 'Uploaded. Please check for any irregularity of data under Forms/ Entries menu. If that is the case, then your database settings does not allow this operation.', 'custom-searchable-data-entry-system' );
			} else {
				/**
				 * Error generated by _wp_handle_upload()
				 * @see _wp_handle_upload() in wp-admin/includes/file.php
				 */
				$_SESSION['sds-message-error'] = __('Your WordPress configuration does not allow this operation. This is the original error that WordPress has returned:<br>"' . $movefile['error'] . '"', 'custom-searchable-data-entry-system');
			}

		}

	}
}

add_action( 'init', 'ghazale_sds_insert_csv_file' );
/**
 * options page
 */
function ghazale_sds_options_page() {
	echo "<div class='card'>";
	echo "<h3>" . esc_html__( 'Options', 'custom-searchable-data-entry-system' ) . "</h3>";
	echo "<h4>" . esc_html__( 'You have 2 options to search the tables:', 'custom-searchable-data-entry-system' ) . "</h4>";
	echo "<h4><ol>";
	echo "<li>" . esc_html__( 'You can choose to search ALL tables with a single search engine.', 'custom-searchable-data-entry-system' ) . "<i style='color: #ff5500'> Example shortcode: [sds-search]</i></li>";
	echo "<li>" . esc_html__( 'You can choose to search tables SEPARATELY with a unique search engine for each table.', 'custom-searchable-data-entry-system' ) . "<i style='color: #ff5500'> Example shortcode: [sds-search table=\"name\"]</i></li>";
	echo "</ol></h4>";
	echo "<h4 style='color: #0064cd'>" . esc_html__( 'If the option is enabled you should use the shortcode WITH ITS ATTRIBUTE [sds-search table="name"]', 'custom-searchable-data-entry-system' );
	echo "<br>" . esc_html__( 'and if the option is disabled you need to use the simple form of shortcode [sds-search]', 'custom-searchable-data-entry-system' );
	echo "</h4>";
	echo "<form action='options.php' id='sds_options_form' method='post'>";
	settings_errors();
	settings_fields( 'ghazale_sds_options' );
	echo "<p><input type='checkbox' name='ghazale_sds_separate_search' value='1' ";
	if ( get_option( 'ghazale_sds_separate_search' ) ) {
		echo "checked";
	}
	echo " />" . esc_html__( 'Search Tables Separately With Separate Search Engines', 'custom-searchable-data-entry-system' ) . "</p>";

	echo "<input type='submit' class='button button-primary button-large' name='sds_submit_options'>";
	echo "</form>";
	echo "</div>";
	echo "<div class='card'>";
	echo "<h4>" . esc_html__( 'GUIDE NOTES:', 'custom-searchable-data-entry-system' ) . "</h4>";
	echo "<h4>" . esc_html__( 'After you enabled the above option, the shortcode WILL HAVE AN ATTRIBUTE THAT HAS TO BE ADDED in order to make the search engine work.', 'custom-searchable-data-entry-system' );
	echo "<br>" . __( 'For example the search shortcode would be <pre>[sds-search table="name"]</pre> Where "name" is the name of the table that you wish the search engine to search.', 'custom-searchable-data-entry-system' );
	echo "</h4>";
	echo "</div>";
	echo "<div class='card' style='max-width: 70%'>";
	echo "<h4>" . esc_html( 'When this option is enabled, each input table will have its own unique "Search Engine" shortcode that will appear above each respective table under "Entries" submenu. See below screenshot to realize where it is located', 'custom-searchable-data-entry-system' ) . "</h4>";
	echo "<img src='" . plugins_url( 'images/separate-search-engine.png', __FILE__ ) . "'>";
	echo "</div>";
}

function ghazale_sds_options_page_admin_menu() {
	add_submenu_page( 'custom-searchable-data-entry-system', __( 'Options', 'custom-searchable-data-entry-system' ), __( 'Options', 'custom-searchable-data-entry-system' ), 'manage_options', 'sds-options_page', 'ghazale_sds_options_page' );
}

add_action( 'admin_menu', 'ghazale_sds_options_page_admin_menu' );
/**
 * front-end search field
 */
function ghazale_sds_front_end_search_field( $atts ) {
	$output = '<form id="sds-search-entries" method="post">';
	$output .= '<h3>' . __( 'Search', 'custom-searchable-data-entry-system' ) . ':</h3>';
	$output .= '<p><input type="text" name="sds-search-data" size="40" placeholder="' . __( 'SEARCH HERE...', 'custom-searchable-data-entry-system' ) . '"></p>';
	$output .= '<p><input type="submit" name="submit-sds-search-query" value="' . __( 'Search', 'custom-searchable-data-entry-system' ) . '"></p>';
	$output .= '</form>';
	if ( isset( $_POST['submit-sds-search-query'] ) ) {
		global $wpdb;
		$tables       = $wpdb->prefix . "ghazale_sds_";
		$input_tables = $wpdb->get_results( "SHOW TABLES LIKE " . "'" . $tables . "%_inputs'", ARRAY_A );
		$field_tables = $wpdb->get_results( "SHOW TABLES LIKE " . "'" . $tables . "%_fields'", ARRAY_A );
		$has_result   = array();
		if ( ! empty( $input_tables ) ) {
			$hidden_field  = array();
			$shown_field   = array();
			$results_array = array();
			foreach ( $input_tables as $input_table ) {
				foreach ( $input_table as $table ) {
					if ( get_option( 'ghazale_sds_separate_search' ) ) {
						shortcode_atts( array(
							'table' => str_replace( array(
								$tables,
								'_inputs'
							), '', $table )
						), $atts );
					}
					if ( get_option( 'ghazale_sds_separate_search' ) && str_replace( array(
							$tables,
							'_inputs'
						), '', $table ) == $atts['table'] ) {

						$inputs_sql = "SELECT * FROM " . $table . " ORDER BY id ASC";
						$inputs     = $wpdb->get_results( $inputs_sql, ARRAY_A );
						if ( trim( $_POST['sds-search-data'] != '' ) ) {
							$results_sql = "SELECT id,field_id,field_input FROM " . $table . " WHERE field_input COLLATE UTF8_GENERAL_CI LIKE '" . $_POST['sds-search-data'] . "%' ORDER BY id ASC";
							$results     = $wpdb->get_results( $results_sql, ARRAY_A );
							foreach ( $field_tables as $field_table ) {
								foreach ( $field_table as $field_table_single ) {
									if ( $field_table_single == str_replace( "_inputs", "_fields", "$table" ) ) {
										$fields_sql = "SELECT id,field_name,field_type,field_hide FROM " . $field_table_single;
										$fields     = $wpdb->get_results( $fields_sql, ARRAY_A );

										if ( ! empty( $inputs ) ) {

											foreach ( $fields as $field ) {
												$first_id = $field['id'];
												break;
											}

											foreach ( $fields as $field ) {
												$last_id = $field['id'];
											}
											if ( $results ) {

												foreach ( $results as $result ) {
													if ( strstr( $result['field_input'], '@' ) != true ) {
														$output            .= "<div id=\"" . $table . "\">";
														$output            .= "<table class = \"table\">";
														$range_initial_sql = 'SELECT id FROM ' . $table . ' WHERE field_id<= ' . $result['field_id'] . ' AND field_id =' . $first_id . ' AND id<= ' . $result['id'] . ' ORDER BY id DESC LIMIT 1';
														$range_initial     = $wpdb->get_results( $range_initial_sql, ARRAY_A );
														$range_final_sql   = 'SELECT id FROM ' . $table . ' WHERE field_id>= ' . $result['field_id'] . ' AND field_id =' . $last_id . ' AND id>= ' . $result['id'] . ' ORDER BY id ASC LIMIT 1';
														$range_final       = $wpdb->get_results( $range_final_sql, ARRAY_A );

														$result_range_sql = 'SELECT id,field_id,field_input FROM ' . $table . ' WHERE id BETWEEN ' . $range_initial[0]['id'] . ' and ' . $range_final[0]['id'];
														$result_range     = $wpdb->get_results( $result_range_sql, ARRAY_A );
														foreach ( $fields as $field ) {
															if ( $field['field_hide'] == "Hide" ) {
																//if the field is hidden don't show anything
																array_push( $hidden_field, $field['id'] );
															} else {
																//otherwise show it on search query
																array_push( $shown_field, $field['field_name'] );
															}
														}
														foreach ( $result_range as $single_result ) {
															if ( ! in_array( $single_result['field_id'], $hidden_field ) ) {
																array_push( $results_array, $single_result['field_input'] );
															}
														}


														foreach ( $shown_field as $index => $single_field ) {
															$output .= "<tr>";
															if ( $results_array[ $index ] != "" ) {
																$link_or_img = strlen( $results_array[ $index ] ) - 3;
																$jpeg_img    = strlen( $results_array[ $index ] ) - 4;
																if ( substr( $results_array[ $index ], 0, 4 ) === "http" && ( substr( $results_array[ $index ], $link_or_img, 3 ) == "png" || substr( $results_array[ $index ], $link_or_img, 3 ) == "jpg" || substr( $results_array[ $index ], $link_or_img, 3 ) == "gif" || substr( $results_array[ $index ], $link_or_img, 3 ) == "bmp" || substr( $results_array[ $index ], $jpeg_img, 4 ) == "jpeg" ) ) {
																	$output .= "<th style='text-align: center'>" . $single_field . "</th><td style='text-align: center'><img src='" . $results_array[ $index ] . "' width=\"100\"></td>";
																} elseif ( substr( $results_array[ $index ], 0, 4 ) === "http" && ( substr( $results_array[ $index ], $link_or_img, 3 ) != "png" || substr( $results_array[ $index ], $link_or_img, 3 ) != "jpg" || substr( $results_array[ $index ], $link_or_img, 3 ) != "gif" || substr( $results_array[ $index ], $link_or_img, 3 ) != "bmp" || substr( $results_array[ $index ], $jpeg_img, 4 ) != "jpeg" ) ) {
																	$output .= "<th style='text-align: center'>" . $single_field . "</th><td style='text-align: center'><a href='" . $results_array[ $index ] . "'>" . $results_array[ $index ] . "</a></td>";
																} else {
																	$output .= "<th style='text-align: center'>" . $single_field . "</th><td style='text-align: center'>" . stripslashes( $results_array[ $index ] ) . "</td>";
																}
															}

															$output .= "</tr>";

														}
														$output .= "</table>";
														$output .= "</div>";
														unset( $hidden_field );
														$hidden_field = array();
														unset( $shown_field );
														$shown_field = array();
														unset( $results_array );
														$results_array = array();
													}
												}

												array_push( $has_result, 'Has Result' );
											}
										}
									}
								}
							}
						}
					} elseif ( ! get_option( 'ghazale_sds_separate_search' ) ) {
						$inputs_sql = "SELECT * FROM " . $table . " ORDER BY id ASC";
						$inputs     = $wpdb->get_results( $inputs_sql, ARRAY_A );
						if ( trim( $_POST['sds-search-data'] != '' ) ) {
							$results_sql = "SELECT id,field_id,field_input FROM " . $table . " WHERE field_input COLLATE UTF8_GENERAL_CI LIKE '" . $_POST['sds-search-data'] . "%' ORDER BY id ASC";
							$results     = $wpdb->get_results( $results_sql, ARRAY_A );
							foreach ( $field_tables as $field_table ) {
								foreach ( $field_table as $field_table_single ) {
									if ( $field_table_single == str_replace( "_inputs", "_fields", "$table" ) ) {
										$fields_sql = "SELECT id,field_name,field_type,field_hide FROM " . $field_table_single;
										$fields     = $wpdb->get_results( $fields_sql, ARRAY_A );

										if ( ! empty( $inputs ) ) {

											foreach ( $fields as $field ) {
												$first_id = $field['id'];
												break;
											}

											foreach ( $fields as $field ) {
												$last_id = $field['id'];
											}
											if ( $results ) {

												foreach ( $results as $result ) {
													if ( strstr( $result['field_input'], '@' ) != true ) {
														$output            .= "<div id=\"" . $table . "\">";
														$output            .= "<table class = \"table\">";
														$range_initial_sql = 'SELECT id FROM ' . $table . ' WHERE field_id<= ' . $result['field_id'] . ' AND field_id =' . $first_id . ' AND id<= ' . $result['id'] . ' ORDER BY id DESC LIMIT 1';
														$range_initial     = $wpdb->get_results( $range_initial_sql, ARRAY_A );
														$range_final_sql   = 'SELECT id FROM ' . $table . ' WHERE field_id>= ' . $result['field_id'] . ' AND field_id =' . $last_id . ' AND id>= ' . $result['id'] . ' ORDER BY id ASC LIMIT 1';
														$range_final       = $wpdb->get_results( $range_final_sql, ARRAY_A );

														$result_range_sql = 'SELECT id,field_id,field_input FROM ' . $table . ' WHERE id BETWEEN ' . $range_initial[0]['id'] . ' and ' . $range_final[0]['id'];
														$result_range     = $wpdb->get_results( $result_range_sql, ARRAY_A );
														foreach ( $fields as $field ) {
															if ( $field['field_hide'] == "Hide" ) {
																//if the field is hidden don't show anything
																array_push( $hidden_field, $field['id'] );
															} else {
																//otherwise show it on search query
																array_push( $shown_field, $field['field_name'] );
															}
														}
														foreach ( $result_range as $single_result ) {
															if ( ! in_array( $single_result['field_id'], $hidden_field ) ) {
																array_push( $results_array, $single_result['field_input'] );
															}
														}


														foreach ( $shown_field as $index => $single_field ) {
															$output .= "<tr>";
															if ( $results_array[ $index ] != "" ) {
																$link_or_img = strlen( $results_array[ $index ] ) - 3;
																$jpeg_img    = strlen( $results_array[ $index ] ) - 4;
																if ( substr( $results_array[ $index ], 0, 4 ) === "http" && ( substr( $results_array[ $index ], $link_or_img, 3 ) == "png" || substr( $results_array[ $index ], $link_or_img, 3 ) == "jpg" || substr( $results_array[ $index ], $link_or_img, 3 ) == "gif" || substr( $results_array[ $index ], $link_or_img, 3 ) == "bmp" || substr( $results_array[ $index ], $jpeg_img, 4 ) == "jpeg" ) ) {
																	$output .= "<th style='text-align: center'>" . $single_field . "</th><td style='text-align: center'><img src='" . $results_array[ $index ] . "' width=\"100\"></td>";
																} elseif ( substr( $results_array[ $index ], 0, 4 ) === "http" && ( substr( $results_array[ $index ], $link_or_img, 3 ) != "png" || substr( $results_array[ $index ], $link_or_img, 3 ) != "jpg" || substr( $results_array[ $index ], $link_or_img, 3 ) != "gif" || substr( $results_array[ $index ], $link_or_img, 3 ) != "bmp" || substr( $results_array[ $index ], $jpeg_img, 4 ) != "jpeg" ) ) {
																	$output .= "<th style='text-align: center'>" . $single_field . "</th><td style='text-align: center'><a href='" . $results_array[ $index ] . "'>" . $results_array[ $index ] . "</a></td>";
																} else {
																	$output .= "<th style='text-align: center'>" . $single_field . "</th><td style='text-align: center'>" . stripslashes( $results_array[ $index ] ) . "</td>";
																}
															}

															$output .= "</tr>";

														}
														$output .= "</table>";
														$output .= "</div>";
														unset( $hidden_field );
														$hidden_field = array();
														unset( $shown_field );
														$shown_field = array();
														unset( $results_array );
														$results_array = array();
													}
												}

												array_push( $has_result, 'Has Result' );
											}
										}
									}
								}
							}
						}
					}
				}

			}

		}
		if ( count( $has_result ) == 0 ) {
			$output .= "<h4>" . __( 'No Result', 'custom-searchable-data-entry-system' ) . "</h4>";
		}

	}

	return $output;
}

add_shortcode( 'sds-search', 'ghazale_sds_front_end_search_field' );

/**
 * loading language file
 */
function ghazale_sds_load_plugin_textdomain() {
	load_plugin_textdomain( 'custom-searchable-data-entry-system', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'ghazale_sds_load_plugin_textdomain' );