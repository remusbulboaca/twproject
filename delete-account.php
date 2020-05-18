<?php require_once('includes/functions/function.php') ;
require_once ('includes/functions/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/delete-account.css">
</head>
<body>

    <div class="all">
    <div class="top">
        <a href="home.php">COLR</a>
        <h3>If you delete your account, every cap from your personal and favorite collection will be deleted never to be recovered again</h3>
        <div class="next">
            <h4>Next</h4>
            <img src="images/arrow.png" alt="">
        </div>
    </div>

    <div class="allign">
    <form action="" method="POST" class="form">
        <input type="submit" value="YES"  class="SignUp" name="go" method="post" >
        <a href="profile-personal-details.php" class="no">NO</a>
        <?php echo delete_account(); ?>
    </form>
    </div>
    </div>

</body>
</html>