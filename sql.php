<?php
define('DBHOST','localhost');
define('DBUSER','catalogue');
define('DBPASS','ujdx645a');
define('DBNAME','catalogue');

try {
        $db = new PDO("mysql:host=".DBHOST.";port=3306;dbname=".DBNAME, DBUSER, DBPASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
        //show error
        echo '<p>'.$e->getMessage().'</p>';
        exit;
}
