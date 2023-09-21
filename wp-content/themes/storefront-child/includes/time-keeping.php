<?php
/**
 * This is an include file for functions.php
 */

/*
-------------------------------------------------------------------------------------------------------
	Theme Setup
-------------------------------------------------------------------------------------------------------
*/
function time_keeping_register() {
    add_menu_page(
        'Owner\'s Draws',
        'Time Keeping',
        'manage_options',
        'time-keeping',
        'owners_draws_page_contents',
        'dashicons-clock',
        70
    );
}
add_action( 'admin_menu', 'time_keeping_register' );

function time_sheet_page()
{
	add_submenu_page(
		'time-keeping',
		'Time Sheet',
		'Time Sheet',
        'manage_options',
		'time-sheet',
		'time_sheet_page_contents'
	);
}
add_action('admin_menu', 'time_sheet_page');

function time_category_page()
{
	add_submenu_page(
		'time-keeping',
		'Time Categories',
		'Time Categories',
        'manage_options',
		'time-category',
		'time_category_page_contents'
	);
}
add_action('admin_menu', 'time_category_page');

function upsert_check_notes_ajax(){
    global $wpdb;
    $pay_period = $_POST['payPeriod'];
    $users_id = $_POST['usersID'];
    $check_number = $_POST['checkNumber'];
    $notes = $_POST['notes'];

    $record_exists = $wpdb->get_row("
        SELECT *
        FROM wordpress.wp_rosecoded_checks
        WHERE users_id = '" . $users_id . "' AND pay_period = '" . $pay_period . "';
    ");

    if ($record_exists) {
        $wpdb->update(
            'wp_rosecoded_checks',
            array(
                'pay_period' => $pay_period,
                'users_id' => $users_id,
                'check_number' => $check_number,
                'notes' => $notes
            ),
            array(
                'pay_period' => $pay_period,
                'users_id' => $users_id
            )
        );
    }
    else {
        $wpdb->insert(
            'wp_rosecoded_checks',
            array(
                'pay_period' => $pay_period,
                'users_id' => $users_id,
                'check_number' => $check_number,
                'notes' => $notes
            )
        );
    }
    
}
add_action('wp_ajax_nopriv_upsert_check_notes_ajax', 'upsert_check_notes_ajax');
add_action('wp_ajax_upsert_check_notes_ajax', 'upsert_check_notes_ajax');


function delete_time_entry_ajax(){
    global $wpdb;
    $time_entry_id = $_POST['timeEntryID'];

    $wpdb->delete(
        'wp_rosecoded_time_entries',
        array( 'ID' => $time_entry_id )
    );
}
add_action('wp_ajax_nopriv_delete_time_entry_ajax', 'delete_time_entry_ajax');
add_action('wp_ajax_delete_time_entry_ajax', 'delete_time_entry_ajax');

//Owner's Draws page
function owners_draws_page_contents() {
    include __DIR__.'/owners-draws.php';
}

//Time Sheet page
function time_sheet_page_contents() {
    include __DIR__.'/time-sheet.php';
}

//Time Categories page
function time_category_page_contents() {
    include __DIR__.'/time-categories.php';
}
