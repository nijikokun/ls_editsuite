<html>
<head>
<title>WeBringYouGaming - LocalShops Advanced Shop Editor</title>
</head>
<body>
<center><?php
$fn = $_POST[edit] . '.shop';

if (isset($_POST['content']))
{
    $content = stripslashes($_POST['content']);
    $fp = fopen($fn,"w") or die ("Error opening file in write mode!");
    fputs($fp,$content);
    fclose($fp) or die ("Error closing file!");
}
?>
<h3>Note! Saving doesn't always work, copy the edit to clipboard before saving!</h3><br />
<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
    <textarea rows="30" cols="80" name="content"><?php readfile($fn); ?></textarea><br />
    <input type="submit" value="Save File" name="submit" /></form></center>
</body>