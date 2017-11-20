<link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<?php


?>
<!-- Custom Theme Style -->
<link href="../build/css/custom.min.css" rel="stylesheet">
<link href="../vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

<style>
    .hide-me {
        display:none;
    }

    .panel {

     }
    .panel .panel-heading {
        padding:7px 15px;
    }
    .panel .panel-heading .panel-title {

    }

</style>
<div>


</div>
<div class="row">
  <div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_content">
            <form class="form-horizontal form-label-left" id="EventMetaInformationForm">
                <div class="form-group" >
                    <label class="<?= $labelClass ?>" >Name </label>
                    <div class="col-md-10 col-sm-10 col-xs-12" >
                        <input type="text" name="eventName" id="eventName" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group" >
                    <label class="<?= $labelClass ?>" >From </label>
                    <div class="col-md-6 col-sm-6 col-xs-12" >
                        <div class='input-group date hide-me' id='startDateTime'>
                            <input type='text' class="form-control" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <div class='input-group date hide-me' id='startDate'>
                            <input type='text' class="form-control" />
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="checkbox col-md-4 col-sm-4 col-xs-2">
                        <select class="recurrence-controller" id="timezone">
                            <?php
                                $timezoneList = Timezones::all();
                                var_dump($timezoneList);
                                foreach($timezoneList as $key=>$zone) {

                                        echo "<option value='" . $zone->conventionalName . "'";
//                                        if($zone->conventionalName === $defaultTimezone) {
//                                            echo " selected ";
//                                        }

                                        echo ">" . $zone->longCode . "</option>";

                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" >
                        <label class="<?= $labelClass ?>">To </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class='input-group date hide-me' id='endDateTime'>
                                <input type='text' class="form-control" />
                                <span class="input-group-addon">
                                   <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <div class='input-group date hide-me' id='endDate'>
                                <input type='text' class="form-control" />
                                <span class="input-group-addon">
                                   <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    <div class="checkbox col-md-4 col-sm-4 col-xs-2">
                        <label>
                            <input type="checkbox" id="allDay" value=""> All Day
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="<?= $labelClass ?>">Location</label>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <input type="text" id="companyId" name="companyId" id="autocomplete-locationId" class="form-control col-md-10"/>
                    </div>
                </div>
                <div class="form-group" >
                    <label class="<?= $labelClass ?>"></label>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="accordion" id="accordion" role="tablist" aria-multiselectable="false">
                            <div class="panel" style="padding:0px">
                                <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <table>
                                        <tr>
                                            <td>
                                                <h4 class="panel-title">
                                                    <i class="fa fa-repeat"></i>
                                                    &nbsp; Repeating
                                                </h4>
                                            </td>
                                            <td style="padding-left:10px">
                                                <span style="font-weight:normal" id="recurrenceSummaryString"></span>
                                            </td>
                                        </tr>
                                    </table>
                                </a>
                                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        @include('secure.scheduler.modals.recurrence')
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <h4 class="panel-title">Teacher</h4>
                                </a>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        @include('secure.scheduler.modals.employees')
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <h4 class="panel-title">Student</h4>
                                </a>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        @include('secure.scheduler.modals.customers')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>



