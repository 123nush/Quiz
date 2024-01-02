$(document).ready(function(){
    var  emailChanged = false;
    var  passwordChanged = false;
    var  confirmpasswordchanged=false; 
    var update_username;
    var originalEmail=$('#update_email').val();
    update_username=$('#username').val();
    $('.pass_open_eye').hide();
    $('.cpass_open_eye').hide();
    function testInput(event) {
        var value = String.fromCharCode(event.which);
        var pattern = new RegExp(/[a-zåäö ]/i);
        return pattern.test(value);
     }
    $('#update_full_name').bind('keypress', testInput);
    $('#update_email').on('input',function(){
        emailChanged=true;
        var update_email = $('#update_email').val();
        if(update_email==''){
            $('#emailVerify').text("Enter Valid Email!").css("color", "red");
            $('#email').css("border-color","red");
        }
        else if(originalEmail!=update_email){
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 
            if (emailRegex.test(update_email)){
                $.ajax({
                    type: 'POST',
                    url: 'ajax_work.php',
                    data: {update_user_email : update_email},
                    success: function(data) {
                        console.log(data);
                        if(data=='Email already exists')
                        {
                            $('#emailVerify').text("Email Already registered!").css("color", "red");
                    $('#email').css("border-color","red");
                        }
                        else
                        {
                            $('#emailVerify').text("Valid email!").css("color", "green");
                    $('#email').css("border-color","green");
                        }
                    },
                    error: function() {
                        console.log(response.status);
                    },
                })
            }
            else if(update_email==originalEmail){
                $('#emailVerify').text("Valid email!").css("color", "green");
                $('#email').css("border-color","green");
            }
        }
    })
    $('.pass_icon').on('click',function(){
        if('password' == $('#update_password').attr('type')){
            $('#update_password').prop('type', 'text');
            $('.pass_open_eye').show();
            $('.pass_close_eye').hide();
       }else{
            $('#update_password').prop('type', 'password');
            $('.pass_open_eye').hide();
            $('.pass_close_eye').show();
       }
    })
    $('.confirm_pass_icon').on('click',function(){
        if('password' == $('#update_confirm_password').attr('type')){
            $('#update_confirm_password').prop('type', 'text');
            $('.cpass_open_eye').show();
            $('.cpass_close_eye').hide();
    
       }else{
            $('#update_confirm_password').prop('type', 'password');
            $('.cpass_open_eye').hide();
            $('.cpass_close_eye').show();
       }
    })
    $('#update_password').on("input",function(){
        passwordChanged=true;
        $password = $('#update_password').val();
        if($password.length >= 8){
            if(/[A-Z]/.test($password) && /\d/.test($password)) 
            {
                $('#pass_verify').text("Valid Password !").css("color", "green");
                $('#update_password').css("border-color","green");
            }
            else {
                $('#pass_verify').text("Password must contain a uppercase letter and number.").css("color", "red");
                $('#update_password').css("border-color","red");
            }
            
        }
        else{
            $('#pass_verify').text("Password must be more than 8 characters.").css("color", "red");
            $('#update_password').css("border-color","red");
        }
        
    })
    $('#update_confirm_password').on("input",function(){
        confirmpasswordchanged=true;
        $password = $('#update_password').val();
        $confirm_password = $('#update_confirm_password').val();
        if($password==$confirm_password){
                $('#confirm_password_verify').text("Password matched !").css("color", "green");
                $('#update_confirm_password').css("border-color","green");
        }
        else{
            $('#confirm_password_verify').text("Password not matched !").css("color", "red");
                $('#update_confirm_password').css("border-color","red");
        }
    })
    
    $('#submit').on('click',function(e){
        e.preventDefault();
        if ((emailChanged && $('#emailVerify').text() === 'Valid email!') || !emailChanged) {
            if ((passwordChanged && $('#pass_verify').text() === 'Valid Password !') || !passwordChanged) {
                if((confirmpasswordchanged && $('#confirm_password_verify').text()==='Password matched !') || !confirmpasswordchanged){
                    var update_full_name = $('#update_full_name').val();
                    var update_email = $('#update_email').val();
                    var update_password = $('#update_password').val();
                    var confirm_update_password=$('#update_confirm_password');
                    console.log(confirm_update_password);
                    $.ajax({
                    type: 'POST',
                    url: 'ajax_work.php',
                    data: {update_full_name : update_full_name,
                    update_email: update_email,
                    update_password : update_password,
                    update_username:update_username},
                    success: function(data) {
                    console.log(data);
                    if(data=='User Data updated successfully')
                    {
                    window.location.href="../User/participant_profile.php";
                    }                                 
                    else
                    {
                    alert("Sorry Something went wrong");
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
            } else {
                alert("Password must be more than 8 characters and have an uppercase letter and number");
            }
        } else {
            alert("Please input a valid email!");
        }
        
          e.preventDefault();
    })
    });

