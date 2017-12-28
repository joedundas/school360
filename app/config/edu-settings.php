<?php

// To determine whether it is on or off, it starts with default value, then user, then school, then role
return [
    'api-logging'=>array(
        'default'=>'off',
        'order'=>array('user','school','role'),
        'user'=>array(
        //    '6'=>'on'
        ),
        'school'=>array(
         //   '1'=>'on'
        ),
        'role'=>array()
    ),
    'feature-flip-cache'=>array(
        'default'=>'off',
        'order'=>array('user','school','role'),
        'user'=>array(
            //    '6'=>'on'
        ),
        'school'=>array(
            '1'=>'on'
        ),
        'role'=>array()
    ),
    'force-logout'=>array(
        'default'=>'off',
        'order'=>array('user','school','role'),
        'user'=>array(
            //    '6'=>'on'
        ),
        'school'=>array(
          //  '1'=>'on'
        ),
        'role'=>array()
    )
];