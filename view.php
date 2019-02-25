<?php
session_start();
require_once "pdo.php";
$st=$pdo->prepare("Select * from profile where profile_id=:zip1");
$st->execute(array(":zip1"=> $_GET['profile_id']));
$row= $st->fetch(PDO::FETCH_ASSOC);
if($row===false)
{
	$_SESSION['errordel']="Bad value for profile_id";
	header("Location:index.php");
	return;
}
else{
	echo '<table border="1">'."\n";
	echo "<tr><th>Name</th><th>Email</th><th>Headline</th><th>Summary</th>";
	echo "<tr><td>";
	echo $row['first_name'].' '.$row['last_name'];
    echo "</td><td>";
    echo $row['email'];
    echo "</td><td>";
    echo $row['headline'];
    echo "</td><td>";
    echo $row['summary'];
    echo "</td>";
    echo "</table>\n";
    echo('<a href="index.php">Done</a>');
}
?>
