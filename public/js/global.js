function modalController() {

}
// function bizModal() {
//     var me = this;
//
//     me.create = function(params) {
//         if(typeof params.view == 'undefined' || params.view == '') {
//             exceptionHandler({
//                 message:'View must be defined for the modal'
//             });
//             return 1;
//         }
//         if(typeof params.postData == 'undefined' || params.postData == '') {
//             params.postData = {};
//         }
//         ajaxFeed(
//             {
//                 'url': params.view,
//                 'loader':'body',
//                 'stopSubsequentAttemptsUntilComplete':true,
//                 'data': params.postData,
//                 'submitType': 'POST',
//                 'successCallback': me.display
//             }
//         );
//     }
//     me.display = function(params) {
//         var divString = '\
//         <div class="modal fade bs-example-modal-lg2" tabindex="-1" role="dialog" aria-hidden="true" id="biz-modal-dialog"> \
//                     <div class="modal-dialog modal-lg"> \
//             <div class="modal-content"> \
//             <div class="modal-header"> \
//             <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> \
//         </button> \
//         <h4 class="modal-title" id="bizModalLabel">' + params.passback.title + '</h4>\
//         </div>\
//         <div class="modal-body"> \
//         ' + params.passback.html + '\
//         </div> \
//         <div class="modal-footer"> \
//             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> \
//             <button type="button" class="btn btn-primary" id="biz-modal-save-button">Save changes</button> \
//         </div> \
//         </div> \
//         </div> \
//         </div> \
//         ';
//         //alert(divString);
//         var $newdiv = $(divString).appendTo('body');
//         $('#biz-modal-dialog').modal('show');
//         $('#biz-modal-dialog').on('show.bs.modal', function() {
//             // When it is about to be shown
//         });
//         $('#biz-modal-dialog').on('shown.bs.modal', function() {
//             // Once it is shown
//         });
//         $('#biz-modal-dialog').on('hide.bs.modal', function() {
//             // When it is about to be hidden
//         });
//         $('#biz-modal-dialog').on('hidden.bs.modal', function() {
//             $('#biz-modal-dialog').remove();
//         });
//     }
//
//     me.setTitle(title) {
//
//     }
// }


function createModal(params ) {
    // if(modals.queue.length > 0) {
    //
    // }

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
            'successCallback': displayModal
        }
    );

}
function displayModal(params) {

    var divString = '\
        <div class="modal fade bs-example-modal-lg2" tabindex="-1" role="dialog" aria-hidden="true" id="biz-modal-dialog"> \
                    <div class="modal-dialog modal-lg"> \
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
function displayModalSetTitle(title) { $("#bizModalLabel").text(title); }

function exceptionHandler(params) {
    alert(params.message);

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

function getFormData(formId) {
    return $('#' + formId).serializeObject();
}


function setOrPush(target, val) {
    var result = val;
    if (target) {
        result = [target];
        result.push(val);
    }
    return result;
}

function getFormResults(formElement) {
    var formElements = formElement.elements;
    var formParams = {};
    var i = 0;
    var elem = null;
    for (i = 0; i < formElements.length; i += 1) {
        elem = formElements[i];
        switch (elem.type) {
            case 'submit':
                break;
            case 'radio':
                if (elem.checked) {
                    formParams[elem.name] = elem.value;
                }
                break;
            case 'checkbox':
                if (elem.checked) {
                    formParams[elem.name] = setOrPush(formParams[elem.name], elem.value);
                }
                break;
            default:
                formParams[elem.name] = setOrPush(formParams[elem.name], elem.value);
        }
    }
    return formParams;
}
(function($){
    $.fn.serializeObject = function() {
        var data = {};
        $.each( this.serializeArray(), function( key, obj ) {
            var a = obj.name.match(/(.*?)\[(.*?)\]/);
            if(a !== null)
            {
                var subName = new String(a[1]);
                var subKey = new String(a[2]);
                if( !data[subName] ) {
                    data[subName] = { };
                    data[subName].length = 0;
                };
                if (!subKey.length) {
                    subKey = data[subName].length;
                }
                if( data[subName][subKey] ) {
                    if( $.isArray( data[subName][subKey] ) ) {
                        data[subName][subKey].push( obj.value );
                    } else {
                        data[subName][subKey] = { };
                        data[subName][subKey].push( obj.value );
                    };
                } else {
                    data[subName][subKey] = obj.value;
                };
                data[subName].length++;
            } else {
                var keyName = new String(obj.name);
                if( data[keyName] ) {
                    if( $.isArray( data[keyName] ) ) {
                        data[keyName].push( obj.value );
                    } else {
                        data[keyName] = { };
                        data[keyName].push( obj.value );
                    };
                } else {
                    data[keyName] = obj.value;
                };
            };
        });
        return data;
    };
})(jQuery);

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
var modals = {
    queue:[],
    current:-1,
};

function JS_FeatureFlip () {
    var me = this;
    var testingTags = {
        newScheduledEvent: {
            level: 1
        }
    }
    me.getTestingLevel = function(tag) {
        if(tag in testingTags) {
            return 'level' in testingTags[tag] ? testingTags[tag].level : false;
        }
        return false;
    }
    me.addTestingTag = function(tag,params) {
        testingTags[tag] = params;
    }
    me.removeTestingTag = function(tag) {
        delete testingTags[tag];
    }
    me.setTestingLevel = function(tag,level) {
        testingTags[tag].level = level;
    }
    me.setTestingParameter = function(tag,param,value) {
        testingTags[tag][param] = value;
    }
    me.getTestingParameter = function(tag,param) {
        if(tag in testingTags) {
            return param in testingTags[tag] ? testingTags[tag][param] : false;
        }
        return false;
    }
    me.removeTestingParameter = function(tag,param) {
        delete testingTags[tag][param];
    }
}
function FormErrorHandler () {
    // As of now, it allows you to add multiple errors for a single input element,
    //  but will only display the first.  We should build this out to be able to display
    //  multiple errors.
    var me = this;
    var errors = false;
    var errorList = {};
    me.addError = function(elementId,errorText) {
        if(! (elementId in errorList) ) {
            errorList[elementId] = [];
        }
        errorList[elementId][errorList[elementId].length] = errorText;
        errors = true;
    }
    me.clearErrors = function() {
        $.each(errorList,function(elementId,errors) {
            me.unattachErrorFromElement(elementId);
        });
        errors = false;
        errorList = {};
    }
    me.hasErrors = function() {
        return errors;
    }
    me.showErrorsAsString = function() {
        return JSON.stringify(errorList);
    }
    me.attachErrorToElement = function(elementId,message) {
        $("#" + elementId).after('<p class="form-error" id="form-error-message-' + elementId + '">' + message + '</p>');
        $("#" + elementId).addClass('form-error');
    }
    me.attachErrorsToFormElements = function() {
        $.each(errorList,function(elementId,errors) {
            me.attachErrorToElement(elementId,errors[0]);
        });
    }

    me.unattachErrorFromElement = function(elementId) {
        $("#form-error-message-" + elementId).remove();
        $("#" + elementId).removeClass('form-error');
    }

}