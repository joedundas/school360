<!doctype html>
<html lang="en">
<head>
	<title>StudioFlow Sign In</title>
	@include(
		'includes.head',
		array('formValidation'=>true)
	)
	<link rel="stylesheet" href="css/registration.css">
</head>

<script>
    var controller = new controller(
        new pageController(
            new modalController(),
            new workingBlindController()
        ),
        new sessionController()
    );

    var ajax = new ajaxController();


</script>
<body>


<form action="" id="msform" name="signInForm">

	<fieldset id="signIn">
		<h2 class="fs-title">Secure Sign In</h2>
		{{--<h3 class="fs-subtitle">The owner of the studio will own the StudioFlow account</h3>--}}
		<input type="email" name="email" placeholder="Email" id='email' value="jdunda1@gmail.com"/>
		<input type="password" id='password' name="password" placeholder="Password" value=""/>
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>

	<fieldset id="forgotPassword">
		<h2 class="fs-title">Forgot your password?</h2>
		<h3 class="fs-subtitle">Enter your e-mail below and we will help you reset your password</h3>
		<input type="email" name="emailForReset" id='emailForReset' placeholder="Email" value=""/>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>

</form>
</body>
</html>

<script>

//	var validator;
//	var currentFormData;
//	$().ready(function() {
//        getSurroundingFieldSet(current_fs_id);
//		validator = new MyBiz.validationHelper();
//		validator.fetch(
//		    'user',
//			['email','password'],
//			'#msform'
//		);
//	});



	var fs_order = new Array(
	  	'signIn','forgotPassword'
	);
	var current_fs, next_fs, previous_fs; //fieldsets
	var current_fs_id = 'signIn';
	var next_fs_id,previous_fs_id;
	var left, opacity, scale;
	var animating;
	var signup_id = 0;
	$(".next").click(function(){
	    if(current_fs_id == 'signIn') {
			var email = $('#email').val().trim();
			var password = $('#password').val().trim();



            controller.page.ajax.send(
                {
                    url:'public/auth/login',
                    data:{
                        'email':email,
						'password':password
					},
                    'callback': {
                        'success':receiveAuthentication
                    }
                }
            );
//            ajaxFeed(
//                {
//                    'url': 'login',
//                    'loader':'#msform',
//                    'stopSubsequentAttemptsUntilComplete':true,
//                    'data': {
//                        'email':email,
//						'password':password
//                    },
//                    'submitType': 'POST',
//                    'successCallback': receiveAuthentication
//                }
//            );
//            var validator = $("#msform").validate();
//            if (validator.form()) {
//               // createIniUser();
//            }
        }
        else if(current_fs_id == 'forgotPassword') {

		}
		else {
	        alert("Where am i?");
		}
		//moveSlidesForward();
	});

	function receiveAuthentication(data) {
        controller.page.blind.hide();
	    alert(JSON.stringify(data));
	    if(data.hasErrors) {
	        alert("NO way dude!!");
			return 1;
		}
		window.location.href = 'secure';
	}
	$(".previous").click(function(){
        moveSlidesBackward();
	});

	$(".submit").click(function(){
		return false;
	})

	function setSurroundingFieldSet(input) {
	    next_fs_id = input.next;
	    previous_fs_id = input.previous;
	}
	function getSurroundingFieldSet(fs) {
	    var output = {
	       'previous':'',
			'next':''
		};
	    for(var i=0; i<fs_order.length; i++) {
	        if(fs_order[i] == fs) {
	            if(i+1 <= fs_order.length) {
	                output.next = fs_order[i+1];
				}
	            return output;
	        }
	        output.previous = fs_order[i];
		}
	}
	function moveSlidesBackward() {
        if(animating) return false;
        animating = true;

        setSurroundingFieldSet(getSurroundingFieldSet(current_fs_id));

        current_fs = $('#' + current_fs_id);
        previous_fs = $('#' + previous_fs_id);

        current_fs_id = previous_fs_id;
        previous_fs.show();

        current_fs.animate({opacity: 0}, {
            step: function(now, mx) {
                scale = 0.8 + (1 - now) * 0.2;
                left = ((1-now) * 50)+"%";
                opacity = 1 - now;
                current_fs.css({'left': left});
                previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
            },
            duration: 800,
            complete: function(){
                current_fs.hide();
                animating = false;
            },
            easing: 'easeInOutBack'
        });
	}
	function moveSlidesForward() {
        if(animating) return false;
        animating = true;

		setSurroundingFieldSet(getSurroundingFieldSet(current_fs_id));

        current_fs = $('#' + current_fs_id);
        next_fs = $('#' + next_fs_id);

        current_fs_id = next_fs_id;

        next_fs.show();

        current_fs.animate({opacity: 0}, {
            step: function(now, mx) {
                scale = 1 - (1 - now) * 0.2;
                left = (now * 50)+"%";
                opacity = 1 - now;
                current_fs.css({
                    'transform': 'scale('+scale+')',
                    'position': 'absolute'
                });
                next_fs.css({'left': left, 'opacity': opacity});
            },
            duration: 800,
            complete: function(){
                current_fs.hide();
                animating = false;
            },
            easing: 'easeInOutBack'
        });

	}
</script>
