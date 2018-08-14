<?php
$name =    $_FILES['file']['name'];

$info =    $_POST['info'];

$newName = substr($name, 0, -4);
$Extension = substr($name, -3, strlen($name));


$counter = 0;

$target_dir = "../Upload/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


if (file_exists($target_file)) {
    $target_file = $target_dir . $newName.$counter.".".$Extension;
    while(file_exists($target_file)){
        $counter = $counter+1;
        $target_file = $target_dir . $newName. $counter.".".$Extension;
    }
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Lo sentimos, solo JPG, JPEG, PNG & GIF son permitidos.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Lo sentimos, tu archivo no pudo ser cargado.";
// if everything is ok, try to upload file
} else {

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        if($counter>0)
            echo "<input type='hidden' value='$newName$counter.$Extension' id='newName'>";
        else {
            echo "<input type='hidden' value='$newName.$Extension' id='newName'>";
        }
        echo "El archivo $newName$counter.$Extension ha sido cargado.";
    } else {
        echo "Oops, hubo un error en la carga, intentelo nuevamente";
    }
}



 ?>
