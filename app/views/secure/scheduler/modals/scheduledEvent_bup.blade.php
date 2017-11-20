<!DOCTYPE html>
<html lang="en">
<head>
    @include('secure.includes.js')
    <link rel="stylesheet" href="/css/global.css">
    <link href="../vendors/jquery-ui/jquery-ui.css" rel="stylesheet">
    <script src="../vendors/jquery-ui/jquery-ui.js"></script>

    <script>


        var mytimezone = 'America/Phoenix';
        $( function() {
            var tabs = $( "#tabs" ).tabs();
            tabs.find( ".ui-tabs-nav" ).sortable({
                axis: "x",
                stop: function() {
                    tabs.tabs( "refresh" );
                }
            });
        } );



        //          $event->companyId = $data['companyId'];
        //          $event->employeeId = $data['employeeId'];
        //          $event->categoryId = $data['categoryId'];
        //          $event->labelId = $data['labelId'];
        //          $event->eventName = $data['eventName'];
        //
        //          $event->addByUserId = $userId;
        var errorHandler = new FormErrorHandler();
        var testingHandler = new JS_FeatureFlip();
        testingHandler.addTestingTag('scheduledEvent', {
            'skipValidation':false
        });

        $('#saveMetaButton').click(

            function(event) {
                event.preventDefault();

                var tmp = getEventMetaInformation();
                alert(JSON.stringify(tmp));
                return true;
                ajaxFeed(
                    {
                        'url': 'api/events/add',
                        'loader':'body',
                        'stopSubsequentAttemptsUntilComplete':true,
                        'data': entryInfo,
                        'submitType': 'POST',
                        'successCallback': receiveSaveResults
                    }
                );
            }
        );

        function receiveSaveResults(dta) {
            alert(dta);
        }

        function getEventMetaInformation() {
            return validateAndPrepareEventMetaInformation(getFormResults(document.getElementById('EventMetaInformationForm')));
        }
        function validateAndPrepareEventMetaInformation(obj) {
            errorHandler.clearErrors();
            var validatedData = validate(obj)
            if(errorHandler.hasErrors()) {
                errorHandler.attachErrorsToFormElements();
                return false;
            }
            return {
                'companyId':1,
                'eventName':obj.eventName.trim(),
                'allday':(obj.eventType == 'allday') ? 1 : 0,
                'InitialDate':obj.startDateMoment,
                'startDateTime':obj.startDateTimeMoment,
                'endDateTime':obj.endDateTimeMoment,
                'startTime':obj.startTimeMoment,
                'endTime':obj.endTimeMoment,
                'hasRecurrence':0

            };

        }
        function validate(obj) {

            // Add to obj some values that help with validation (e.g. moments)
            obj.eventType = getSelectedRadioButton('eventType').val();
            obj.startDateMoment = moment(obj.startDate.trim(), 'MM/DD/YYYY',true);
            obj.endDateMoment = moment(obj.endDate.trim(), 'MM/DD/YYYY', true);
            obj.startTimeMoment = moment.tz(obj.startTime.trim(),['hh:mm A', 'h:mm A'],mytimezone,true);
            obj.endTimeMoment = moment(obj.endTime.trim(),['hh:mm A', 'h:mm A'],true);
            obj.startDateTimeMoment = moment(obj.startDate.trim() + " " + obj.startTime.trim(),['MM/DD/YYYY hh:mm A','MM/DD/YYYY h:mm A'], true);
            obj.endDateTimeMoment = moment(obj.endDate.trim() + " " + obj.endTime.trim(),['MM/DD/YYYY hh:mm A','MM/DD/YYYY h:mm A'], true);
            obj.validDateTimes = (obj.startDateTimeMoment.isValid() && obj.endDateTimeMoment.isValid());
            obj.validDates = (obj.startDateMoment.isValid() && obj.endDateMoment.isValid());

            alert(JSON.stringify({'stime':obj.startTimeMoment, 'etime':obj.endTimeMoment}));
            if(testingHandler.getTestingParameter('scheduledEvent','skipValidation')) { return true; }

            if(obj.eventName.trim() === '') {
                errorHandler.addError('eventName','You must give an event name');
            }
            if(!obj.validDateTimes && !obj.startDateMoment.isValid()) {
                errorHandler.addError('startDate',obj.startDate === '' ? 'Date is required' : 'Valid format is MM/DD/YYYY');
            }
            if(!obj.validDateTimes && !obj.endDateMoment.isValid()) {
                errorHandler.addError('endDate',obj.endDate === '' ? 'Date is required' : 'Valid format is MM/DD/YYYY');
            }

            if(obj.eventType == 'range') {
                RangeTypeValidationHelper(obj);
            }
            if(obj.eventType == 'allday') {
                AllDayTypeValidationHelper(obj);
            }

        }
        function RangeTypeValidationHelper(obj) {

            if(!obj.validDateTimes && !obj.startTimeMoment.isValid()) {
                errorHandler.addError('startTime',obj.startTime === '' ? 'Time is required' : 'Valid format is HH:MM A');
            }
            if(!obj.validDateTimes && !obj.endTimeMoment.isValid()) {
                errorHandler.addError('endTime',obj.endTime === '' ? 'Time is required' : 'Valid format is HH:MM A');
            }

            // The following logic block need only be run if the dates/times are valid.
            if(obj.validDateTimes) {
                // Check if end date/time is greater than start/date time.
                if (obj.endDateTimeMoment.diff(obj.startDateTimeMoment) < 0) {
                    errorHandler.addError('endDate', 'To date must be after from date')
                }
            }

        }
        function AllDayTypeValidationHelper(obj) {
            if(obj.validDates) {
                // Check if end date/time is greater than start/date time.
                if (obj.endDateMoment.diff(obj.startDateMoment) < 0) {
                    errorHandler.addError('endDate', 'To date must be after from date')
                }
            }
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

          <div class="x_content" >
              <div id="tabs">
                  <ul>
                      <li><a href="#tabs-general">General</a></li>
                      <li><a href="#tabs-customers"><?php echo ucfirst(TerminologyController::replaceStringWithTerminology('%%customer.plural%%')); ?></a></li>
                      <li><a href="#tabs-employees"><?php echo ucfirst(TerminologyController::replaceStringWithTerminology('%%employee.plural%%')); ?></a></li>
                      <li><a href="#tabs-recurrence">Recurrence</a></li>
                      <li><a href="#tabs-labels">Labels</a></li>
                      <li><a href="#tabs-billing">Billing</a></li>
                  </ul>
                  <div id="tabs-general">
                      @include('secure.scheduler.modals.general')
                  </div>
                  <div id="tabs-customers">
                      @include('secure.scheduler.modals.customers')
                  </div>
                  <div id="tabs-employees">
                      @include('secure.scheduler.modals.employees')
                  </div>
                  <div id="tabs-recurrence">
                      @include('secure.scheduler.modals.recurrence')
                  </div>
                  <div id="tabs-labels">
                      @include('secure.scheduler.modals.labels')
                  </div>
                  <div id="tabs-billing">
                      @include('secure.scheduler.modals.billing')
                  </div>
              </div>
          </div>

          <div class="form-group">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  {{--<button type="submit" class="btn btn-primary">Cancel</button>--}}
                  <button id="saveMetaButton" type="submit" class="btn btn-success">Save</button>
              </div>
          </div>
      </div>
  </div>
  </div>



  </body>
</html>




