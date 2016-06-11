<?php
// Start The Session
session_start();

// Include The Config File With Database Credentials
// include("config.inc.php");

// Require The Autoload PHP File. Will Load All The Facebook SDK Files
require_once 'fb/autoload.php';

// Create The MySQL Connection. Will Be Used Throughout The Script.
// $mysqli = new MySQLi(HOST_NAME , USERNAME , PASSWORD , DB_NAME);

// Import All The Useful Namespaces
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;


// Change The Below APP ID And APP SECRET with your APP's Credentials
FacebookSession::setDefaultApplication( '1075301472498825','512acc15a69c09a625014719ca4eb4e9' );


// Set The Redirect URL. After Login, User Will Be Redirected To This URL. This Must Be The Absolute URL To Your facebooklogin.php(this) file
$redirect_login_helper = new FacebookRedirectLoginHelper( 'http://handybooks.in/fb/facebooklogin.php' );


// Check If We Have Any Data Sent By Facebook
// If Session Is Null Then It Means That We Have Not Redirected The User To Facebook Yet
try {
    $session = $redirect_login_helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
    // When Graph Returns An Error
    echo $e->getMessage();
} catch( Exception $ex ) {
    // Any Other Local Issues
}


/*
 * If The Session Variable is Not Null
 * Then It Means That We Have Already Redirected The User To Facebook
 * And User Has Logged In Successfully
 */
if ( isset( $session ) ) {


    // Request The Graph API For User Data
    // '/me' denotes the currently logged in user
    $request = new FacebookRequest( $session, 'GET', '/me' );


    // Execute The Request Just Like A MySQL Query
    $response = $request->execute();


    // Get The Response Graph Object
    $graphObject = $response->getGraphObject();

    $facebook_id = $graphObject->getProperty('id'); // Get The User's Numeric Unique Facebook User ID
    $first_name = $graphObject->getProperty('first_name'); // Get The User's First Name
    $last_name = $graphObject->getProperty('last_name'); // Get The User's Last Name
    $facebook_email = $graphObject->getProperty('email'); // Get The Email Used By User To Sign Up On Facebook
    $gender = $graphObject->getProperty('gender'); // Get The User's Gender(Optional In Many Cases)

    $access_token = $session->getToken(); // Get The Access Token

    // Escape The Facebook Numeric ID
    $facebook_id = $mysqli->real_escape_string($facebook_id);
    echo $access_token;

    // Check The Database For Facebook ID Existence
    // $result = $mysqli->query("SELECT * FROM users WHERE facebook_id = '$facebook_id'");


    // If MySQL Returned Zero Rows Or An Negative Integer
    // Than It Means That The User Doesn't Exist In The Database.
    // if( $result->num_rows <= 0 )
    // {
    //     // Escape All The Data We Relieved From Facebook
    //     $first_name = $mysqli->real_escape_string($first_name);
    //     $last_name = $mysqli->real_escape_string($last_name);
    //     if( isset( $facebook_email ) && $facebook_email != '' )
    //         $facebook_email = $mysqli->real_escape_string($facebook_email);
    //     $facebook_id = $mysqli->real_escape_string($facebook_id);
    //     $gender = $mysqli->real_escape_string($gender);
    //     $access_token = $mysqli->real_escape_string($access_token);


        // Create The SQL Statement
        // $SQL = "INSERT INTO users(f_name, l_name, gender, email, access_token, facebook_id )
        //         VALUES('$first_name' , '$last_name' , '$gender' , '$facebook_email' , '$access_token' , $facebook_id );";

        // We Added The User Successfully
        // if( $mysqli->query($SQL) === TRUE )
        // {
        //     $_SESSION['user_id'] = $mysqli->insert_id;
        //     $_SESSION['facebook_id'] = $facebook_id;
        //     $_SESSION['access_token'] = $access_token;

        //     header("Location: index.php");
        //     exit;
        // }
    }
    else
    {
        /*
         * The User Already Exists In The Database
         * Just Need To Set The user_id key in $_SESSION variable
         */

        // Fetch The User's Row
        $user = $result->fetch_assoc();

        // Set The user_id Session Variable
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['facebook_id'] = $user['facebook_id'];
        $_SESSION['access_token'] = $user['access_token'];

        // Redirect Back To Home Page
        header("Location: index.php");
        exit;

    }
}
else
{
    /*
     * The Session Variable Was Empty Or NULL
     * This Means That We Have Not Redirected The User Yet
     */

    // Set The Parameters For The getLoginUrl function.
    $params = array('scope' => 'public_profile,email',redirect_uri => 'http://handybooks.in/fb/facebooklogin.php');

    // Get The Login URL
    $loginUrl = $redirect_login_helper->getLoginUrl($params);

    // Redirect The User To Facebook's Login URL
    header("Location: ".$loginUrl);
    exit;

}