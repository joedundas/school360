<?php
$PAGE = (new SessionManager())->reviveSessionFromCache();





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

                            $roles = $PAGE->user->roles()->asArray();
      foreach($roles as $roleId=>$roleDto) {

          echo HTMLGenerator::createUserRoleCard(
                $roleDto,
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


