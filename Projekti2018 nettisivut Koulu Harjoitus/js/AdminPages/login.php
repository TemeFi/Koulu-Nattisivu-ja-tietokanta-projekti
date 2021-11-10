
<?php
//yeeeeeeeeeeeeeeeeeeeeeeet



//login.php
/**
 * Start the session.
 */
session_start();
/**
 * Include our MySQL connection.
 */
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
    $sql = "SELECT login, pass FROM Admins WHERE login = :username";
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
            
            //Redirect to our protected page, which we called home.php
            header('Location: home.php');
            exit;
    }
}
?>

