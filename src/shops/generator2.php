<HTML>
<HEAD>
<TITLE>WeBringYouGaming - LocalShops Shop Item Adder</TITLE>
</HEAD>
<BODY>
<center><h2>WeBringYouGaming - LocalShops Item Generator</h2>
<!-- Unused configuration code by iffa --!>
<?php
require_once 'magicquotes.php';
// LocalShops Generator - Settings
// Location of index.php, without http:// or index.php
$mainsite = 'google.com'
?>
<!-- Generation Code by iffa, special thanks to Tenmilesout for cleaning it a bit --!>
<?php

if (file_exists($_POST[shop] . '.shop'))
{
	$out = fopen($_POST[shop]. '.shop', 'a');
	if (!$out)
	{
		print('Failed to generate shop file!');
		exit;
	}
    fputs($out, "\n");
    fputs($out, $_POST[item]);
    fputs($out, '=');
    fputs($out, $_POST[buyprice]);
    fputs($out, '\:');
    fputs($out, $_POST[bundlebuy]);
    fputs($out, ',');
    fputs($out, $_POST[sellprice]);
    fputs($out, '\:');
    fputs($out, $_POST[bundlesell]);
    fputs($out, ',');
    fputs($out, $_POST[stock]);
    fputs($out, '\:0');
	//end of write-to-file script
	print('<img src="thatfuckingcat.png" alt="That Fucking Cat!"/><br />');
	echo 'Successfully added a new item for LocalShops V3+.<br />';
	echo 'Visit shops/' . $_POST[shop] . '.shop to download the file!<br />';
    echo 'The UUID of your shop is: ' . $shop . '!<br />';
	//end of script 2
	fclose($out);
	
}
else
{
print("Couldn't find the UUID you specified! Did you paste it correctly?");
}
?>
<?php
$fn = $_POST[shop] . '.shop';

if (isset($_POST['content']))
{
    $content = stripslashes($_POST['content']);
    $fp = fopen($fn,"w") or die ("Error opening file in write mode!");
    fputs($fp,$content);
    fclose($fp) or die ("Error closing file!");
}
?>
<h3>Click <a href="TO_ADDITEM.PHP">here</a> to add a new item! (remember the UUID!)</h3><br />
<h3>Click <a href="TO_MAIN">here</a> to go to the main page!</h3><br />
<h4>To use the generated .shops file on your server, move the file to plugins/LocalShops/shops/ and reload/restart your server.<br /></h4>
<br />
<h4>LocalShops Shop Suite (c) iffa 2011 - LocalShops made by Mineral, cereal and Jonbas</h4></center>
</BODY>
</HTML>