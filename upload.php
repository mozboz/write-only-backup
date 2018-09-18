<?php
    $currentDir = getcwd();
    $uploadDirectory = "uploads";

    $errors = []; // Store all foreseen and unforseen errors here

    $post_var_name = 'backup';
    $fileName = $_FILES[$post_var_name]['name'];
    $fileSize = $_FILES[$post_var_name]['size'];
    $fileTmpName  = $_FILES[$post_var_name]['tmp_name'];
    $fileType = $_FILES[$post_var_name]['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));

    $bucketName = preg_replace("/[^A-Za-z0-9]/", '', $_POST['bucket']);

    $uploadPath = $currentDir . '/' . $uploadDirectory . '/' . $bucketName;

    if (!file_exists($uploadPath)) {
 	mkdir($uploadPath, 0755);
    }
 		
    $uploadFile = $uploadPath . '/' . basename($fileName); 

    if (file_exists($uploadFile)) {
	$errors[] = "Destination file exists. Bucket $bucketName";
    } 
    if (isset($_POST['submit'])) {

        if ($fileSize > 100 * 1000000) {
            $errors[] = "This file is more than 100MB.";
        }

        if (empty($errors)) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadFile);

            if ($didUpload) {

                $success = "The file " . basename($fileName) . " has been uploaded into bucket ".$bucketName;
            } else {
		$errors[] = "move_uploaded_file() failed";
            }

        } 
    }
    
    foreach ($errors as $error) {
        $errorString .= $error . "\n";
    }

    echo $errorString ? $errorString : "Success";

    $from = "test@dreamhost.com";
    $to = "lewis.james@gmail.com";

    if ($errorString) {
        $subject = "Upload failed";
        $message = $errorString;
    } else {   
        $subject = "Upload complete";
        $message = $success;
    }

    $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);

echo $success;
?>
