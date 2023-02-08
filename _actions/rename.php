<?php

include("../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;

$auth = Auth::check();

$table = new UsersTable( new MySQL() );

$id = $auth->id;

$name = $_POST['name'];

$table->updateName( $id, $name );
HTTP::redirect( "/profile.php" );