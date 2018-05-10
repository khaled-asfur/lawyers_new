<?php

$connect = mysqli_connect("localhost", "root", "", "lowyers_website");
if(isset($_POST["id"])&&$_POST['action']=='delete')
{
 $query = "DELETE FROM users  WHERE id = '".$_POST["id"]."'";
 
 if(mysqli_query($connect, $query))
 {
  echo 'Data Deleted';
 }
}
else if(isset($_POST["id"])&&$_POST['checked']=='1')
{
 $value = mysqli_real_escape_string($connect, $_POST["value"]);
 $query = " UPDATE privilages  SET ".$_POST["column_name"]." = ".$value." WHERE user_id = ".$_POST["id"]."";
 if(!mysqli_query($connect, $query))
 {
  echo $query;
 }
}

else if(isset($_POST["id"])&&$_POST['action']=='update')
{
 $value = mysqli_real_escape_string($connect, $_POST["value"]);
 $query = "UPDATE users  SET ".$_POST["column_name"]."='".$value."' WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
  echo 'Data Updated';
 }
}

else if (isset($_POST["name"], $_POST["phone_num"], $_POST["email"])&&$_POST['action']=='insert')
{
    session_start();
 $first_name = mysqli_real_escape_string($connect, $_POST["name"]);
 $phone_num = mysqli_real_escape_string($connect, $_POST["phone_num"]);
 $email = mysqli_real_escape_string($connect, $_POST["email"]);
 $password = mysqli_real_escape_string($connect, $_POST["password"]);
 $office_id=$_SESSION['office_id'];
 
 $query = "INSERT INTO users (name,phone_num,email,office_id,password)  VALUES('$first_name', '$phone_num','$email','$password','$office_id');";
  ;
 if(mysqli_query($connect, $query))
 {
    $nextId=mysqli_fetch_array(mysqli_query($connect,'SELECT MAX(Id)  FROM users'))['0'];

   $query2=" INSERT INTO privilages (user_id)  VALUES('$nextId')";
   if(mysqli_query($connect, $query2)){
    echo 'data insert';
   }
 }
 mysqli_close($connect);
}
?>
