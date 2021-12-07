<?php
/**
 * Class: Navigation
 * This class is used to generate navigation menu items in an an array for the view.
 * 
 * It uses the logged in status, user type  and currently selected pageID to determine which items 
 * are included in the menu for that specific page.
 *
 * It also provides examples of how to generate drop down menus
 * 
 * @author gerry.guinane
 * 
 */

class NavigationEventAdmin {
    
//CLASS properties
        protected $loggedin; //boolean - user logged in state
        protected $modelType; //String - identifues the type of model 
        protected $pageID;   //String: currently selected page
        protected $menuNav;  //Array: array of menu items    
        protected $user;     //User: object of User class
        
//CLASS methods	

	//METHOD: constructor 
	function __construct($user,$pageID) {               
            $this->loggedin=$user->getLoggedInState();
            $this->modelType='NavigationAdmin';
            $this->user=$user;
            $this->pageID=$pageID;
            $this->setmenuNav();
	}
        //END METHOD: constructor 
      
        //METHOD: setmenuNav()
        public function setmenuNav(){//set the menu items depending on the users selected page ID
            
            //empty string for menu items
            $this->menuNav='';

            if($this->loggedin){ 
                //handlers for logged in user
                switch ($this->pageID) {
                    case "home":
                        $this->menuNav.='<li class="nav-item"><a class="nav-link active" href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li class="nav-item"><a class="nav-link" href="'.$_SERVER['PHP_SELF'].'?pageID=events">Events</a></li>';
                        $this->menuNav.='<li class="nav-item"><a class="nav-link" href="'.$_SERVER['PHP_SELF'].'?pageID=profile">Profile</a></li></ul>';
                        $this->menuNav.='<ul class="navbar-nav ms-auto"><li class="nav-item"><a class="nav-link" href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out - '.$_SESSION['userFirstName'].' '.$_SESSION['userLastName'].'</a></li>';
                        break;
                    case "events":
                        $this->menuNav.='<li class="nav-item"><a class="nav-link" href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li class="nav-item"><a class="nav-link active" href="'.$_SERVER['PHP_SELF'].'?pageID=events">Events</a></li>';
                        $this->menuNav.='<li class="nav-item"><a class="nav-link" href="'.$_SERVER['PHP_SELF'].'?pageID=profile">Profile</a></li></ul>';
                        $this->menuNav.='<ul class="navbar-nav ms-auto"><li class="nav-item"><a class="nav-link" href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out - '.$_SESSION['userFirstName'].' '.$_SESSION['userLastName'].'</a></li>';
                        break;
                    case "profile":
                        $this->menuNav.='<li class="nav-item"><a class="nav-link" href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li class="nav-item"><a class="nav-link" href="'.$_SERVER['PHP_SELF'].'?pageID=events">Events</a></li>';
                        $this->menuNav.='<li class="nav-item"><a class="nav-link active" href="'.$_SERVER['PHP_SELF'].'?pageID=profile">Profile</a></li></ul>';
                        $this->menuNav.='<ul class="navbar-nav ms-auto"><li class="nav-item"><a class="nav-link" href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out - '.$_SESSION['userFirstName'].' '.$_SESSION['userLastName'].'</a></li>';
                        break; 
                    default:
                        $this->menuNav.='<li class="nav-item"><a class="nav-link" href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li class="nav-item"><a class="nav-link" href="'.$_SERVER['PHP_SELF'].'?pageID=events">Events</a></li>';
                        $this->menuNav.='<li class="nav-item"><a class="nav-link" href="'.$_SERVER['PHP_SELF'].'?pageID=profile">Profile</a></li></ul>';
                        $this->menuNav.='<ul class="navbar-nav ms-auto"><li class="nav-item"><a class="nav-link" href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out - '.$_SESSION['userFirstName'].' '.$_SESSION['userLastName'].'</a></li>';
                        break;
                    }//end switch                
            }
            else{
                //redirect to main index.php page
                header("Location:". $_SERVER['PHP_SELF']);
            }        
        } 
        //END METHOD: setmenuNav()
        
        //METHOD: getMenuNav()
        public function getMenuNav(){return $this->menuNav;}    
        //END METHOD: getMenuNav()
    
        //METHOD: getDiagnosticInfo()
        public function getDiagnosticInfo(){

            echo '<!-- NAVIGATION ADMIN CLASS PROPERTY SECTION  -->';
                echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV
                    
                    echo '<h3>NAVIGATION GENERAL (CLASS) properties</h3>';
                    echo '<table border=1 border-style: dashed; style="background-color: #EEEEEE" >';
                    echo '<tr><th>PROPERTY</th><th>VALUE</th></tr>';                        
                    echo "<tr><td>pageID</td>   <td>$this->pageID</td></tr>";
                    echo "<tr><td>menuNav</td>  <td>$this->menuNav      </td></tr>";
                    echo '</table>';
                    echo '<p><hr>';
                echo '</div>';            
            echo '<!-- END NAVIGATION CLASS PROPERTY SECTION  -->';
            
 }      
        //END METHOD:  getDiagnosticInfo() 
        //     
        //END GETTER METHODS
 
}//end class
        