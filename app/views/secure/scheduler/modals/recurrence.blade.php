
<div class="row">
    <div class="col-xs-12">
        <table class="plain-table">
            <tr>
                <td>
                    Repeats:
                </td>
                <td>
                    <select class="recurrence-controller" id="recurrence-repeat-type">
                        <option value="none">Does not repeat</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly (Custom)</option>
                        <option value="weekly-weekdays">Weekly (Monday thru Friday)</option>
                        <option value="weekly-tue-thu">Weekly (Tuesday and Thursday)</option>
                        <option value="weekly-mon-wed-fri">Weekly (Monday, Wednesday and Friday)</option>
                        <option value="weekly-weekends">Weekly (Saturday and Sunday)</option>
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </td>
            </tr>
            <tr class="recurrence-if-repeats">
                <td>
                  Every:
                </td>
                <td>
                    <select class="recurrence-controller" id="recurrence-repeat-every">
                        <?php
                        for($i=1; $i<=30; $i++) {
                            echo "<option value=$i>$i</option>";
                        }
                        ?>
                    </select>
                    <span id="recurrence-repeat-label"></span>
                </td>
            </tr>
            <tr class="recurrence-if-repeats recurrence-if-monthly">
                <td>
                    Repeat by:
                </td>
                <td>
                    <input type="radio" checked name='recurrenceMonthlyRepeatBy' value="dom" id='rec-monthly-dom' class="recurrence-controller"><span class="radio-label recurrence-controller">Day Of Month</span> &nbsp;&nbsp;
                    <input type="radio" name='recurrenceMonthlyRepeatBy' value="dow" id='rec-monthly-dow' class="recurrence-controller"><span class="radio-label recurrence-controller">Day of Week</span>

                </td>
            </tr>
            <tr class="recurrence-if-repeats recurrence-if-weekly">
                <td>
                    On:
                </td>
                <td>
                    <input type="checkbox" name='recurrenceDaysOfWeek[]' value="mon" id='rec-mon' class="recurrence-controller">Mon
                    <input type="checkbox" name='recurrenceDaysOfWeek[]' value="tue" id='rec-tue' class="recurrence-controller">Tue
                    <input type="checkbox" name='recurrenceDaysOfWeek[]' value="wed" id='rec-wed' class="recurrence-controller">Wed
                    <input type="checkbox" name='recurrenceDaysOfWeek[]' value="thu" id='rec-thu' class="recurrence-controller">Thu
                    <input type="checkbox" name='recurrenceDaysOfWeek[]' value="fri" id='rec-fri' class="recurrence-controller">Fri
                    <input type="checkbox" name='recurrenceDaysOfWeek[]' value="sat" id='rec-sat' class="recurrence-controller">Sat
                    <input type="checkbox" name='recurrenceDaysOfWeek[]' value="sun" id='rec-sun' class="recurrence-controller">Sun
                </td>
            </tr>
            <tr class="recurrence-if-repeats">
                <td>
                    Ends:
                </td>
                <td>
                    <ul class="ul-table">
                        <li>
                            <input type="radio" name="recurrenceEndType" class="recurrence-controller" checked value="occurrences"> <span class="radio-label recurrence-controller">After <input type="number" min=1 step=1 class="form-inline recurrence-controller" id="recurrenceEndAfterTimes" style="width:50px; line-height:15px"> occurrences</span>
                        </li>
                        <li>
                            <input type="radio" name="recurrenceEndType" class="recurrence-controller" value="date">
                            <span class="radio-label">On
                                <span class='input-group date form-inline recurrence-controller'  style="line-height:15px; width:180px; display:inline">
                                    <input type="text" class="form-inline recurrence-controller" id="recurrenceEndDate" style="width:90px">
                                </span>
                            </span>
                        </li>
                    </ul>
                </td>
            </tr>
        </table>
    </div>
</div>
<style>
    .plain-table tr td {
        padding:4px 10px;
        font-size:14px;
    }
    .plain-table tr td:first-child {
        vertical-align: top;
        font-weight:bold;
        text-align: right;
        padding-right:5px;
    }

    .plain-table input[type='checkbox'] {
        margin-left:7px;
        margin-right:3px;
    }

    .ul-table {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }
    .ul-table  li {

    }
    .radio-label {
        padding-left:6px;
    }
    .hiddenTableRow {
        display:none;
    }
</style>