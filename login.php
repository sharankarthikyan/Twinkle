<?php
  require "dbconnect.php";
  if(isset($_POST['login']))
  {
    if ( isset($_SESSION['Twinkle'])!="" ) 
    {
      header("Location: index1.php");
      exit;
    }
    $errMSG='';
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashPassword = hash('sha256',$password);
    if($email=="admin@gmail.com"&& $password=="password")
    {
      header("Location:Admin/index.html");
    }
    
    $res=mysqli_query($scon,"SELECT * FROM information WHERE email='$email'");
    $row=mysqli_fetch_array($res);
    $count = mysqli_num_rows($res);      
    
    if($count == 1 && $row['pass'] == $password)
    {
      if($row['category']=="Staff")
      {
        $_SESSION['Users'] = $row['email'];
        header("Location: Staff/index.html");
      }
      else if($row['category']=="Student")
      {
        $_SESSION['Users'] = $row['email'];
        header("Location: Student/BS3/dashboard.html");
      }
    }
    else{
      $errMSG = "Invalid data. Check credentials. <br>";
    }            
  }

  if(isset($_POST['signup']))
  {
    $errMSG='';
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $category = $_POST['category'];
    $hashPassword = hash('sha256',$password);
    if($password == $repassword)
    {
      $res=mysqli_query($scon,"SELECT * FROM information WHERE email='$email'");
      $row=mysqli_fetch_array($res);
      $count = mysqli_num_rows($res);
      if($count == 0)
      {
        $sql = "INSERT INTO information (username, email, category, pass)VALUES ('$username', '$email', '$category', '$password')";
        if ($scon->query($sql) === TRUE) {
          echo "New record created successfully";
        }
        else
        {
          echo "Error: " . $sql . "<br>" . $scon->error;
        }
      } 
      else{
        $errMSG="E-mail already taken";
      }   
    }
    else
    {
      $errMSG="Check the Password";
    }

  }
?>

<!DOCTYPE html>
<html>
    <head>
    <title>Signin-Signup</title>
        <link rel="stylesheet" href="css/login.css">
        <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
</head>
<body>
    <h1 id="Pagetitle">Twinkle Portal</h1>

           <div class="login">  
            <h2>Welcome Back!</h2>
               <br>
          <form action="login.php" method="post">
         
            <div class="field-wrap">
            <input type="email" name="email" placeholder="E-mail" required autocomplete="off"/>
          </div>
          <br>
          <div class="field-wrap">
            <input type="password" name="password" placeholder="Password" required autocomplete="off"/>
          </div><br>
         
          <p class="forgot"><a href="#">Forgot Password?</a></p>
              <br><br>
         
          <button class="button button-block" name="login">Log In</button>
         
          </form>
        </div>
     
        <div class="signup">  
          <h2>Get On Board</h2>
         
          <form action="login.php" method="post" >
            <div class="field-wrap">
              <input type="text" name="username" placeholder="Name" required autocomplete="off" />
            </div>
       
          <div class="field-wrap">
            <input type="email" name="email" placeholder="E-mail" required autocomplete="off"/>
          </div>
         
          <div class="field-wrap">
            <input type="password" name="password" placeholder="Enter Password" required autocomplete="off"/>
          </div>
             
          <div class="field-wrap">
            <input type="password" name="repassword" placeholder="Confirm Password" required autocomplete="off"/>
          </div>
          
          <input type="radio" id="Staff" name="category" value="Staff">
          <label for="Staff">Staff</label><br>
          <input type="radio" id="Student" name="category" value="Student">
          <label for="Student">Student</label><br>
          
          <button type="submit" name="signup" class="button button-block">Sign Up</button>
          </form>
        </div>
       
   
    <!-- tab-content -->

        <div id='stars'></div>
        <div id='stars2'></div>
        <div id='stars3'></div>
        

</body>
</html>