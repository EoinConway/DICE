<?php

/**
 * Class: EventPage
 * 
 * This class is used to generate text content for the EVENT PAGE page view.
 * 
 * It handles all user types. 
 *
 * 
 */
class EventPage extends Model {

//CLASS properties
    protected $eventModel;
    protected $eventID;
    protected $row;               //contains data for each attribute of event
    protected $user;              //object of User class
    protected $db;
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
    function __construct($user, $pageTitle, $pageHead, $getArray, $db) {
        parent::__construct('EventPage', $user->getLoggedInState());
        $this->user = $user;

        $this->db = $db;

        $this->eventID = $getArray['eventID'];

        $this->eventModel = new EventTable($this->db);
        if ($rs = $this->eventModel->getEventDetailsByID($this->eventID)) {
            //  echo HelperHTML::generateTABLE($rs);
            $row = $rs->fetch_assoc();
            //make this row a model attribute
            $this->row = $row;
        }

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
        $this->panelHead_1 = "<h1>" . $this->row['Name'] . "</h1>";
    }

//end METHOD - //set the panel 1 heading

    public function setPanelContent_1() {//set the panel 1 content
        $eventTable = new EventTable($this->db);
        $attend = new AttendeeTable($this->db); //generate an attend table object
        if ($this->loggedin) {
            if ($this->user->getUserType() === 'USER') { //A User is logged in
                if ($attend->getAttendeeRecord($this->user->getUserID(), $this->eventID)) {//check if user is already attending event
                    $this->panelContent_1 .= '<button data-bs-toggle="dropdown" type="submit" class="btn btn-primary dropdown-toggle" name="btnAttend" id="dropdownMenu">Attending</button>';
                    $this->panelContent_1 .= '<ul class="dropdown-menu"><li><button class="dropdown-item" type="submit" name="btnNotAtt">Not Attending</button></li>';
                    $this->panelContent_1 .= '<li><button class="dropdown-item"><a href="#QRModal" data-bs-toggle="modal" data-id="' . $_GET['eventID'] . '" onclick="generateQR(this);">QR Code</a></button></li></ul>';

                    if (isset($_POST['btnNotAtt'])) {
                        if ($attend->deleteAttendee($this->user->getUserID(), $this->eventID)) {
                            $this->eventModel->decrementAttendees($this->eventID);
                            header("Refresh:0");
                        }
                    }
                }
                else if (!$eventTable->checkMaxLimit($this->eventID)){//check if max number of attendees has already been reached
                    $this->panelContent_1 .= '<button type="submit" class="btn btn-primary" name="btnAttend" disabled>Event At Full Capacity</button>';
                }
                
                else if ($this->row['Fee'] == '0') {//user is not attending event and event is free
                    if (isset($_POST['btnAttend'])) {
                        if ($attend->addAttendee($this->user->getUserID(), $this->eventID)) {
                            $this->eventModel->incrementAttendees($this->eventID);
                            header("Refresh:0");
                        } else {
                            $this->panelContent_1 .= '<p>attendee not added</p>';
                        }
                    }
                    $this->panelContent_1 .= '<button type="submit" class="btn btn-primary" name="btnAttend">Attend</button>'; //attend button only avaialble for users
                }
            }

            if ($this->user->getUserType() === 'EVENTADMIN') { //An ADMIN is logged in 
                $eventAdmin = new EventAdminTable($this->db);
                if ($rs = $eventAdmin->getRecordByEvent($this->user->getUserID(), $this->eventID)) {//check if the logged in account is administrating this event
                    $this->panelContent_1 .= '<button data-bs-toggle="dropdown" type="submit" class="btn btn-primary dropdown-toggle" name="btnAttend" id="dropdownMenu">Modify</button>';
                    $this->panelContent_1 .= '<ul class="dropdown-menu"><li><a href="' . $_SERVER['PHP_SELF'] . '?pageID=editEvent&eventID=' . $_GET['eventID'] . '" class="dropdown-item">Change Event Details</a></li>';
                    $this->panelContent_1 .= '<li><a href="#myModal" data-bs-toggle="modal" class="dropdown-item">Cancel Event</a></li></ul>';
                    if (isset($_POST['btnDelete'])) {
                        $eventTable = new EventTable($this->db);
                        if ($eventTable->archiveEvent($_POST['id'])) {
                            $eventTable->deleteEventbyID($_POST['id']);
                            $this->panelContent_2 .= "<h4 class='text-success'>Event Successfully Deleted</h4>"; //panel content 2 of 'yourEvents' page
                        } else
                            $this->panelContent_2 .= "<h4 class='text-danger'>Event Not Deleted</h4>"; //panel content 2 of 'yourEvents' page
                    }
                } else
                    $this->panelContent_1 .= '<p>Log in as User if you would like to attend this event</p>';
            }
        } else  //User is not logged in
            $this->panelContent_1 .= '<p><i><a href="' . $_SERVER['PHP_SELF'] . '?pageID=login">Log in</a> to attend event.</i></p>';
    }

//end METHOD - //set the panel 1 content        
//Panel 2
    public function setPanelHead_2() { //set the panel 2 heading
        if ($this->loggedin) {
            $this->panelHead_2 = $this->row['Fee'];
        } else {
            $this->panelHead_2 = '<h3>Panel 2</h3>';
        }
    }

//end METHOD - //set the panel 2 heading

    public function setPanelContent_2() { //set the panel 2 content
        if ($rs = $this->eventModel->getEventDetailsByID($this->eventID)) //check if record exists
            $this->panelContent_2 .= HelperHTML::generateEventDetailsCARD($this->row);
    }

//end METHOD - //set the panel 2 content  
    //Panel 3
    public function setPanelHead_3() { //set the panel 3 heading
        $location = preg_replace('/\s+/', '+', $this->row['Location']); //escapes spaces in location. This is for the maps iframe
        $this->panelHead_3 = $location;
    }

//end METHOD - //set the panel 3 heading

    public function setPanelContent_3() { //set the panel 2 content
        if ($this->user->getUserType() === 'USER') {
            if ($this->row['Fee'] != '0') {//if there is an event fee, include paypal widget
                $this->panelContent_3 .= '<p>If you would like to attend this event please complete the PayPal transaction below. <b>Please note no refunds will be issued unless event is cancelled.</b></p>';
                $this->panelContent_3 .= '<div id="paypal-button-container"></div>';
            }
        }
    }

//end METHOD - //set the panel 2 content 
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
        