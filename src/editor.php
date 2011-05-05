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

$content = "";
$success = false;
$error = false;

if(isset($_GET['edit'])) {
    $_POST['edit'] = $_GET['edit'];
}

if(isset($_POST['edit'])) {
    $file = $_POST['edit'];
    $name = $_POST['edit'];
    
    if($_POST['edit'] != "") {
        $file = $common->name2UUID($file);
        
        if($file != false || $file != null) {
            $filename = $config['path'] . (($common->endsWith($file, '.shop')) ? $file : $file . '.shop');
            $FileManager->setFile($filename, true);
            
            echo "<strong>Editing:</strong> {$name} - <small>({$filename})</small>";
            
            if (isset($_POST['content']) && $_POST['content'] != ""){
                if ($FileManager->writable()) {
                    $content = stripslashes($_POST['content']);
                    
                    if($FileManager->write($content)) {
                        $success = "Saved @ " . time();
                        $content = $_POST['content'];
                    } else {
                        $success = "Could not save data!";
                        $content = $_POST['content'];
                    }
                } else {
                    $error = "Cannot save shop data, the file is not writable.";
                    $content = $_POST['content'];
                }
            } else {
                if(!file_exists($filename)) {
                    $error = "File does not exist!";
                } else if($content == "") {
                    $FileManager->read();
                    $content = $FileManager->getSource();
                }
            }
        } else {
            $error = "No shop by that name found.";
        }
    } else {
        $error = "No shop specified!";
    }
} else {
    $error = "No shop specified!";
}

if(!$error):
    if($success){
        echo "<br /><small>{$success}</small>";
    }
?>
<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
    <input type="hidden" name="edit" value="<?php echo $_POST['edit']; ?>" />
    <textarea rows="30" cols="80" name="content"><?php echo $content; ?></textarea><br />
    <input type="submit" value="Save File" name="submit" />
</form>
<?php
else:
?>
<h4><?php echo $error; ?></h4>
<?php
endif;

include($config['template_path'] . $config['template'] . "/footer.php");
