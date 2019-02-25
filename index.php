<html>
<head><title>Tejasvi Mishra</title></head>
<body>
<h2>Welcome to Resume!</h2>
<?php
require_once "pdo.php";
session_start();
	echo "<h3>Resume:</h3>";
    $stmnt = $pdo->query("Select * from profile");
    $count = $pdo->query("SELECT count(*) FROM profile")->fetchColumn();
    if($count==0)
        echo "<h4>No rows found<br></h4>";
    else
    {
    echo '<table border="1">'."\n";
    echo "<tr><th>Name</th><th>Headline</th>";
    if (isset($_SESSION['name']))
      echo "<th>Action</th>";
    while($row = $stmnt->fetch(PDO::FETCH_ASSOC))
    {
    echo "<tr><td>";
    echo('<a href="view.php?profile_id='.$row['profile_id'].'">'.$row['first_name'].' '.$row['last_name'].'</a>');
    echo ("</td><td>");
    echo(($row['headline']));
    echo ("</td>");
    if(isset($_SESSION['name'])){
      echo ("<td>");
    echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a>/
        <a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
    }
    echo ("</td></tr>\n");
   }
   echo "</table>\n";
   }

   if(isset( $_SESSION['name']))
   {
   if(isset( $_SESSION['successmsg']))
   {
    $msg= $_SESSION['successmsg'];
    echo "<p style='color:green;'>$msg</p>";
    unset($_SESSION['successmsg']);
   }
   if(isset( $_SESSION['successset']))
   {
    $msg= $_SESSION['successset'];
    echo "<p style='color:green;'>$msg</p>";
    unset($_SESSION['successset']);
   }
   if(isset( $_SESSION['errordel']))
   {
    $msg= $_SESSION['errordel'];
    echo "<p style='color:red;'>$msg</p>";
    unset($_SESSION['errordel']);
   }
   if(isset( $_SESSION['successdel']))
   {
    $msg= $_SESSION['successdel'];
    echo "<p style='color:green;'>$msg</p>";
    unset($_SESSION['successdel']);
   }
	echo '<a href="add.php">Add New Entry</a><br>';
	echo '<a href="logout.php">Logout</a>';
}
else{
echo '<a href="login.php">Please log in</a>';
}
?>
</body>
</html>