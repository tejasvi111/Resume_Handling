<?php
if(isset($_POST['cancel']))
{
	header("location:index.php");
	return;
}
session_start();
require_once "pdo.php";
if(isset($_POST['login']))
{
	$salt= 'XyZzy12*_';
	if(isset($_POST['email']) && isset($_POST['pass']))
	{
    if(substr_count($_POST['email'],"@")==0)
        $_SESSION['errormsg']="Email must contain @";
      else{
		$check = hash('md5', $salt.$_POST['pass']);
        $stmt = $pdo->prepare('SELECT user_id, name FROM users
                WHERE email = :em AND password = :pw');
        $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ( $row !== false ) 
        {
            $_SESSION['name'] = $row['name'];
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: index.php");
            return;
        }
        else
          $_SESSION['errormsg']="Incorrect pass";
        }   
	}
  header("Location: login.php");
  return;
}
?>

<!doctype html>
<html>
<head><title>Tejasvi Mishra login</title>
  <script type="text/javascript">
 function doValidate() {
    console.log('Validating...');
    try {
        pw = document.getElementById('id_1723').value;
        console.log("Validating pw="+pw);
        if (pw == null || pw == ""  ) {
            alert("Both fields must be filled out");
            return false;
        }
        e = document.getElementById('id_email').value;
        console.log("Validating email="+e);
        if (e == null || e == "" ) {
            alert("Both fields must be filled out");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}
</script>
</head>
<body>
   <?php
  if (isset($_SESSION['errormsg']) ) {
    $failure1=$_SESSION['errormsg'];
    echo('<p style="color: red; font-style:italic;">'.htmlentities($failure1)."</p>\n");
unset($_SESSION['errormsg']);}
?>
   <form method="post">
   	Email
   	<input type="text" name="email" id="id_email"/><br>
   	Password
   	<input type="text" name="pass" id="id_1723"/><br>
   	<input type="submit" onclick="return doValidate();" name="login" value="Log In"/>
   	<input type="submit" name="cancel" value="Cancel"/>
   </form>
</body>
</html>

