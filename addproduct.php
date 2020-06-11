<?php
    require_once('functionsproduct.php');
    ob_start();
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>
        <title>Add Cap</title>
        <link rel="stylesheet" href="css/addproduct.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyBU_xuzlNRWJ6aciJaWJNH6QXuBAdGVeDg"></script>
    </head>
    <body>
        <header>
            <div class="topheader">
                <a href="home.php" class="logoclass">COLR</a>
                <img src="images/<?php echo displayProfilePicture()?>" alt="" class="profile" onclick="location.href='profile-personal-details.php'">
            </div>
        </header>

        <div class="content">
            <div class="main">
                <div class="title">
                    <h1>ADD CAPS</h1>
                    <h1>IN YOUR COLLECTION</h1>
                </div>
                <div class="forminput">
                    <form method="POST" action="addproduct.php" enctype="multipart/form-data">
                        <label for="capname">CAP'S NAME</label>
                        <input type="text" id="capname" name="capname" required>

                        <label for="year">EST YEAR</label>
                        <input type="text" id="year" name="year" required>

                        <label for="location"> LOCATION </label>
                        <input type="text" class="form-control" id="search_input" name="location" required>

                        <label for="description">DESCRIPTION</label>
                        <input type="text" id="description" name="description" required>

                        <label for="history">HISTORY</label>
                        <input type="text" id="history" name="history" required>

                        <label for="img">
                            <span class="material-icons">
                                insert_photo
                                </span> &nbsp;
                            ADD IMAGE</label>
                        <input type="file" id="img" name="img" accept="image/*" required>
                        <input type="submit" name="submit" value="Submit">
                        <?php addproduct() ?>
                    </form>
                </div>
            </div>
            <div class="info">
                <h3>Organize,find and enjoy</h3>
                <h3>your caps collection in a</h3>
                <h3>modern,relaxed and</h3>
                <h3>dynamic way.</h3>
            </div>
        </div>
<script>
    var searchInput = 'search_input';
 
    $(document).ready(function () {
    var autocomplete;
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
    types: ['geocode'],
    /*componentRestrictions: {
    country: "USA"
    }*/
 });
  
 google.maps.event.addListener(autocomplete, 'place_changed', function () {
  var near_place = autocomplete.getPlace();
 });
});
</script>
    </body>
</html>