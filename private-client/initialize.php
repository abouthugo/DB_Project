<?php
/*
 * START COOKIE
 * ============
 */
session_start();

/*
 * CONSTANTS
 * ==========
 */
//P refers to this file's parent directory
//dirname returns the path of parent directory
define("P", dirname(__FILE__).'/');
define("CSTYLE", dirname(P).'/style/');
define("CLIENT", P.'client-html/');
//Absolute url to home, CPanel link will differ
define("HOMEURL", 'http://cyan.csam.montclair.edu/~perdomoh1/');
//define("HOMEURL", 'http://localhost:8888/');

/*
 * Default Functions
 * -----------------
 */
require('funcs.php');
require('navGen.php');
require('tableGen.php');
require('db.funcs.php');