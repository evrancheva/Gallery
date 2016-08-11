<html>
<body>
<div id="content">
<?php
  $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'pictures_db';
  

    $mysqli = new mysqli($hostname, $username, $password, $dbname);
    if ($mysqli->connect_errno) {
        die("Error! Failed to connect to MySQL!");
    }
$start=0;
$limit=10;

if(isset($_GET['id']))
{
$id=$_GET['id'];
$start=($id-1)*$limit;
}

 $sql = "select * from iamges LIMIT $start, $limit";
	$query = $mysqli->query($sql);

echo "<ul>";
while($query2=fetch_assoc())
{
echo "<li>".$query2['text1']."</li>";
}
echo "</ul>";
$rows=mysql_num_rows(mysql_query("select * from pagination"));
$total=ceil($rows/$limit);

if($id>1)
{
echo "<a href='?id=".($id-1)."' class='button'>PREVIOUS</a>";
}
if($id!=$total)
{
echo "<a href='?id=".($id+1)."' class='button'>NEXT</a>";
}

echo "<ul class='page'>";
for($i=1;$i<=$total;$i++)
{
if($i==$id) { echo "<li class='current'>".$i."</li>"; }

else { echo "<li><a href='?id=".$i."'>".$i."</a></li>"; }
}
echo "</ul>";
?>
</div>
</body>
</html>