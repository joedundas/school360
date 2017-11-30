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