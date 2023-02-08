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
            <h1 class="h3 mb-3">Login</h1>

            <?php if( isset( $_GET['registered'] ) ) : ?>
                <div class="alert alert-success">Successfully Registered. Please Login.</div>
            <?php endif ?>

            <?php if( isset( $_GET['incorrect'] ) ) : ?>
                <div class="alert alert-warning">Incorrect Email or Password</div>
            <?php endif ?>
            
            <form action="_actions/login.php" method="post">
                <div class="form-floating">
                    <input type="email" name="email" placeholder="Your Email" class="form-control" id="email" required/>
                    <label for="email"><i class="fa-solid fa-envelope me-2"></i>Your Email</label>
                </div>
                <div class="form-floating">
                    <input type="password" name="password" placeholder="Your Password" class="form-control" id="password" required/>
                    <label for="password"><i class="fa-solid fa-key me-2"></i>Your Password</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary">Login</button>
            </form>
            <br/>
            <a href="register.php">Register</a>
        </div>
    </body>
</html>