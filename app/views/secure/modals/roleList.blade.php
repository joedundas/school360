<?php
$PAGE = new PageController(
new userDTO(),
new schoolDTO(),
new AuthorizationDTO(),
new AuthViewDTO(),
new FeatureFlipDTO()
);
$PAGE->loadSessionInfo();





?>
<!DOCTYPE html>
<html lang="en">
<head>

</head>

<body class="nav-md">


<!-- page content -->
<div role="main">
    <div class="">


        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="row">

<?php

                            $roles = $PAGE->getUsersRoles();
      foreach($roles as $userRoleId=>$info) {
          echo HTMLGenerator::createUserRoleCard(
              $userRoleId,
              $PAGE->getUserDto(),
              array(
                'showSchool'=>true
              )
              );
      }
                            ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->




</body>


