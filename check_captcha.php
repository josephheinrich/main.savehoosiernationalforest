<!-- <script async defer src="https://www.google.com/recaptcha/api.js?render=6LdDEakfAAAAAAguARIalRAKgGoCPowEnjFKipy3"></script> -->

<!-- <script>
    $(document).ready(function() {
       // when form is submit
        $('#subscribe_form').submit(function() {
            // we stoped it
            event.preventDefault();
            var email = $('#email').val();
            // needs for recaptacha ready
            grecaptcha.ready(function() {
                // do request for recaptcha token
                // response is promise with passed token
                grecaptcha.execute('6LdDEakfAAAAAAguARIalRAKgGoCPowEnjFKipy3', {action: 'create_comment'}).then(function(token) {
                    // add token to form
                    $('#subscribe_form').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                        // $.post("/public_html/process_captcha.php",{email: email, comment: comment, token: token}, function(result) {
                            $.post("process_captcha.php",{email: email, token: token}, function(result) {
                                console.log(result);
                                if(result.success) {
                                    console.log("captcha success");
                                    registeredSuccess();
                                } else {
                                    alert('Captcha verification failed. Please try again.');
                                }
                        });
                    });;
                });
            });
    });
  </script> -->