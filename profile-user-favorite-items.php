<?php require_once('includes/functions/function.php') ;
require_once ('includes/functions/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FavoriteItems</title>
    <link rel="stylesheet" href="css/profile-favorite-items.css">
</head>
<body>
<?php
    $username=$_GET['username'];
    ?>
    <div class="all">
        <div class="top">
            <a href="home.php" class="logo">COLR</a>
            <div class="profile">
            <img src="images/<?php echo get_profile_image($username)?>" alt="">
                <div class="name">
                    <h1> 
                    <?php get_Fname($username)?> <?php get_Lname($username)?>
                    </h1>
                </div>
            </div>

            <div class="bar">
                <a href="profile-user-personal-details.php?username=<?php echo $username ?>" >Personal details</a>
                <a href="" class="pd">Favorite items</a>
                <a href="profile-user-personal-collection.php?username=<?php echo $username ?>">Personal Collection</a>
            </div>
        </div>
        
        <div class="bottom">
        <h1>favorite <span>items</span></h1>
        <div class="allcaps">            
                    
                    <?php
                    
                    $noOfCaps= get_noofcaps_favorite($username);
                    
                    for($i = 1; $i <= $noOfCaps; $i++){
                            $id_cap=get_cap_id($i,$username);
                            
                    ?>
                    <div class="product" onclick="location.href='productView.php?id=<?php echo $id_cap ?>'">
                        <img src="images/<?php echo get_cap_image($i,$username) ?>" alt="" >
                        <div class="nameCap">
                            <h2><?php echo get_cap_name($i,$username)  ?></h2>
                            <h3>est <?php echo get_cap_year($i,$username)  ?></h3>
                        </div>
                    </div>

                    <?php } ?>


            
                    </div>
        </div>


    </div>

    
</div>
</body>
</html>