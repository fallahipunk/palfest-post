<?php 
/*Plugin Name: PalFest Post Types
Description: Custom post types for the PalFest website
Version: 1.0
License: GPLv2
*/

require(__DIR__ .'/palfestivians.php'); 
require(__DIR__ .'/programme.php'); 
require(__DIR__ .'/article.php'); 



add_action( 'init', 'palfest_create_programme' );
add_action( 'init', 'palfest_create_palfestivians' );
add_action( 'init', 'palfest_create_articles' );


?>