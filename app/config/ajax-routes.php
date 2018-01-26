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
                'method'=>'tester',
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

];