<?php

add_action('admin_menu', 'ohw_setting_menu');
add_action('admin_init', 'ohw_register_setting_and_field');
$ohw_option = get_option('openhybridwordpress_option');

function ohw_register_setting_and_field(){
    register_setting(
           'openhybridwordpress_setting_options', // $option_group
           'openhybridwordpress_option', // $option_name
           'validate_setting'
   );
    add_settings_section(SECTION_NAME, '', '', SETTING_PAGE_NAME);
    add_settings_field('openhybridwordpress_menu','
                        Select page for app menu:', 'display_menu_field', SETTING_PAGE_NAME, SECTION_NAME);
}

function ohw_setting_menu(){
    add_menu_page(
		SETTING_PAGE_TITE,
		SETTING_PAGE_MENU,
		'manage_options',
		SETTING_PAGE_NAME, 
		'ohw_view_setting_page'
	);
}

function ohw_view_setting_page(){
	require OPENHYBRIDWORDPRESS_PLUGIN_DIR .'settings.php';
}

function display_menu_field(){
    global $ohw_option;
    $pages = get_pages();
    foreach ($pages as $page) {
        $checked = (isset($ohw_option['menu']) && in_array($page->ID, $ohw_option['menu'])) ? ' checked="checked" ' : '';
        echo '<input type="checkbox" name="openhybridwordpress_option[menu][]" value="' .$page->ID. '" '.$checked.' />'.$page->post_title.'<br>';
    }
    
}

function validate_setting($input_values){
	return $input_values;
}


?>