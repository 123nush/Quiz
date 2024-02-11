$(document).ready(function(){
    $('.pass_open_eye').hide();
    $('.alert-danger').hide();
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
    
    $('#submit').on('click',function(e){
        e.preventDefault();
        $username = $('#username').val();
        $password = $('#password').val();
        $.ajax({
            type: 'POST',
            url: 'ajax_work.php',
            data: {username_login: $username, password_login : $password},
            success: function(data) {
                console.log(data);
                if(data.trim()==='1')
                {
                    // alert(data);
                    window.location.href = '../User/quiz_section.php';
                }
                else if(data.trim()==='2')
                {
                    // alert(data);
                    window.location.href = '../admin/admin_home.php';
                }
                else{
                    $('#failed').modal('show');
                }
            },
            error: function() {
                console.log(response.status);
            },
        })
        e.preventDefault();
    })
    // intended to prevent users from navigating back to the previous page in a browser's history.
    function disableBack() {
                    window.history.forward()
                }
                window.onload = disableBack();
                window.onpageshow = function(e) {
                    if (e.persisted)
                        disableBack();
                }                      
    })