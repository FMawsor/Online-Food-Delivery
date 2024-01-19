<?

    //include constants.php file here
    include('../config/constants.php');
    //1. get the ID of Admin to be deleted
    $id= $_GET['id'];


    //2.create SQL Query to delete Admin
    $sql = "DELETE tbl_admin WHERE id=$id";

    //execute the query
    $res = mysql_query($conn, $sql);
    
    //check whether the query executed sucessfully or not
     if($res==true)
     {
            //query executed successfully and Admin deleted
           //echo "Admin deleted";
          //create Session variable to display message

          $_SESSION['delete'] ="Admin Deleted Successfully.";
          //redirect to Manage Admin page 
          header('location:'.SITEURL.'admin/manage-admin.php');
      }
    else
        {
         
             //failed to delete admin
            //echo "Failed to delete admin";

         $_SESSION['delete'] = "Failed to deleted Admin.Try Again Later.";
         header('location:'.SITEURL.'admin/manage-admin.php');
        }
    
   //3.redirect to Manage Admin page with message (success/error)

   ?>