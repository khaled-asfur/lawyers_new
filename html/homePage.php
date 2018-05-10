<?php
session_start();
if(empty($_SESSION["username"])){
    header("Location: ../html/LogIn.php");
}
/*$_SESSION["customers_page"]=1;
$_SESSION["sessions_page"]=0;
$_SESSION["financial_page"]=0;
$_SESSION["users_page"]=1;
$_SESSION["ended_procecutions"]=1;*/
$user_name=$_SESSION["username"] ;
 $office_id=$_SESSION["office_id"] ;
 $profile_picture_url=$_SESSION["get_profile_picture_url"];
/*echo$_SESSION["username"] ."<br>";
echo $_SESSION["office_id"] ."<br>";
echo $_SESSION["get_profile_picture_url"] ."<br>";*/
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>الصفحة الرئيسية </title>
        <link rel="stylesheet" href="../css/bootstrap.min.css"/>
        <!---fonts-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--end font-->
        <link rel="stylesheet" href="../css/as-admin-css.css"/>
        <link rel="stylesheet" href="../css/publicStyle.css"/>
        <link rel="stylesheet" href="../css/homePage.css"/>
    </head>
    <body dir="rtl">
        <header>
            <!--start navbar-->
                <nav class="navbar navbar-default" id="the-sticky-div">
                <div class="container-fluid">
                        <div class="navbar-header navbar-right">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                </button>
                              <a class="navbar-brand " href="#"><h1><span> نظام  </span>المحامين</h1></a>
                             <img src="../image/2.jpeg" class="image-header" width="40px" height="40px" id="image-laywer">
                        </div>

                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                               <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo "مرحبا " . $user_name ?> <span class="caret"></span></a>
                                  <ul class="dropdown-menu navbar-inverse">
                                    <li><a href="#"><i class="material-icons">settings</i>الاعدادات</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="../php/logout.php"><i class="material-icons">&#xE314;</i>خروج</a></li>
                                  </ul>
                                </li>
                              </ul>
                        </div><!-- /.navbar-collapse -->
                  
              </div><!-- /.container-fluid -->
            </nav>
            <!--end navbar-->
            
                <div class="container">
                <div class="row">
                    <section class="header-intro">
                        <div class="img-intro col-md-6 col-xs-12">
                            <img src="../image/3.jpg"/>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <h2 class="h1">نظام إدارة المحامين!</h2>
                            <p>استخدام هذا النظام يسهل عليك سرعة الوصول الى بيانات الموكلين والى القضايا .
ويعمل هذا النظام ضمن تقنية حديثة حيث تعمل على تذكيرك بموعد القضايا وغيرها من التقنيات الحديثة . </p>
                            <button class="btn btn-ligth btn-lg">التعرف على المزيد</button>
                        </div>
                    </section>
                </div>
            </div>
        </header>
        <!--end header section--->
        
        
        <!--start option section-->
            <div class="option text-center">
                <div class="container">
                    <h2 class="h1">الخيارات</h2>
                    <div class="row">

                 
                        <div class="col-md-6 col-sm-6 col-xs-12"  <?php if($_SESSION["customers_page"]!=1){ echo 'style="display:none"';}?>>
                          <a href="customers.php"><img width="105px" height="105px" class="img-circle" src="../image/cust.png"></a>
                            <p class="text-center">الزبائن </p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 even"  <?php if($_SESSION["financial_page"]!=1){ echo 'style="display:none"';}?>>
                            <a href="financial%20Records.html"><img width="105px" height="105px" class="img-circle" src="../image/money.png"/></a>
                            <p class="text-center">الأمور المالية </p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 even"  <?php if($_SESSION["ended_procecutions"]!=1){ echo 'style="display:none"';}?>>
                            <a href="caseEnded.html"><img width="105px" height="105px" class="img-circle" src="../image/endfile.png"/></a>
                            <p class="text-center">القضايا المنتهية</p>
                        </div>
                          <div class="col-md-6 col-sm-6 col-xs-12 even"  <?php if($_SESSION["sessions_page"]!=1){ echo 'style="display:none"';}?> >
                            <a href="records.php"><img width="105px" height="105px" class="img-circle" src="../image/file.png"/></a>
                            <p class="text-center">الجلسات</p>
                        </div>
                        <div class="col-xs-12"  <?php if($_SESSION["users_page"]!=1){ echo 'style="display:none"';}?>>
                            <a href="Lowyer.html"><img width="105px" height="105px" class="img-circle" src="../image/users.png"/></a>
                            <p class="text-center">المستخدمين</p>
                        </div>
                    </div>  
                </div>
            </div>
            
        <!--end option section-->
        
        <footer class="text-center">
            <span>
                تم انتاجه في 2018 .جميع الحقوق محفوظة
                <i class="fa fa-copyright"></i>
            </span>
        </footer>
        
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/nicescroll.js"></script>
        <script src="../js/scroll.js"></script>
        <script src="../js/homePage.js"></script>
    
    </body>
</html>