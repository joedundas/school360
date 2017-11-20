<!DOCTYPE html>
<html lang="en">
  <head>
    @include('secure.includes.js')
    <link href="../vendors/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="../vendors/fullcalendar/dist/fullcalendar.print.css" rel="stylesheet" media="print">
 <script>

   $('document').ready(function() {

       $("#TSEARCH").html("Click to load");
       $("#TSEARCH").click(function() {
           calendarController.getEvents();
       });



   });

 </script>

  </head>

  <body class="nav-md">


  <span onclick="createModal({view:'modal/new-scheduled-event'})">Click Here</span>

  <span id='TSEARCH' style='padding-left:20px;' >Test Searche</span>
        <!-- page content -->
        <div role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Calendar <small>Click to add/edit events</small></h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Calendar Events <small>Sessions</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id='calendar'></div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

    <!-- calendar modal -->
    <div id="CalenderModalNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">New Calendar Entry</h4>
          </div>
          <div class="modal-body">
            <div id="testmodal" style="padding: 5px 20px;">
              <form id="antoform" class="form-horizontal calender" role="form">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Title</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="title" name="title">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Description</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" style="height:55px;" id="descr" name="descr"></textarea>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary antosubmit">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel2">Edit Calendar Entry</h4>
          </div>
          <div class="modal-body">

            <div id="testmodal2" style="padding: 5px 20px;">
              <form id="antoform2" class="form-horizontal calender" role="form">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Title</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="title2" name="title2">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Description</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" style="height:55px;" id="descr2" name="descr"></textarea>
                  </div>
                </div>

              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary antosubmit2">Save changes</button>
          </div>
        </div>
      </div>
    </div>

    <div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
    <div id="fc_edit" data-toggle="modal" data-target="#CalenderModalEdit"></div>
    <!-- /calendar modal -->

    <!-- FullCalendar -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/fullcalendar/dist/fullcalendar.min.js"></script>


    <!-- FullCalendar -->
    <script>


      function eventsController() {
          var me = this;
          me.cache;
          me.list = [
//              {
//                title: 'All Day Event',
//                start: new Date(2017, 10, 1)
//              },
//              {
//                title: 'Long Event',
//                start: new Date(2017, 10, 20 - 5),
//                end: new Date(2017, 10, 20 - 2)
//              }
          ];
          me.fetch = function(params,passBackToReceive) {

              if(typeof params !== 'object') { params = {}; }
              if(typeof passBackToReceive === undefined) { passBackToReceive = false; }


              ajaxFeed(
                  {
                      'url': 'api/events/search',
                      'loader': 'body',
                      'stopSubsequentAttemptsUntilComplete': true,
                      'data': params,
                      'submitType': 'POST',
                      'successCallback': me.receive,
                      'passthru':passBackToReceive
                  }
              );
          };
          me.receive = function(dta,callback) {

              var results = dta.passback;
              for(var i=0; i<results.items.length; i++) {
                  me.list[me.list.length] = me.convertToFullCalendarObject(results.items[i]);
              }

              if(typeof callback === 'function') { callback(); }
          };

          me.deleteEventsList = function() {
              me.list = [];
          }

          me.convertToFullCalendarObject = function(event) {
             // alert(JSON.stringify(event));
              return {
                  title:event.schedule.eventName,
                  //title:event.meta.eventGroupId,
                  start:new Date(event.schedule.startTime),
                  end:new Date(event.schedule.endTime),
                  eventId:event.meta.eventId
              };
          }
          me.asArray = function() {
              return me.list;
          }
      }

      function calendarController(eventsController) {
          var me = this;
          me.events = eventsController;


          me.currentDate = new Date();
          me.calendar = '';


          me.getCalendarDateRange = function() {
              var calendar = me.calendar.fullCalendar('getCalendar');
              var view = calendar.view;
              var start = view.start._d;
              var end = view.end._d;
              var dates = { start: start, end: end };
              return dates;
          }


          me.setDate = function(date) {
              me.currentDate = date;
          };
          me.getMonth = function(adjust) {
              if(typeof adjust == 'undefined') { adjust = false; }
              var add = adjust == true ? 1 : 0;
              return me.currentDate.getMonth() + add;
          }
          me.getDay = function() {
              return me.currentDate.getDate();
          }
          me.getDayOfWeek = function() {
              return me.currentDate.getDay();
          }
          me.getYear = function() {
              return me.currentDate.getFullYear();
          }

          me.getEvents = function() {
              var dates = me.getCalendarDateRange();
              var searchParams = {
                  beginDate : dates.start,
                  endDate: dates.end
              };
              me.events.fetch(searchParams,me.renderEventsToCalendar);
          }

          me.renderEventsToCalendar = function() {

              var list = me.events.asArray();

              me.calendar.fullCalendar('renderEvents',list,true);
          }

          me.initiateCalendar = function() {

             me.calendar = $('#calendar').fullCalendar({
                 header: {
                     left: 'prev,next today',
                     center: 'title',
                     right: 'month,agendaWeek,agendaDay'
                 },
                 selectable: true,
                 selectHelper: true,
                 select: function(start, end, allDay) {
                     createModal({view:'modal/new-scheduled-event','postData':{'startDate':start.format(),'endDate':end.format()}});
                 },
                 eventClick: function(calEvent, jsEvent, view) {
                     createModal({view:'modal/edit-scheduled-event','postData':{'eventId':calEvent.eventId}});
                     calendar.fullCalendar('unselect');
                 },
                 editable: true,


             });
             me.calendar.fullCalendar('addEventSource',me.getEvents);
          }

      }
      var calendarController;
      $(window).load(function() {

          calendarController = new calendarController(
              new eventsController()
          );
          calendarController.getMonth();
          calendarController.initiateCalendar();
//          var date = new Date(),
//              d = date.getDate(),
//              m = date.getMonth(),
//              y = date.getFullYear(),
//              started,
//              categoryClass;

      });

      function getEvents(beginDate,endDate,searchParams) {

      }
    </script>
    <!-- /FullCalendar -->
  </body>
</html>