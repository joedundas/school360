<script>
    var _PAGE = {
        mode:"<?php echo $pageViewType != '' ? $pageViewType : 'add'; ?>",
        personaId:"<?php echo $personaId ?>",
        personaInfo:null,
        views: {
            view:{
                url:'customer/view',
                header:''

            },
            edit: {
                url:'customer/edit',
                header:''
            },
            add:{
                url:'customer/new',
                header:"New <?php echo ucfirst(Session::get('settings.terminology.customer.singular')); ?>"
            }
        },
        api:{
            get: {
                url:'api/customer/get'
            },
            new:{
                url:'api/customer/new',

            },
            edit: {
                url: 'api/customer/edit'
            }
        }
    };

    function fillEditFormFields() {
        $('#edit-first-name').val(_PAGE.personaInfo.name.firstName);
        $('#edit-middle-name').val(_PAGE.personaInfo.name.middleName);
        $('#edit-last-name').val(_PAGE.personaInfo.name.lastName);
        $('#edit-nick-name').val(_PAGE.personaInfo.name.nickName);
    }
    function fillViewFormFields() {
        var name = ((_PAGE.personaInfo.name.firstName + " " + _PAGE.personaInfo.name.middleName).trim() + " " + _PAGE.personaInfo.name.lastName).trim();
        if(_PAGE.personaInfo.name.nickName != '') { name += ' "' + _PAGE.personaInfo.name.nickName + '"'; }
        $('#view-customer-name').html(name);
    }

    function getFormInformation() {
        var customerInfo = {
            'profile': {
                id:_PAGE.personaId
            },
            'name': {
                'firstName': $('#edit-first-name').val().trim(),
                'middleName': $('#edit-middle-name').val().trim(),
                'lastName': $('#edit-last-name').val().trim(),
                'nickName': $('#edit-nick-name').val().trim()
            }
        }

        return customerInfo;
    }
</script>

