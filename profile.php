<?php

include( "vendor/autoload.php");

use Helpers\Auth;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;

$auth = Auth::check();

$id = $auth->id;

$table = new UsersTable( new MySQL() );
$auth = $table->findById( $id );
$rosters = $table->getAllRoster();
$lack = [];

if( $auth->role_id === 1 ) {
    $own = $table->getOwnedRoster( $id );
    $arr1 = [];
    foreach( $rosters as $roster ) $arr1[] = $roster->id;
    $arr2 = [];
    foreach( $own as $roster ) $arr2[] = $roster->id;
    $lacks = array_diff( $arr1, $arr2 );
    $lack = [];
    foreach( $lacks as $roster ) {
        $lack[] = $table->findRoster( $roster );
    }
} else {
    $own = $rosters;
    $lack = [];
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-08"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Profile</title>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <script src="https://kit.fontawesome.com/9b20e7d2a7.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container px-2">
            <nav class="navbar navbar-expend-lg navbar-dark bg-gradient bg-dark sticky-top">
                <div class="container-fluid px-3">
                    <a href="#" class="navbar-brand  fst-italic fw-bolder text-primary">TenkafuMa</a>
                    <ul class="navbar nav">
                        <li class="nav-item dropdown">
                            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                                <img src="_actions/photos/<?= $auth->photo ?>" alt="profile" 
                                style="width : 40px; heigh : 40px; border-radius : 20px;"/>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li>
                                    <a href="#" class="dropdown-item disabled">
                                        <i class="fa-solid fa-user me-2"></i>
                                        <span class="text-capitalize">
                                            <?= $auth->name ?>
                                        </span>
                                    </a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <span class="dropdown-item" data-bs-toggle="modal" data-bs-target="#change-profile">
                                        <i class="fa-solid fa-image me-2"></i>Change Profile
                                    </span>
                                </li>
                                <li>
                                    <span class="dropdown-item" data-bs-toggle="modal" data-bs-target="#change-name">
                                    <i class="fa-solid fa-address-card me-2"></i>Change Name
                                    </span>
                                </li>
                                <li>
                                    <span class="dropdown-item" data-bs-toggle="modal" data-bs-target="#change-password">
                                        <i class="fa-solid fa-key me-2"></i>Change Password
                                    </span>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="_actions/logout.php" class="dropdown-item">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <?php if( isset( $_GET['error'] ) ): ?>
                <div class="alert alert-warning">
                    Cannot Upload File.
                </div>
            <?php endif ?>

            <?php if( isset( $_GET['pass'] ) ) { 
                if( $_GET['pass'] == "match" ) { ?>
                    <div class="alert alert-warning">
                        Passwords Don't Match.
                    </div>
                <?php } elseif( $_GET['pass'] == "incorrect" ) { ?>
                    <div class="alert alert-danger">
                        Incorrect Password.
                    </div>
            <?php }} ?>
            
            <ul class="nav nav-tabs nav-fill mt-2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#all"><i class="fa-solid fa-users me-2"></i>All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#owned"><i class="fa-solid fa-user-check me-2"></i>Owned</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#lacked"><i class="fa-solid fa-user-xmark me-2"></i>Lacked</a>
                </li>
            </ul>

            <div class="tab-content">
                
                <div id="all" class="tab-pane container active">
                    <div class="container m-2 p-2">
                        <div class="row">
                            <?php foreach( $rosters as $roster ) : ?>
                                <div class="text-center col-12 col-lg-3">
                                    <div class="card mb-3" 
                                        data-bs-toggle="modal" data-bs-target="#roster<?= $roster->id ?>">
                                        <div class="card-body">
                                            <img src="_actions/rosters/<?= $roster->photo ?>" alt="<?= $roster->name ?>" 
                                            class="w-100 h-90 mb-2"/>
                                            <span class="h3 text-primary"><?= $roster->name ?></span>
                                        </div>
                                    </div>
                                </div>    
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                
                <div id="owned" class="tab-pane container fade">
                    <div class="container m-2 p-2">
                        <div class="row">
                            <?php foreach( $own as $roster ) : ?>
                                <div class="text-center col-12 col-lg-3">
                                    <div class="card mb-3" 
                                    data-bs-toggle="modal" data-bs-target="#roster<?= $roster->id ?>">
                                        <div class="card-body">
                                            <img src="_actions/rosters/<?= $roster->photo ?>" alt="<?= $roster->name ?>" 
                                            class="w-100 h-90 mb-2"/>
                                            <span class="h3 text-primary"><?= $roster->name ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                
                <div id="lacked" class="tab-pane container fade">
                    <div class="container m-2 p-2">
                        <div class="row">
                            <?php foreach( $lack as $roster ) : ?>
                                <div class="text-center col-12 col-lg-3">
                                    <div class="card mb-3" 
                                    data-bs-toggle="modal" data-bs-target="#roster<?= $roster->id ?>">
                                        <div class="card-body">
                                            <img src="_actions/rosters/<?= $roster->photo ?>" alt="<?= $roster->name ?>" 
                                            class="w-100 h-90 mb-2"/>
                                            <span class="h3 text-primary"><?= $roster->name ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="change-profile">
                
                <div class="modal-dialog">
                    <div class="modal-content">
                        
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa-solid fa-image me-2"></i>Change Profile</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <form action="_actions/upload.php" method="post" enctype="multipart/form-data">
                                <div class="input-group mb-3">
                                    <input type="file" name="photo" class="form-control"/>
                                    <button class="btn btn-secondary"><i class="fa-solid fa-upload me-2"></i>Upload</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>

            <div class="modal" id="change-name">
                
                <div class="modal-dialog">
                    <div class="modal-content">
                        
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa-solid fa-address-card me-2"></i>Change Name</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <form action="_actions/rename.php" method="post">
                                <div class="input-group mb-3">
                                    <input type="text" name="name" class="form-control"/>
                                    <button class="btn btn-secondary"><i class="fa-solid fa-address-card me-2"></i>Change</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>

            <div class="modal" id="change-password">
                
                <div class="modal-dialog">
                    <div class="modal-content">
                        
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa-solid fa-key me-2"></i>Change Password</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <form action="_actions/changePassword.php" method="post">
                                <div class="form-floating mb-2">
                                    <input 
                                        type="password" 
                                        name="password" 
                                        placeholder="Current Password" 
                                        class="form-control" 
                                        id="password" required/>
                                    <label for="password"><i class="fa-solid fa-key me-2"></i>Current Password</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input 
                                        type="password" 
                                        name="password1" 
                                        placeholder="New Password" 
                                        class="form-control" 
                                        id="password1" required/>
                                    <label for="password1"><i class="fa-solid fa-key me-2"></i>New Password</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input 
                                        type="password" 
                                        name="password2" 
                                        placeholder="Confirm Password" 
                                        class="form-control" 
                                        id="password2" required/>
                                    <label for="password2"><i class="fa-solid fa-key me-2"></i>Confirm Password</label>
                                </div>
                                <button class="w-100 btn btn-primary">Change</button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>

            <?php foreach( $rosters as $roster ) : ?>
                <div class="modal" id="roster<?= $roster->id ?>">
                
                    <div class="modal-dialog">
                        <div class="modal-content bg-primary">
                        
                            <div class="modal-header">
                                <h5 class="modal-title fw-bolder">
                                    <i class="fa-solid fa-user-ninja me-6"><?= $roster->name ?></i>
                                </h5>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                
                                <div class="row mb-2">
                                    <div class="col">
                                    <img class="w-100" src="_actions/rosters/<?= $roster->photo ?>" alt="<?= $roster->name ?>"/>
                                    </div>
                                    <div class="col">
                                        <div class="text-start bg-dark text-light p-2" 
                                            style="font-family : roboto, arial; font-size : 90%;">
                                            <?= $roster->info ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <div class="col card bg-dark text-light me-2">
                                        <div class="card-header">
                                            <div class="card-title fw-bold">Ultimate Skill</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-text"><?= $roster->ultimate_skill ?></div>
                                        </div>
                                    </div>
                                    <div class="col card bg-dark text-light me-2">
                                        <div class="card-header">
                                            <div class="card-title fw-bold">Normal Skill</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-text"><?= $roster->normal_skill ?></div>
                                        </div>
                                    </div>
                                    <div class="col card bg-dark text-light">
                                        <div class="card-header">
                                            <div class="card-title fw-bold">Leader Skill</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-text"><?= $roster->leader_skill ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col me-2 bg-light bg-transparent">
                                        <h5 class="d-block disabled mb-2">ATK</h5>
                                        <p class="d-block disabled"><?= $roster->attack ?></p>
                                    </div>
                                    <div class="col bg-light bg-transparent">
                                        <h5 class="d-block disabled mb-2">HP</h5>
                                        <p class="d-block disabled"><?= $roster->hp ?></p>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <span class="w-25 input-group-text">Rarity</span>
                                    <input type="text" placeholder="
                                        <?php 
                                            switch( $roster->rarity_id ) {
                                                case 1: 
                                                    echo "SSR";
                                                    break;
                                                case 2: 
                                                    echo "SR";
                                                    break;
                                                case 3: 
                                                    echo "R";
                                                    break;
                                                case 4: 
                                                    echo "N";
                                                    break;
                                            }
                                        ?>" class="form-control" id="rarity" readonly/>
                                </div>

                                <div class="input-group mb-3">
                                    <span class="w-25 input-group-text">Job</span>
                                    <input type="text" placeholder="
                                        <?php 
                                            switch( $roster->job_id ) {
                                                case 1: 
                                                    echo "Attacker";
                                                    break;
                                                case 2: 
                                                    echo "Defender";
                                                    break;
                                                case 3: 
                                                    echo "Obstructer";
                                                    break;
                                                case 4: 
                                                    echo "Supporter";
                                                    break;
                                                case 5:
                                                    echo "Healer";
                                                    break;
                                            }
                                        ?>" class="form-control" id="job" readonly/>
                                </div>

                                <div class="input-group mb-3">
                                    <span class="w-25 input-group-text">Attribute</span>
                                    <input type="text" placeholder="
                                        <?php 
                                            switch( $roster->attribute_id ) {
                                                case 1: 
                                                    echo "Fire";
                                                    break;
                                                case 2: 
                                                    echo "Water";
                                                    break;
                                                case 3: 
                                                    echo "Wind";
                                                    break;
                                                case 4: 
                                                    echo "Light";
                                                    break;
                                                case 5: 
                                                    echo "Dark";
                                                    break;
                                            }
                                        ?>" class="form-control" id="attribute" readonly/>
                                </div>
                                
                            </div>

                        </div>
                    </div>

                </div>
            <?php endforeach ?>
        </div>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>