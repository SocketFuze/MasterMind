<?php
require( '../../../wp-load.php' );
require_once( 'functions.php' );
require_once( 'includes/front-end/functions-posts.php' );
$defaults = array();
$r = wp_parse_args( $_REQUEST['queryString'], $defaults );
//echo '<li> >> ' . $_REQUEST['action'];
//echo '<li> >> ' . isset($_REQUEST['action']);
//echo '<li> >> ' . function_exists($_REQUEST['action']);
if(isset($_REQUEST['action'])) {
    //print_debug($_REQUEST);
    switch ($_REQUEST['action']) {
        case 'mastermind_programs_and_events_list':
            mastermind_programs_and_events_list();
            break;
        case 'items_filter':
            get_inner_loop_post_content($r);
            break;
        case 'peoples_filter':
            get_peoples_list();
            break;
    }
}
die();
?>
