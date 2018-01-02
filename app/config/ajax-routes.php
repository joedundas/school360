<?php

return [
    'auth'  =>  [
       'class'=>'AuthenticationController',
        'calls'=>[
            'test'=>[
                'method'=>'tester'
            ],
            'refresh'=>[
                'method'=>'refreshSession'
            ]
        ]
    ],

];