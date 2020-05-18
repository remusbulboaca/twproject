<?php


$connection = mysqli_connect('localhost','root','','TW');
if (!$connection){
    echo 'CONNECTION TO DATABASE ERROR';
}
if(!function_exists('escape')){
function escape($string){
    GLOBAL $connection;
    return mysqli_real_escape_string($connection,$string);
}
}

if(!function_exists('escape')){
//querry function
function query($query){
    GLOBAL $connection;
    return mysqli_query($connection,$query);
}
}

if(!function_exists('confirm')){
//confirmation funtion
function confirm($result){
    GLOBAL $connection;
    if(!$result){
        die('Query failed'.mysqli_error($connection));
    }
}
}

//fetch
if(!function_exists('fetch_data')){
function fetch_data($result){
    GLOBAL $connection;
    return mysqli_fetch_assoc($result);
}
}
//no of rows
if(!function_exists('no_of_rows')){
function no_of_rows($count){
    return mysqli_num_rows($count);
}
}
?>