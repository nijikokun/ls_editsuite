<?php
//Thanks to tenmilesout for the code, he is like a second dev on this
if (get_magic_quotes_gpc())
{
	foreach ($_GET as &$a) $a = stripslashes($a);
	foreach ($_POST as &$a) $a = stripslashes($a);
	foreach ($_COOKIE as &$a) $a = stripslashes($a);
}
?>