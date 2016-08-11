<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
Logged Person : <?php echo $_COOKIE['LoggedPerson']; ?>
<a href="logout.php"> Log out </a>
<br><br>
<form action="reviewGallery.php" method="GET">

    <span> Choose Category </span>
    <select name="category">
        <option value="1">Dogs</option>
        <option value="2">Cats</option>
        <option value="3">Birds</option>
    </select>
    <br><br>
    <input type="submit" value="Choose">
    <br><br>
</form>
<?php
if (!isset($_COOKIE['LoggedPerson'])) {

    header('Location: loginPictures.php');


}
if (isset($_GET['category'])) {
	


	
			
	if ((isset($_GET['page'])) == false)
	{
		$page1 = 0;
    }
	elseif($_GET['page'] == "1"){
	
		$page1 = 0;
	}
	else{
		$page = $_GET["page"];
		$page1 =($page*3)-3;
	}
	
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'pictures_db';
    $category_id = $_GET['category'];


    $mysqli = new mysqli($hostname, $username, $password, $dbname);
    if ($mysqli->connect_errno) {
        die("Error! Failed to connect to MySQL!");
    }
    $sql = "SELECT * FROM images WHERE category_id = '$category_id' LIMIT $page1,3";
    $result = $mysqli->query($sql);
    echo '<p> Gallery </p>';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
			
            $imagePath = $row['path'];
            $imageName = $row['name'];
			
            $name = $row['name'];
            echo '<form method="POST" action="adminPanel.php">';
            echo '<img src=' . $imagePath . ' alt=' . $imageName . ' style="padding:30px;border-radius:20px;width:300px;height:200px;"/>';
        }
    } else {
        echo "There are no products in this category";
    }


$sql = "SELECT * FROM images WHERE category_id = '$category_id' ";
    $result = $mysqli->query($sql);
    $count = mysqli_num_rows($result);
    $a = $count / 3;
    $a = ceil($a);
    echo "<br><br>";
    for ($b = 1; $b <= $a; $b++) {
        ?><a href="reviewGallery.php?category=<?php echo $category_id;?>&page=<?php echo $b; ?>"
             style="text-decoration:none;" ><?php echo $b . ' '; ?></a> <?php
    }


}   


?>


</body>
</html>