<script>
    var lastSavedFormInformation = '';
    $(document).ready(function() {

        initializePage();
        lastSavedFormInformation = JSON.stringify(getFormInformation());
    });

    function initializePage() {
        $('[data-show-initial=hidden]').addClass("hidden-div");
        $('#page-header-left').text(_PAGE.views[_PAGE.mode].header);
        if(_PAGE.mode == 'add') {
            initializePageToAddPersonaForm();
        }
        else if(_PAGE.mode == 'view') {
            if(_PAGE.personaInfo !== null) {
                fillPersonaView();
            }
            else {
                getPersonaInformation(_PAGE.personaId);
            }
        }
        else if(_PAGE.mode == 'edit') {
            if(_PAGE.personaInfo !== null) {
                fillPersonaEditForm();
            }
            else {
                getPersonaInformation(_PAGE.personaId);
            }
        }

    }
    function initializePageToViewPersonaForm() {
        $('[data-show-on-view]').removeClass("hidden-div");
    }
    function initializePageToAddPersonaForm() {
        $('[data-show-on-new]').removeClass("hidden-div");
    }
    function initializePageToEditPersonaForm() {
        $('[data-show-on-edit]').removeClass("hidden-div");
    }
    function receivePersonaInformation(data) {
        if(data.error) {
            // TODO - Handle error from API return
            alert("There was an error");
            return 1;
        }
        _PAGE.personaInfo = data.passback;
        lastSavedFormInformation = JSON.stringify(_PAGE.personaInfo);
        if(_PAGE.mode == 'view') {
            fillPersonaView();
        }
        else if(_PAGE.mode == 'edit') {
            fillPersonaEditForm();
        }
    }
    function fillPersonaEditForm() {
        fillEditFormFields();
        initializePageToEditPersonaForm();
    }
    function fillPersonaView(cinfo) {
        fillViewFormFields();
        initializePageToViewPersonaForm();
    }
    function getPersonaInformation() {
        ajaxFeed(
            {
                'url': _PAGE.api.get.url,
                'loader':'body',
                'stopSubsequentAttemptsUntilComplete':true,
                'data': { 'id':_PAGE.personaId },
                'submitType': 'POST',
                'successCallback': receivePersonaInformation
            }
        );
    }
    $('#save-button').click(
        function(event) {
            var personaInfo = getFormInformation();

            event.preventDefault();
            ajaxFeed(
                {
                    'url': _PAGE.api.new.url,
                    'loader':'body',
                    'stopSubsequentAttemptsUntilComplete':true,
                    'data': personaInfo,
                    'submitType': 'POST',
                    'successCallback': receiveSaveResults
                }
            );
        }
    )
    $('#save-changes-button').click(
        function(event) {
            var personaInfo = getFormInformation();
            event.preventDefault();
            ajaxFeed(
                {
                    'url': _PAGE.api.edit.url,
                    'loader':'body',
                    'stopSubsequentAttemptsUntilComplete':true,
                    'data': personaInfo,
                    'submitType': 'POST',
                    'successCallback': receiveSaveResults
                }
            );

        }
    )
    $('#nevermind-button').click(
        function(event) {
            _PAGE.mode = 'view';
            initializePage();
        }
    )
    $('#toggle-edit-button').click(
        function(event) {
            _PAGE.mode = 'edit';
            initializePage();
        }
    )
    function receiveSaveResults(data) {
        if(data.error) {
            // TODO - Handle error from API return
            alert("There was an error");
            return 1;
        }
        navigateToPage(_PAGE.views.view.url + '/' + data.passback.id);
    }

</script>