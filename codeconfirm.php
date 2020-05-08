<?php require_once('includes/functions/function.php');
include ('includes/functions/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignIn</title>
    <link rel="stylesheet" href="css/codeconfirm.css">
</head>

<body>
    <body>
    <header>
        <a href="home.php">COLR</a>
    </header>
    <div class="all">
        <h2>Organize, find and enjoy 
            your cap’s collection in a
            modern, relaxed and 
            dynamic way</h2>


    <div class="Forgot">
        
        <form method="POST">
        <h1>confirmation <span>code</span></h1>
            <input type="password" id="code" name="code" placeholder="Enter code" required><br><br>
            <div class="signin">
            <button class="button"> Verify</button>
            </div>
            <?php echo validate_code() ?>
        </form>
    
    </div>
    
    </div>  
    
        
    
</body>
</body>
</html>