<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/2/17
 * Time: 8:23 AM
 */
class RecurrenceUtilities
{
    static public function giveGeneralRecurrenceType($recurrence) {
        if($recurrence === false || $recurrence === 'false') { return 'none'; }
        return preg_match("/^weekly/", $recurrence['type']) ? 'weekly' :
            ($recurrence['type'] == 'monthly' ? 'monthly-' . $recurrence['monthly']['type'] : $recurrence['type']);
    }
}