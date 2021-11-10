<?php

require_once "reCaptcha.php";

// your secret key
$secret = "--";
 
// empty response
$response = null;
 
// check secret key
$reCaptcha = new ReCaptcha($secret);

// if submitted check response
if ($_POST["g-recaptcha-response"]) {
  $response = $reCaptcha->verifyResponse(
      $_SERVER["REMOTE_ADDR"],
      $_POST["g-recaptcha-response"]
  );
}

if ($response != null && $response->success) {

  // kirjautuminen

session_start();

require 'connect.php';


//If the POST var "login" exists (our submit button), then we can
//assume that the user has submitted the login form.
if(isset($_POST['login'])){
    
    //Retrieve the field values from our login form.
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
	//echo $username;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;
    //echo $passwordAttempt;
    //Retrieve the user account information for the given username.
    $sql = "SELECT AdminID, login, pass FROM Admins WHERE login = :username";
    $stmt = $pdo->prepare($sql);
    
    //Bind value.
    $stmt->bindValue(':username', $username);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //If $row is FALSE.
    if($user['pass'] !== $passwordAttempt){
        //Could not find a user with that username!
        //PS: You might want to handle this error in a more user-friendly manner!
        die('Incorrect username / password combination!');
    } else{
        //User account found. Check to see if the given password matches the
        //password hash that we stored in our users table.
        
            //Provide the user with a login session.
            $_SESSION['user_id'] = $user['login'];
            $_SESSION['logged_in'] = time();
            
            //Redirect to our protected page, which we called adminpage.php
            header('Location: adminpage.php');
            exit;
    }
}
}
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>Vertailutyökalu - Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body>
    <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="../etusivu.php"><img class="img-responsive" src="Logo.png" alt="Chania" width="150" height="150"> </a>
    </div>
    <ul class="nav navbar-nav">
    <li class="active"><a href="../etusivu.php">Home</a></li>
      <li><a href="../cpucomparison.php">Compare CPU's</a></li>
      <li><a href="../gpucomparison.php">Compare GPU's</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Listed components
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="../listCPU.php">CPU list</a></li>
          <li><a href="../listGPU.php">GPU list</a></li>
        </ul>
      </li>
    </ul>
    <form class="navbar-form navbar-left" action="haku.php">
      <div class="form-group">
      <input type="text" class="form-control" autocomplete="off" placeholder="Search CPU or GPU" name="names" id="search" />
      </div>
      <div id="show_up"></div>
    </form>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="adminlogin.php"><span class="glyphicon glyphicon-log-in"></span> Admin Login</a></li>
    </ul>
  </div>
</nav>



        <div class="container">
        <h2>Login</h2>
        <form action="adminlogin.php" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username"><br>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password"><br>
        </div>
            <div class="g-recaptcha" data-sitekey="6Ldg33cUAAAAAGTa76rl2fYd_pM93SQsEfBQ-NRi"></div>
            <button type="submit" name="login" class="btn btn-success">Login</button>
            <a href="resetpass.php">Unohtuiko salasana?</a>
        </form>
        </div>
    </body>
</html>

