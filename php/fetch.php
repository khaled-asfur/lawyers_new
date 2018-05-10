<?php
//fetch.php
session_start();

if(isset($_SESSION['user_page'])){
 $connect = mysqli_connect("localhost", "root", "", "lowyers_website");
$columns = array('users.name', 'phone_num');

$query = "SELECT users.id,users.name,phone_num,email,customers_page,sessions_page,financial_page,users_page FROM users  join offices join privilages ON office_id=offices.ID and users.id=privilages.user_id ";

$data ;
if(isset($_POST['checked'])&&$_POST['checked']==1){
 $query = "SELECT * FROM  lowyers_website.privilages  where user_id = ".$_POST['id']. "";

 $result = mysqli_query($connect, $query );
 while($row = mysqli_fetch_array($result))
{
 $data = array(
                    
                   $row["customers_page"],
                     $row["sessions_page"],
                   $row["financial_page"],
                  $row["users_page"],
                    );
 }

echo json_encode($data);
}else{
if(isset($_POST["search"]["value"]))
{
 $query .= '
 WHERE users.name LIKE "%'.$_POST["search"]["value"].'%" 
 OR phone_num LIKE "%'.$_POST["search"]["value"].'%" 
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY id DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();
if(isset($_POST['checked'])&&$_POST['checked']==1){
 while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 
	$sub_array[] = ' <input type="checkbox" class="A1" id='.$row["id"].' checked='.$row["customers_page"].'"> <span class="checkmark"></span> ' ;
 	$sub_array[] = ' <input type="checkbox" class="A2" id='.$row["id"].' checked='.$row["sessions_page"].'"> <span class="checkmark"></span> ' ;
  	$sub_array[] = ' <input type="checkbox" class="A3" id='.$row["id"].' checked='.$row["financial_page"].'"> <span class="checkmark"></span> ' ;
   	$sub_array[] = ' <input type="checkbox" class="A4" id='.$row["id"].' checked='.$row["users_page"].'"> <span class="checkmark"></span> ' ;

 $data[] = $sub_array;
 }
}
while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="name">' . $row["name"] . '</div>';
	$sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="phone_num">' . $row["phone_num"] . '</div>';
	$sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="email">' . $row["email"] . '</div>';
 $sub_array[] = '<button type="button" class="btn btn-primary  btn-xs edit-button " id="'.$row["id"].'">Edit</button> <button type="button" name="delete" class="btn btn-info  btn-xs view-button" id="'.$row["id"].'">View</button> <button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["id"].'">Delete</button>';
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM users  join offices join privilages ON office_id=offices.ID and users.id=privilages.user_id ";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);
}
}

?>