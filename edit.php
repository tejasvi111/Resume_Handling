<?php
session_start();
require_once "pdo.php";
if(isset($_POST['cancel']))
{
	header("location:index.php");
	return;
}	
if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline'])
 && isset($_POST['summary']) && isset($_POST['profile_id']) && isset($_POST['save'])) 
  { 
    if(strlen($_POST['first_name'])>0 && strlen($_POST['last_name'])>0 && strlen($_POST['email'])>0 && strlen($_POST['headline'])>0 && strlen($_POST['summary'])>0)
    {
      /*$make=$_POST['make']; $year=$_POST['year']; $mileage=$_POST['mileage']; $model=$_POST['model'];
       if(!is_numeric($year)) 
       {
          $_SESSION['error1']="Year must be numeric";
          $f=1;
       }
       if(!is_numeric($mileage))
       {
          $_SESSION['error3']="Mileage must be numeric";
          $f=1;
       }
       if(strlen($make)<1)
       {
          $_SESSION['error2']="Make is required";
          $f=1;
       }
    if($f!=1)
       {*/
        if(substr_count($_POST['email'],"@")==0)
        $_SESSION['error1']="User name must contain @";
      else{
        $stmt = $pdo->prepare('update profile set first_name= :f, last_name= :l, email= :e, headline= :h, summary= :s
		    where profile_id= :profile_id');
            $stmt->execute(array(
            	':profile_id' => $_POST['profile_id'],
                ':f' => htmlentities($_POST['first_name']),
                ':l' => htmlentities($_POST['last_name']),
                ':e' => htmlentities($_POST['email']),
                ':h' => htmlentities($_POST['headline']),
                ':s' => htmlentities($_POST['summary'])));
        $_SESSION['successset']="Record updated";
        header("location: index.php");
        return;
      }
//}
}
else{
   $_SESSION['error1']="All values are required";
 }

}


$st=$pdo->prepare("Select * from profile where profile_id=:zip1");
$st->execute(array(":zip1"=> $_GET['profile_id']));
$row= $st->fetch(PDO::FETCH_ASSOC);
if($row===false)
{
	$_SESSION['errordel']="Bad value for profile_id";
	header("Location:index.php");
	return;
}

$n= $row['first_name'];
$o= $row['last_name'];
$p= $row['email'];
$q= $row['headline'];
$r= $row['summary'];
$s= $row['profile_id'];

?>
<p>Edit User</p>
<?php
     if(isset($_SESSION['error1']))
     {
      $msg1=$_SESSION['error1'];
      echo "<p style='color:red;'>$msg1</p>";
      unset($_SESSION['error1']);
     }
  ?>
  <!doctype html>
  <html>
  <head><title>Tejasvi Mishra Edit</title>
  </head>
  <body>
    
<form method="post">
	First Name:
	<input type="text" id="f" name="first_name" value="<?= $n ?>"/><br>
	Last Name:
	<input type="text" id="l" name="last_name" value="<?= $o ?>"/><br>
	Email:
	<input type="text" id="e" name="email" value="<?= $p ?>"/><br>
  Headline:
  <input type="text" id="h" name="headline" value="<?= $q ?>"/><br>
	Summary:
	<input type="text" id="s" name="summary" value="<?= $r ?>"/><br>
	<input type="hidden" name="profile_id" value="<?= $s ?>"/><br>
	<input type="submit" name="save" value="Save"/>
	<input type="submit" name="cancel" value="Cancel"/>

</form>
</body>
</html>