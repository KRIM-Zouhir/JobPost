<?php

// $db = null ;

try {
    $db = new PDO('mysql:host=localhost;dbname=jobboard;charset=utf8;', 'root', 'YourDbPassword');
}

catch (Exception $e) {
    echo "An error has occured!";
}

?>
