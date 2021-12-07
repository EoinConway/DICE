<?php
/* 
 * Class - generic controller parent class
 *
 * 
 */

class Controller { 
    //class properties
    protected $userLoggedIn; //boolean - user logged in state
    private $controllerType; //String - identifues the type of model (eg USER, ADMINISTRATOR)
	
    //constructor method
    function __construct($controllerType,$loggedinState) {  //constructor  
        //initialise the model
        $this->userLoggedIn=$loggedinState;
        $this->controllerType=$controllerType;
    } //end METHOD - constructor
        

    //METHOD: getPageContent()
    protected function getPageContent($contentMod,$navMod) {
        //get the content from the navigation model - put into the $data array for the view:
        $data['menuNav'] = $navMod->getMenuNav();       // an array of menu items and associated URLS
        //get the content from the page content model  - put into the $data array for the view:
        $data['pageTitle'] = $contentMod->getPageTitle();
        $data['pageHeading'] = $contentMod->getPageHeading();
        $data['panelHead_1'] = $contentMod->getPanelHead_1(); // A string containing the LHS panel heading/title
        $data['panelHead_2'] = $contentMod->getPanelHead_2();
        $data['panelHead_3'] = $contentMod->getPanelHead_3(); // A string containing the RHS panel heading/title
        $data['panelContent_1'] = $contentMod->getPanelContent_1();     // A string intended of the Left Hand Side of the page
        $data['panelContent_2'] = $contentMod->getPanelContent_2();     // A string intended of the Left Hand Side of the page
        $data['panelContent_3'] = $contentMod->getPanelContent_3();     // A string intended of the Right Hand Side of the page
        return $data;
        
    }
    //END METHOD: getPageContent()
    
    //METHOD: getEventPageContent()
    protected function getEventPageContent($contentMod,$navMod,$sideNavMod) {
        //get the content from the navigation model - put into the $data array for the view:
        $data['menuNav'] = $navMod->getMenuNav();       // an array of menu items and associated URLS
        //get the content from the sidenav model 
        $data['sideNav'] = $sideNavMod->getSideNav();
        //get the content from the page content model  - put into the $data array for the view:
        $data['pageTitle'] = $contentMod->getPageTitle();
        $data['pageHeading'] = $contentMod->getPageHeading();
        $data['panelHead_1'] = $contentMod->getPanelHead_1(); // A string containing the LHS panel heading/title
        $data['panelHead_2'] = $contentMod->getPanelHead_2();
        $data['panelHead_3'] = $contentMod->getPanelHead_3(); // A string containing the RHS panel heading/title
        $data['panelContent_1'] = $contentMod->getPanelContent_1();     // A string intended of the Left Hand Side of the page
        $data['panelContent_2'] = $contentMod->getPanelContent_2();     // A string intended of the Left Hand Side of the page
        $data['panelContent_3'] = $contentMod->getPanelContent_3();     // A string intended of the Right Hand Side of the page
        return $data;
        
    }
    //END METHOD: getEventPageContent()
        
          
    //METHOD: debug()
    public function debug() {   //Diagnostics/debug information - dump the application variables if DEBUG mode is on

        echo '<!--CONTROLLER CLASS PROPERTY SECTION  -->';
            echo '<div class="container-fluid"   style="background-color: #22AAAA">'; //outer DIV green blue

            echo '<h2>'.strtoupper($this->controllerType).' Controller Class - Debug information</h2><br>';

            //SECTION 1
            echo '<section style="background-color: #AABBCC">'; //light blue
                echo '<h3>'.strtoupper($this->controllerType).' Controller (CLASS) properties</h3>';
                
                
                echo '<h4>User Logged in Status:</h4>';
                if ($this->userLoggedIn) {
                    echo 'User Logged In state is TRUE ($loggedin) <br>';
                } else {
                    echo 'User Logged In state is FALSE ($loggedin) <br>';
                }

                echo '<h4>$postArray Values (user input - values entered in any form)</h4>';
                echo '<pre>';
                var_dump($this->postArray);
                echo '</pre>';
                echo '<br>';

                echo '<h4>$getArray Values (user input - page selected)</h4>';
                echo '<pre>';
                var_dump($this->getArray);
                echo '</pre>';
                echo '<br>';

                echo '<h4>$data Array Values (Array of Values passed to view)</h4>';
                echo '<pre>';
                var_dump($this->viewData);
                echo '</pre>';
                echo '<br>';

            echo '</section>';

            //SECTION 2
            echo '<section style="background-color: #AABBCC">'; //light blue
                echo '<h4>Controller - Class Objects</h4>';
                echo '<pre>';
                foreach($this->controllerObjects as $object){$object->getDiagnosticInfo();}
                echo '</pre>';
            echo '</section>';
                       
            echo '</div>';  //END outer DIV
            echo '<!-- END GENERAL CONTROLLER CLASS PROPERTY SECTION  -->';
        
    }
    //END METHOD: debug()
    
    
} //end CLASS