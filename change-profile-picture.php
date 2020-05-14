<?php require_once('includes/functions/function.php') ;
require_once ('includes/functions/config.php');
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/change-profile-picture.css">
</head>
<body>
<?php if(loggedIn()==true){
                    }
                    else{
                        redirect('profile-nologin.php');
                    }?>
    <div class="all">
    <div class="top">
        <a href="home.php">COLR</a>
        <h3>Organize, find and enjoy 
            your cap’s collection in a
            modern, relaxed and 
            dynamic way</h3>
        <div class="next">
            <h4>Next</h4>
            <img src="images/arrow.png" alt="">
        </div>
    </div>

    <div class="allign">
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" id="file" class="inputfile" />
        <label for="file"><span id="file-name">Choose a file </span></label>
        

        <script>  
        let inputFile=document.getElementById('file');
        let filenameField= document.getElementById('file-name');
        inputFile.addEventListener('change',function(event){
                let uploadedFileName = event.target.files[0].name;
                filenameField.textContent = uploadedFileName;
        })
        
        </script>
        <input type="Submit" value="Submit" class="SignIn"/>
        <?php echo upload_profile_image() ?>
        </form>
</div>
    </div>
</body>
</html>