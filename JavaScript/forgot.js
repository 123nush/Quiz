//code to send otp only when username and email match
$(document).ready(function(){
    var otp;
    var email;
    var send_email;
    var send_username;
    otp = Math.floor(1000 + Math.random() * 9000);
$('#section2').hide();//for otp verification
$('#section3').hide();//to reset password
$('#sendotp').hide();
$('#CrossCheckUser').on('click',function(e){
    e.preventDefault();
    var email_message=$('#email').val();
    var username_message=$('#username').val();
    $email = $('#email').val();
    $username=$('#username').val();
    // console.log($email+" "+$username);
    // console.log(username_message+"  "+email_message);
    $.ajax({
        type: 'POST',
        url: 'ajax_work.php',
        data: {forgot_password_email :$email,forgot_password_username:$username},
        success: function(data) {
           // console.log(otp);
           // console.log(data);
            if(data=='User and Email Matched')
            {
                $('#verify').text("Valid details!click on get otp button").css("color", "green");
                $('#CrossCheckUser').hide();
                $('#sendotp').show();
            }
            else
            {
                $('#verify').text("Hello "+username_message+" your email and username not matched with registerd data in system").css("color", "red");
                $('#sendotp').hide();
            }
        },
        error: function() {
            console.log(response.status);
        },
    })
    e.preventDefault();
})
$('#sendotp').on('click',function(e){
    e.preventDefault();
    email=$('#email').val();
    send_email=$('#email').val();
    send_username=$('#username').val();
    sendEmail(send_email,otp,send_username);
    $('#section2').show();
    e.preventDefault();
})

function moveClass()
        {
            $('#emailTemp').html(" ");
        }

      function sendEmail(send_email,otp,send_username)
      {
        console.log("calling sendEmail()");
        $.ajax({
            type: 'POST',
            url:'email.php',
            data:{send_email:send_email,send_username:send_username,otp:otp},
            success: function(data){
                console.log(data);
                $('#emailTemp').html(data);
                setInterval(moveClass, 10000); 
            },
            error: function() {
                console.log(response.status);
            },
        })
      }
//code to verify otp
$('#verifyOtp').on('click', function(e) {
    e.preventDefault();
    verifyOTP(); // Call the verifyOYP function when the button is clicked
    e.preventDefault();
});
//code to dynamically move focus
function otp_field_focus() {
    const inputs = document.querySelectorAll('#otp > *[id]');
    for (let i = 0; i < inputs.length; i++) 
    { 
        inputs[i].addEventListener('keydown', function(event) 
        { 
            if (event.key==="Backspace" ) 
            { 
                inputs[i].value='' ; 
                if (i !==0) inputs[i - 1].focus(); 
            } 
            else 
            { 
                if (i===inputs.length - 1 && inputs[i].value !=='' ) 
                { 
                    return true; 
                } 
                else if (event.keyCode> 47 && event.keyCode < 58) 
                { 
                    inputs[i].value=event.key; 
                    $value = inputs[i].value;
                    if (i !==inputs.length - 1) inputs[i + 1].focus(); 
                    event.preventDefault(); 
                } 
                
            } 
        });
     } 
    } 
    otp_field_focus();
//code to verify otp
function verifyOTP() {
    var enteredOTP = $('#first').val() + $('#second').val() + $('#third').val() + $('#fourth').val();

    if (typeof otp !== 'undefined' && otp !== null) {
        if (enteredOTP === otp.toString()) {
            // alert('OTP verified successfully!');
            $('#invalidOtp').text('Now reset the password').css('color','green');
            $('#section3').show();

            // Perform actions after successful OTP verification
        } else {
            $('#invalidOtp').text('Invalid OTP. Please try again.').css('color','red');
        }
    } else {
        // Handle the case where generatedOTP is not defined or null
        console.error('generatedOTP is undefined or null');
    }
}
$('.pass_open_eye').hide();
$('.cpass_open_eye').hide();
$('.pass_icon').on('click',function(){
    if('password' == $('#password').attr('type')){
        $('#password').prop('type', 'text');
        $('.pass_open_eye').show();
        $('.pass_close_eye').hide();

   }else{
        $('#password').prop('type', 'password');
        $('.pass_open_eye').hide();
        $('.pass_close_eye').show();
   }
})
$('.confirm_pass_icon').on('click',function(){
    if('password' == $('#confirm_password').attr('type')){
        $('#confirm_password').prop('type', 'text');
        $('.cpass_open_eye').show();
        $('.cpass_close_eye').hide();

   }else{
        $('#confirm_password').prop('type', 'password');
        $('.cpass_open_eye').hide();
        $('.cpass_close_eye').show();
   }
})
$('#password').on("input",function(){
    $password = $('#password').val();
    if($password.length >= 8){
        if(/[A-Z]/.test($password) && /\d/.test($password)) 
        {
            $('#pass_verify').text("Valid Password !").css("color", "green");
            $('#password').css("border-color","green");
        }
        else {
            $('#pass_verify').text("Password must contain a uppercase letter and number.").css("color", "red");
            $('#password').css("border-color","red");
        }
        
    }
    else{
        $('#pass_verify').text("Password must be more than 8 characters.").css("color", "red");
        $('#password').css("border-color","red");
    }
    
})

$('#confirm_password').on("input",function(){
    $password = $('#password').val();
    $confirm_password = $('#confirm_password').val();
    if($password==$confirm_password){
            $('#confirm_password_verify').text("Password matched !").css("color", "green");
            $('#confirm_password').css("border-color","green");
    }
    else{
        $('#confirm_password_verify').text("Password not matched !").css("color", "red");
            $('#confirm_password').css("border-color","red");
    }
})
$('#resetpassword').on('click',function(e){
    e.preventDefault();
    $password_verify = $('#pass_verify').text();
    $confirm_password_verify = $('#confirm_password_verify').text();
    
    if($password_verify=="Valid Password !")
    {
        if($confirm_password_verify=="Password matched !")
        {
                $password = $('#password').val();
                $username = $('#username').val();
                $.ajax({
                    type: 'POST',
                    url: 'ajax_work.php',
                    data: {reset_password : $password,user_name:$username},
                    success: function(data) {
                        console.log(data);
                        if(data=='Password Reset')
                        {
                            $('#success').modal('show');
                        }                                 
                        else
                        {
                            $('#failed').modal('show');
                        }
                    },
                    error: function() {
                        console.log(response.status);
                    },
                })
        }
        else{
            alert("Your Password has not matched with the Password")
        }
    }
    else{
        alert("Password must be more than 8 charaters and have a Upper case letter and number ");
    }
    e.preventDefault();

})
    

})

          