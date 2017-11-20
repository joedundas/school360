<?php
$user = unserialize(Session::get('user'));
$defaultTimezone = $user->getTimezone();

$inputData = isset($_POST['data']) ? $_POST['data'] : array();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    @include('secure.includes.js')
    <link rel="stylesheet" href="/css/global.css">
    <link href="../vendors/jquery-ui/jquery-ui.theme.css" rel="stylesheet">
    <link href="../vendors/jquery-ui/jquery-ui.css" rel="stylesheet">
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../vendors/jquery-ui/jquery-ui.js"></script>


    <link href="../vendors/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
    <link href="/css/global.css" rel="stylesheet">

    <script>

        var inputValues = {
            'eventId': '<?php echo isset($inputData['eventId']) ? $inputData['eventId'] : "NEW" ?>',
            'startDate':'<?php echo isset($inputData['startDate']) ? $inputData['startDate'] : "" ?>',
            'endDate':'<?php echo isset($inputData['endDate']) ? $inputData['endDate'] : "" ?>',
            'allDay':'',
            'location':''

        };
        function parseInitialInput() {

        }
        var controller,errorHandler,testingHandler;


        $('document').ready(function() {

            // Initiate Tabs
            var tabs = $( "#tabs" ).tabs();

            // error handler and testing handler

            errorHandler = new FormErrorHandler();
            testingHandler = new JS_FeatureFlip();
            testingHandler.addTestingTag('scheduledEvent', {
                'skipValidation':false
            });

            initiate_datetimepicker();


            controller = new controller(
                new eventController(new eventModel()),
                new recurrenceController(new recurrenceModel()),
                new formController()
            );
            controller.init(inputValues);
            controller.form.setToDefaultTimezone();
            $('#biz-modal-save-button').click(
                function(event) {
                    event.preventDefault();
                    controller.send(event);
                }
            );


        });


        function formController() {
            var me = this;
            me.setToDefaultTimezone = function() {
               me.setToTimezone(BizSettings.user.timezone);
            }
            me.setToTimezone = function(timezone) {
                $('#timezone').val(timezone);
            }
            me.setDateFieldsBasedOnAllDayIndicator = function() {
                if($("#allDay").prop("checked")) {
                    me.showAllDayFields();
                }
                else {
                    me.showTimeRangeFields();
                }
            }
            me.showAllDayFields = function() {
                $('#startDate').removeClass('hide-me');
                $('#startDateTime').addClass('hide-me');
                $('#endDate').removeClass('hide-me');
                $('#endDateTime').addClass('hide-me');
                $('#timezone').addClass('hide-me');
            }
            me.showTimeRangeFields = function() {
                $('#startDate').addClass('hide-me');
                $('#startDateTime').removeClass('hide-me');
                $('#endDate').addClass('hide-me');
                $('#endDateTime').removeClass('hide-me');
                $('#timezone').removeClass('hide-me');
            }
            me.giveMeStartDate = function() {
                if($("#allDay").prop("checked")) {
                    return $("#startDate").data("DateTimePicker").date();
                }
                else {
                    return $("#startDateTime").data("DateTimePicker").date();
                }
            }
            me.giveMeEndDate = function() {
                if($("#allDay").prop("checked")) {
                    return $("#endDate").data("DateTimePicker").date();
                }
                else {
                    return $("#endDateTime").data("DateTimePicker").date();
                }
            }
            me.read = function() {

               controller.recurrence.readInputForm();
               controller.event.model.eventName = $('#eventName').val().trim();
               controller.event.model.allDayEvent = $('#allDay').is(':checked') ? true : false;
               controller.event.model.timezone = $('#timezone').val();
               controller.event.model.startTime = me.giveMeStartDate().format('MM/DD/YYYY hh:mm A');
               controller.event.model.endTime = me.giveMeEndDate().format('MM/DD/YYYY hh:mm A');
               controller.event.model.duration = moment.duration(me.giveMeEndDate().diff(me.giveMeStartDate())).asHours();
               controller.event.model.locationId = '';
               controller.event.model.recurrence = controller.recurrence.model.type == 'none' ? false : controller.recurrence.model;
               controller.event.model.employees = {};
               controller.event.model.customers = {};
               if(typeof controller.recurrence.model.ends.on == 'object') {
                   controller.recurrence.model.ends.on = controller.recurrence.model.ends.on.format('MM/DD/YYYY');
               }
            }
            me.show = function() {
                 alert(JSON.stringify(controller.event.model));
            }
        }



        function controller(event,recurrence,form) {
            var me = this;
            me.event = event;
            me.recurrence = new recurrenceController(new recurrenceModel());
            me.form = form;
            me.postData;

            me.init = function(inData) {
                me.postData = inData;
                //displayModalSetTitle("Fofofofo");
                if(me.postData.eventId === 'NEW') {

                    //var target = $(this).parent();
                    //target.('#myModalLabel');
                    //alert(target);
                   // $('#myModalLabel', parent.document).text("Poop");

                }
                else {
                    displayModalSetTitle('Edit Event ID: ' + me.postData.eventId)
                }
                me.form.setDateFieldsBasedOnAllDayIndicator();
                $("#allDay").change(function() {
                    me.form.setDateFieldsBasedOnAllDayIndicator();
                });
                me.recurrence.readInputForm();
            }

            me.validate = function() {
                // Add to obj some values that help with validation (e.g. moments)
//                obj.eventType = getSelectedRadioButton('eventType').val();
//                obj.startDateMoment = moment(obj.startDate.trim(), 'MM/DD/YYYY',true);
//                obj.endDateMoment = moment(obj.endDate.trim(), 'MM/DD/YYYY', true);
//                obj.startTimeMoment = moment.tz(obj.startTime.trim(),['hh:mm A', 'h:mm A'],mytimezone,true);
//                obj.endTimeMoment = moment(obj.endTime.trim(),['hh:mm A', 'h:mm A'],true);
//                obj.startDateTimeMoment = moment(obj.startDate.trim() + " " + obj.startTime.trim(),['MM/DD/YYYY hh:mm A','MM/DD/YYYY h:mm A'], true);
//                obj.endDateTimeMoment = moment(obj.endDate.trim() + " " + obj.endTime.trim(),['MM/DD/YYYY hh:mm A','MM/DD/YYYY h:mm A'], true);
//                obj.validDateTimes = (obj.startDateTimeMoment.isValid() && obj.endDateTimeMoment.isValid());
//                obj.validDates = (obj.startDateMoment.isValid() && obj.endDateMoment.isValid());

//                alert(JSON.stringify({'stime':obj.startTimeMoment, 'etime':obj.endTimeMoment}));
//                if(testingHandler.getTestingParameter('scheduledEvent','skipValidation')) { return true; }

                if(controller.event.model.eventName.trim() === '') {
                    errorHandler.addError('eventName','You must give an event name');
                }
//                if(!obj.validDateTimes && !obj.startDateMoment.isValid()) {
//                    errorHandler.addError('startDate',obj.startDate === '' ? 'Date is required' : 'Valid format is MM/DD/YYYY');
//                }
//                if(!obj.validDateTimes && !obj.endDateMoment.isValid()) {
//                    errorHandler.addError('endDate',obj.endDate === '' ? 'Date is required' : 'Valid format is MM/DD/YYYY');
//                }
//
//                if(obj.eventType == 'range') {
//                    RangeTypeValidationHelper(obj);
//                }
//                if(obj.eventType == 'allday') {
//                    AllDayTypeValidationHelper(obj);
//                }
            }
            me.prepare = function() {
                errorHandler.clearErrors();
                me.form.read();
                me.validate();
                //var validatedData = validate(obj)
                if(errorHandler.hasErrors()) {
                    errorHandler.attachErrorsToFormElements();
                    return false;
                }
                return true;

            }

            me.send = function() {

                if(controller.prepare() === true) {

                    ajaxFeed(
                        {
                            'url': 'api/events/add',
                            'loader': 'body',
                            'stopSubsequentAttemptsUntilComplete': true,
                            'data': me.event.model,
                            'submitType': 'POST',
                            'successCallback': me.receiveSaveResults
                        }
                    );
                }
            }
            me.receiveSaveResults = function(dta) {
                alert(JSON.stringify(dta));
            }

        }

        function eventModel() {
            var me = this;
            me.eventName = '';
            me.eventType = '';
            me.allDayEvent = false;
            me.startTime = '';
            me.endTime = '';
            me.InitialDate = '';
            me.duration = '';
            me.hasRecurrence = false;
            me.locationId = '';
            me.recurrence = {};
            me.employees = {};
            me.customers = {};

        }
        function eventController(model) {
            var me = this;
            me.model = model;


        }

    </script>
</head>
  <body class="nav-md">
<?php
    $labelClass = "control-label col-md-2 col-sm-2 col-xs-12";
?>


<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">

            <div class="x_content">


                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_general" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Schedule Info</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Notes</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Billing Info</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_general" aria-labelledby="home-tab">
                            @include('secure.scheduler.modals.general')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                            <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                                booth letterpress, commodo enim craft beer mlkshk aliquip</p>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                            <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                                booth letterpress, commodo enim craft beer mlkshk </p>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<script src="../vendors/moment/min/moment.min.js"></script>
<script src="../vendors/moment/src/moment-timezone-with-data.js"></script>
<script src="../vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="/js/scheduler/newEventEntryForm.js"></script>
<script>



    function initiate_datetimepicker() {
        // Date Time Pickers
        $('#recurrenceEndDate').datetimepicker({
            format: 'MM/DD/YYYY',
            allowInputToggle:true,
            inline:false,
            keepOpen:false
        });
        $('.recurrence-controller').change(function() {
            controller.recurrence.readInputForm();

        });
        // Had to make a specfic call to this on datetimepicker field,
        //  as just changing the date was not firing it on the 'change' above.
        $('#recurrenceEndDate').on('dp.change',function() {
            controller.recurrence.readInputForm();
        });

        $('#startDateTime').datetimepicker({
            allowInputToggle:true,
            toolbarPlacement: 'top',
            showTodayButton:true,
            showClose:true,
            sideBySide:true,
            keepOpen:false,
            defaultDate:moment().minute(Math.ceil(moment().minute() / 15) * 15)
        }).on('dp.change',function(e){
            // If changes start time to be after the current end time.  Attempt to adjust the end time to the same
            //   duration.
            var duration = moment.duration($('#endDateTime').data('DateTimePicker').date().diff(e.oldDate));
            var hours = duration.asHours();
            if(e.date >= $('#endDateTime').data('DateTimePicker').date()) {
                $('#endDateTime').data('DateTimePicker').date(e.date.add(hours,'hours'));
            }
            $('#endDateTime').data('DateTimePicker').minDate($('#startDateTime').data("DateTimePicker").date().add(1,'minutes'));

            controller.recurrence.setMinDateForRecurrenceBasedOnThisDate(e);
            controller.recurrence.readInputForm();

        });
        $('#endDateTime').datetimepicker({
            allowInputToggle:true,
            toolbarPlacement: 'top',
            showTodayButton:true,
            showClose:true,
            sideBySide:true,
            defaultDate:moment().minute(Math.ceil(moment().minute() / 15) * 15).add(1,'hours'),
            minDate:$("#startDateTime").data('DateTimePicker').date().add(1,'minutes')

        });
        $('#endDateTime').data('DateTimePicker').date($('#startDateTime').data("DateTimePicker").date().add(1,'hours'));
        $('#startDate').datetimepicker({
            format:'MM/DD/YYYY',
            allowInputToggle:true,
            toolbarPlacement: 'top',
            showTodayButton:true,
            showClose:true,
            sideBySide:true,
            defaultDate:moment().minute(Math.ceil(moment().minute() / 15) * 15)
        }).on('dp.change',function(e){
            // If changes start time to be after the current end time.  Attempt to adjust the end time to the same
            //   duration.
            var duration = moment.duration($('#endDate').data('DateTimePicker').date().diff(e.oldDate));
            var days = duration.asDays();
            if(e.date >= $('#endDate').data('DateTimePicker').date()) {
                $('#endDate').data('DateTimePicker').date(e.date.add(days,'days'));
            }
            $('#endDate').data('DateTimePicker').minDate($('#startDate').data("DateTimePicker").date());
            controller.recurrence.readInputForm();
        });
        $('#endDate').datetimepicker({
            format:'MM/DD/YYYY',
            allowInputToggle:true,
            toolbarPlacement: 'top',
            showTodayButton:true,
            showClose:true,
            sideBySide:true,
            defaultDate:moment().minute(Math.ceil(moment().minute() / 15) * 15).add(1,'hours'),
            minDate:$("#startDate").data('DateTimePicker').date()

        });
        $('#endDate').data('DateTimePicker').date($('#startDate').data("DateTimePicker").date());
    }
</script>

  </body>
</html>




