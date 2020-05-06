<?php
include ('includes/functions/config.php');
session_destroy();
redirect('profile-nologin.php');
?>