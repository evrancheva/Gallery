<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php

if(isset($_POST["username"]) && isset($_POST["password"])){
	$username1 = $_POST["username"]; // ' OR 'a'='a
	$password1 = $_POST["password"];
	
	
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'pictures_db';

    $mysqli = new mysqli($hostname, $username, $password, $dbname);
	if($mysqli->connect_errno){
		die("Error! Failed to connect to MySQL");
	}
	$query =$mysqli->prepare("SELECT * FROM users WHERE username=? AND password=?");
	$query->bind_param("ss",$username1,$password1);
	$query->execute();
	$result = $query->get_result();
	
	
	if(!$result){
		die('Error! Failed to process query');
	}
	
	if($result->num_rows>0){
		
		$row = $result->fetch_assoc();
		$userType =$row['type'];
		if($userType =="admin"){
			header("Location: adminPanel.php");
			if (isset($_POST['rememberme'])) {
				setcookie('LoggedPerson',$username1,time() + (86400 * 30),'','','',TRUE);
			}
			else {
            setcookie('LoggedPerson', $username1,false, '', '','',TRUE);
			}
		}
		else{
			header("Location: userPanel.php");
			if (isset($_POST['rememberme'])) {
				setcookie('UserLoggedPerson',$username1,time() + (86400 * 30),'','','',TRUE);
			}
			else {
            setcookie('UserLoggedPerson', $username1,false, '', '','',TRUE);
			}
		}
	}
	else{
		echo "No";
	}
}
else
{
	$username1="";
}
?>

<form method="POST" action="loginPictures.php">
	Login
	<br>
	Username : <input type="text" name="username" value="<?php echo "$username1";?>">
	<br>
	Password : <input type = "password" name="password">
	<br>
	Remember Me: <input type="checkbox" name="rememberme" value="1">
	<br>
	<input type="submit" class="button" name="Submit" value="Submit">
	<br>
	<a href="registrationPictures.php">Register Here!</a>

</form>




</body>
</html>