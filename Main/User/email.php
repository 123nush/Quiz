<?php

require "../connection/connect.php";
if(!empty($_POST['send_email']) && !empty($_POST['send_username']) && !(empty($_POST['otp'])))
{
        $email = $_POST['send_email'];
        $username=$_POST['send_username'];
        $otp=$_POST['otp'];
        // echo '<script>';
        // echo($otp);
        // echo '</script>';
        $get_user_name = "SELECT * FROM `USER` WHERE `email` = '$email' ";
        $execute_query = mysqli_query($con,$get_user_name);
        if(mysqli_num_rows($execute_query)>0)
        {
                while($row = mysqli_fetch_assoc($execute_query))
                {
                        $name = $row['name'];
                }
        }

        ?>
        
        <div id="emailContent" style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; background-color: #f9f9f9;">
        <div style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; background-color: #f9f9f9;'>
    <table style='height: 100%; width: 100%; background-color: #f5f6f8;'>
        <tbody>
            <tr>
                <td valign='top' class='edimg' style='padding: 5px; box-sizing: border-box; text-align: center;'>
                    <img src='https://wallpaperaccess.com/full/2384073.jpg' alt='Image' width='108' style='border-width: 0px; border-style: none; max-width: 108px; width: 100%;'>
                </td>
            </tr>
            
            <tr>
                <td valign='top' class='edtext' style='background-color: #ffffff;padding: 32px; text-align: left; color: #5f5f5f; font-size: 15px; '>
                    
                    <p class='text-center' style='text-align: center; margin: 0px; padding: 0px;'>
                        Hello <strong><?php echo($name);?></strong>!
                    </p>
                        <br>
                    <p class='text-center' style='text-align: center; margin: 0px; padding: 0px;'>You have requested to reset the password of your account</p>
                        <br>
                        <br>
                    <p class='text-center' style='text-align: center; margin: 0px; padding: 0px;'>
                        Please find the security code to change your password: <strong><?php echo($otp);?></strong>
                    </p>
                </td>
            </tr>
                            <tr>
                                <td valign='top' class='edtext' style='padding: 20px; text-align: left; color: #5f5f5f; font-size: 15px;'>
                                    <p class='text-center' style='line-height: 1.75em; text-align: center; margin: 0px; padding: 0px;'>
                                        <span style='font-size: 11px;'>
                                            If you no longer wish to receive mail from us, you can <a href='{unsubscribe}' style='background-color: initial; color: #5457ff; text-decoration: none;'>unsubscribe</a>
                                        </span>
                                        <br>
                                        <span style='font-size: 11px;'>{accountaddress}</span>
                                    </p>
                                </td>
                            </tr>    
        </tbody>
    </table>

</div>
  </div>
  <script>
    // console.log("Sending emial");
    function sendEmail(){
            Email.send({
            SecureToken:"f2f3cfda-66c6-4625-b3cb-01d2c950bda6",
            To : <?php echo($email); ?>,
            From : "dalvianushka999@gmail.com",
            Subject : "Reset password for skill analysis quiz",
            Body : document.getElementById('emailContent').innerHTML
        }).then(
        message => {
            alert("OTP sent successfully on "+<?php echo($email); ?>);
        }
        );
    }
    sendEmail();
    // console.log("email send");

        </script>
  <?php
}
?>