$(document).ready(function(){
    $('.pass_open_eye').hide();
    $('.cpass_open_eye').hide();

    function testInput(event) {
        var value = String.fromCharCode(event.which);
        var pattern = new RegExp(/[a-zåäö ]/i);
        return pattern.test(value);
     }
     $('#full_name').bind('keypress', testInput);

     //code to check if user already exists
     $('#username').on('input',function(){
        var username = $('#username').val();
        //console.log(username);
        $.ajax({
            type: 'POST',
            url: 'ajax_work.php',
            data: {username : username},
            success: function(data) {
                console.log(data);
                if(data=='User Name already Exists')
                {
                    $('#usernameVerify').text("Username Already exists!").css("color", "red");
            $('#username').css("border-color","red");
                }
                else
                {
                   $('#usernameVerify').text("Valid username!").css("color", "green");
            $('#username').css("border-color","green");
                }
            },
            error: function() {
                console.log(response.status);
            },
        })
    })
    //code to check whether new email is getting registered or old
    $('#email').on('input',function(){
        var email = $('#email').val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regex for email validation

    if (emailRegex.test(email)){
        $.ajax({
            type: 'POST',
            url: 'ajax_work.php',
            data: {sign_up_email : email},
            success: function(data) {
                console.log(data);
                if(data=='Email is already registered')
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
    })
    

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
    
    $('#submit').on('click',function(e){
        e.preventDefault();
        $email_verify =  $('#emailVerify').text();
        $password_verify = $('#pass_verify').text();
        $confirm_password_verify = $('#confirm_password_verify').text();
        $username_verify=$('#usernameVerify').text();
        if( $email_verify=="Valid email!")
            {
                 if($username_verify=="Valid username!")
                {
                    if($password_verify=="Valid Password !")
                    {
                        if($confirm_password_verify=="Password matched !")
                        {
                                $username_register=$('#username').val();
                                $full_name = $('#full_name').val();
                                $email = $('#email').val();
                                $password = $('#password').val();
                                $.ajax({
                                    type: 'POST',
                                    url: 'ajax_work.php',
                                    data: {full_name : $full_name, 
                                        email: $email, password : $password,
                                        username_register:$username_register},
                                    success: function(data) {
                                        console.log(data);
                                        if(data=='Register')
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
                        alert("Password must be more than 8 charaters and have a Upper case letter and number");
                    }
                }
                else{
                     alert("Please input valid username!");
                 }
                
             }
            else{
                alert("Please input a valid email!");
            }
          e.preventDefault();
    })
    });

