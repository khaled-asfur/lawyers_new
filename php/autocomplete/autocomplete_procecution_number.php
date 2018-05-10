<?php 
include_once("C:/xampp/htdocs/Lawyers/php/DBConnect.php");
        $procecution_numbers=array();
        $conn= DBConnect::getConnection();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql="SELECT procecution_number FROM procecutions where customer_id = (SELECT id FROM customers where name=\"khaled\");";
        $result=$conn->query($sql);
        if ($result->num_rows ==0 ){ 
            echo "لا يوجد مستخدم يحمل نفس الاسم";
        }
        else{
            while($row = $result->fetch_assoc()) {
                  $procecution_numbers[]=$row["procecution_number"];        
            }
        }
        $myJSON = json_encode($procecution_numbers);
         echo($myJSON);
?>