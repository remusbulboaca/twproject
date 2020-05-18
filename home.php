<?php require_once('includes/functions/function.php') ;
require_once ('includes/functions/config.php');
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css/home.css">
</head>

<style>

.searchButton{
    background-image: url(images/icons8-search-24.png);
    background-repeat: no-repeat;
    background-position: center;
}
</style>
<body>
    <header>
            <a href="home.php" class="logoclass" >COLR</a>
            <a href="addproduct.php" class="button1" >ADD PRODUCT</a>
            <img src=<?php echo "images/icons8-male-user-48.png" ?> alt="" class="profile" onclick="location.href='profile-personal-details.php'">
            
    </header>

    <div class="subtitle">
        <div class="SPAN">
        <h1><span>your cap’s</span>
        collection
        in one place</h1>
    </div>
    
        <div class="wrap">
            
                <form action="" class="search" method="POST">
                        <input type="text" class="searchTerm" placeholder="You can search caps or users" name="search" id="search">
                        <button type="submit" class="searchButton" > <i class="b-search"></i></button>
                </form>
                <?php redirect_search() ?>
        </div>

        </div>
<div class="bottom">
    <a href="popular-caps.php" >Popular Caps</a>
    <a href="popular-caps.php" >Statistics</a>
</div>



</body>
</html>