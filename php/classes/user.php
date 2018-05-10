<?php 
include_once("Client.php");
$path=Client::get_path();
include_once($path."php/DBConnect.php");
class User{
    var $user_id;
    var $name;
    var $office_id;
    var $email;
    var $profile_picture_url;
    private $invoked_data=true;// لفحص ااذا جبنا الداتا من الداتا بيز او لا 
    private $log_info=array();
    private $emails=array();
    private static  $conn ;
    function User(){
        if(empty($conn)){
        $c = DBConnect::getConnection();
        $this->conn=$c;
        }
    }

    function get_user_id(){
        if($this->invoked_data==false){
            $this->get_user_info();
        }else 
        return $this->user_id;
    }
    function set_user_id($user_id){
        $this->user_id=$user_id;
    }
    function get_profile_picture_url(){
        if($this->invoked_data==false){
            $this->get_user_info();
        }else 
        return $this->profile_picture_url;
    }
    function set_profile_picture_url($profile_picture_url){
        $this->profile_picture_url=$profile_picture_url;
    }
    function get_email(){
        return $this->email;
    }
    function set_email($email){
        $this->email=$email;
    }
    function get_office_id(){
        if($this->invoked_data==false){
            $this->get_user_info();
        }else 
        return $this->office_id;
    }
    function set_office_id($office_id){
        $this->office_id=$office_id;
    }

    function get_name(){
        if($this->invoked_data==false){
            $this->get_user_info();
        }else 
        return $this->name;
    }
    function set_name($name){
        $this->name=$name;
    }

    function get_user_info(){
        if(empty($this->email)){
            die("You must set the email before fetching user info");
        }
        $conn=$this->conn;
         if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
         }
                $sql1="SELECT id, `name`,  `office_id`, `profile_picture_url` FROM users where email='$this->email'";
                $result1=$conn->query($sql1);
                if ($result1->num_rows ==0 ) { die("no office id was_found");}
                 while($row1 = $result1->fetch_assoc()) {
                    $this->office_id=$row1["office_id"];
                    $this->name=$row1["name"];
                    $this->profile_picture_url=$row1["profile_picture_url"];
                    $this->user_id=$row1["id"];
                 }
         }
    function  get_users_login_info(){
       $conn=$this->conn;
        $emails=array();
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
            $sql="SELECT email,password FROM users;";
            $result=$conn->query($sql);
            if ($result->num_rows > 0) {
             while($row = $result->fetch_assoc()) {
                $mail=$row["email"];
                $password=$row["password"];
                array_push($emails ,$mail);
                $log_info[$mail]=$password;
             }
             }
            return $log_info;
         
     }
}
?>