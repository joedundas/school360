<?php
$goToPage = '';
$SESSION = array(
  'user'=> Session::get('user'),
    'currentSchool'=>Session::get('currentSchool')
);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $SESSION['currentSchool']['name']; ?>  </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">

    <script>

    </script>
</head>

<body class="nav-md">



<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="index.html" class="site_title"><i class="fa fa-paw"></i>
                        <span>
                        <?php echo $SESSION['currentSchool']['name']; ?>
                        </span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                @include('secure.includes.sidebar.quick-user-info')
                <!-- /menu profile quick info -->

                <br />

                <!-- sidebar menu -->
                @include('secure.includes.sidebar.menu')
                <!-- /sidebar menu -->


            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
        @include('secure.includes.topbar.layout')
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main" id="pageMainContent">
          @include('secure.includes.limbo')
            {{--@include('secure.dashboard.admin.layout')--}}
        </div>
        <!-- /page content -->

        <!-- footer content -->
        @include('secure.includes.footer.layout')
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../vendors/fastclick/lib/fastclick.js"></script>





<script src="../build/js/main.js"></script>

<script>

$(document).ready(function() {

    initiate_to_page = "<?php echo $goToPage; ?>";
    if(initiate_to_page == '') {
        initiate_to_page = 'dashboard';
    }
    navigateToPage(initiate_to_page);
    initiate_to_page = '';
});


</script>

</body>
</html>