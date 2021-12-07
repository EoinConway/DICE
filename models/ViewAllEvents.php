<?php

/**
 * Class: ViewAllEvents
 * 
 * This class is used to generate text content for the YOUR EVENT page view.
 * 
 * It handles both user and event admin accounts. 
 *
 * 
 */
class ViewAllEvents extends Model {

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
        parent::__construct('ViewAllEvents', $user->getLoggedInState());
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
        $this->panelHead_1 = '<h3>All Events</h3>';
    }

//end METHOD - //set the panel 1 heading

    public function setPanelContent_1() {//set the panel 1 content
        if ($this->loggedin) {
            if ($this->user->getUserType() === 'EVENTADMIN') { //An ADMIN is logged in 
                $this->panelContent_1 .= '<p>You are currently logged in as an EVENT ADMINISTRATOR.';
            } else if ($this->user->getUserType() === 'USER') { //A USER is logged in 
                $this->panelContent_1 .= '<p>You are currently logged in as a USER.';
            }
        } else { //User is not logged in
            $this->panelContent_1 .= "<p>Browse all currently available events here. If you'd like to attend one, please log in as a User. If you'd like to create one, please log in as an Event Administrator.";
        }
    }

//end METHOD - //set the panel 1 content        
    //Panel 2
    public function setPanelHead_2() { //set the panel 3 heading
        if ($this->loggedin) {
            $this->panelHead_2 .= '<h3>Here are all the events currently available</h3>';
        } else {
            $this->panelHead_2 = '<h3>EVENTS</h3>';
        }
    }

//end METHOD - //set the panel 2 heading

    public function setPanelContent_2() { //set the panel 2 content
        if ($this->loggedin) {
            $events = new EventTable($this->db);
            $result = $events->getAllEvents();
                $this->panelContent_2 .= HelperHTML::generateAllEventsTable($result);
            
        } else {//user not logged in
//            $events = new EventTable($this->db);//make EventTable object
//            if ($resultSet = $events->getAllEvents()) {
//                while ($row = $resultSet->fetch_assoc()){//take single events from table
//                    $this->panelContent_2 .= '<div class="grid-item">';
//                    $this->panelContent_2 .= HelperHTML::generateEventCARD($row);
//                    $this->panelContent_2 .= '</div>';
//                }
//            }
            //pagination
            // find out how many rows are in the table 
            $events = new EventTable($this->db);
            $result = $events->getAllEvents() or trigger_error("SQL", E_USER_ERROR);
            $r = mysqli_num_rows($result);

// number of rows to show per page
            $rowsperpage = 6;
// find out total pages
            $totalpages = ceil($r / $rowsperpage);

// get the current page or set a default
            if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
                // cast var as int
                $currentpage = (int) $_GET['currentpage'];
            } else {
                // default page num
                $currentpage = 1;
            } // end if
// if current page is greater than total pages...
            if ($currentpage > $totalpages) {
                // set current page to last page
                $currentpage = $totalpages;
            } // end if
// if current page is less than first page...
            if ($currentpage < 1) {
                // set current page to first page
                $currentpage = 1;
            } // end if
// the offset of the list, based on current page 
            $offset = ($currentpage - 1) * $rowsperpage;

// get the info from the db 
            $result = $events->getAllEventsPaginate($offset, $rowsperpage) or trigger_error("SQL", E_USER_ERROR);

            
            $this->panelContent_2 .= '<div class="grid-container row">';
// while there are rows to be fetched...
            while ($row = mysqli_fetch_assoc($result)) {
                // echo data
                $this->panelContent_2 .= '<div class="grid-item">';
                $this->panelContent_2 .= HelperHTML::generateEventCARD($row);
                $this->panelContent_2 .= '</div>';
            } // end while

            $this->panelContent_2 .= '</div>';
            
            /*             * ****  build the pagination links ***** */
// range of num links to show
            $range = 3;
            $this->panelContent_2 .= "<div class='paginationNav'>";
            $this->panelContent_2 .= "<div id='horizontalItems'>";
// if not on page 1, don't show back links
            if ($currentpage > 1) {
                // show << link to go back to page 1
                $this->panelContent_2 .= " <a href='{$_SERVER['PHP_SELF']}?pageID=events&currentpage=1'><<</a> ";
                // get previous page num
                $prevpage = $currentpage - 1;
                // show < link to go back to 1 page
                $this->panelContent_2 .= " <a href='{$_SERVER['PHP_SELF']}?pageID=events&currentpage=$prevpage'><</a> ";
            } // end if 
// loop to show links to range of pages around current page
            for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
                // if it's a valid page number...
                if (($x > 0) && ($x <= $totalpages)) {
                    // if we're on current page...
                    if ($x == $currentpage) {
                        // make it a dummy link
                        $this->panelContent_2 .= " <a class='btn-primary'>$x</a> ";
                        // if not current page...
                    } else {
                        // make it a link
                        $this->panelContent_2 .= " <a href='{$_SERVER['PHP_SELF']}?pageID=events&currentpage=$x'>$x</a> ";
                    } // end else
                } // end if 
            } // end for
// if not on last page, show forward and last page links        
            if ($currentpage != $totalpages) {
                // get next page
                $nextpage = $currentpage + 1;
                // echo forward link for next page 
                $this->panelContent_2 .= " <a href='{$_SERVER['PHP_SELF']}?pageID=events&currentpage=$nextpage'>></a> ";
                // echo forward link for lastpage
                $this->panelContent_2 .= " <a href='{$_SERVER['PHP_SELF']}?pageID=events&currentpage=$totalpages'>>></a> ";
            } // end if
            /*             * **** end build pagination links ***** */
            //paginationNav end div
            $this->panelContent_2 .= '</div>';
             $this->panelContent_2 .= '</div>';
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
//        if ($this->loggedin) {
//            $events = new EventTable($this->db);
//
//            if ($rs = $events->getAllEvents()) {
//
//                $this->panelContent_3 .= HelperHTML::generateTABLE($rs);
//            } else {
//                $this->panelContent_3 .= 'Record not found';
//            }
//        } else {
//            $this->panelContent_3 = "Panel 3 content for <b>$this->pageHeading</b> menu item is under construction.  This message appears if user is in logged OFF state.";
//            ;
//        }
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
