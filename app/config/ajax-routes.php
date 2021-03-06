<?php

return [
    'auth'  =>  [
       'class'=>'AuthenticationController',
        'calls'=>[
            'test'=>[
                'method'=>'tester',
                'requires'=>array(
                    'auth'=>true
                )
            ],
            'refresh'=>[
                'method'=>'refreshSession',
                'requires'=>array(
                    'auth'=>true
                )
            ],
            'login'=>[
                'method'=>'login',
                'requires'=>array(
                    'auth'=>false
                )
            ],
            'change-role'=>[
                'method'=>'switchToRole',
                'requires'=>array(
                    'auth'=>true
                )
            ]
        ]
    ],
    'courses'  =>  [
        'class'=>'CoursesController',
        'calls'=>[
            'add'=>[
                'method'=>'add',
                'requires'=>array(
                    'auth'=>true
                )
            ],
            'list'=>[
                'method'=>'get',
                'requires'=>array(
                    'auth'=>true
                )
            ]
        ]
    ],

];