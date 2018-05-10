<?php

$path="C:/xampp/htdocs/Lawyers/";
include($path."php/DBConnect.php");
include($path."php/classes/Client.php");
include_once("functions.php");

$insert_error_messages= array("court"=>"1", "customer"=>"1", "procecution"=>"1", "discount"=>"1", "discount_agent"=>"1");//بخزن فيها كل جمل الخطا الي رح تظهر
function insert_court($court_address,$court_name,$conn){
    global $insert_error_messages;
    $id;
    $sql = "insert into courts (`name`,address) values (\" $court_address\",\"$court_name\")  ;";
    $conn->query($sql);
    if ($conn->query($sql) !== TRUE){
        $insert_error_messages["court"]=$conn->error . "on line".__LINE__; 
        echo json_encode($insert_error_messages); 
       die();
    }
    $sql2="select last_insert_id() as court_id ";
    $result=$conn->query($sql2);
    if($row = $result->fetch_assoc())
    $id=$row["court_id"];
    return $id;
}

function insert_customer($first_name,$father_name,$grand_name,$family_name,$identity_number,$phone_number,$customer_address,$customer_notes,$conn)
{    global $insert_error_messages;
    $office_id=$_SESSION["office_id"];
    $name=$first_name." ".$father_name." ".$grand_name." ".$family_name;
    $id;
    $sql = "insert into customers (name, phone_number,identity_number,address,notes,office_id)
     values(\"$name\",$phone_number,$identity_number,\"$customer_address\",\"$customer_notes\", $office_id)  ;";
    if ($conn->query($sql) !== TRUE){
        $insert_error_messages["customer"]=$conn->error . " on line".__LINE__; 
        echo json_encode($insert_error_messages);
       die( );
    }
    $sql2="select last_insert_id() as customert_id ";
    $result=$conn->query($sql2);
    if($row = $result->fetch_assoc())
    $id=$row["customert_id"];
    return $id;
}
function insert_procecution($procecution_number,$court_id,$procecution_subject,$procecution_value,$procecution_date, $customer_id,$conn){
    global $insert_error_messages;
    $id;
    $sql = "insert into procecutions (procecution_number,court_id,`subject`,`date`,`value`,customer_id) 
    values($procecution_number,$court_id,\"$procecution_subject\",'$procecution_date',$procecution_value,$customer_id);";
    if ($conn->query($sql) !== TRUE) {
        $insert_error_messages["procecution"]=$conn->error . " on line".__LINE__; 
        echo json_encode($insert_error_messages);
        die();
    }
    $sql2="select last_insert_id() as procecution_id ";
    $result=$conn->query($sql2);
    if($row = $result->fetch_assoc())
    $id=$row["procecution_id"];
    return $id;
}
function insert_discount($discount_name,$discount_number,$discount_address,$discount_notes,$procecution_id,$conn){
    global $insert_error_messages;
     $sql = "insert into discounts (name,number,address,notes,procecution_id)
     values(\"$discount_name\",$discount_number,$discount_address,$discount_notes,$procecution_id); ";
      if ($conn->query($sql) !== TRUE) {
        
        $insert_error_messages["discount"]=$conn->error . " on line".__LINE__; 
        echo json_encode($insert_error_messages);
        die();
    }
}
function insert_discount_agent($agent_name,$agent_number,$agent_address,$agent_notes,$procecution_id,$conn){
    global $insert_error_messages;
     $sql = "insert into discount_agent (name,number,address,notes,procecution_id)
    values(\"$agent_name\",\"$agent_number\",\"$agent_address\",\"$agent_notes\",$procecution_id); ";
     if ($conn->query($sql) !== TRUE) {
        $insert_error_messages["discount_agent"]=$conn->error . " on line".__LINE__; 
        echo json_encode($insert_error_messages);
        
       die();
}
}
//$operation=$_POST["operation"];
if($_SERVER["REQUEST_METHOD"]=="POST"){

    if($_POST["operation"]=="insert"){
      
       
                // validate_string() from functions file
                  $office_id=$_SESSION["office_id"];

                  /** customer info */
                   $customer=json_decode($_POST["customer"]);// وصل من البوست سترنج كستمر وبهاي العملية بحوله لاوبجكت 
                   $first_name= validate_string($customer->first_name);
                    $father_name= validate_string($customer->father_name);
                    $grand_name=validate_string($customer->grand_name);
                    $family_name=validate_string($customer->family_name);
                    $identity_number=validate_string($customer->identity_number);
                     $phone_number=validate_string($customer->phone_number);
                    $customer_address= validate_string($customer->customer_address);
                    $customer_notes= validate_string($customer->customer_notes);
      //echo $first_name."<br>".$father_name."<br>".$grand_name."<br>".$family_name."<br>".$identity_number."<br>".$phone_number."<br>".$customer_address."<br>".$customer_notes."<br>";

                   /*** discount info */
                   $discount=json_decode($_POST["discount"]);// وصل من البوست سترنج كستمر وبهاي العملية بحوله لاوبجكت 
                   $discount_name= validate_string($discount->discount_name);
                    $discount_number= validate_string($discount->discount_number);
                    $discount_address=validate_string($discount->discount_address);
                    $discount_notes=validate_string($discount->discount_notes);
                    

              // echo $discount_name."<br>".$discount_number."<br>".$discount_address."<br>".$discount_notes."<br>";

                   /**** agent info */
                   $agent=json_decode($_POST["agent"]);// وصل من البوست سترنج كستمر وبهاي العملية بحوله لاوبجكت 
                   $agent_name= validate_string($agent->agent_name);
                   $agent_number= validate_string($agent->agent_number);
                    $agent_address= validate_string($agent->agent_address);
                    $agent_notes=validate_string($agent->agent_notes);
                    // echo $agent_name."<br>".$agent_number."<br>".$agent_address."<br>".$agent_notes."<br>";

                   /**  court info */
                    $court= json_decode($_POST["court"]);
                    $court_address= validate_string($court->court_address);
                     $procecution_number= validate_string($court->procecution_number);
                     $court_name=validate_string($court->court_name);
                     $procecution_subject=validate_string($court->procecution_subject);
                     $procecution_value=validate_string($court->procecution_value);
                     $procecution_date=$court->procecution_date;
                     

                    // echo $court_address."<br>".$procecution_number."<br>".$court_name."<br>".$procecution_subject."<br>".$procecution_value."<br>".$procecution_date."<br>";

                    $conn =  DBConnect::getConnection();
                     if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    } 
                   $court_id= insert_court($court_address,$court_name,$conn);
                  $customer_id=insert_customer($first_name,$father_name,$grand_name,$family_name,$identity_number,$phone_number,$customer_address,$customer_notes,$conn);
                    $procecution_id=insert_procecution($procecution_number,$court_id,$procecution_subject,$procecution_value,$procecution_date, $customer_id,$conn);
                    insert_discount($discount_name,$discount_number,$discount_address,$discount_notes,$procecution_id,$conn);  
                    insert_discount_agent($agent_name,$agent_number,$agent_address,$agent_notes,$procecution_id,$conn);

                    
                    $conn->close();
                    
                    echo json_encode($insert_error_messages);
        }





}
