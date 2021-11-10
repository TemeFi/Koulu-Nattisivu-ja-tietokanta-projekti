<?php   
function testaaLogin() { 
    /**
 * Check if the user is logged in.
 */
    if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])){
    //User not logged in. Redirect them back to the login.php page.
    header('Location: adminlogin.php');
    exit;
    }
}

function julkinenTest() { 

    if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])){
     echo '<li><a href="AdminPages/adminlogin.php"><span class="glyphicon glyphicon-log-in"></span> Admin Login</a></li>';
    } 
    else 
    {
        echo '<li><a href="AdminPages/adminpage.php"><span class="glyphicon glyphicon-log-in"></span> Admin Home</a></li>';
    }
}

?>