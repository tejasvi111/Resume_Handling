<?php
session_start();
if(!isset($_SESSION['user_id']))
{
   die("ACCESS DENIED");
   return;
}
if(isset($_POST['cancel']))
{
   header("Location:index.php");
   return;
}
else if(isset($_POST['add']))
{
   if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline'])
 && isset($_POST['summary']) && isset($_SESSION['user_id'])) 
  { 
    if(strlen($_POST['first_name'])>0 && strlen($_POST['last_name'])>0 && strlen($_POST['email'])>0 && strlen($_POST['headline'])>0 && strlen($_POST['summary'])>0)
    {
      if(substr_count($_POST['email'],"@")==0)
        $_SESSION['error1']="Email must contain @";
      else{
    	  require_once "pdo.php";
          $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary)
        VALUES ( :uid, :fn, :ln, :em, :he, :su)');
    $stmt->execute(array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => htmlentities($_POST['first_name']),
        ':ln' => htmlentities($_POST['last_name']),
        ':em' => htmlentities($_POST['email']),
        ':he' => htmlentities($_POST['headline']),
        ':su' => htmlentities($_POST['summary'])));

            $_SESSION['successmsg']="added";//success msg
            header("location:index.php");
            return;
        }
      }
    else
    {
  	   $_SESSION['error1']="All fields are required";
    }
  }
    header("Location: add.php");
    return;
 }
?>

<!DOCTYPE html>
<html>
<head><title>Tejasvi Mishra Add</title></head>
<body>
	<?php
     if(isset($_SESSION['error1']))
     {
     	$msg1=$_SESSION['error1'];
     	echo "<p style='color:red;'>$msg1</p>";
     	unset($_SESSION['error1']);
     }
	?>
	<form method="post">
  First Name:
  <input type="text"  name="first_name" /><br>
  Last Name:
  <input type="text" name="last_name" /><br>
  Email:
  <input type="text" name="email" /><br>
  Headline:
  <input type="text" name="headline" /><br>
  Summary:
  <input type="text" name="summary" /><br>
		<input type="submit" name="add" value="Add" />
		<input type="submit" name="cancel" value="Cancel" />
	</form>
</body>
</html>