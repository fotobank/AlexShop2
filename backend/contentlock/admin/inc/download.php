<?php

include('functions.php');

$get = isset( $_GET['type'] ) ? $_GET['type'] : '';

if( $get && $get === 'export' ) {
   export();
} else if( $get === 'subs' ) {
   saveSubscribers();
}
 	
?>