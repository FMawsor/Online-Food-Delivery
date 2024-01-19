<?php
//include const page
include('../config/constants.php');
//echo "delete";
if(isset($_GET['id']) && isset($_GET['image_name'])) //use "AND" or &&
{
    //process to delete
   // echo "Process to Delete";
   //1.get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
   //2.remove the image if available
   //check whether the image is available or not  and delete only if available
   if($image_name!= "")
   {
    //it has image and need to remove
    $path = "../images/food/".$image_name;

    //remove image file from folder
    $remove = unlink($path);

    //check whether the image is remove or not
    if($remove==false)
    {
        //fail to remove image
        $_SESSION['upload'] = "<div class='error'>Failed to Remove Image.</div>";
        //redirect to manage food
        header('location:'.SITEURL.'admin/manage-food.php');
        //stop the process of deleting food item
        die();
    }
   }
   
   //3.delete food from dbse 
        $sql = "DELETE FROM tbl_food WHERE id=$id";
   //execute the query
   $res = mysqli_query($conn, $sql);

   //check whether the query execute or not and set the session message respectively
   //4.redirect to manage food with session message
   if($res==true)
   {
        //food deleted
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
   }
   else 
   {
    //failed to delete food
    $_SESSION['delete'] = "<div class='error'>Failed to delete food.</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
   }
}

   else 
{
    //redirect to manage food page
   
    $_SESSION['unauthorize'] = "<div class='error'>unauthorized Acces</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
}
   


?>