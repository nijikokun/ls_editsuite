<?php
/*
 * LocalSuite
 * 
 * @author: Nijikokun <nijikokun@gmail.com>
 * @author: iffa
 * @copyright: Copyright (C) 2011
 * @license: GNUv3 Affero License <http://www.gnu.org/licenses/agpl-3.0.html>
 */

include('inc/config.php');
include('classes/common.php');
include('classes/file.php');
include('classes/item.php');
include('classes/items.php');
include('classes/shop_item.php');
include('classes/shop.php');

// Initialize Classes
$common = new Common();
$FileManager = new File();
$items = new Items('inc/items.db');

// Version
$config['version'] = "0.1";

// Strip those magic quotes
if (get_magic_quotes_gpc()){
	foreach ($_GET as &$a) $a = stripslashes($a);
	foreach ($_POST as &$a) $a = stripslashes($a);
	foreach ($_COOKIE as &$a) $a = stripslashes($a);
}
