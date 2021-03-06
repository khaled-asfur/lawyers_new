<?php 
session_start();
//$_SESSION["offfice_id"]=0;
//$_SESSION["username"]="ahmad";
include_once("../php/DBConnect.php");
include_once("../php/functions.php");
include_once("../php/classes/Session.php");
include_once("../php/classes/Client.php");
echo $_SESSION["username"];
if(!isset($_SESSION["username"])){
    header("Location: ../html/LogIn.php");
} 
if($_SESSION["sessions_page"]!= 1){
    header("Location: ../html/homePage.php");

}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>الجلسات</title>
        <!-- the css file  for auto complete -->
        <!--<link rel="stylesheet" href="../js/EasyAutocomplete/easy-autocomplete.min.css">-->

        <link rel="stylesheet" href="../css/bootstrap.min.css"/>
        <link rel="stylesheet" href="../css/publicStyle.css"/>
        <link rel="stylesheet" href="../css/as-admin-css.css"/>
        <link rel="stylesheet" href="../css/records.css"/>
          <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>

                        <!-- jquery from cdn -->
                      
    </head>

    <body dir="rtl" >


           
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<!-- the java script file  for auto complete -->
<script src="../js/EasyAutocomplete/jquery.easy-autocomplete.min.js"></script>


        <!--start header-->
        <header>
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="homePage.php"><i class="fas fa-gavel"></i> نظام المحامين</a>
                                <img src="../image/2.jpeg" class="image-header" width="40px" height="40px" id="image-laywer">

                        </div>

                     <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                          <li <?php if($_SESSION["financial_page"]!=1){ echo 'style="display:none"';}?> ><a href="financial%20Records.html">الأمور المالية</a></li>
                          <li<?php if($_SESSION["ended_procecutions"]!=1){ echo 'style="display:none"';}?> ><a href="caseEnded.html">القضايا المنتهية </a></li>
                          <li<?php if($_SESSION["customers_page"]!=1){ echo 'style="display:none"';}?> ><a href="customers.php">الزبائن</a></li>
                          <li   <?php if($_SESSION["users_page"]!=1){ echo 'style="display:none"';}?>><a href="../php/lowyer.php">المستخدمين</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">مرحبا بعودتك!
                                <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                      <li><a href="#"><i class="material-icons">settings</i>الاعدادت</a></li>
                                      <li><a href="../php/logout.php"><i class="material-icons">&#xE314;</i>خروج</a></li>
                                    </ul>
                            </li>
                        </ul>
                    </div>
              </div>
            </nav>
        </header>
        <!--end header-->

    
        <!--Start search box-->
        <div class="container text-center">
                   
                <form class="form-search" METHOD ="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <div class="row" >
                         <input id="name_or_id_search" type="text"  name="name_or_id" size="40" max-length="40" placeholder="ادخل الاسم او رقم الهوية " class="text-search" />
                         <input type="submit" value="بحث" class="btn-search" style="width:83px"/>
                       
                        </div>
                </form>
       
        <div class="row">
                <form class="form-search" autocomplete="on" METHOD ="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <input id="procecution_number_search" name="procecution_number" type="text" size="20" max-length="20" placeholder="ادخل رقم القضية" class="text-search"/>
                    <input type="submit" value="ابحث" class="btn-search" style="width:83px"/>
                </form>
        </div>
        <div class="row">
            <div class="row">
                <button  class="btn btn-primary" id="addNew">اضافة جلسة جديدة<i class="fas fa-plus"></i></button>
            </div>
        </div>
       <!--end search box-->


       <!-- show delete error start-->
       <div  style="display:none" id="error_dialog"  class="row">
           
            <div class="alert alert-danger alert-dismissible show " role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div id="show_Error">
                <!-- the delete error wil be printed here-->
            </div>      
                
            </div>
        </div>
         <!-- show delete error end-->
         <div  style="display:none"   id="success_dialog"  class="row">
            <div class="alert alert-success alert-dismissible " role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <div id="show_success_msg">
                  <!-- the success error will be printed here-->
                </div> 

               
            </div>
        </div>
        
        <section class="table-section container">
            <table id="my_table" class="table-section table-bordered table-condensed table-hover">
                <thead class="thead-light">
                     <th>الاسم </th>
                     <th>رقم القضية</th>
                     <th>رقم الجلسة</th>
                     <th>تاريخ الجلسة</th>
                     <th>تاريخ التذكير</th>
                     <th>وقت التذكير</th>
                     <th>الأحداث</th>
                </thead>
                <tbody>
                        <?php 
                        // ضروري مشان يكتب الاسم ورقم القضية في التكست بوكسز   في ديالوج اضافة جلسة 
                        $name="";
                        $procecution_id="";
                      
                        if($_SERVER["REQUEST_METHOD"]=="POST")
                            {
                                //اذا كانت طريقة البحث هي الاسم او رقم الهوية 
                                if (isset($_POST["name_or_id"])){
                                    $name_or_id=$_POST["name_or_id"];
                                        if(is_numeric($name_or_id)){ 
                                        //اذا كانت هي رقم الهوية 
                                        $identity_number =$_POST["name_or_id"];
                                         $sess=new Session();
                                        $procecution_ids=Client::get_procecution_idS_using_identity_no($identity_number,$_SESSION["office_id"]);
                                        if(!empty($procecution_ids) ){
                                        $str_procecution_ids=client:: format_proc_ids($procecution_ids);// تحويل ارقام القضايا من اري الى سترنج واحد فيه ارقام الجلسات مفصولة ب فواصل
                                        $name=Client::get_customer_name_using_identity_no(123);
                                        $sess->show_sessions_info($str_procecution_ids,$name);
                                        }else { echo " يرجى التأكد من ان  رقم هوية صحيح وان القضية المرتبطة بهذا الموكل غير منتهية  ";}
                                        
                                        } else{
                                        // اذا كانت طريقة البحث هي الاسم
                                        $name=$_POST["name_or_id"];
                                        $sess=new Session();
                                       $procecution_ids=Client::get_procecution_ids_using_name($name,$_SESSION["office_id"]);
                                       if(!empty($procecution_ids) ){
                                       $str_procecution_ids=client:: format_proc_ids($procecution_ids);// تحويل ارقام القضايا من اري الى سترنج واحد فيه ارقام الجلسات مفصولة ب فواصل
                                       $sess->show_sessions_info($str_procecution_ids,$name);    
                                       } else { echo " يرجى التأكد من الاسم";}                            
                                    }


                                }
                                // اذا كانت طريقة البحث هي رقم القضية 
                                if(isset($_POST["procecution_number"])){
                                    $procecution_number=$_POST["procecution_number"];
                                    $sess=new Session();
                                     $procecution_id=Client::get_procecution_id_using_procecution_no($procecution_number,$_SESSION["office_id"]);
                                
                                     
                                    if($procecution_id !=-1 ){
                                       
                                        $name=Client::get_customer_name_using_procecution_id($procecution_id);
                                        $sess->show_sessions_info($procecution_id,$name);
                                    }
                                    else {echo " <br>   يرجى التأكد من رقم القضية ";}
                                }
                            
                            }
                            ?>
                    
                </tbody>
               <!-- <tfoot>
                    <tr>
                        <td colspan="2">يظهر 3 من 10</td>
                        <td colspan="4" class="nextPrevoiusButton">
                        <button type="button" value="arrowLeft" id="arrowRight" class="btn btn-light" disabled><i class="fas fa-angle-double-right"></i></button>
                        <button type="button" value="1" class="btn btn-light" >1</button>
                        <button type="button" value="1" class="btn btn-light">2</button>
                        <button type="button" value="1" class="btn btn-light">3</button>
                        <button type="button" value="arrowLeft" id="arrowLeft" class="btn btn-light"><i class="fas fa-angle-double-left"></i></button>
                        </td>
                    </tr>
                    
                </tfoot>-->
            </table>
        </section>
        
       
        <div class="overlay confirm-delete" id="confirm-delete">
            <div class="container">
                     <div class="close-icons"><span><i onclick="document.getElementById('confirm-delete').style.display='none'" class="fas fa-times"></i></span></div>
                <div class="row">
                    <p class="text-center">هل تريد فعلا حذف هذه الجلسة</p>
                </div>
                <div class="row btn-confirm-delete">
                    <button class="btn btn-success" id="confirm-yes-delete">نعم</button>
                    <button class="btn btn-danger"  onclick="document.getElementById('confirm-delete').style.display='none'">لا</button>
                </div>
            </div>
        </div>
        
          <div class="overlay confirm-edit" id="confirm-edit">
            <div class="container">
                     <div class="close-icons"><span><i onclick="document.getElementById('confirm-edit').style.display='none'" class="fas fa-times"></i></span></div>
                <div class="row">
                    <p class="text-center">هل تريد حفظ التعديلات</p>
                </div>
                <div class="row btn-confirm-delete">
                    <button class="btn btn-success" id="confirm-yes-edit">نعم </button>
                    <button class="btn btn-danger" id="confirm-no" onclick="document.getElementById('confirm-edit').style.display='none'">لا</button>
                </div>
            </div>
        </div>
        
        <!-- ديالوج اضافة جلسة جديدة  -->
        <div class="overlay" class="sec-info" id="add_session_dialog">
            <div class="container">
                <div class="close-icons"><span><i onclick="document.getElementById('add_session_dialog').style.display='none'" class="fas fa-times"></i></span></div>
                <div class="row">

                <div class="row">
                    <form class="form-search" autocomplete="on">
                        <input id="search_name_id_no_input_dialog" type="text"  name="name_or_id" size="40" max-length="40" placeholder="ادخل الاسم او رقم الهوية " class="text-search" />
                        <input id="search_name_id_no_button_dialog" type="submit" value="بحث" class="btn-search" style="width:83px"/>
                     </form>
                </div>
                <div class="row">
                        <form class="form-search" autocomplete="on" >
                            <input id="dialog_search_procecution_number" name="procecution_number" type="text"  size="20" max-length="20" placeholder="ادخل رقم القضية" class="text-search"/>
                            <input type="submit" value="ابحث" class="btn-search" style="width:83px"/>
                        </form>
                </div>

                     <div class="info">
                        <label class="sub-title">رقم الجلسة</label>
                        <input id="session_number"class="info-value" type="text" value="" name="session-number"/>
                    </div>
                     <div class="info">
                        <label class="sub-title">تاريخ الجلسة</label>
                        <input id="session_date"class="info-value" type="date" value="" name="date-session"/>
                    </div>
                    <div class="info">
                        <label class="sub-title">تاريخ التذكير</label>
                        <input id="remind_date" class="info-value" type="date" value="" name="date-remember"/>
                    </div>
                    <div class="info">
                        <label class="sub-title"> وقت التذكير</label>
                        <input id="remind_time" class="info-value" type="time" value="" name="time-remember"/>
                    </div>
                    <div class="info">
                        <label class="sub-title">الاجراءات المقررة على الجلسة</label>
                        <textarea id="actions" class="info-value" name="note"></textarea>
                    </div>
                    
                    <div class="btn-info-section">
                        <button  type="submit" class="btn btn-ligth" id="save">حفظ</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- ديالوج تعديل جلسة -->
        <div class="overlay" class="sec-info" id="update_session_dialog">
            <div class="container">
                <div class="close-icons"><span><i onclick="document.getElementById('update_session_dialog').style.display='none'" class="fas fa-times"></i></span></div>
                <div class="row">

                   <div class="info">
                        <label class="sub-title">اسم الزبون</label>
                        <input id="customer_name_update"  class="info-value" type="text" value=" 
                        <?php if(isset($name)){ echo trim($name);}?>
                        " name="name-customer"/>
                    </div>
                     <div class="info">
                        <label class="sub-title">رقم القضية</label>
                        <input id="procecution_number_update" class="info-value" type="text" value="
                        <?php if(isset($procecution_number)){ echo trim($procecution_number);}?>
                        " name="case-number"/>
                    </div> 

                     <div class="info">
                        <label class="sub-title">رقم الجلسة</label>
                        <input id="session_number_update"class="info-value" type="text" value="" name="session-number"/>
                    </div>
                     <div class="info">
                        <label class="sub-title">تاريخ الجلسة</label>
                        <input id="session_date_update"class="info-value" type="date" value="" name="date-session"/>
                    </div>
                    <div class="info">
                        <label class="sub-title">تاريخ التذكير</label>
                        <input id="remind_date_update" class="info-value" type="date" value="" name="date-remember"/>
                    </div>
                    <div class="info">
                        <label class="sub-title"> وقت التذكير</label>
                        <input id="remind_time_update" class="info-value" type="time" value="" name="time-remember"/>
                    </div>
                    <div class="info">
                        <label class="sub-title">الاجراءات المقررة على الجلسة</label>
                        <textarea id="actions_update" class="info-value" name="note"></textarea>
                    </div>
                    
                    <div class="btn-info-section">
                        <button  type="submit" class="btn btn-ligth" id="save_update_dialog">حفظ</button>
                    </div>
                </div>
            </div>
        </div>
        
        <footer class="text-center">
            <span>
                copyRigth 2018 Medical Clinic.All rigth reserved
                <i class="fa fa-copyright"></i>
            </span>
        </footer>

        <script>
           var options = {
		url: "../php/autocomplete/autocomplete_name_identity.php",
		getValue: "name",
		list: {
			match: {
				enabled: true
			}
		},
		theme: "plate-dark"
	};
    $("#name_or_id_search111111111").easyAutocomplete(options);

    var options1 = {
		url: "../php/autocomplete/autocomplete_name_identity.php",
		getValue: "name",
		list: {
			match: {
				enabled: true
			}
		},
		theme: "plate-dark"
	};
    $("#procecution_number_search11111111").easyAutocomplete(options1);
        /*
    var options = {
			url: "../php/autocomplete/autocomplete_name_identity.php",
		    getValue: "name",
		    list: {
		        match: {
		            enabled: true
		        }
		    },
		    theme: "plate-dark"
		};
		$("#countries").easyAutocomplete(options);
    
    */
    </script>


        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/nicescroll.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
       <script src="../js/records.js"></script>
    </body>
</html>