<?php

include("../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;

$auth = Auth::check();

$table = new UsersTable( new MySQL() );

$id = $auth->id;

$password = md5( $_POST['password'] );
$password1 = md5( $_POST['password1'] );
$password2 = md5( $_POST['password2'] );

if( $table->checkPassword( $id, $password ) ) {
    if( $password1 === $password2 ) {
        $table->updatePassword( $id, $password1 );
        HTTP::redirect( "/profile.php" );
    } else {
        HTTP::redirect( "/profile.php", "pass=match" );
    }
} else {
    HTTP::redirect( "/profile.php", "pass=incorrect" );
}