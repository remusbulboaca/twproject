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
<?php if(loggedIn()==true){
                       
                    }
                    else{
                        redirect('profile-nologin.php');
                    }?>
    <div class="all">
        <div class="top">
            <a href="home.php" class="logo">COLR</a>
            <div class="profile">
                <img src="images/Ellipse 21.png" alt="">
                <div class="name">
                    <h1> 
                    <?php get_Fname($_SESSION['userName'])?> <?php get_Lname($_SESSION['userName'])?>
                    </h1>
                </div>
            </div>

            <div class="bar">
                <a href="profile-personal-details.php" >Personal details</a>
                <a href="profile-favorite-items.php">Favorite items</a>
                <a href="" class="pd">Personal Collection </a>
            </div>
        </div>
        
        <div class="bottom">
        <h1>personal <span>collection</span></h1>
        <div class="allcaps">            
        <?php
                    
                    $noOfCaps= get_noofcaps($_SESSION['userName']);
                    
                    for($i = 1; $i <= $noOfCaps; $i++){
                            $id_cap=get_cap_id_collection($i,$_SESSION['userName']);
                            
                    ?>
                    <div class="product" onclick="location.href='productView.php?id=<?php echo $id_cap ?>'">
                        <img src="images/<?php echo get_cap_image_collection($i,$_SESSION['userName']) ?>" alt="" >
                        <div class="nameCap">
                            <h2><?php echo get_cap_name_collection($i,$_SESSION['userName'])  ?></h2>
                            <h3>est <?php echo get_cap_year_collection($i,$_SESSION['userName'])  ?></h3>
                        </div>
                    </div>

                    <?php } ?>
                    


            
                    </div>
        </div>


    </div>

    
</div>
</body>
</html>