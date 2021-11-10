<?php

require_once "reCaptcha.php";

// your secret key
$secret = "----";
 
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
    //echo $passwordAttempt;
    //Retrieve the user account information for the given username.
    $sql = "SELECT hashi, email FROM Admins WHERE email = :username";
    $stmt = $pdo->prepare($sql);
    
    //Bind value.
    $stmt->bindValue(':username', $username);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //If $row is FALSE.
    if($user['email'] !== $username){
        //Could not find a user with that username!
        //PS: You might want to handle this error in a more user-friendly manner!
        header('Location: emailnotfound.php');
        exit;
    } else{

            $hash = $user['hashi'];

            $to = $user['email'];
            $subject = "Vertailutyökalu password reset";

            $message = "
            <html>
            <head>
            <title>Vertailutyökalu password reset</title>
            </head>
            <body>
            <a class='btn btn-primary' href='http://www.cc.puv.fi/~e1801584/Vertailusivu/AdminPages/newpass.php?hash=$hash' role='button'>Nollaa salasana</a>
            </html>
            ";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <Support@vertailutyokalu.fi>' . "\r\n";

mail($to,$subject,$message,$headers);



            header('Location: checkemail.php');
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
    <li class="active"><a href="etusivu.php">Home</a></li>
      <li><a href="cpucomparison.php">Compare CPU's</a></li>
      <li><a href="gpucomparison.php">Compare GPU's</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Listed components
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="listCPU.php">CPU list</a></li>
          <li><a href="listGPU.php">GPU list</a></li>
        </ul>
      </li>
    </ul>
    <form class="navbar-form navbar-left" action="haku.php">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Search CPU or GPU" name="search">
      </div>
      <button type="submit" class="btn btn-default">Search</button>
    </form>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="adminlogin.php"><span class="glyphicon glyphicon-log-in"></span> Admin Login</a></li>
    </ul>
  </div>
</nav>



        <div class="container">
        <h2>Unohtuiko salasana?</h2>
        <form action="resetpass.php" method="post">
        <div class="form-group">
            <label for="username">Sähköposti</label>
            <input type="text" class="form-control" id="username" name="username"><br>
        </div>
            <div class="g-recaptcha" data-sitekey="6Ldg33cUAAAAAGTa76rl2fYd_pM93SQsEfBQ-NRi"></div>
            <button type="submit" name="login" class="btn btn-success">Lähetä</button>
        </form>
        </div>
    </body>
</html>

