<HTML>
<HEAD>
<TITLE>WeBringYouGaming - LocalShops Shop Editor</TITLE>
</HEAD>
<BODY>
<center><h2>WeBringYouGaming - LocalShops Shop Editor</h2>
<!-- Unused configuration code by iffa --!>
<?php
// LocalShops Generator - Settings
// Location of index.php, without http:// or index.php
$mainsite = 'google.com'
?>
<!-- Generation Code by iffa, special thanks to Tenmilesout for cleaning it a bit --!>
<?php
if($_POST[moneyval] == "false") {
$changethis = 'true';
$changeto = 'false';
}
elseif($_POST[moneyval] == "true"){
$changethis = 'false';
$changeto = 'true';
} else {
print("Something went wrong! The setting is on $_POST[moneyval] already, or the input was incorrect.");
exit;
}
    $file = $_POST[shop] . ".shop"; 
    $contents = file_get_contents($file, FILE_TEXT);
    $new_contents = str_replace('unlimited-money=' . $changethis, 'unlimited-money=' . $changeto, $contents);
    file_put_contents($file, $new_contents, FILE_TEXT);
	//end of write-to-file script
if($_POST[stockval] == "false") {
$changethis = 'true';
$changeto = 'false';
}
elseif($_POST[stockval] == "true"){
$changethis = 'false';
$changeto = 'true';
} else {
print("Something went wrong! The setting is on $_POST[stock] already, or the input was incorrect.");
exit;
}
//unlimited stock
    $file = $_POST[shop] . ".shop"; 
    $contents = file_get_contents($file, FILE_TEXT);
    $new_contents = str_replace('unlimited-stock=' . $changethis, 'unlimited-stock=' . $changeto, $contents);
    file_put_contents($file, $new_contents, FILE_TEXT);
//name
    $new_contents = str_replace('name=' . $_POST[oldname], 'name=' . $_POST[newname], $contents);
    file_put_contents($file, $new_contents, FILE_TEXT);
	//end of edit
    print('<img src="thatfuckingcat.png" alt="That Fucking Cat!"/><br />');
	echo 'Successfully edited shop settings for LocalShops V3+.<br />';
	echo 'Visit shops/<b>' . $_POST[shop] . '.shop</b> to download the file!<br />';
    echo 'The UUID of your shop is:<br /><b> ' . $_POST[shop] . '</b>!<br />';
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