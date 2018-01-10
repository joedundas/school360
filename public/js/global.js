
function controller(pageController,sessionController) {

    var me = this;
    me.page = pageController;
    me.session = sessionController;
}

function modalController() {
    'use strict';
   var me = this;

    me.create = function(params) {

        if(typeof params.view === 'undefined' || params.view === '') {

            return 1;
        }
        if(typeof params.postData === 'undefined' || params.postData === '') {
            params.postData = {};
        }
        controller.page.ajax.send(
           {
             url:params.view,
               data:params.postData,
               callback: {
                 success: function(response,textStatus,xhr) {
                     alert(JSON.stringify(xhr));
                 }
               }
           }
       );
    }

    me.display = function(params) {
        alert(JSON.stringify(params));
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
    'use strict';
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
    'use strict';
    var me = this;

    me.refresh = function() {
        controller.page.ajax.send(
            {
                url:'ajax/auth/refresh',
                dataType:'json',
                data:{},
                loader:{
                    hideOnComplete:false
                },
                callback: {
                    'success':controller.page.reload(1000)
                }
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



function ajaxController() {
    "use strict";
    var me = this;
    me.openChannels = {};
    me.defaults = function() {
        return {
            'submitType':'POST',
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
            controller.page.blind.show(params.loader);
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
            success: function(response,textStatus,xhr) {
                //if(xhr.status !== 200) { response = {}; response.output = {'data':'','hasErrors':false}; }
                // alert("in success");
                // alert(JSON.stringify(response));
                me.openChannels[url][index].received = response;

                //@TODO We may want to put something here to check for concurrency on the openChannels queue
                if(params.verbose.showSuccessData) {
                    alert("Success Data: " + JSON.stringify(response));
                }

                if(response.output.hasErrors) {
                    alert("Call worked, but there were errors from call.. need to handle");
                    // response.output.errors is array of error messages that can be used here
                }
                else if(typeof params.callback.success === 'function') {
                    params.callback.success(response.output,params.passthru);
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

