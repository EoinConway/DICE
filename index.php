<?php

/*
 * 
 * Model View Controller FRAMEWORK Application
 * 
 * This is the main entry point for this MVC application
 * 
 */

//join/start a session between the browser client and Apache web server
session_start(); 

//load application configuration
include_once 'config/config.php';
include_once 'config/database.php';

//load class library

//Base Classes
include_once 'classlib/BaseClasses/Controller.php';
include_once 'classlib/BaseClasses/Model.php';
include_once 'classlib/BaseClasses/TableEntity.php';

//System Classes
include_once 'classlib/System/Session.php';
include_once 'classlib/System/User.php';

//helper classes
include ('classlib/HelperClasses/HelperHTML.php');

//Database Table Entities
include_once 'classlib/Entities/AttendeeTable.php';
include_once 'classlib/Entities/EventAdminTable.php';
include_once 'classlib/Entities/EventTable.php';
include_once 'classlib/Entities/UserTable.php';
include_once 'classlib/Entities/SportTable.php';
include_once 'classlib/Entities/RecurringTable.php';
include_once 'classlib/Entities/EventTypeTable.php';

//Controller Clases for specific user types
include_once 'controllers/EventAdminController.php';
include_once 'controllers/GeneralController.php';
include_once 'controllers/UserController.php';

//Navigation models
include_once 'models/NavigationEventAdmin.php';
include_once 'models/NavigationGeneral.php';
include_once 'models/NavigationUser.php';
include_once 'models/SideNavUser.php';
include_once 'models/SideNavAdmin.php';


//Page models - Common
include_once 'models/UnderConstruction.php';
include_once 'models/Login.php';
include_once 'models/Register.php';
include_once 'models/AboutUs.php';
include_once 'models/YourEvents.php';
include_once 'models/ViewAllEvents.php';
include_once 'models/EventPage.php';
include_once 'models/Profile.php';
include_once 'models/Home.php';
include_once 'models/EventsDashboard.php';


//Page models - EVENTADMIN
include_once 'models/CreateEvent.php';
include_once 'models/EditEvent.php';

//Page models USER


//attempt to connect to the MySQL Server (with error reporting supression '@')
@$db=new mysqli($DBServer, $DBUser, $DBPass, $DBName, $DBportNr);
//check if there is an error in the connection
if($db->connect_errno){  
    if (DEBUG_MODE){
        $msg = '<h3>Unable to make Database Connection</h3>';
            //report on connection issue
    $msg.= '<p>There has been a proble making connection to MySQL Server - MySQLi Error message:';
    $msg.= '<ul>';
    $msg.= '<li>MySQLi Error Number  : ' . @$db->connect_errno. '</li>';
    $msg.= '<li>MySQLi Error Message : '.@$db->connect_error. '</li>';
    $msg.= '</ul>';
    
    }
    else{
        $msg= '<h4>Oops - something is not working!</h4>';
        echo $db->connect_errno;
    }
    exit($msg);  //the script exits here if no database connection can be made
}

@$db->query("SET NAMES 'utf8'"); //make sure database connection is set to support UTF8 characterset


//Create the new session object
$session = new Session();
$session->setChatEnabledState(FALSE);
$user = new User($session, $db, ENCRYPT_PW);


if ($user->getLoggedInState()) {
    //load the appropriate controller depending on the user type
    //
    switch ($user->getUserType()) {
        case "USER":  //create new  LECTURER controller
            $controller = new UserController($user, $db);
            break;

        case "EVENTADMIN":  //create new STUDENT controller
            $controller = new EventAdminController($user, $db);
            break;       
        
        default :  //create new general/not logged in controller
            //unidentified user type  - force logout to reset system state
            $user->logout();
            $controller = new GeneralController($user, $db);
            break;
    }
} else {
    //user is not logged in
    //create new general/not logged in controller
    $controller = new GeneralController($user, $db);
}

//run the application
$controller->run();

//Debug information
if (DEBUG_MODE) { 
    //Comment out whichever info you dont want to use.
    

    echo '<section>';
        echo '<!-- The Debug SECTION  of index.php-->';
        echo '<div class="container-fluid"   style="background-color: #AA44AA">'; //outer DIV

        echo '<h2>Index.php - Debug information</h2><br>';

        echo '<section style="background-color: #AAAAAA">';
            echo '<pre><h5>SESSION Class</h5>';
            $session->getDiagnosticInfo();
            echo '</pre>';
        echo '</section>';

        echo '<section style="background-color: #AAAAAA">';
            echo '<pre><h5>USER Class</h5>';
            $user->getDiagnosticInfo();
            echo '</pre>';
        echo '</section>';            

        echo '<section style="background-color: #AAAAAA" >';
            echo '<!-- $_COOKIE ARRAY SECTION  -->';
            echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV  
            echo '<h3>$_COOKIE Array values</h3>';
            echo '<table border=1  style="background-color: #EEEEEE" >';
            foreach($_COOKIE as $key=>$value){
                echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
            }
            echo '</table><hr>';
            echo '<!-- END $_COOKIE ARRAY SECTION  -->';
        echo '</section>'; 
    
    echo '</section>';
    echo '</br>';
    echo '</div>';
    //controller class debug info        
    $controller->debug();

};
echo '</body></html>'; //end of HTML Document

//close or release any open connections/resources
//close the DB Connection
$db->close();
