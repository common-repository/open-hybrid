<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Plugin Name: Open Hybrid
 * Plugin URI: http://blog.buivannguyen.com
 * Description: Plugin for the OpenHybirdWordpress, OpenHybirdWordpress is a free opensource project to build mobile applications use phonegap and wordpress.
 * Version: 0.2
 * Author: Bui van nguyen
 * Author URI: http://buivannguyen.com
 * License: GPLv2 or later
 */

define('OPENHYBRIDWORDPRESS_PLUGIN_DIR', plugin_dir_path( __FILE__ ));

require OPENHYBRIDWORDPRESS_PLUGIN_DIR . 'constants.php';

if ( is_admin() ){
    require OPENHYBRIDWORDPRESS_PLUGIN_DIR .'backend.php';
}
else {
    require OPENHYBRIDWORDPRESS_PLUGIN_DIR .'frontend.php';
}

?>