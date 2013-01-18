<?php
	require 'main.php'; 
    
	echo get_address($_GET['postcode'], $_GET['nummer'], isset($_GET['toevoeging']) ? $_GET['toevoeging'] : '');
?>