<?php 
if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }
$path=Client::get_path();
include_once($path."php/DBConnect.php");
class Client{

      public static function get_path(){
           return $_SERVER['DOCUMENT_ROOT']."/lawyers/";
           /* if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
                  $uri = 'https://';
            } else {
                  $uri = 'http://';
            }
      
            $uri .= $_SERVER['HTTP_HOST']."/";
            return $uri ;*/
      }
/**** login page methods  */
/** puts the privilage of thie user in the session */
public static function put_privilages_in_session($user_id){
      $conn= DBConnect::getConnection();
      if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      }
             $sql="SELECT * FROM privilages where user_id=$user_id";
             $result=$conn->query($sql);
             if ($result->num_rows ==0 ){ 
                echo "Error while fetching user privilages";
                }
              else{
                  while($row = $result->fetch_assoc()) {
                        $_SESSION["customers_page"]=$row["customers_page"];
                        $_SESSION["sessions_page"]=$row["sessions_page"];
                        $_SESSION["financial_page"]=$row["financial_page"];
                        $_SESSION["users_page"]=$row["users_page"];
                        $_SESSION["ended_procecutions"]=$row["ended_procecutions"];
                       
                  }  
                  echo  $_SESSION["customers_page"];
                  echo $_SESSION["sessions_page"];
                  echo $_SESSION["financial_page"];
                  echo $_SESSION["users_page"];
                  echo $_SESSION["ended_procecutions"];
            }
}



/****** end login page methods */

    public static function get_customer_name_using_identity_no($identity_number){
        $name="";
        $conn= DBConnect::getConnection();
        if ($conn->connect_error) {
              echo "Connection failed: " . $conn->connect_error;
              }else{
                     $sql=" SELECT name FROM customers where identity_number = $identity_number;";
                     $result=$conn->query($sql);
                     if ($result->num_rows ==0 ) { echo" لا يوجد مستخدم يحمل رقم الهوية هذا \"$identity_number\" ";}
                     else{
                      while($row = $result->fetch_assoc()) {
                      $name=$row["name"];
                      }
                      return $name;
                  }
            }

     }
    public static function get_customer_name_using_procecution_id($procecution_id){
        $name="";
        $conn= DBConnect::getConnection();
              if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
              }
                     $sql="SELECT `name` FROM customers where id=
                     (SELECT customer_id FROM procecutions where id = $procecution_id);";

                     $result=$conn->query($sql);
                     if ($result->num_rows ==0 ) { echo " يرجى التاكد من procecution id لا يوجد مستخدمين ";}
                     else{
                      while($row = $result->fetch_assoc()) {
                      $name=$row["name"];
                      }
                      return $name;
                  }
    }

         // gets all procecution ids for this customer using his identity number
         public static function get_procecution_ids_using_identity_no($identity_number,$office_id){
            $Procecution_ids=array();
         $conn= DBConnect::getConnection();
               if ($conn->connect_error) {
               die("Connection failed: " . $conn->connect_error);
               }
                      $sql="SELECT  id FROM procecutions where customer_id=(
                      SELECT id FROM customers where identity_number= $identity_number and  office_id = $office_id );";
                      $result=$conn->query($sql);
                      if ($result->num_rows ==0 ) { 
                            echo " p u identity error" ;
                      }else{
                       while($row = $result->fetch_assoc()) {
                        $Procecution_ids[]=$row["id"];
                       }
                  }
                       return $Procecution_ids;

               }
    
    
            // gets all procecution ids for this customer using his name
               public  function get_procecution_ids_using_name($name,$office_id){
                $Procecution_ids=array();
             $conn= DBConnect::getConnection();
                   if ($conn->connect_error) {
                   die("Connection failed: " . $conn->connect_error);
                   }
                          $sql="SELECT id FROM procecutions where customer_id=(
                          SELECT id FROM customers where name= \"$name\" and  office_id = $office_id );";   
                          $result=$conn->query($sql);
                          if ($result->num_rows ==0 ) { echo " p u name Error ";}
                          else{
                           while($row = $result->fetch_assoc()) {
                            $Procecution_ids[]=$row["id"];
                           }
                           return $Procecution_ids;
                        }
                   }
                           // gets  procecution id  using  procecution number
         public static function get_procecution_id_using_procecution_no($procecution_number,$office_id){
            $Procecution_id="ex" ;
         $conn= DBConnect::getConnection();
               if ($conn->connect_error) {
               die("Connection failed: " . $conn->connect_error);
               }
              $sql=" SELECT id FROM procecutions where procecution_number = $procecution_number 
              and (select office_id from customers where customers.id = procecutions.customer_id) = $office_id;";
                  
                      $result=$conn->query($sql);
                      if ($result->num_rows ==0 ) { echo $procecution_number.' لا يوجد قضية تحمل هذا الرقم يرجى التأكد من رقم القضية  ';}
                      else{
                       while($row = $result->fetch_assoc()) {
                        $Procecution_id=$row["id"];
                       }
                       
                       return $Procecution_id;
                  }
               }
    
    
                    //  اضافة فاصلة بعد كل رقم قضية وبحطها كلها في سترنج كونديشن
                    public static function format_proc_ids($Procecution_ids){
                        $condition="";
                        foreach($Procecution_ids as $id){
                             $condition.=$id.",";
                        }
                        
                       $condition= substr($condition,0,strlen($condition)-1) ; // delete last index (which will be a , )
                    return $condition;
                  }

                  // برجع ارري فيها ارقام القضايا لهذا المستخدم حسب الاسم او رقم الهوية 
                  public  function get_procecution_numbers_using($key,$office_id){

                        $key_type="name";
                        $msg="يرجى التاكد من أن الاسم صحيح وان هذا المستخدم يوجد له قضايا مسجلة من قبل";
                        // اذا كان الكيي رقم يعني بدو يبحث في رقم الهوية 
                        if(is_numeric($key)){
                              $key_type="identity_number";
                              $msg="يرجى التاكد من أن رقم الهوية صحيح وان هذا المستخدم يوجد له قضايا مسجلة من قبل";
                        }
                        $Procecution_numbers=array();
                     $conn= DBConnect::getConnection();
                           if ($conn->connect_error) {
                           die("Connection failed: " . $conn->connect_error);
                           }
                                  $sql="SELECT procecution_number FROM procecutions where customer_id=(
                                  SELECT id FROM customers where name= \"$name\" and  office_id = $office_id );";   
                                  $result=$conn->query($sql);
                                  if ($result->num_rows ==0 ) { echo $msg;}
                                  else{
                                   while($row = $result->fetch_assoc()) {
                                    $Procecution_numbers[]=$row["id"];
                                   }
                                   return $Procecution_numbers;
                                }
                           }
}