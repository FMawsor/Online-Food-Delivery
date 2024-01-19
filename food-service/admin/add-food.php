<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php 
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
        <tr>
        <td>Title:</td>
        <td>
            <input type="text" name="title" placeholder="Title of the food">
</td>
</tr>
<tr>
    <td>Description</td>
    <td>
        <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
</td>
</tr>
<tr>
    <td>Price</td>
    <td>
        <input type="number" name="price">
</td>
</tr>
<tr>
    <td>Select Image:</td>
    <td>
        <input type="file" name="image">
</td>
</tr>
<tr>
    <td>Category:</td>
    <td>
        <select name="category">
            <?php //create php to display categories from database
            //craete sql to get all active categories from database
            $sql = "SELECT * from tbl_category where active='Yes'";

            //executing query
            $res = mysqli_query($conn, $sql);
            
            //count rows to check whether we have categories or not
            $count = mysqli_num_rows($res);

            //if count is greater than zero we have categories else we do not have
            if($count>0)
            {
                //we have categories
                while($row=mysqli_fetch_assoc($res))
                {
                    //get the details of categories
                    $id  = $row['id'];
                    $title = $row['title'];
                    ?>

                    <option value="<?php echo $id?>"><?php echo $title; ?></option>
                    <?php
                }
            }
            else
            {
                //we do not have categories
                ?>
                <option value="0">No Category found</option>
                <?php
            }
            //display on dropdown
            ?>
            
        </select>
</td>
</tr>
<tr>
    <td>Featured:</td>
    <td>
        <input type="radio" name="featured" value="Yes">Yes
        <input type="radio" name="featured" value="No">No
</td>
</tr>
<tr>
    <td>Active:</td>
     <td>
        <input type="radio" name="active" value="Yes">Yes
        <input type="radio" name="active" value="No">No
    </td>
</tr>
<tr>
    <td colspan="2">
        <input type="submit" name="submit" value="Add food" class="btn-secondary">
</td>
</tr>
</table>

    </form>

    <?php 
    //check whether the button is click or not
    if(isset($_POST['submit']))
    {
        //Add the food in the database
        //echo "Click";
        //1. to get the data from form 
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        //check whether the radio button for featured and active are click or not
        if(isset($_POST['featured']))
        {
            $featured = $_POST['featured'];
        }
        else
        {
            $featured = "No"; //setting deafult value
        }
        if(isset($_POST['active']))
        {
            $active = $_POST['active'];
        }
        else
        {
            $active = "No"; //setting deafult value
        }

        //2.uoload the image if selected
        //check whether the image is select or not and upload the image only if the image is selected
        if(isset($_FILES['image']['name']))
        {
            //get the details of the selected image
            $image_name = $_FILES['image']['name'];
            
            //check whether the image is selected or not and upload image only if the image is selected
            if($image_name!="")
            {
                //image is selected
                //rename the image
                //get the extension of the selected image like jpg,png
                $ext = end(explode('.',$image_name));
                
                //create new name for image
                $image_name = "Food-name".rand(0000,9999).".".$ext; //new image name

                //B. upload the image
                //get the src path and destination path

                //src path is the current location of the image
                $src =$_FILES['image']['tmp_name'];

                //destiantion path for the image to be uploaded
                $dst = "../images/food/".$image_name;

                //finally upload the food image
                $upload = move_uploaded_file($src, $dst);

                //check whether image uploaded or not
               if($upload==false)
                {
                   //Failed to upload image
                   
                   $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                   //redirect to add food page with error message
                   header('location:'.SITEURL.'admin/add-food.php');
                    //stop the process
                    die();
                }
           
            }

        }
        else
        {
            $image_name = ""; //setting default value as blank
        }

        //3 insert into database

        //create sql query to save or add food
        //for numerical value we not need to past value inside code but for string value it is compulsary
        $sql2 = "INSERT INTO tbl_food SET 
        title = '$title',
        description = '$description',
        price = $price,
        image_name = '$image_name',
        category_id = $category,
        featured = '$featured',
        active = '$active'
        ";

        //execute the query
        $res2 = mysqli_query($conn, $sql2);

        //whether data inserted or not
         //4. redirect message to manage food page 
        if($res2 == true)
        {
            //data inserted successfully
            $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //data not inserted(fail)
            $_SESSION['add'] = "<div class='error'>Failed to add food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
       
    }

    ?>

</div>
</div>
<?php include('partials/footer.php'); ?>