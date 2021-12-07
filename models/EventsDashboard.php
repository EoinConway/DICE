<?php

/**
 * Class: EventsDashboard
 * 
 * This class is used to generate text content for the EVENT page view.
 * 
 * It handles both logged in and not logged in usee cases. 
 *
 * 
 */
class EventsDashboard extends Model {

//CLASS properties
    protected $db;                //MySQLi object: the database connection ( 
    protected $user;              //object of User class
    protected $pageTitle;         //String: containing page title
    protected $pageHeading;       //String: Containing Page Heading
    protected $panelHead_1;       //String: Panel 1 Heading
    protected $panelHead_2;       //String: Panel 2 Heading
    protected $panelHead_3;       //String: Panel 3 Heading      
    protected $panelContent_1;    //String: Panel 1 Content
    protected $panelContent_2;    //String: Panel 2 Content     
    protected $panelContent_3;    //String: Panel 3 Content

//CLASS methods
    //METHOD: constructor 
    function __construct($user, $pageTitle, $pageHead, $database) {
        parent::__construct('EventsDashboard', $user->getLoggedInState());
        $this->user = $user;

        $this->db = $database;

        //set the PAGE title
        $this->setPageTitle($pageTitle);

        //set the PAGE heading
        $this->setPageHeading($pageHead);

        //set the FIRST panel content
        $this->setPanelHead_1();
        $this->setPanelContent_1();

        //set the DECOND panel content
        $this->setPanelHead_2();
        $this->setPanelContent_2();

        //set the THIRD panel content
        $this->setPanelHead_3();
        $this->setPanelContent_3();
    }

    //END METHOD: constructor 
    //SETTER METHODS
    //Headings
    public function setPageTitle($pageTitle) { //set the page title    
        $this->pageTitle = $pageTitle;
    }

//end METHOD -   set the page title       

    public function setPageHeading($pageHead) { //set the page heading  
        $this->pageHeading = $pageHead;
    }

//end METHOD -   set the page heading
    //Panel 1
    public function setPanelHead_1() {//set the panel 1 heading
        $this->panelHead_1 = '<h3>Events Framework</h3>';
    }

//end METHOD - //set the panel 1 heading

    public function setPanelContent_1() {//set the panel 1 content
        if ($this->loggedin) {
            if ($this->user->getUserType() === 'EVENTADMIN') { //An ADMIN is logged in 
                $this->panelContent_1 .= '<p>You are currently logged in as an EVENT ADMINISTRATOR.';
            }
        } else { //User is not logged in
            $this->panelContent_1 .= '<p>You are currently logged in as a USER.';
        }
    }

//end METHOD - //set the panel 1 content        
    //Panel 2
    public function setPanelHead_2() { //set the panel 3 heading
        if ($this->loggedin) {
            $this->panelHead_2 = '<h3>Panel 2</h3>';
        } else {
            $this->panelHead_2 = '<h3>Panel 2</h3>';
        }
    }

//end METHOD - //set the panel 2 heading

    public function setPanelContent_2() { //set the panel 2 content
        if ($this->loggedin) {
            $this->panelContent_2 = "Panel 2 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged ON state.";
            ;
        } else {
            $this->panelContent_2 = "Panel 2 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged OFF state.";
            ;
        }
    }

//end METHOD - //set the panel 2 content 
    //Panel 3
    public function setPanelHead_3() { //set the panel 3 heading
        switch ($this->user->getUserType()) {
            case "USER":
                $this->panelHead_3 = '<h3>Event rules</h3>';
                break;
            case "EVENTADMIN":
                $this->panelHead_3 = '<h3>Events to archive</h3>';
                break;
            default:
                $this->panelHead_3 = '<h3>Not logged in</h3>';
                break;
        }
    }

//end METHOD - //set the panel 3 heading

    public function setPanelContent_3() { //set the panel 2 content
        $now = new DateTime(); //find todays date to compare with
        $toArchive = array(); //array to hold past event IDs

        switch ($this->user->getUserType()) {
            case "USER":
                $this->panelContent_3 = '<ul class="list-group list-group-flush">
                                            <li class="list-group-item">1. Event attendees must show up on time</li>
                                            <li class="list-group-item">2. No refunds unless event cancelled by administrator</li>
                                            <li class="list-group-item">3. Bring friends only if administrator has agreed</li>
                                            <li class="list-group-item">4. Please be respectful of other attendees</li>
                                            <li class="list-group-item">5. Most importantly, have fun!</li>
                                          </ul>';
                break;
            case "EVENTADMIN":
                if (isset($_POST['btnArchive'])) {
                    $eventTable = new EventTable($this->db);
                    if ($eventTable->archiveEvent($_POST['id'])) {
                        $eventTable->deleteEventbyID($_POST['id']);
                        $this->panelContent_3 .= "<h4 class='text-success'>Event archived</h4>";
                    } else
                        $this->panelContent_3 .= "<h4 class='text-danger'>Event not archived</h4>"; 
                }
                
                $eventAdminTable = new EventAdminTable($this->db);
                if ($rs = $eventAdminTable->getEventsToArchive($this->user->getUserID())) {
                    $this->panelContent_3 .= '<p>If you have no outstanding issues with past events, please archive them.</p>';
                    $this->panelContent_3 .= HelperHTML::generateArchiveTABLE($rs);
                } else {
                    $this->panelContent_3 = '<h3>There are no events to archive</h3>';
                }
                
                break;
            default://not logged in
                $this->panelContent_3 = '<h3>NOT LOGGED IN</h3>';
                break;
        }
    }

//end METHOD - //set the panel 3 content  
    //GETTER METHODS
    public function getPageTitle() {
        return $this->pageTitle;
    }

    public function getPageHeading() {
        return $this->pageHeading;
    }

    public function getPanelHead_1() {
        return $this->panelHead_1;
    }

    public function getPanelContent_1() {
        return $this->panelContent_1;
    }

    public function getPanelHead_2() {
        return $this->panelHead_2;
    }

    public function getPanelContent_2() {
        return $this->panelContent_2;
    }

    public function getPanelHead_3() {
        return $this->panelHead_3;
    }

    public function getPanelContent_3() {
        return $this->panelContent_3;
    }

    //END GETTER METHODS        
}

//end class
        