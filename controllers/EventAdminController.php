<?php

/**
 * Class: EventAdminController
 * This is the controller for the EVENTADMIN user type
 *
 * 
 */
class EventAdminController extends Controller {

//CLASS properties
    protected $postArray;     //a copy of the content of the $_POST superglobal array
    protected $getArray;      //a copy of the content of the $_GET superglobal array
    protected $viewData;          //an array containing page content generated using models
    protected $controllerObjects;          //an array containing models used by the controller
    protected $user; //session object
    protected $db;
    protected $pageTitle;

//CLASS methods

    //METHOD: constructor 
    function __construct($user,$db) { 
        parent::__construct('EventAdmin',$user->getLoggedinState());
        
        //initialise all the class properties
        $this->postArray = array();
        $this->getArray = array();
        $this->viewData=array();
        $this->controllerObjects=array();
        $this->user=$user;
        $this->db=$db;
        $this->pageTitle='DICE - Event Admin';

    }
    //END METHOD: constructor 

    //METHOD: run()
    public function run() {  // run the controller
        $this->getUserInputs();
        $this->updateView();
    }
    //END METHOD: run()

    //METHOD: getUserInputs()
    public function getUserInputs() { // get user input
        //
        //This method is the main interface between the user and the controller.
        //
        //Get the $_GET array values
        $this->getArray = filter_input_array(INPUT_GET) ; //used for PAGE navigation
        
        //Get the $_POST array values
        $this->postArray = filter_input_array(INPUT_POST);  //used for form data entry and buttons
        
    }
    //END METHOD: getUserInputs()

    //METHOD: updateView()
    public function updateView() { //update the VIEW based on the users page selection
        if (isset($this->getArray['pageID'])) { //check if a page id is contained in the URL
            switch ($this->getArray['pageID']) {
                case "home":
                    //create objects to generate view content
                    $contentModel = new Home($this->user, $this->pageTitle, strtoupper($this->getArray['pageID']), $this->db);
                    $navigationModel = new NavigationEventAdmin($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_homepage.php';  //load the view                      
                    break;      
                case "events":
                    //create objects to generate view content
                    $contentModel = new EventsDashboard($this->user, $this->pageTitle, 'events', $this->db);
                    $navigationModel = new NavigationEventAdmin($this->user, $this->getArray['pageID']);
                    $sidenavModel = new SideNavAdmin($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel,$sidenavModel);
                    $data = $this->getEventPageContent($contentModel,$navigationModel,$sidenavModel);  //get the event page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_eventsDashboard.php';  //load the view                      
                    break;
                case "yourEvents":
                    //create objects to generate view content
                    $contentModel = new YourEvents($this->user, $this->pageTitle, 'events', $this->db);
                    $navigationModel = new NavigationEventAdmin($this->user, $this->getArray['pageID']);
                    $sidenavModel = new SideNavAdmin($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel,$sidenavModel);
                    $data = $this->getEventPageContent($contentModel,$navigationModel,$sidenavModel);  //get the event page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_yourEvents.php';  //load the view                      
                    break;
                case "createEvent":
                    //create objects to generate view content
                    $contentModel = new CreateEvent($this->user, $this->pageTitle, 'events', $this->db);
                    $navigationModel = new NavigationEventAdmin($this->user, $this->getArray['pageID']);
                    $sidenavModel = new SideNavAdmin($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel,$sidenavModel);
                    $data = $this->getEventPageContent($contentModel,$navigationModel,$sidenavModel);  //get the event page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_createEvent.php';  //load the view                      
                    break;
                case "viewAllEvents":
                    //create objects to generate view content
                    $contentModel = new ViewAllEvents($this->user, $this->pageTitle, 'events', $this->db);
                    $navigationModel = new NavigationEventAdmin($this->user, $this->getArray['pageID']);
                    $sidenavModel = new SideNavAdmin($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel,$sidenavModel);
                    $data = $this->getEventPageContent($contentModel,$navigationModel,$sidenavModel);  //get the event page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_viewAllEvents.php';  //load the view                      
                    break;
                case "attendance":
                    //create objects to generate view content
                    $contentModel = new Events($this->user, $this->pageTitle, 'events');
                    $navigationModel = new NavigationEventAdmin($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_1_panel.php';  //load the view                      
                    break;
                case "profile":
                    //create objects to generate view content ($loggedin,$pageTitle,$pageHead,$database,$pageID)
                    $contentModel = new Profile($this->user, $this->pageTitle, 'profile',$this->db);
                    $navigationModel = new NavigationEventAdmin($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_profile.php';  //load the view                      
                    break; 
                case "event":
                    //create objects to generate view content
                    $contentModel = new EventPage($this->user, $this->pageTitle, 'events', $this->getArray, $this->db);
                    $navigationModel = new NavigationEventAdmin($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the event page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_eventPage.php';  //load the view                      
                    break;
                case "editEvent":
                    //create objects to generate view content
                    $contentModel = new EditEvent($this->user, $this->pageTitle, 'events', $this->db, $this->getArray['eventID']);
                    $navigationModel = new NavigationEventAdmin($this->user, $this->getArray['pageID']);
                    $sidenavModel = new SideNavAdmin($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel,$sidenavModel);
                    $data = $this->getEventPageContent($contentModel,$navigationModel,$sidenavModel);  //get the event page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_editEvent.php';  //load the view                      
                    break;
                case "logout":                    
                    //Change the login state to false
                    $this->user->logout();
                    $this->loggedin=FALSE;

                    //create objects to generate view content
                    $contentModel = new Home($this->user, $this->pageTitle, 'HOME', $this->db);
                    $navigationModel = new NavigationGeneral($this->user, 'home');
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_homepage.php'; //load the view                  
                    break;  
                default:
                    //no valid pageID selected by user - default loads HOME page
                    //create objects to generate view content
                    $contentModel = new Home($this->user, $this->pageTitle, strtoupper($this->getArray['pageID']), $this->db);
                    $navigationModel = new NavigationEventAdmin($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$contentModel,$navigationModel);
                    $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
                    //update the view
                    include_once 'views/view_navbar_homepage.php';
                    break;
            }
        } 
        else {//no page selected and NO page ID passed in the URL 
            //no page selected - default loads HOME page
            //create objects to generate view content
            $contentModel = new Home($this->user, $this->pageTitle, 'HOME', $this->db);
            $navigationModel = new NavigationEventAdmin($this->user, 'home');
            array_push($this->controllerObjects,$contentModel,$navigationModel);
            $data = $this->getPageContent($contentModel,$navigationModel);  //get the page content from the models                 
            $this->viewData = $data;  //put the content array into a class property for diagnostic purpose
            //update the view
            include_once 'views/view_navbar_homepage.php';  //load the view
        }
    }
    //END METHOD: updateView()
       
     
}

//end CLASS
