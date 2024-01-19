<?php include('partials-front/menu.php'); ?>



<html>
    <head>
        <title>Login - food service system</title>
        <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

<div class="login">
    <h1 class="text-center">Login</h1>
<br><br>

<?php
    if(isset($_SESSION['login']))
    {
        echo $_SESSION['login'];
        unset($_SESSION['login']);
    }

    if(isset($_SESSION['no-login-message']))
    {
        echo $_SESSION['no-login-message'];
        unset($_SESSION['no-login-message']);
    }
?>
<br><br>
    <!--Login Form starts here-->
    <form action="" method="POST" class="text-center">
        Username: <br>
        <input type="text" name="username" placeholder="Enter username"> <br><br>

        Password: <br>
        <input type="password" name="password" placeholder="Enter Password"> <br><br>

        <input type="submit" name="submit" value="Login" class="btn-primary">
        <br><br>
    </form>
    <!--Login Form end here-->

    <p class="text-center">Created By - <a href="www.frankymawsor.com">Franky Mawsor</a></p>
</div>

</body>
</html>

<?php 
    //check whether the submit button is clicked or not
    if(isset($_POST['submit']))
   {
    //process for login

    //1. get the data from the login form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    //2. SQL to check whether the user with username and password exists or not
    $sql = "SELECT * FROM tbl_user_login WHERE username='$username' AND password='$password'";
    
    //3.execute the query
    $res = mysqli_query($conn, $sql);

    //4. count rows to check whether the user exists or not
    $count = mysqli_num_rows($res);

    if($count==1)
    {
        //user available and login success
        $_SESSION['login'] = "<div class='success'>Login Successfully.</div>";
        $_SESSION['user'] = $username;  //to check wherher the user is login or not and logout will unst it
        //redirect to home page/dashboard
        header('location:'.SITEURL);
    }
    else 
    {
        // user not available and login fail
        $_SESSION['login'] = "<div class='error text-center'>Username or password did not matched.</div>";
        //redirect to home page/dashboard
        header('location:'.SITEURL);
    }
} 
?>