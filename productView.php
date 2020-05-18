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
    <script type="text/javascript" src="js/googlemap.js"></script>
</head>

<body>
    <?php  $id=$_GET['id'];
    if (!isset($id)) redirect('home.php');

    if(confirm_cap_id($id)=='0') redirect('home.php');
    
    
    ?>
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
                <img src=<?php echo "images/icons8-male-user-48-2.png" ?> alt="" class="profile" onclick="location.href='profile-personal-details.php'">
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
                <input type="image" src="images/icons8_add_to_favorites_30.png" name="favorite" class="favorite" id="favorite" >
                <input type="hidden" name="number1" value="number1">
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


        <h2>Location: </h2>
        <?php $location= get_cap_location($id)?>
       
        
        <div id="floating-panel">
      <input id="address" type="hidden" value="<?php echo $location ?>">
    </div>
    <div id="map"></div>
    <script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          center: {lat: -34.397, lng: 150.644}
        });
        var geocoder = new google.maps.Geocoder();

          geocodeAddress(geocoder, map);
        
      }

      function geocodeAddress(geocoder, resultsMap) {
        <?php $location="Iasi"?>  
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBh86Regcye5iR9QMCJiynW-JNfbwIGIMQ&callback=initMap">
    </script>




      <h5>Product added on: <?php echo get_cap_add_year($id) ?></h5>
      <h5><?php echo get_cap_no_fav($id) ?> users have this product in their favorite list</h5>

      <?php 
                $owner=cap_owner($id);
                if($owner==$_SESSION['userName']){
                  echo '<div class="delete">
                  <form method="POST">
                  <input type="submit" value="Delete this product"  name="go" method="post" >
                  <input type="hidden" name="number2" value="number2">
                  </form>
                  </div>';
                }
                echo delete_cap($id);
                ?>
    </div>

    

</body>

</html>