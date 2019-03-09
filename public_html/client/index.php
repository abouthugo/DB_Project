<?php
$page_title = 'Coche'; //set title of page
require_once('../../private-client/initialize.php'); //load libraries
require(CLIENT.'head.php');
checkLog();
//indexAcces(); //check for credentials
makeNav($page_title);

include(CLIENT.'index-content.php');
require_once(CLIENT . 'tidy-up.php'); ?>
