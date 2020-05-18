<?php
include ('includes/functions/config.php');
require_once('includes/functions/function.php');
$web_url=$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
$str="<?xml version='1.0' ?>";
$str .="<rss version='2.0'>";
$str .="<channel>";
    $str.="<title>COLR</title>";
    $str.="<description>Your cap’s collection in one place</description>";
    $str.="<language>en-US</language>";
    $str.="<link>$web_url</link>";


    $noOfCaps= no_of_popular_caps();
    for($i = 1; $i <= $noOfCaps; $i++){
        $id_cap=get_id_cap_popular($i);
        $str.="<item>";
                $str.="<title>".get_cap_name_popular($i)."</title>";
                $str.="<description>".get_cap_year_popular($i)."</description>";
                $str.="<link>".$web_url."/productView.php?id=".$id_cap."</link>";

        $str.="</item>";
    }


$str.="</channel>";
$str.="</rss>";
file_put_contents("rss.xml",$str);
?>