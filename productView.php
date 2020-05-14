<?php require_once('includes/functions/function.php') ;
require_once ('includes/functions/config.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProductView</title>
    <link rel="stylesheet" href="css/productView.css">
</head>
<body>
    <?php  $id=$_GET['id'];?>
    <section class="top">
      <div class="img-container">
        <header>
             <a href="">COLR</a>
            <div class="search">
                <form action=""> 
                    <label for="search"></label>
                    <input type="text" name="search" id="search">
                </form>
            </div>
            <div class="profile">
                <img src=<?php echo "images/icons8-male-user-48.png" ?> alt="" class="profile" onclick="location.href='profile-personal-details.php'">
            </div>
        </header>
        <div class="images">
            <img src="images/<?php echo get_cap_image_product($id) ?>" alt="">
        </div>

        
       
      </div>


    <div class="name">
        
        <a href="home.php">COLR</a>
        <button type ="button"> Return to search </button>
        <div class="cap">
            <h1><?php  echo get_cap_name_product($id) ?></h1>
                <h4> est <?php  echo get_cap_year_product($id) ?></h4>
                <form action="" method="POST">
                <input type="image" src="images/icons8_add_to_favorites_30.png" name="favorite" class="favorite">
                <?php echo add_to_favorite($id) ?>
                </form>
                
                
        </div>
        
        
    </div>
</section>

    <div class="contentText">
    <h2>User which have this cap: </h2>
        <img src="images/<?php echo get_cap_owner_image($id)?>" alt="" onclick="location.href='profile-user-personal-details.php?username=<?php echo get_username_by_productid($id) ?>'">
        <h2>Description</h2>
        <p><?php echo get_cap_description($id) ?></p>

        <h2>History</h2>
        <p><?php echo get_cap_history($id)  ?></p>

    </div>



</body>
</html>