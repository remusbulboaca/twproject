<?php


$connection = mysqli_connect('localhost','root','','TW');
if (!$connection){
    echo 'CONNECTION TO DATABASE ERROR';
}

function escape($string){
    GLOBAL $connection;
    return mysqli_real_escape_string($connection,$string);
}

//querry function
function query($query){
    GLOBAL $connection;
    return mysqli_query($connection,$query);
}


//confirmation funtion
function confirm($result){
    GLOBAL $connection;
    if(!$result){
        die('Query failed'.mysqli_error($connection));
    }
}

//fetch

function fetch_data($result){
    GLOBAL $connection;
    return mysqli_fetch_assoc($result);
}

//no of rows

function no_of_rows($count){
    return mysqli_num_rows($count);
}

?>