<?php
$PAGE = (new SessionManager())->reviveSessionFromCache();





?>
{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}

{{--</head>--}}

<body class="nav-md">


<!-- page content -->
<div role="main">

    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="x_panel">
                {{--<div class="x_title">--}}
                    {{--<h2>Form Design <small>different form elements</small></h2>--}}
                    {{--<ul class="nav navbar-right panel_toolbox">--}}
                        {{--<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>--}}
                        {{--</li>--}}
                        {{--<li class="dropdown">--}}
                            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>--}}
                            {{--<ul class="dropdown-menu" role="menu">--}}
                                {{--<li><a href="#">Settings 1</a>--}}
                                {{--</li>--}}
                                {{--<li><a href="#">Settings 2</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li><a class="close-link"><i class="fa fa-close"></i></a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                    {{--<div class="clearfix"></div>--}}
                {{--</div>--}}
                <div class="x_content">

                    <form class="form-horizontal form-label-left input_mask">

                        <div class="form-group">
                            <label>Course Name
                            </label>
                            <input type="text" id='courseName' class="form-control" placeholder="Enter course name">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    var form = new formController();


    form.addFields(
        [
            ['courseName','text',{'value':true}]
        ]
    )

    function formController() {
        'use strict';
        var me = this;
        me.isValid = true,
        me.fields = {};
        me.data = {};

        me.addFields = function(fields) {
            for(var i=0; i<fields.length; i++) {
                me.addField.apply(this,fields[i]);
            }
        };
        me.addField = function(elementId,elementType,requirements) {
            if(typeof requirements === 'undefined') { requirements = false; }
            me.fields[elementId] = {
                type:elementType,
                require:requirements,
                error:{
                    isValid:true,
                    message:''
                }
            }
        };

        me.isFormValid = function() {
            me.isValid = true;
            for(var eleId in me.fields) {
                me.fields[eleId].error.isValid = true;
                me.fields[eleId].error.message = '';
                var info = me.fields[eleId];
                if(info.require !== false)
                {
                    if(typeof info.require.value !== 'undefined' && info.require.value === true && me.data[eleId] === '') {
                        me.isValid = false;
                        me.fields[eleId].error.isValid = false;
                        me.fields[eleId].error.message = 'Field is required';
                    }
                }
            }
            return me.isValid;
        };
        me.gather = function() {
            for(var eleId in me.fields) {
                if(me.fields[eleId].type === 'text') {
                    me.data[eleId] = $('#' + eleId).val().trim()
                }
            }
            return true;
        };
        me.getData = function() {
            return me.data;
        };
        me.clearForm = function() {
            for(var eleId in me.fields) {
                if(me.fields[eleId].type === 'text') {
                    $('#' + eleId).val("");
                }
            }
        };
    }

    function textFeildController() {
        'use strict';
        var me = this;
    }



    $('#biz-modal-save-button').on('click',function() {
        form.gather();
        if(form.isFormValid()) {
            saveInfo(form.getData());
        }
        else {
            //alert(JSON.stringify(form.fields));
        }

    })



    function setFieldToError(msg) {

    }

    function resetFieldError() {

    }



    function saveInfo(data) {
        ajax.send(
            {
                url:'/secure/api/courses/add',
                data:data,
                verbose:{
                    'showSuccessData':true,
                    'showErrorData':true
                },
                callback: {
                    'error': function() { alert("error"); },
                    'success': function() { form.clearForm(); alert('success'); }
                }
            }
        );
    }

</script>
