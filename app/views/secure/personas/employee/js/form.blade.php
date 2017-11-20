<script>
    var _PAGE = {
        mode:"<?php echo $pageViewType != '' ? $pageViewType : 'add'; ?>",
        personaId:"<?php echo $personaId ?>",
        personaInfo:null,
        views: {
            view:{
                url:'employee/view',
                header:''

            },
            edit: {
                url:'employee/edit',
                header:''
            },
            add:{
                url:'employee/new',
                header:"New <?php echo ucfirst(Session::get('settings.terminology.employee.singular')); ?>"
            }
        },
        api:{
            get: {
                url:'api/employee/get'
            },
            new:{
                url:'api/employee/new',

            },
            edit: {
                url: 'api/employee/edit'
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
        $('#view-employee-name').html(name);
    }

    function getFormInformation() {
        var employeeInfo = {
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

        return employeeInfo;
    }
</script>

