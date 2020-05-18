<?php require_once('includes/functions/function.php') ;
require_once ('includes/functions/config.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/profile-personal-details.css">
</head>
<style>
    .bottom a{
    text-decoration: none;
    color:white;
    font-family:'proxima_nova_rgregular';
    background:#f22c2c;
    padding:0.8em 2em;
    border-radius: 10px;
    transition: all 0.3s ease 0s;
}

.bottom a:hover{
    border-radius:0;
    background:#bf1d1d;
    letter-spacing: 1px;
    transition: all 0.3s ease 0s;
}

</style>

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
                <img src="images/<?php echo get_profile_image($_SESSION['userName'])?>" alt="">
                <div class="name">
                    <h1> 
                    <?php get_Fname($_SESSION['userName'])?> <?php get_Lname($_SESSION['userName'])?>
                    </h1>
                </div>
            </div>
            <div class="bar">
                <a href="" class="pd">Personal details</a>
                <a href="profile-favorite-items.php">Favorite items</a>
                <a href="profile-personal-collection.php">Personal Collection</a>
            </div>
        </div>

        <div class="bottom">
        <h1>personal <span>details</span></h1>
            <div class="info">
            <div class="username">
                <h2>Name:</h2>
                <h3><?php get_Fname($_SESSION['userName'])?> <?php get_Lname($_SESSION['userName'])?></h3>
                <h2>Username:</h2>
                <h3><?php echo $_SESSION['userName'];  ?></h3>
            </div>

            <div class="email">
                <h2>Email:</h2>
                <h3><?php get_email($_SESSION['userName'])?></h3>
            </div>

            <div class="items">
                <h2>No of items in collection:</h2>
                <h3><?php echo get_noofcaps($_SESSION['userName']) ?></h3>
            </div>
            <div class="logout">
            <a href="logout.php">Logout</a>
            </div>
            </div>

        <div class="reset">

            <input type="button" onclick="location.href='reset-password.php'" value="Reset your password">
            <input type="button" onclick="location.href='change-profile-picture.php'" value="Change profile picture">
            <input type="button" onclick="location.href='delete-account.php'" value="Delete this account">
        </div>
            

        </div>


    </div>

    
</div>
</body>
</html>