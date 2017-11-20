function recurrenceModel() {
    var me = this;
    me.type = 'none';
    me.every = 1;

    me.daysOfWeek = {
        mon:false,
        tue:false,
        wed:false,
        thu:false,
        fri:false,
        sat:false,
        sun:false
    };

    me.monthly = {
        type:'dom',
        dom: {
            value:'',
            display:''
        },
        dow: {
            day:'',
            weekNumberOfMonth:'',
            weekNumberOfMonthDisplay:'',
            totalOfDaysOfWeekInMonth:''
        }
    }
    me.ends = {
        type:'occurrences',
        occurrences:'30',
        on:''
    }
}
function recurrenceController(model) {
    var me = this;
    me.model = model;


    me.setRecurrenceRepeatLabel = function() {
        var plural = '';
        var label = '';

        if(model.every > 1) { plural = 's'; }
        if(model.type == 'daily') {
            label = 'day';
        }
        else if(model.type == 'monthly') {
            label = 'month';
        }
        else if(model.type == 'yearly') {
            label = 'year';
        }
        else if(model.type.match(/^weekly/)) {
            label = 'week';
        }
        $("#recurrence-repeat-label").html(label + plural);
    }
    me.readInputForm = function() {
        model.type = $('#recurrence-repeat-type').val();
        if(model.type == 'none') {
            $(".recurrence-if-repeats").addClass('hiddenTableRow');
        }
        else {
            $(".recurrence-if-repeats").removeClass('hiddenTableRow');
            if(model.type == 'weekly-weekdays') {
                me.checkDaysOfWeek({mon:true,tue:true,wed:true,thu:true,fri:true});
                me.setDaysOfWeek();
                me.setRecurrenceRepeatLabel('week');
            }
            else if(model.type == 'weekly-mon-wed-fri') {
                me.checkDaysOfWeek({mon:true,wed:true,fri:true});
                me.setDaysOfWeek();
            }
            else if(model.type == 'weekly-tue-thu') {
                me.checkDaysOfWeek({tue:true,thu:true});
                me.setDaysOfWeek();
            }
            else if(model.type == 'weekly-weekends') {
                me.checkDaysOfWeek({sat:true,sun:true});
                me.setDaysOfWeek();
            }
            else if(model.type == 'weekly') {
                var startDate = controller.form.giveMeStartDate().format('ddd').toLowerCase();
                var days = {};
                days[startDate] = true;
                me.checkDaysOfWeek(days,false);
            }


        }

        model.every = $('#recurrence-repeat-every').val();
        me.setMonthlyParameters();
        me.setDaysOfWeek();
        me.setEnds();
        me.toggleDaysOfWeekBasedOnRepeatType();
        me.setRecurrenceRepeatLabel();
        $("#recurrenceSummaryString").html(me.createSummaryString());

    }

    me.setMonthlyParameters = function() {
        model.monthly.type = $("input[name='recurrenceMonthlyRepeatBy']:checked").val();
        if(model.monthly.type == 'dom') {
            model.monthly.dom.value = controller.form.giveMeStartDate().format('D');
            model.monthly.dom.display = controller.form.giveMeStartDate().format('Do');
        }
        else if (model.monthly.type == 'dow') {
            var startDatesDayOfWeek = controller.form.giveMeStartDate().format('ddd').toLowerCase();
            var weekNumberOfMonth = me.getWeekNumberOfMonth(controller.form.giveMeStartDate());

            model.monthly.dow.day = startDatesDayOfWeek;
            model.monthly.dow.weekNumberOfMonth = weekNumberOfMonth;
            model.monthly.dow.weekNumberOfMonthDisplay = me.createNumberWithSuffix(weekNumberOfMonth);
            model.monthly.dow.totalOfDaysOfWeekInMonth = me.getNumberOfDayOfWeekOccurrencesInMonth(controller.form.giveMeStartDate());

        }

    }

    me.getWeekNumberOfMonth = function(targetDate) {
        return Math.ceil(targetDate.date() / 7)
    }
    me.getNumberOfDayOfWeekOccurrencesInMonth = function(targetDate) {
        var lastDayOfWeekOfMonth = me.getLastDayOfWeekOfMonth(targetDate);
        return me.getWeekNumberOfMonth(lastDayOfWeekOfMonth);
    }
    me.getLastDayOfWeekOfMonth = function(targetDate) {
        var dayOfWeek = targetDate.format('d');
        var lastDay = targetDate.endOf('month').startOf('day');
        var lastDow = lastDay.format('d');
        var difference = lastDow - dayOfWeek;
        if(difference == 0) { return lastDay; }
        if(difference > 0)
        {
            return lastDay.subtract(difference,'days');
        }
        else
        {
            return lastDay.add(difference,'days');
        }

    }

    me.createNumberWithSuffix = function(number) {
        if(number == 1) { return number + "st"; }
        if(number == 2) { return number + "nd"; }
        if(number == 3) { return number + "rd"; }
        return number + "th";
    }
    me.checkDaysOfWeek = function(days,eraseCurrentChecked) {
        if(typeof eraseCurrentChecked === 'undefined') { eraseCurrentChecked = true; }
        for(key in model.daysOfWeek) {
            if(key in days) {
                if(days[key]) {
                    $("#rec-" + key).prop("checked", "checked");
                }
                else {
                    $("#rec-" + key).prop("checked", "");
                }
            }
            else {
                if(eraseCurrentChecked) {
                    $("#rec-" + key).prop("checked", "");
                }
            }
        }
    }
    me.toggleDaysOfWeekBasedOnRepeatType = function() {
        $(".recurrence-if-weekly").addClass("hiddenTableRow");
        $(".recurrence-if-monthly").addClass("hiddenTableRow");
        if(model.type === 'weekly') {
            $(".recurrence-if-weekly").removeClass("hiddenTableRow");
        }
        else if(model.type === 'monthly') {
            $(".recurrence-if-monthly").removeClass("hiddenTableRow");
        }
    }

    me.setEndDefaultsBasedOnCurrentSelection = function() {

        $("#recurrenceEndAfterTimes").prop('disabled',true);
        $("#recurrenceEndDate").data("DateTimePicker").disable();

        if(model.ends.type == 'occurrences') {

            $("#recurrenceEndAfterTimes").prop('disabled',false);
            if($("#recurrenceEndAfterTimes").val().trim() === '') {
                $("#recurrenceEndAfterTimes").val(30);
            }
        }
        if(model.ends.type == 'date') {
            $("#recurrenceEndDate").data("DateTimePicker").enable();
            if($("#recurrenceEndDate").data("DateTimePicker").date() == null) {
                $("#recurrenceEndDate").data("DateTimePicker").date(controller.form.giveMeStartDate().add(3,'months'));
            }
        }
    }
    me.setEnds = function() {
        model.ends.type = $("input[name='recurrenceEndType']:checked").val();
        me.setEndDefaultsBasedOnCurrentSelection();
        model.ends.occurrences = '';
        model.ends.on = '';
        if(model.ends.type == 'occurrences') {
            model.ends.occurrences = $("#recurrenceEndAfterTimes").val().trim();
        }
        else if(model.ends.type == 'date') {
            model.ends.on = $("#recurrenceEndDate").data("DateTimePicker").date();
        }
    }
    me.setMinDateForRecurrenceBasedOnThisDate = function(e) {
        // TODO: Work on this to get the min date set by the start date.
    }
    me.setDaysOfWeek = function() {
        for(key in model.daysOfWeek) {
            model.daysOfWeek[key] = false;
        }
        $("input[name='recurrenceDaysOfWeek[]']:checked").each(function() {
            model.daysOfWeek[$(this).val()] = true;
        });
    }
    me.numDaysOfWeek = function() {
        count = 0;
        for(key in model.daysOfWeek) {
            if(model.daysOfWeek[key] === true) {
                count++;
            }
        }
        return count;
    }
    me.convertShortDayOfWeekNameToLongName = function(dayOfWeek) {
        if(dayOfWeek == 'sun') { return 'sunday'; }
        if(dayOfWeek == 'mon') { return 'monday '; }
        if(dayOfWeek == 'tue') { return 'tuesday'; }
        if(dayOfWeek == 'wed') { return 'wednesday'; }
        if(dayOfWeek == 'thu') { return 'thursday'; }
        if(dayOfWeek == 'fri') { return 'friday'; }
        if(dayOfWeek == 'sat') { return 'saturday'; }
    }
    me.createSummaryString = function() {

        if(model.type == 'none') { return 'Does not repeat.'; }
        var summary = 'Repeats every ';
        if(model.every > 2) {
            summary += model.every;
        }
        else if(model.every == 2) {
            summary += 'other'
        }

        var shortType = '';

        if(model.type == 'daily') { summary += ' day'; }
        else if(model.type == 'weekly') { summary += ' week'; shortType = 'weekly'; }
        else if(model.type == 'weekly-weekdays') { summary += ' week'; shortType = 'weekly'; }
        else if(model.type == 'weekly-tue-thu') { summary += ' week'; shortType = 'weekly'; }
        else if(model.type == 'weekly-mon-wed-fri') { summary += ' week'; shortType = 'weekly'; }
        else if(model.type == 'weekly-weekends') { summary += ' week'; shortType = 'weekly'; }
        else if(model.type == 'monthly')
        {
            if(model.every > 2) {
                summary += ' months on the';
            }
            else if(model.every == 2) {
                summary += ' month on the';
            }
            if(model.monthly.type == 'dom') {
                summary += ' ' + model.monthly.dom.display;
            }
            else if(model.monthly.type == 'dow') {
                summary += model.monthly.dow.weekNumberOfMonthDisplay + ' ' + me.convertShortDayOfWeekNameToLongName(model.monthly.dow.day).toLowerCase().replace(/\b[a-z]/g,function(letter) { return letter.toUpperCase(); });;
            }

            summary += ' of the month';
        }
        else if(model.type == 'yearly') { summary += ' year'; }
        if(model.every > 2 && model.type != 'monthly') { summary += 's'; }

        if(shortType == 'weekly' && me.numDaysOfWeek() > 0) {
            summary += ' on ';
            var dowString = '';
            var counter = 0;
            var dayCount = me.numDaysOfWeek();
            for(key in model.daysOfWeek) {
                if(model.daysOfWeek[key]) {
                    if(counter > 0) {
                        if(counter < (dayCount - 1)) {
                            dowString += ', ';
                        }
                        else { dowString += ' and '; }
                    }
                    counter++;
                    dowString += key.toLowerCase().replace(/\b[a-z]/g,function(letter) { return letter.toUpperCase(); });
                }
            }
            summary += dowString;
        }
        if(model.ends.type === 'occurrences') {
            if(model.ends.occurrences == 1) {
                summary += ' once.';
            }
            else {
                summary += ', ' + model.ends.occurrences + ' times.'
            }
        }
        else if(model.ends.type === 'date') {
            summary += ' until ' + model.ends.on.format('MM/DD/YYYY') + '.';
        }

        return summary;
    }

}
