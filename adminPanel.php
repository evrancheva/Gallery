<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
Logged Person : <?php echo $_COOKIE['LoggedPerson']; ?>
<a href="logout.php"> Log out </a>
<br><br>
<?php
if (isset($_FILES['file']) && isset($_POST['category'])) {
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $type = $_FILES['file']['type'];
    $temporary_name = $_FILES['file']['tmp_name'];
    $location = 'uploads/';
    $nameCopy = $name;


    $category_id = intval($_POST['category']);


    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'pictures_db';


    $mysqli = new mysqli($hostname, $username, $password, $dbname);
    if ($mysqli->connect_errno) {
        die("Error! Failed to connect to MySQL!");
    }


    $total = count($_FILES['file']['name']);

    for ($i = 0; $i < $total; $i++) {

        $tmpFilePath = $_FILES['file']['tmp_name'][$i];
     
		if ($tmpFilePath != "") {
             $id = uniqid();
             $name = $id . '.jpeg';

             $newFilePath = $location . $name;


             if (move_uploaded_file($tmpFilePath, $newFilePath)) {


                 $locationName = $location . $name;
                 $size = $_FILES['file']['size'][$i];
                 $query = $mysqli->prepare("INSERT INTO images (name,size,path,category_id) VALUES(?,?,?,?)");
                 $query->bind_param("sisi", $name, $size, $locationName, $category_id);
                 $query->execute();

                 if ($query->affected_rows == 1) {

                     echo "<p>Picture uploaded</p>";
                 } else {
                     echo "<span style='color:red;'>The picture is in the gallery!</span><br><br>";
                 }
             
         }
     }
    }


    if (!isset($_COOKIE['LoggedPerson'])) {

        header('Location: loginPictures.php');


    }

}

?>

<form action="adminPanel.php" method="POST" enctype="multipart/form-data">

    <p> Choose files to upload</p>
    <input type="file" name="file[]" value="Choose a file" multiple>
    <br><br>


    <span> Choose Category </span>
    <select name="category">
        <option value="1">Dogs</option>
        <option value="2">Cats</option>
        <option value="3">Birds</option>
    </select>
    <br><br>
    <input type="submit" value="Upload Image">
    <br><br>
</form>
<form action="reviewGallery.php" method="POST">
    <input type="submit" value="Review pictures">
</form>
</body>
</html>

