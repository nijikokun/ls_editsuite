<html>
<head>
<title>WeBringYouGaming - LocalShops Config Generator</title>
</head>
<body>
<center><h2>WeBringYouGaming - Shop Uploader</h2><br />

    <?
    // target place
    $target_path = "shops/";
     
     
    $sub = $_POST['submit'];
    if(isset($sub)){
    if(!is_dir($target_path)){
    @mkdir($target_path, 0777);
    }
    $doRename = $_POST['rename'];
    $rename = $_POST['newname'];
    $target_path = $target_path . basename( $_FILES['file1']['name']);
    $target_path = str_replace("..", "", $target_path);
    $ext = substr($_FILES['file1']['name'], strrpos($_FILES['file1']['name'], '.') + 1);
    $ext = strtolower($ext);
    $err = false;
    if($ext == "shops" || $ext == "shop"){
    $err = false;
    }
    else{
    $err = true;
    }
     
     
    if(!$err == true){
    if(move_uploaded_file($_FILES['file1']['tmp_name'], $target_path)) {
        echo "The file ".  basename( $_FILES['file1']['name']).
        " has been uploaded.";
    } else{
        echo "There was an error uploading the file.";
    }
    }
    else{
    echo "Only upload .shop!";
    }
    }
    else{
    ?>
    <form enctype="multipart/form-data" action="upload.php" method="POST">
    <input name="file1" type="file" /><br />
    <input type="submit" value="Upload" name="submit" />
    </form>
    <?php
    }
    ?> 
<h4>LocalShops Shop Suite (c) iffa 2011 - LocalShops made by Mineral, cereal and Jonbas</h4></center>

</body>
</html>