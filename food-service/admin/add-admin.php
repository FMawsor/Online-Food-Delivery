<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br /><br />

        <?php
          if(isset($_SESSION['add'])) //checking whether the session is set or  not
          {
              echo $_SESSION['add']; //display the session message if set
              unset($_SESSION['add']);  //remove session message
          } 
        ?>

        <form action="" method="POST">

        <table class="tbl-30">
            <tr>
                <td>Full Name: </td>
                <td>
                <td><input type="text" name="full_name"placeholder="Enter your name"></td>
            </tr>
        </tr>

            <tr>
                <td>Username: </td>
                <td>
                <td><input type="text" name="username"placeholder="Your username"></td>
            </tr>
         </tr>

            <tr>
            <td>Password: </td>
            <td>
                <td><input type="password" name="password"placeholder="Your password">
            </td>
        </tr>
          
        <tr>
            <td colspan="2">
                <input type="Submit" name="submit" value="Add Admin" class="btn-secondary">
</td>
</tr>
        </table>

        </form>


    </div>
</div>


<?php include('partials/footer.php'); ?>


<?php
    //process the value from form and save it in database

    //check whether the submit button is clicked or not

if(isset($_POST['submit'])) 
  {
       //button clicked 
       //echo "Button Clicked";
 
 
     //get the data from form
  $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = md5($_POST['password']) ; //Password Encryption with MD5

  //2.SQL querry to save tne data into database
  $sql = "INSERT INTO tbl_admin SET
      full_name='$full_name',
      username='$username',
      password='$password'
      ";

      //3.executing query and saving data into database
     $res = mysqli_query($conn,$sql) or die(mysqli_error());

     //4.check whether the (query is executed) data is inputted or not and display appropriate message
     if($res==TRUE)
     {
         //data inserted
         //echo "data inserted"
         //create a session variable to display message
         $_SESSION['add']= "Admin Added Succesfully";
         //redirect page to manage admin
         header("location:".SITEURL.'admin/manage-admin.php');
     }
     else
     {
         //failed to insert data
         //echo "data not inserted"
         //create a session variable to display message
         $_session['add']= "failed to add admin";
         //redirect page to add admin
         header("location:".SITEURL.'admin/add-admin.php');
     }
  }

?>
