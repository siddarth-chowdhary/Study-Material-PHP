<?php

error_reporting(E_ALL);

// we first include the upload class, as we will need it here to deal with the uploaded file
include('class.upload.php');

// set variables
$dir_dest = (isset($_GET['dir']) ? $_GET['dir'] : 'test');
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv=content-type content="text/html; charset=UTF-8">
<head>
    <title>class.php.upload test forms</title>

    <style>
        body {
        }
        p.result {
          width: 50%;
          margin: 15px 0px 25px 0px;
          padding: 0px;
          clear: right;
        }
        img {
          float: right;
          background: url(bg.gif);
        }
        fieldset {
          width: 50%;
          margin: 15px 0px 25px 0px;
          padding: 15px;
        }
        legend {
          font-weight: bold;
        }
        fieldset p {
          font-size: 70%;
          font-style: italic;
        }
        .button {
          text-align: right;
        }
        .button input {
          font-weight: bold;
        }
    </style>
</head>

<body>

    <h1>class.upload.php test forms</h1>

<?php
    $handle = new Upload($_FILES['my_field']);
    //$handle->file_max_size = '1M';
    var_dump($handle->file_src_size);

    if ($handle->uploaded) {

        #upload the orignal image

        #control allowed mime types from here
        //$handle->allowed = array('image/*');
        
        $handle->Process($dir_dest.'/1');
        if ($handle->processed) {
            echo '<p class="result">';
            echo '  <b>File uploaded with success</b><br />';
            echo '  File: <a href="'.$dir_dest.'/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a>';
            echo '   (' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB)';
            echo '</p>';

            #create a thumbnail for the image
            #control allowed mime types from here
            #$handle->allowed = array('application/pdf','application/msword', 'image/*');

            $handle->file_new_name_body   = 'image_resized';
            $handle->image_resize         = true;
            $handle->image_x              = 100;
            $handle->image_ratio_y        = true;
            $handle->Process($dir_dest.'/1');
            
            if ($handle->processed) {            
                echo '<p class="result">';
                echo '  <b>File uploaded with success</b><br />';
                echo '  File: <a href="'.$dir_dest.'/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a>';
                echo '   (' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB)';
                echo '</p>';
            } else {
                echo '<p class="result">';
                echo '  <b>File not uploaded to the wanted location</b><br />';
                echo '  Error: ' . $handle->error . '';
                echo '</p>';
            }
        } else {
                echo '<p class="result">';
                echo '  <b>File not uploaded to the wanted location</b><br />';
                echo '  Error: ' . $handle->error . '';
                echo '</p>';
        }

        echo '<pre>';
        echo($handle->log);
        echo '</pre>';

        #delete the temporary files
        $handle-> Clean();

    } else {
        // if we're here, the upload file failed for some reasons
        // i.e. the server didn't receive the file
        echo '<p class="result">';
        echo '  <b>File not uploaded on the server</b><br />';
        echo '  Error: ' . $handle->error . '';
        echo '</p>';
    } 

?>
</body>

</html>
