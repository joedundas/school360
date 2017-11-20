
<?php
    if(!isset($jquery)) {
        $jquery = true;
    }
    if(!isset($global)) {
        $global = true;
    }
    if(!isset($formValidation)) {
        $formValidation = true;
    }
    if(!isset($charset)) {
        $charset = "UTF-8";
    }
?>

<meta charset="{{$charset}}">
<link rel="stylesheet" href="/css/global.css">
@if($jquery)
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endif
@if($formValidation)
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/jquery.validate.helper.js"></script>
@endif
@if($global)
    <script src="/js/global.js"></script>
@endif
@if($jquery)
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endif





