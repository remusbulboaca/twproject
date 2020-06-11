<?php
include ('includes/functions/config.php');
require_once('includes/functions/function.php');
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics</title>
    <link rel="stylesheet" type="text/css" href="css/stats.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['', ''],
          ['Popular Caps',   <?php echo no_of_popular_caps() ?>],
          ['No Popular Caps',      <?php echo  abs(get_nr_caps() - no_of_popular_caps()) ?>]
          
        ]);

        var options = {
          title: '',
          legendTextStyle: {
            color: 'white',
            fontName: 'Gobold',
            fontSize: 12,
            bold: 0,
           italic: 0
          },
          backgroundColor: 'transparent',
          titleTextStyle: {
            color: 'white',
            fontName: 'Gobold',
            fontSize: 20,
            bold: 0,
           italic: 0
          },
          
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
</head>

<body>
    <header>
            <a href="home.php" class="logoclass" >COLR</a>
        
    </header>
    

    <div class="subtitle">
       
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
       <div id="piechart" style="width: 800px; height: 400px; "></div>
    
        <div class="wrap">
          <div class="stats">
                <div class="totalUsers">
                    <h3>Total Users</h3>
                    <h2><?php echo get_nr_user() ?></h2>
                </div>
                <div class="totalProducts">
                    <h3>Total Products</h3>
                    <h2><?php echo get_nr_caps() ?></h2>
                  
                </div>
                <div class="TopUser">
                    <h3>Top User</h3>
                    <h2><?php echo get_top_user() ?></h2>
                  
                </div>
                <div class="LastUser">
                    <h3>Last User</h3>
                    <h2><?php echo get_last_user() ?></h2>
                  
                </div>
                <div class="LastCaps">
                    <h3>Last Caps</h3>
                    <h2><?php echo get_last_caps() ?></h2>
                  
                </div>
                
        </div>
    </div>

        </div>

</body>
</html>