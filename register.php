<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Home</title>
        <meta charset="UTF-08"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <script src="https://kit.fontawesome.com/9b20e7d2a7.js" crossorigin="anonymous"></script>

        <style>
            .warp {
                width: 100%;
                max-width: 400px;
                margin: 40px auto;
            }
        </style>
    </head>
    <body class="text-center">
        <div class="warp">
            <h1 class="h3 mb-3">Register</h1>
            
            <?php if( isset( $_GET['email'] ) ) : ?>
                <div class="alert alert-danger">Account Already Exist</div>
            <?php endif ?>

            <?php if( isset( $_GET['pass'] ) ) : ?>
                <div class="alert alert-warning">The Two Passwords Doesn't Match</div>
            <?php endif ?>

            <form action="_actions/create.php" method="post">
                <div class="form-floating">
                    <input type="text" name="name" placeholder="Name" class="form-control" id="name" required/>
                    <label for="name"><i class="fa-solid fa-address-card me-2"></i>Name</label>
                </div>
                <div class="form-floating">
                    <input type="email" name="email" placeholder="Email" class="form-control" id="email" required/>
                    <label for="email"><i class="fa-solid fa-envelope me-2"></i>Email</label>
                </div>
                <div class="form-floating">
                    <input type="password" name="password" placeholder="Password" class="form-control" id="password" required/>
                    <label for="password"><i class="fa-solid fa-key me-2"></i>Password</label>
                </div>
                <div class="form-floating">
                    <input type="password" name="password2" placeholder="Confirm Password" class="form-control" id="password2" required/>
                    <label for="password2"><i class="fa-solid fa-key me-2"></i>Confirm Password</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary">Register</button>
            </form>
            <br/>
            <a href="index.php">Login</a>
        </div>
    </body>
</html>