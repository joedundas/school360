<?php
$personaId = isset($personaId) ? $personaId : 0;
if($personaId == 0) { $pageViewType = 'add'; }


?>



@include('secure.includes.js');
  @include("secure.personas." . $persona . ".js.form")


<body class="nav-md">
<!-- page content -->
<div role="main">
  <div class="row">
    <div class="page-title">
      @include("secure.personas." . $persona . ".form.title")
    </div>
    <div class="clearfix"></div>
    <div class="row">
      @include("secure.personas." . $persona . ".form.name")
    </div>
  </div>
</div>


<!-- /page content -->



@include("secure.personas.js.form")
