<?php
session_start();
require_once "pdo.php";
if(isset($_POST['delete']) && isset($_POST['profile_id']))
{
	$sql= "Delete from profile where profile_id= :zip";
	$stmnt=$pdo->prepare($sql);
	$stmnt->execute(array(':zip'=> $_POST['profile_id']));
	$_SESSION['successdel']="Record deleted";
	header("Location:index.php");
	return;
}
$st=$pdo->prepare("Select first_name, profile_id from profile where profile_id=:zip1");
$st->execute(array(":zip1"=> $_GET['profile_id']));
$row= $st->fetch(PDO::FETCH_ASSOC);
if($row===false)
{
	$_SESSION['errordel']="Bad value for profile_id";
	header("Location:index.php");
	return;
}
?>
<p>Confirm Deleting <?= ($row['first_name'])?></p>
<form method="post" >
<input type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>"/>	
<input type="submit" name="delete" value="Delete"/>
<a href="index.php">Cancel</a>
</form>
