<?php

include("../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;

$auth = Auth::check();

$table = new UsersTable( new MySQL() );

$id = $auth->id;

$name = $_FILES['photo']['name'];
$tmp = $_FILES['photo']['tmp_name'];
$error = $_FILES['photo']['error'];
$type = $_FILES['photo']['type'];

if( $error ) {
    HTTP::redirect( "profile.php", "error=file" );
}

if($type === "image/jpeg" || $type === "image/png") {
    $table->updatePhoto( $id, $name );
    move_uploaded_file($tmp, "photos/" . $name);
    HTTP::redirect( "/profile.php" );
} else {
    HTTP::redirect( "/profile.php", "error=type" );
}