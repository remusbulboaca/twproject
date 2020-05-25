<?php
include 'functionsproduct.php';


function abcd(){
if(isset($_POST['submit'])){
    $conn = getDB();

    $allowed = [
        'name' => 'like',
        'year' =>'=',
        'location' => 'like',
        'alcool' => 'like',
    ];

    $name = $_POST['name'];
    $year = $_POST['year'];
    $location = $_POST['location'];
    $alcool = $_POST['alcool'];

    $fields = [];
    $queryParts = [];
    $parameters = [];

   

    foreach($allowed as $field => $op){
        if($$field==null || $$field=='none'){
        }else{
            $fields[] = $field;
            $value = $$field;
            if($op == 'like'){
                $value = sprintf('%%%s%%',$value);
            }
            $xx = sprintf('`%s` %s ?',$field,$op);
            array_push($queryParts,$xx);
            array_push($parameters,$value);
            
            echo "<br>";
        }
    }
    $sql = sprintf('SELECT * FROM caps where 1 AND %s',implode(' AND ',$queryParts));
    
    $host = '127.0.0.1';
    $db   = 'TW';
    $user = 'root';
    $pass = '';
    $port = "3306";
    $charset = 'utf8mb4';

    $options = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";


    $pdo = new \PDO($dsn, $user, $pass, $options);

    $stmt = $pdo->prepare($sql);
    if($stmt){
        $stmt->execute($parameters);
        while($row = $stmt->fetch()){
            echo "<div class='card'>";
                echo "<img src='product_images/".$row['image']."'"."style:100%>";
                echo "<h1>".$row['name']."</h1>";
                echo "<p class='price'>".$row['year']."</p>";
                echo "<p>".$row['location']."</p>";
                echo "<a href='productView.php?id=".$row['id']."'><button>View Product</button></a>";
            echo "</div>";
        }
    }
}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <title>Search</title>
    <link rel="stylesheet" href="css/search.css">
</head>
<body>
    <header>
        <div class="topheader">
            <a href="" class="logoclass">COLR</a>
            <a href="addproduct.php" class="button1">Add Product</a>
            <img src="images/icons8-male-user-48.png" alt="" class="profile">
        </div>

        <div class="bottomheader">
            <form method="POST" action="search.php">
                <div class="searchInput">
                <input type="text" id="name" name="name" placeholder="Search name or description">
                </div>
                <div class="searchOpt">
                <input type="number" name="year" id="year" placeholder="Year">
                <input type="text" name="location" id="location" placeholder="City">
                <select id="alcool" id="alcool" name="alcool">
                    <option value="none">Drink type</option>
                    <option value="alcool">Bautura Alcoolica</option>
                    <option value="noalcool">Bautura Nealcoolica</option>
                </select> 
                </div>
                <div class="searchBtn">
                <input type="submit" id="submit" name="submit" value="Search!">
            </div>
            </form>
        </div>
    </header>

    <div class="content">

        <div class="cardList">
              <?php abcd() ?>
              
    </div>
        </div>
    </div>
    <div class="footer">
        <a href="" class="footerlink">Popular Caps</a>
        <a href="" class="footerlink">  Statistics</a>
    </div>



</body>
</html>