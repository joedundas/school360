function modalController() {
   var me = this;

    me.create = function(params) {

        if(typeof params.view == 'undefined' || params.view == '') {
            exceptionHandler({
                message:'View must be defined for the modal'
            });
            return 1;
        }
        if(typeof params.postData == 'undefined' || params.postData == '') {
            params.postData = {};
        }
        ajaxFeed(
            {
                'url': params.view,
                'loader':'body',
                'stopSubsequentAttemptsUntilComplete':true,
                'data': params.postData,
                'submitType': 'POST',
                'successCallback': me.display
            }
        );
    }

    me.display = function(params) {

        var modalSize = params.passback.width;
        var divString = '\
        <div class="modal fade bs-example-modal-' + modalSize + '" tabindex="-1" role="dialog" aria-hidden="true" id="biz-modal-dialog"> \
                    <div class="modal-dialog modal-' + modalSize + '"> \
            <div class="modal-content"> \
            <div class="modal-header"> \
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> \
        </button> \
        <h4 class="modal-title" id="bizModalLabel">' + params.passback.title + '</h4>\
        </div>\
        <div class="modal-body"> \
        ' + params.passback.html + '\
        </div> \
        <div class="modal-footer"> \
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> \
            <button type="button" class="btn btn-primary" id="biz-modal-save-button">Save changes</button> \
        </div> \
        </div> \
        </div> \
        </div> \
        ';
        //alert(divString);
        var $newdiv = $(divString).appendTo('body');

        $('#biz-modal-dialog').modal('show');

        $('#biz-modal-dialog').on('show.bs.modal', function() {
            // When it is about to be shown
        });
        $('#biz-modal-dialog').on('shown.bs.modal', function() {
            // Once it is shown
        });
        $('#biz-modal-dialog').on('hide.bs.modal', function() {
            // When it is about to be hidden
        });
        $('#biz-modal-dialog').on('hidden.bs.modal', function() {
            $('#biz-modal-dialog').remove();
        });
    };
}

function pageController(modalController,workingBlindController) {
    var me = this;
    me.modal = modalController;
    me.blind = workingBlindController;
    me.ajax = new ajaxController();
    me.helpers = new helpers();
    me.switchToRole = function(roleId) {

        ajaxFeed(
            {
                'url': 'switchRole',
                'loader': {'attachTo':'body','showLoadingGif':true,'hideWhenComplete':false  },
                'stopSubsequentAttemptsUntilComplete': true,
                'data': {'roleId':roleId},
                'submitType': 'POST',
                'successCallback': me.reload(),
            }
        );
    }
    me.reload = function(waitTime) {
        if(typeof waitTime === 'undefined') {
            window.location.reload(true);
        }
        else {
            setTimeout(function () {
                window.location.reload(true);
            }, 1000);
        }
    };



}
function sessionController() {
    var me = this;

    me.refresh = function() {

        ajaxFeed(
            {
                'url': 'session/refresh',
                'loader': {'attachTo':'body','showLoadingGif':true,'hideWhenComplete':false  },
                'stopSubsequentAttemptsUntilComplete': true,
                'data': {},
                'submitType': 'POST',
                'successCallback': controller.page.reload(1000),
            }
        );


    };
    me.reloadPage = function() {
        setTimeout(function() {window.location.reload(true); },1000);
    };


}

function workingBlindController() {
    "use strict";
    var me = this;

    me.hideWorkingBlindWhenFinished = true;
    me.externalSuccessCallback = function() {};
    me.externalErrorCallback = function() {};
    me.defaults = function() {
        return {
            'attachTo':'body',

            'callback':{
                'onShow':false,
                'onAjax': {
                    'success': false,
                    'error': false
                }
            },
            'fadeIn':false,
            'hideOnComplete':true,
            'spinner': {
                'show':true,

            },
            'css':{
                'opacity':0.6,
                'z-index':100000
            }
        };
    };
    me.loadInputParams = function(params,input) {
        for(var key in input) {
            if (typeof input[key] === 'object') {
                me.loadInputParams(params[key], input[key]);
                delete input[key];
            }
            else {
                params[key] = input[key];
                delete input[key];
            }
        }
    };
    me.hasInvalidInputParams = function(input) {
        for(var key in input) {
            if(input.hasOwnPropery(key)) {
                return true;
            }
        }
        return false;
    };
    me.show = function(input) {
        var params = me.defaults();
        if(typeof input !== 'undefined') {
            me.loadInputParams(params, input);

            if (me.hasInvalidInputParams(input)) {
                alert("Had invalid input params... please handle this error?");
            }
        }
        var html = "<div class='blind' id='BBLIND'>";
        if(params.spinner.show) {
            html += "<div class='loader'></div>";
        }
        html += "</div>";

        $(params.attachTo).append(html);
        for(var item in params.css) {
            $('#BBLIND').css(item,params.css[item]);
        }
        $('#BBLIND').css('opacity',0.6);
        $('#BBLIND').css('z-index',100000);
        if(params.fadeIn) {
            $('#BBLIND').fadeIn('slow',function() {
                if(typeof params.callback.onShow === 'function') {
                    params.callback.onShow();
                }
            });
        }
        else {

            $('#BBLIND').show(0, function () {
                if(typeof params.callback.onShow === 'function') {
                    params.callback.onShow();
                }
            });
        }

        me.hideWorkingBlindWhenFinished = params.hideOnComplete;
        me.externalSuccessCallback = typeof params.callback.onAjax.success === 'function' ? params.callback.onAjax.success : false;
        me.externalErrorCallback = typeof params.callback.onAjax.error === 'function' ? params.callback.onAjax.error : false;
    };
    me.hide = function() {
        if(me.hideWorkingBlindWhenFinished === true) {
            $('#BBLIND').remove();
        }
    };
    me.externalCallFinished = function(type) {
        if(typeof type === 'undefined') { type = 'success'; }
        me.hideWorkingBlindWhenFinished = true;
        if(type === 'success') {
            if(me.externalSuccessCallback) {
                me.externalSuccessCallback();
            }
        }
        else if(type === 'error') {
            if(me.externalErrorCallback) {
                me.externalErrorCallback();
            }
        }
        me.externalSuccessCallback = false;
        me.externalErrorCallback = false;
    };

}
function controller(pageController,sessionController) {

    var me = this;
    me.page = pageController;
    me.session = sessionController;
}


function ajaxController() {
    "use strict";
    var me = this;
    me.openChannels = {};
    me.defaults = function() {
        return {
            'submitType':'GET',
            'dataType':'json',
            'url':'',
            'loader': {

            },
            'blockUntilDone':false,
            'passthru': {},
            'sessionFlash':{},
            'data':{},
            'verbose':{
                'showSuccessData':false,
                'showErrorData':false
            },
            'callback': {
                'error': function() {},
                'success': function() {}
            },
            'diagnostics': {
                'time': {
                    'local': {
                        'sent':controller.page.helpers.timeStamp(),
                        'received':false
                    },
                    'server': {
                        'received':false,
                        'sent':false
                    }
                }
            }
        };
    };
    me.loadInputParams = function(params,input) {
        for(var key in input) {
            if (typeof input[key] === 'object') {
                me.loadInputParams(params[key], input[key]);
                delete input[key];
            }
            else {
                params[key] = input[key];
                delete input[key];
            }
        }
    };
    me.send = function(input) {
        var params = me.defaults();
        me.loadInputParams(params,input);

        if(
            params.blockUntilDone &&
            params.url in me.openChannels &&
            me.openChannels[params.url] !== false
        )
        {
            alert("Process has already started.. please wait until finished");
            return 1;
        }
        if(!(params.url in me.openChannels)) {
            me.openChannels[params.url] = {};
        }
        var index = controller.page.helpers.randomString(8) + "-" + controller.page.helpers.timeStamp();
        me.openChannels[params.url][index] = { 'params':params,'received':false };
        if(params.loader !== false) {
            controller.page.blind.show();
        }
        me.transmit(params.url,index);
    };

    me.transmit = function(url,index) {
        me.openChannels[url][index].params.diagnostics.time.local.sent = controller.page.helpers.timeStamp();
        var params = me.openChannels[url][index].params;
        var input = {
            'call': { id:index,url:url},
            'data': params.data,
            'diagnostics':params.diagnostics,
            'sessionFlash': params.sessionFlash
        };

        $.ajax({
            url:url,
            type: params.submitType,
            data: input,
            dataType: params.dataType,
            success: function(response) {
                me.openChannels[url][index].received = response;

                //@TODO We may want to put something here to check for concurrency on the openChannels queue
                if(params.verbose.showSuccessData) {
                    alert("Success Data: " + JSON.stringify(response));
                }
                if(response.output.hasErrors) {
                    alert("Call worked, but there were errors from call.. need to handle");
                }
                if(typeof params.callback.success === 'function') {
                    params.callback.success(response.output.data,params.passthru);
                }
                controller.page.blind.hide();
            },
            error:function(xhr, ajaxOptions, thrownError) {
                alert("error");
                alert(JSON.stringify(xhr));
                me.openChannels[url][index].received = xhr.responseText;
                if(params.verbose.showErrorData) {
                    alert("Error: " + JSON.stringify(xhr.responseText));
                }
                if(typeof params.callback.error === 'function') {
                    params.callback.error(e);
                }
                controller.page.blind.hide();
              }
        });
    };

}
var _ajaxFeedWorkingProcesses = {};
function ajaxFeed(params) {
    var me = this;
    var verbose = false;
    /*
     ** Pre-call defaults and functions
     */
    if(!('verbose' in params)) {
        params.verbose = {};
    }
    if(params.verbose.showInputParams) {
        alert("Input Parameters:" + JSON.stringify(params));
    }

    if(!'loader' in params) {
        params.loader = false;

    }
    else if(params.loader !== false) {

        showWorkingBlind(params.loader);
    }

    if(! 'passthru' in params) {
        params.passthru = false;
    }
    if(!'stopSubsequentAttemptsUntilComplete' in params) {
        params.stopSubsequentAttemptsUntilComplete = false;
    }
    if(
        params.stopSubsequentAttemptsUntilComplete &&
        params.url in _ajaxFeedWorkingProcesses &&
        _ajaxFeedWorkingProcesses[params.url] == true
    )
    {
        alert("Process has already started.. please wait until finished");
        return 1;
    }
    _ajaxFeedWorkingProcesses[params.url] = true;


    var input = {
        'data': typeof params.data != 'undefined' ? params.data : {},
        'sessionFlash': typeof params.sessionFlash != 'undefined' ? params.sessionFlash : {}
    };

    /*
     **  Make the call
     */
    $.ajax({

        url:params.url,
        type: typeof params.submitType != 'undefined' ? params.submitType : 'GET',
        data: input,
        dataType: typeof params.dataType != 'undefined' ? params.dataType : 'json',
        success: function(data) {
            alert(JSON.stringify(data));
            delete _ajaxFeedWorkingProcesses[params.url];
            if(params.verbose.showSuccessData) {
                alert("Success Data: " + JSON.stringify(data));
            }
            if(typeof params.successCallback == 'function') {
                params.successCallback(data,params.passthru);
            }
            if(params.loader !== false  && me.getParameterValue(params.loader,'hideWhenComplete',true)) {
                hideWorkingBlind();
            }


        },
        error:function(xhr, ajaxOptions, thrownError) {
            alert(JSON.stringify(xhr.responseText));
            delete _ajaxFeedWorkingProcesses[params.url];
            if(params.verbose.showError) {
                alert("Error: " + JSON.stringify(xhr.responseText));
            }
            if(typeof params.failureCallback == 'function') {
                params.failureCallback(e);
            }
            if(params.loader !== false && me.getParameterValue(params.loader,'hideWhenComplete',true) ) {
                hideWorkingBlind();
            }


        }
    });
    me.getParameterValue = function(params,key,defaultValue) {

        if(typeof params[key] !== 'undefined') {

           return params[key];
        }

        return defaultValue;
    };
}

function helpers() {
    "use strict";
    var me = this;

    me.randomString = function(length) {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for(var i = 0; i < length; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    };

    me.timeStamp = function() {
        return Math.floor(Date.now()/1000);
    };

}

function showWorkingBlind(params) {
    var div_id = params.attachTo;

    var showLoadingGif = true;
    var callback = false;
    var fadeIn = true;
    if(typeof params != 'undefined') {
        if(typeof params.showLoadingGif) {
            showLoadingGif = params.showLoadingGif;
        }
        if(typeof params.callback != 'undefined') {
            callback = params.callback;
        }
        if(typeof params.fade != 'undefined') {
            fadeIn = params.fade;
        }
    }
    var html = "<div class='blind' id='BIZBLIND'>";

    if(showLoadingGif) {
        html += "<div class='loader'></div>";
    }
    html += "</div>";

    $(div_id).append(html);
    $('#BIZBLIND').css('opacity',.6);
    $('#BIZBLIND').css('z-index',100000);
    if(fadeIn) {
        $('#BIZBLIND').fadeIn('slow',function() {
            if(typeof callback == 'function') {
                callback();
            }
        });
    }
    else {
        $('#BIZBLIND').show(0, function () {
            if (typeof callback == 'function') {
                callback();
            }
        });
    }


}
function hideWorkingBlind(callback) {
    $('#BIZBLIND').remove();
}