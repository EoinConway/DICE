<?php

/**
 * Class: YourEvents
 * 
 * This class is used to generate text content for the YOUR EVENT page view.
 * 
 * It handles both user and event admin accounts. 
 *
 * 
 */
class Profile extends Model {

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
        parent::__construct('Profile', $user->getLoggedInState());
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
        $this->panelHead_1 = 'Edit your profile information';
    }

//end METHOD - //set the panel 1 heading

    public function setPanelContent_1() {//set the panel 1 content
        if ($this->user->getUserType() === 'EVENTADMIN') { //A USER is logged in 
            $admin = new EventAdminTable($this->db);
            if (isset($_POST['btnUpdateMobile'])) {//change mobile number
                if ($admin->updateMobile($_POST['newMob'], $this->user->getUserID()))
                    $this->panelContent_1 .= '<p class="success">Mobile Number Updated</p>';
            }
            if (isset($_POST['btnUpdatePW'])) {//change password form
                if ($admin->verifyPW($_POST['oldPW'], $this->user->getUserID())) {
                    if ($_POST['pass'] === $_POST['pass-repeat']) {  //verify passwords match
                        if ($admin->updatePW($_POST['pass'], $this->user->getUserID())) {
                            $this->panelContent_1 .= '<p class="success">Password Updated</p>';
                        } else {
                            $this->panelContent_1 .= '<p class="fail">Password Update Unsuccessful</p>';
                        }
                    } else
                        $this->panelContent_1 .= '<p class="fail">Please re-enter the same new password</p>';
                } else
                    $this->panelContent_1 .= '<p class="fail">Please enter the correct old password</p>';
            }
        }
        if ($this->user->getUserType() === 'USER') { //A USER is logged in 
            $user = new UserTable($this->db);
            if (isset($_POST['btnUpdateMobile'])) {
                if ($user->updateMobile($_POST['newMob'], $this->user->getUserID()))
                    $this->panelContent_1 .= '<p class="success">Mobile Number Updated</p>';
            }
            if (isset($_POST['btnUpdatePW'])) {
                if ($user->verifyPW($_POST['oldPW'], $this->user->getUserID())) {
                    if ($_POST['pass'] === $_POST['pass-repeat']) {  //verify passwords match
                        if ($user->updatePW($_POST['pass'], $this->user->getUserID())) {
                            $this->panelContent_1 .= '<p class="success">Password Updated</p>';
                        } else {
                            $this->panelContent_1 .= '<p class="fail">Password Update Unsuccessful</p>';
                        }
                    } else
                        $this->panelContent_1 .= '<p class="fail">Please re-enter the same new password</p>';
                } else
                    $this->panelContent_1 .= '<p class="fail">Please enter the correct old password</p>';
            }
        }
    }

//end METHOD - //set the panel 1 content 
    //Panel 2
    public function setPanelHead_2() { //set the panel 3 heading
        if ($this->loggedin) {
            if ($this->user->getUserType() === 'EVENTADMIN') { //An Admin is logged in
                $this->panelHead_2 = '<h3>Here are all the events you are currently administrating</h3>';
            } else if ($this->user->getUserType() === 'USER') { //A USER is logged in 
                $this->panelHead_2 .= '<h3>Here are all the events you are currently attending</h3>';
            }
        } else {
            $this->panelHead_2 = '<h3>Panel 2</h3>';
        }
    }

//end METHOD - //set the panel 2 heading

    public function setPanelContent_2() { //set the panel 2 content
        if ($this->loggedin) {
            if ($this->user->getUserType() === 'EVENTADMIN') { //An Admin is logged in
                
            } else if ($this->user->getUserType() === 'USER') { //A USER is logged in 
            }
        } else {
            $this->panelContent_2 = "Panel 2 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged OFF state.";
            ;
        }
    }

//end METHOD - //set the panel 2 content 
    //Panel 3
    public function setPanelHead_3() { //set the panel 3 heading
        if ($this->loggedin) {
            $this->panelHead_3 = '<h3>Panel 3</h3>';
        } else {
            $this->panelHead_3 = '<h3>Panel 3</h3>';
        }
    }

//end METHOD - //set the panel 3 heading

    public function setPanelContent_3() { //set the panel 2 content
        if ($this->loggedin) {
            
        } else {
            $this->panelContent_3 = "Panel 3 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged OFF state.";
            ;
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
        