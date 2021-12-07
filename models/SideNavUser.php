<?php

/**
 * Class: Side Navigation User
 * This class is used to generate side navigation menu items in an an array for the event view.
 * 
 * It uses the logged in status, user type  and currently selected pageID to determine which items 
 * are included in the menu for that specific page.
 *
 * It also provides examples of how to generate drop down menus
 * 
 * 
 */
class SideNavUser {

//CLASS properties
    protected $loggedin; //boolean - user logged in state
    protected $modelType; //String - identifues the type of model 
    protected $pageID;   //String: currently selected page
    protected $sideNav;  //Array: array of menu items    
    protected $user;     //User: object of User class

//CLASS methods	
    //METHOD: constructor 
    function __construct($user, $pageID) {
        $this->loggedin = $user->getLoggedInState();
        $this->modelType = 'SideNavUser';
        $this->user = $user;
        $this->pageID = $pageID;
        $this->setSideNav();
    }

    //END METHOD: constructor 
    //METHOD: setSideNav()
    public function setSideNav() {//set the menu items depending on the users selected page ID
        //empty string for menu items
        $this->sideNav = '';

        if ($this->loggedin) {
            switch ($this->pageID) {
                    case "events":
                        $this->sideNav .= '<li class="nav-item"><a class="nav-link active" href="' . $_SERVER['PHP_SELF'] . '?pageID=events">Dashboard</a></li>';
                        $this->sideNav .= '<li class="nav-item"><a class="nav-link" href="' . $_SERVER['PHP_SELF'] . '?pageID=yourEvents">Your Events</a></li>';
                        $this->sideNav .= '<li class="nav-item"><a class="nav-link" href="' . $_SERVER['PHP_SELF'] . '?pageID=viewAllEvents">View All Events</a></li>';
                        break;
                    case "yourEvents":
                        $this->sideNav .= '<li class="nav-item"><a class="nav-link" href="' . $_SERVER['PHP_SELF'] . '?pageID=events">Dashboard</a></li>';
                        $this->sideNav .= '<li class="nav-item"><a class="nav-link active" href="' . $_SERVER['PHP_SELF'] . '?pageID=yourEvents">Your Events</a></li>';
                        $this->sideNav .= '<li class="nav-item"><a class="nav-link" href="' . $_SERVER['PHP_SELF'] . '?pageID=viewAllEvents">View All Events</a></li>';
                        break;
                    case "viewAllEvents":
                        $this->sideNav .= '<li class="nav-item"><a class="nav-link" href="' . $_SERVER['PHP_SELF'] . '?pageID=events">Dashboard</a></li>';
                        $this->sideNav .= '<li class="nav-item"><a class="nav-link" href="' . $_SERVER['PHP_SELF'] . '?pageID=yourEvents">Your Events</a></li>';
                        $this->sideNav .= '<li class="nav-item"><a class="nav-link active" href="' . $_SERVER['PHP_SELF'] . '?pageID=viewAllEvents">View All Events</a></li>';
                        break;  
                    default:
                        $this->sideNav .= '<li class="nav-item"><a class="nav-link" href="' . $_SERVER['PHP_SELF'] . '?pageID=events">Dashboard</a></li>';
                        $this->sideNav .= '<li class="nav-item"><a class="nav-link" href="' . $_SERVER['PHP_SELF'] . '?pageID=yourEvents">Your Events</a></li>';
                        $this->sideNav .= '<li class="nav-item"><a class="nav-link" href="' . $_SERVER['PHP_SELF'] . '?pageID=viewAllEvents">View All Events</a></li>';
                        break;
                    }//end switch 
            
        } else {
            //redirect to main index.php page
            header("Location:" . $_SERVER['PHP_SELF']);
        }
    }

    //END METHOD: setSideNav()
    //METHOD: getSideNav()
    public function getSideNav() {
        return $this->sideNav;
    }

    //END METHOD: getSideNav()
    //METHOD: getDiagnosticInfo()
    public function getDiagnosticInfo() {

        echo '<!-- NAVIGATION USER CLASS PROPERTY SECTION  -->';
        echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV

        echo '<h3>NAVIGATION GENERAL (CLASS) properties</h3>';
        echo '<table border=1 border-style: dashed; style="background-color: #EEEEEE" >';
        echo '<tr><th>PROPERTY</th><th>VALUE</th></tr>';
        echo "<tr><td>pageID</td>   <td>$this->pageID</td></tr>";
        echo "<tr><td>SideNav</td>  <td>$this->sideNav      </td></tr>";
        echo '</table>';
        echo '<p><hr>';
        echo '</div>';
        echo '<!-- END NAVIGATION CLASS PROPERTY SECTION  -->';
    }

    //END METHOD:  getDiagnosticInfo() 
    //     
    //END GETTER METHODS
}

//end class
        