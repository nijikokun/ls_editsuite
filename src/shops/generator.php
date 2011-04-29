<HTML>
<HEAD>
<TITLE>WeBringYouGaming - LocalShops Config Generator</TITLE>
</HEAD>
<BODY>
<center><h2>WeBringYouGaming - LocalShops Config Generator</h2>
<!-- Unused configuration code by iffa --!>
<?php
// LocalShops Generator - Settings
// Location of index.php, without http:// or index.php
$mainsite = 'google.com'
?>
<!-- UUID V4 code by Andrew Moore --!>
<?php

// UUID Generation Process, LocalShops V3
class UUID {
  public static function v3($namespace, $name) {
    if(!self::is_valid($namespace)) return false;

    // Get hexadecimal components of namespace
    $nhex = str_replace(array('-','{','}'), '', $namespace);

    // Binary Value
    $nstr = '';

    // Convert Namespace UUID to bits
    for($i = 0; $i < strlen($nhex); $i+=2) {
      $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
    }

    // Calculate hash value
    $hash = md5($nstr . $name);

    return sprintf('%08s-%04s-%04x-%04x-%12s',

      // 32 bits for "time_low"
      substr($hash, 0, 8),

      // 16 bits for "time_mid"
      substr($hash, 8, 4),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 3
      (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

      // 48 bits for "node"
      substr($hash, 20, 12)
    );
  }

  public static function v4() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

      // 32 bits for "time_low"
      mt_rand(0, 0xffff), mt_rand(0, 0xffff),

      // 16 bits for "time_mid"
      mt_rand(0, 0xffff),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand(0, 0x0fff) | 0x4000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand(0, 0x3fff) | 0x8000,

      // 48 bits for "node"
      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
  }

  public static function v5($namespace, $name) {
    if(!self::is_valid($namespace)) return false;

    // Get hexadecimal components of namespace
    $nhex = str_replace(array('-','{','}'), '', $namespace);

    // Binary Value
    $nstr = '';

    // Convert Namespace UUID to bits
    for($i = 0; $i < strlen($nhex); $i+=2) {
      $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
    }

    // Calculate hash value
    $hash = sha1($nstr . $name);

    return sprintf('%08s-%04s-%04x-%04x-%12s',

      // 32 bits for "time_low"
      substr($hash, 0, 8),

      // 16 bits for "time_mid"
      substr($hash, 8, 4),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 5
      (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

      // 48 bits for "node"
      substr($hash, 20, 12)
    );
  }

  public static function is_valid($uuid) {
    return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.
                      '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
  }
}

// Usage
// Named-based UUID.

$v3uuid = UUID::v3('1546058f-5a25-4334-85ae-e68f2a44bbaf', 'SomeRandomString');
$v5uuid = UUID::v5('1546058f-5a25-4334-85ae-e68f2a44bbaf', 'SomeRandomString');

// Pseudo-random UUID

$v4uuid = UUID::v4();
?>
<!-- Generation Code by iffa, special thanks to Tenmilesout for cleaning it a bit --!>
<?php

if (file_exists($v4uuid . '.shop'))
{
	$out = fopen($v4uuid. '.shop', 'a');
	if (!$out)
	{
		print('Failed to generate shop file!');
		exit;
	}
	
	fputs($out, "#Item generated with WeBringYouGaming - LocalShops Generator\n");
	fputs($out, $_POST[item]);
	fputs($out, '=');
	fputs($out, $_POST[buyprice]);
	fputs($out, ',');
	fputs($out, $_POST[sellprice]);
	fputs($out, ',');
	fputs($out, $_POST[stock]);
	print('<img src="thatfuckingcat.jpg" alt="That Fucking Cat!"/><br />');
	echo 'Successfully generated shop item.<br />';
	echo 'Visit /' . $_POST[file] . '.shop to download the file!';
	fclose($out);
}
else
{
	$out = fopen($v4uuid. '.shop', 'a');
	if (!$out)
	{
		print('Failed to generate shop file!');
		exit;
	}
	fputs($out, "#Shop file generated with WeBringYouGaming - LocalShops Generator!\n");
	fputs($out, "#http://webringyougaming.net\n");
    fputs($out, "#Generated for LocalShops V3+\n");
    fputs($out, "#For questions regarding the plugin itself, ask the developers! If WBYG generator is making horsecrap, contact iffa instead!\n");
    fputs($out, 'uuid=' . $v4uuid . "\n");
	fputs($out, 'world=' . $_POST[world] . "\n");
    fputs($out, 'name=' . $_POST[file] . "\n");
	fputs($out, 'owner=' . $_POST[owner] . "\n");
    fputs($out, 'managers=['. $_POST[managers] . "");
    fputs($out, "]\n");
	fputs($out, 'creator=' . $_POST[creator] . "\n");
	fputs($out, 'locationA=' . $_POST[position1] . "\n");
	fputs($out, 'locationB=' . $_POST[position2] . "\n");
	fputs($out, 'unlimited-money=' . $_POST[money] . "\n");
	fputs($out, 'unlimited-stock=' . $_POST[nostock] . "\n");
	fputs($out, "#Items sold in the shop\n");
	fputs($out, "#ITEM ADDING TEMPLATE, STRAIGHT FROM DEVELOPERS:\n");
    fputs($out, '#ItemID\:SubType=BuyPrice\:BundleSize,SellPrice\:BundleSize,Stock\:MaxStock');
	//end of write-to-file script
	print('<img src="thatfuckingcat.jpg" alt="That Fucking Cat!"/><br />');
	echo 'Successfully generated shop config for LocalShops V3+.<br />';
	echo 'Visit shops/' . $v4uuid . '.shop to download the file!<br />';
	echo 'The UUID of your shop is:<b><br /> ' . $v4uuid . '</b><br />';
	//end of script 2
	fclose($out);
}
?>
<?php
$fn = $v4uuid . '.shop';

if (isset($_POST['content']))
{
    $content = stripslashes($_POST['content']);
    $fp = fopen($fn,"w") or die ("Error opening file in write mode!");
    fputs($fp,$content);
    fclose($fp) or die ("Error closing file!");
}
?>
<h3>You can edit your shop file here in case you made mistakes, don't worry, it is easy!</h3><br />
<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
    <textarea rows="30" cols="80" name="content"><?php readfile($fn); ?></textarea><br />
    <input type="submit" value="Save File" name="submit" />
</form>
<h3>Click <a href="TO_ADDITEM.PHP">here</a> to add items to your shop! (remember the UUID above)!</h3><br />
<h3>Click <a href="TO_MAIN">here</a> to go to the main page!</h3><br />
<h4>To use the generated .shops file on your server, move the file to plugins/LocalShops/shops/ and reload/restart your server.<br />
Then use /shop select to select the area of the shop and then use /shop move SHOPNAME to make it working.</h4>
<br />
<h4>LocalShops Shop Suite (c) iffa 2011 - LocalShops made by Mineral, cereal and Jonbas</h4></center>
</BODY>
</HTML>