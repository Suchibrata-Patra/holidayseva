<?php session_start(); /* Starts the session */
        
        /* Check Login form submitted */        
        if(isset($_POST['Submit'])){
                /* Define username and associated password array */
                $logins = array('Sumannayak' => 'Suman@1997','username1' => 'password1','username2' => 'password2');
                
                /* Check and assign submitted Username and Password to new variable */
                $Username = isset($_POST['Username']) ? $_POST['Username'] : '';
                $Password = isset($_POST['Password']) ? $_POST['Password'] : '';
                
                /* Check Username and Password existence in defined array */            
                if (isset($logins[$Username]) && $logins[$Username] == $Password){
                        /* Success: Set session variables and redirect to Protected page  */
                        $_SESSION['UserData']['Username']=$logins[$Username];
                        header("location:index.php");
                        exit;
                } else {
                        /*Unsuccessful attempt: Set error message */
                        $msg="<span style='color:red'>Invalid Login Details</span>";
                }
        }
?>





<form action="" method="post" name="Login_Form">
<?php if(isset($msg)){?>
    <tr>
      <td colspan="2" align="center" valign="top"><?php echo $msg;?></td>
    </tr>
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <div class="container" style="margin-top:-30%;border: 1px solid rgb(175, 175, 175);padding: 70px 20px 50px 20px;background-color: white;">
            <!-- <center style="font-weight:200;font-size:2rem;color:#0061c9;">Login</center> -->
            <center style="font-weight:200;font-size:2rem;color:#0061c9;"><img src="https://holidayseva.com/wp-content/uploads/2024/06/cropped-holidayseva.com_favicon-1.png" alt="" style="height:50px;width: 50px;"></center>
          <label for="tour_package">User id</label>
          <input name="Username" type="text" class="Input" style="padding: 10px 100px 10px 10px;border: 1px solid rgb(165, 165, 165);border-radius: 0px;" placeholder="Enter User ID">
          <br>
          <br>
          <label for="pricing">Password</label>
          <input name="Password" id="password" type="password" class="Input" style="padding: 10px 100px 10px 10px;border: 1px solid rgb(181, 181, 181);border-radius: 0px;" placeholder="Enter Password">
          
          <!-- Toggle switch to show/hide password -->
          <div class="password-toggle-container">
            <label class="toggle-switch">
              <input type="checkbox" id="show-password">
              <span class="slider"></span>
            </label>
            <span>Show Password</span>
          </div>
          <center>
          <button type="submit" name="Submit" type="submit" value="Login" class="Button3" style="margin-top:20px;padding: 9px 44.5%;border-radius:0px;font-weight: 300;">Signin</button>
          </center>

        </div>

    </form>

    <style>
        .password-toggle-container {
          display: flex;
          align-items: center;
          margin-top: 10px;
        }
      
        .toggle-switch {
          position: relative;
          display: inline-block;
          width: 48px;
          height: 20px;
        }
      
        .toggle-switch input {
          opacity: 0;
          width: 0;
          height: 0;
        }
      
        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #dadada;
          transition: 0.4s;
          border-radius: 50px;
        }
      
        .slider:before {
          position: absolute;
          content: "";
          height: 15px;
          width: 15px;
          border-radius: 50%;
          left: 4px;
          bottom: 5px;
          background-color: white;
          transition: 0.4s;
        }
      
        input:checked + .slider {
          background-color: #4CAF50;
        }
      
        input:checked + .slider:before {
          transform: translateX(25px);
        }
      
        .password-toggle-container span {
          margin-left: 10px;
          font-size: 14px;
        }
      </style>
      
      <script>
        // Get the toggle switch and password input elements
        const showPasswordToggle = document.getElementById('show-password');
        const passwordInput = document.getElementById('password');
      
        // Add event listener to toggle password visibility
        showPasswordToggle.addEventListener('change', function() {
          if (this.checked) {
            passwordInput.type = 'text'; // Show the password
          } else {
            passwordInput.type = 'password'; // Hide the password
          }
        });
      </script>

    <style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap");
    
    body {
      font-family: "Inter", sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 90vh;
      background-color: #f1f1f1;
    }
    
    .form-container {
      max-width: 900px;
      width: 90%;
      padding: 3px;
      background-color: #ffffff;
      border-radius: 0px;
      border: 0.5px solid #bababa;
    }
    
    .form-container h1 {
      font-size: 2rem;
      margin: 0 0 20px;
      color: #333;
      text-align: center;
      font-weight: 400;
    }
    
    form {
      display: grid;
      gap: 16px;
    }
    
    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }
    
    label {
      display: block;
      font-size: 1.1rem;
      margin-bottom: 0px;
      color: #014283;
      font-weight: 500;
    }
    
    input,
    textarea {
      width: 100%;
      padding: 10px 14px;
      font-size: 0.95rem;
      border: 1px solid #dcdcdc;
      border-radius: 0px;
      background-color: #ffffff;
      transition: border-color 0.2s;
    }
    
    input:focus,
    textarea:focus {
      border-color: #007aff;
      outline: none;
      background-color: #fff;
    }
    
    textarea {
      resize: none;
      height: 80px;
    }
    
    button {
      padding: 12px;
      background-color: #007aff;
      color: white;
      font-size: 1rem;
      font-weight: 600;
      border: none;
      border-radius: 2px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    
    button:hover {
      background-color: #005bb5;
    }
    
    .toggle-container {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .switch {
      position: relative;
      display: inline-block;
      width: 34px;
      height: 20px;
    }
    
    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }
    
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      transition: 0.4s;
      border-radius: 20px;
    }
    
    .slider:before {
      position: absolute;
      content: "";
      height: 14px;
      width: 14px;
      left: 3px;
      bottom: 3px;
      background-color: white;
      transition: 0.4s;
      border-radius: 50%;
    }
    
    input:checked + .slider {
      background-color: #007aff;
    }
    
    input:checked + .slider:before {
      transform: translateX(14px);
    }
    
    .checkbox-container {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .food-toggle-wrapper {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    #meal_plan_field {
      display: flex;
      align-items: center;
    }
    
    #meal_plan {
      margin-left: 10px;
    }
  </style>