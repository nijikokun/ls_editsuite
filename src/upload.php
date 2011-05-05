<?php
/*
 * LocalSuite
 * 
 * @author: Nijikokun <nijikokun@gmail.com>
 * @author: iffa
 * @copyright: Copyright (C) 2011
 * @license: GNUv3 Affero License <http://www.gnu.org/licenses/agpl-3.0.html>
 */

include('inc/init.php');
include($config['template_path'] . $config['template'] . "/header.php");

// target place
$target_path = $config['path'];

if(isset($_POST['submit'])){
    $submit = $_POST['submit'];
    
    if(!is_dir($target_path)) {
        @mkdir($target_path, 0777);
    }
    
    $target_path = $target_path . basename($_FILES['file1']['name']);
    $target_path = str_replace("..", "", $target_path);
    
    $ext = substr($_FILES['file1']['name'], strrpos($_FILES['file1']['name'], '.') + 1);
    $ext = strtolower($ext);
    $err = false;
    
    if($ext == "shops" || $ext == "shop"){
        $err = false;
    } else {
        $err = true;
    }
    
    
    if(!$err == true){
        if(move_uploaded_file($_FILES['file1']['tmp_name'], $target_path)) {
            echo "The file ".  basename($_FILES['file1']['name'])." has been uploaded.";
        } else{
            echo "There was an error uploading the file.";
        }
    }
    else{
        echo "Only upload .shop!";
    }
} else {
?>
    <form enctype="multipart/form-data" action="upload.php" method="POST">
        <input name="file1" type="file" /><br />
        <input type="submit" value="Upload" name="submit" />
    </form>
<?php } ?> 
<?php

include($config['template_path'] . $config['template'] . "/footer.php");
