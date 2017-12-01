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
    }
}

function pageController() {
    var me = this;
    me.switchToRole = function(userRoleId) {
        ajaxFeed(
            {
                'url': 'switchRole',
                'loader': 'body',
                'stopSubsequentAttemptsUntilComplete': true,
                'data': {'userRoleId':userRoleId},
                'submitType': 'POST',
                'successCallback': function() { location.reload(); },
            }
        );
    }
    me.receiveResults = function(dta) {
        alert("I AM BACK");

    }

}
function controller(pageController,modalController) {
    var me = this;
    me.modals = modalController;
    me.page = pageController;

}


var _ajaxFeedWorkingProcesses = {};
function ajaxFeed(params) {

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
    else {
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
            delete _ajaxFeedWorkingProcesses[params.url];
            if(params.verbose.showSuccessData) {
                alert("Success Data: " + JSON.stringify(data));
            }
            if(typeof params.successCallback == 'function') {
                params.successCallback(data,params.passthru);
            }
            if(params.loader) {
                hideWorkingBlind();
            }


        },
        error:function(xhr, ajaxOptions, thrownError) {
            delete _ajaxFeedWorkingProcesses[params.url];
            if(params.verbose.showError) {
                alert("Error: " + JSON.stringify(xhr.responseText));
            }
            if(typeof params.failureCallback == 'function') {
                params.failureCallback(e);
            }
            if(params.loader) {
                hideWorkingBlind();
            }


        }
    });
}


function showWorkingBlind(div_id,params) {
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
    $('#BIZBLIND').css('z-index',100);
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