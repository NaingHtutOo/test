<?php

include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\HTTP;

$table = new UsersTable( new MySQL() );

$name = $_POST['name'];
$email = $_POST['email'];
$password = md5( $_POST['password'] );
$password2 = md5( $_POST['password2'] );

if( $table->findByEmail( $email ) ) {
    HTTP::redirect( "/register.php", "email=exist" );
} elseif( $password !== $password2 ) {
    HTTP::redirect( "/register.php", "pass=match" );
} else {
    $table->addUser( $name, $email, $password );
    HTTP::redirect( "/index.php", "registered=1" );
}