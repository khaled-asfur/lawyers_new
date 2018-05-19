
<?php 


include_once($_SERVER['DOCUMENT_ROOT']."/lawyers/"."php/classes/Client.php");
$path=Client::get_path();
//include($path."php/DBConnect.php");
include_once("functions.php");

if($_SERVER["REQUEST_METHOD"]=="GET"){

    $_SESSION["office_id"]=0;
    $operation= $_GET["operation"];

    if($operation=="insert" ){
        // validate_string() from functions file
        $office_id=$_SESSION["office_id"];

        

   $procecution_number= validate_string($_GET["procecution_number"]);
    $session_number= validate_string($_GET["session_number"]);
    $session_date=$_GET["session_date"];
    $remind_date=$_GET["remind_date"];
     $remind_time=$_GET["remind_time"];
     $ended=$_GET["ended"];
    $actions= validate_string($_GET["actions"]);

    if(empty($procecution_number)){ die("يرجى ادخال رقم القضية أولا");}
    if(empty($session_number)){$session_number = 10000 ;}
 if(empty($session_date)){ $session_date = date("Y-m-d");}
 if(empty( $remind_date)){ $d= strtotime("yesterday");  $remind_date =  date("Y-m-d",$d);}
 if(empty($remind_time)){  $d= strtotime("20:00:00"); $remind_time = date("h:i:s",$d);}
 if(empty($actions)){ $actions="-";}
/*
 echo $procecution_number ."<br>";
 echo $session_number."<br>";
 echo $session_date."<br>";
 echo $remind_date."<br>";
 echo $remind_time."<br>";
 echo $actions."<br>";
*/
    $conn =  DBConnect::getConnection();
    
    $procecution_id=Client::get_procecution_id_using_procecution_no($procecution_number,$office_id,$ended);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "INSERT INTO `sessions`( `session_number`, `date`, `actions`, `remind_time`, `remind_date`, `procecution_id`) VALUES
     ($session_number,'$session_date',\"$actions\",'$remind_time','$remind_date',$procecution_id);";
    if ($conn->query($sql) === TRUE) {
        echo "inserted";
    } else {
        echo " Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}


if($operation=="update"){
    $session_number=$_GET["session_number"];
    $session_date=$_GET["session_date"];
    $remind_date=$_GET["remind_date"];
    $remind_time=$_GET["remind_time"];
    $actions=$_GET["actions"];
    $session_id=$_GET["session_id"];

if(empty($session_date)){ $session_date = " 0000-00-00 ";}
if(empty( $remind_date)){  $remind_date = " 0000-00-00 ";}
if(empty($remind_time)){ $remind_time = " 00:00:00 ";}
if(empty($actions)){ $actions = " ";}
   $conn =  DBConnect::getConnection();

   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   } 
   
   $sql = "UPDATE `sessions` SET `session_number`= $session_number,`date`='$session_date',
   `actions`='$actions',`remind_time`='$remind_time',`remind_date`='$remind_date' WHERE id= $session_id";
    
   
   if ($conn->query($sql) === TRUE) {
       echo "updated";
   } else {
       echo "Error: " . $sql . "<br>" . $conn->error;
   }
   $conn->close();
}

if($operation=="get_proc_numbers_from_dialog"){
    $key=$_GET["key"];
   $procecution_numbers= Client::get_procecution_numbers_using($key,$_SESSION["office_id"]);
   
}
}
?>