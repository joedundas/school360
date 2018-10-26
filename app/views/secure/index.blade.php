<?php
$goToPage = '';
$PAGE = (new SessionManager())->reviveSessionFromCache();


//$loadAuthorizationsFromCache = \Edu3Sixty\SettingsController::getStatus('auth-cache',$PAGE->user->getUserId(),$PAGE->getCurrentSchoolId(),$PAGE->getCurrentRoleId());
//echo "[[" . $PAGE->getCurrentRoleId() . "]]";
//echo "[[" . $loadAuthorizationsFromCache . "]]";
//echo "[[" . $PAGE->authorizations->isAuthorized('add_staff') . "]]";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$PAGE->user->getCurrentSchoolDto()->getName()}}</title>

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

    @include('secure.includes.js')
<style>
    .blind {
        background-color:white;
        display:none;
        position:absolute;
        top:0px;
        left:0px;
        width:100%;
        height:100%;
    }
</style>
    <script>
//        var controller = new controller(
//            new pageController(
//                new modalController(),
//                new workingBlindController()
//            ),
//            new sessionController()
//        );
//
//        var ajax = new ajaxController();


    </script>
</head>

<body class="nav-md">

<?php
//echo "---" . \Edu3Sixty\SettingsController::getStatus('force-logout',6,1,6);
 //echo "||||" . $PAGE->getCurrentSchoolId()  . "--- " . $PAGE->featureFlips->getFeatureFlipStatus('schedule:menu');
//echo Config::get('ajax-routes.auth.class');
       // var_dump($PAGE->featureFlips);
        ?>

<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="index.html" class="site_title"><i class="fa fa-paw"></i>
                        <span>{{$PAGE->user->getCurrentSchoolDto()->getName()}}</span></a>
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


<script src="/build/js/main.js"></script>


{{--<script src="../build/js/main.js"></script>--}}

<script>
function receiveTestResults(dta) {
  // alert(JSON.stringify(dta));
}
$(document).ready(function() {

//    controller.page.ajax.send(
//        {
//          url:'ajax/auth/test',
//            data:{'a':'b'},
//            'callback': {
//              'success':receiveTestResults
//            }
//        }
//    );


//    setTimeout(function() {
//        controller.page.ajax.send(
//            {
//                url:'test2',
//                'callback': {
//                    'success':receiveTestResults
//                }
//            }
//        );
//    },5000);

//
//    return {
//        'submitType':'GET',
//        'dataType':'json',
//        'url':'',
//        'loader': {
//
//        },
//        'blockUntilDone':false,
//        'passthru': {},
//        'sessionFlash':{},
//        'data':{},
//        'verbose':{
//            'showSuccessData':true,
//            'showErrorData':true
//        },
//        'callback': {
//            'error': function() {},
//            'success': function() {}
//        }
//    };
//
//
//
//    'url': 'session/refresh',
//        'loader': {'attachTo':'body','showLoadingGif':true,'hideWhenComplete':false  },
//    'stopSubsequentAttemptsUntilComplete': true,
//        'data': {},
//    'submitType': 'POST',
//        'successCallback': controller.page.reload(1000),
//    controller.blind.show({
////        'attachTo':'body',
////        'spinner': { 'show':false }
//    });

//    var max = 50000;
//    var min = 500;
//    for(var i=0; i<200; i++) {
//            var ctr = ajax.send();
//    }


    initiate_to_page = "<?php echo $goToPage; ?>";
    if(initiate_to_page == '') {
        initiate_to_page = 'dashboard';
    }

    navigateToPage(initiate_to_page);
    initiate_to_page = '';
});

function randomInteger() {
    var max = 1000000;
    var min = 500;
    return Math.floor(Math.random() * (max-min)) + min;
}
</script>

</body>
</html>