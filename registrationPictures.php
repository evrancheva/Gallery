<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
	 <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php


if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["confirmPass"]) && isset($_POST["email"]))
{
    $username1 = (string)$_POST["username"];
    $password1 = ($_POST["password"]);
    $confirmed = ($_POST["confirmPass"]);
    $email = $_POST["email"];
    $len = strlen($username1);


   if ($password1 != $confirmed) {
        echo  "<p>You have entered different passwords!</p>";
    } 
		
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'pictures_db';

    $mysqli = new mysqli($hostname, $username, $password, $dbname);

    if ($mysqli->connect_errno) {
        die("Error! Failed to connect to MySQL!");
    }
			$query = $mysqli->prepare("INSERT INTO users (username,password,email) VALUES(?,?,?)");
            $query->bind_param("sss", $username1, $password1,$email);
            $query->execute();

            if ($query->affected_rows == 1) {
                echo "User successfully added";
            } else {
                die("The username is not available");
            }
}
else
{
	$username1="";
	$email ="";
	
}

?>

<form method="POST" action="registrationPictures.php">

    Username : <input type="text" name="username" value="<?php echo "$username1";?>">
    <br>
    Password : <input type="password" name="password" >
    <br>
    Confirm Password : <input type="password" name="confirmPass">
    <br>
    E-mail: <input type="email" name="email" value="<?php echo "$email";?>">
    <br>
	<input type="submit" class="button" name="Submit" value="Submit">



</form>



</body>
</html>
