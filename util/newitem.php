<?php
//Thanks to tenmilesout for the code
//Used to make a new item in the dropdown list if new items come out
$file = fopen('input.txt','r');
while (($data = fgets($file)) !== false)
{
	preg_match('/(^[0-9]+)(?:([:][0-9]+))?([a-zA-Z ]+)/' , $data, $match);
	echo '<option value="' . $match[1] . '\\' . (isset($match[2]) && $match[2] != '' ? $match[2] : ':0') . '">' . trim($match[3]) . "</option>\n";
}
fclose($file);
?>
