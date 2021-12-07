<?php

class EventTable extends TableEntity {
    //METHOD: Construct

    /**
     * Constructor for the EventTable Class
     * 
     * @param MySQLi $databaseConnection A validated MySQLi database connection object. 
     */
    function __construct($databaseConnection) {
        parent::__construct($databaseConnection, 'event');
    }

    //END METHOD: Construct
    //METHOD: getFullEventByID($eventID)

    /**
     * Returns full event info by ID
     * 
     * @param string $eventID
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
    public function getFullEventByID($eventID) {
        $sql = "SELECT 
                            event.event_name Name,
                            slu.sport Sport,
                            etlu.type Type,
                            event.fee Fee,
                            event.event_date Date,
                            CAST(event.starttime AS TIME (0)) Start,
                            CAST(event.endtime AS TIME (0)) End,
                            event.location Location,
                            event_admin.first_name Admin_First,
                            event_admin.last_name Admin_Last
                        FROM
                            event,
                            eventtypelookup etlu,
                            sportlookup slu,
                            event_admin
                        WHERE
                            slu.sport_nr = event.sport
                                AND etlu.type_nr = event.event_type
                                AND event.admin_ID = event_admin.admin_ID
                                AND event_ID = '$eventID'
                        ;
                        ";
        if ($rs = $this->db->query($sql)) {
            if ($rs->num_rows === 1) {
                return $rs;
            } else {
                return false;
            }//only one record should be returned
        } else {
            return false;
        }
    }

    //END METHOD: getRecordByID($eventID
    //METHOD: getFullEventByID($eventID)

    /**
     * Returns full event info by ID
     * 
     * @param string $eventID
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
    public function getEventDetailsByID($eventID) {
        $sql = "SELECT 
                            event.event_name Name,
                            slu.sport Sport,
                            event.fee Fee,
                            DATE_FORMAT(event.event_date, '%d/%m/%Y') Date,
                            DATE_FORMAT(event.starttime, '%H:%i') Start,
                            DATE_FORMAT(event.endtime, '%H:%i') End,
                            event.nr_attendees Attendees,
                            event.max_nr_attendees Max,
                            event.min_nr_attendees Min,
                            event.location Location,
                            etlu.type Type,
                            rlu.recurring_type Recurring,
                            event_admin.first_name Admin_First,
                            event_admin.last_name Admin_Last
                        FROM
                            event,
                            eventtypelookup etlu,
                            sportlookup slu,
                            recurringlookup rlu,
                            event_admin
                        WHERE
                            slu.sport_nr = event.sport
                                AND etlu.type_nr = event.event_type
                                AND event.admin_ID = event_admin.admin_ID
                                AND rlu.recurring_nr = event.recurring
                                AND event_ID = '$eventID'
                        ;
                        ";
        if ($rs = $this->db->query($sql)) {
            if ($rs->num_rows === 1) {
                return $rs;
            } else {
                return false;
            }//only one record should be returned
        } else {
            return false;
        }
    }

    //END METHOD: getRecordByID($eventID
    //METHOD: getFullEventDataByID($eventID)

    /**
     * Returns all event data to repopulate 'modify' form
     * 
     * @param type $eventID
     * @return boolean
     */
    public function getFullEventDataByID($eventID) {
        $sql = "SELECT     
                            event_ID,
                            event_name ename,
                            sport,
                            fee,
                            event_date edate,
                            CAST(event.starttime AS TIME (0)) stime,
                            CAST(event.endtime AS TIME (0)) etime,
                            max_nr_attendees maxatt,
                            min_nr_attendees minatt,
                            event_type etype,
                            recurring,
                            location
                    FROM event
                    WHERE
                            event_ID = '$eventID';";
        if ($rs = $this->db->query($sql)) {
            if ($rs->num_rows > 0) {
                return $rs;
            } else {
                return false;
            }//at least one record should be returned
        } else {
            return false;
        }
    }

    //END METHOD: getFullEventDataByID($eventID)
    //METHOD: getPartialEventByID($eventID)

    /**
     * Returns a partial event record (Name, Sport, Date, Fee) by $eventID
     * 
     * @param string $eventID
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
    public function getPartialEventByID($eventID) {
        $sql = "SELECT 
                            event.event_name ename,
                            slu.sport sport,
                            event.fee fee,
                            event.event_date edate
                        FROM
                            event,
                            sportlookup slu
                        WHERE
                            slu.sport_nr = event.sport
                                AND event_ID = '$eventID'
                        ;"
        ;
        if ($rs = $this->db->query($sql)) {
            if ($rs->num_rows === 1) {
                return $rs;
            } else {
                return false;
            }//only one record should be returned
        } else {
            return false;
        }
    }

    //END METHOD: getRecordByID($userID
    //METHOD:    getAllEvents() 

    /**
     * Performs a SELECT query to returns all events from the table. 
     * Name, Sport, Date, Fee columns only.
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
    public function getAllEvents() {
        $sql = "SELECT 
                            event.event_ID ID,
                            event.event_name Name,
                            slu.sport Sport,
                            event.fee Fee,
                            event.event_date Date
                        FROM
                            event,
                            sportlookup slu
                        WHERE
                            slu.sport_nr = event.sport
                        AND 
                        event.status = '1'
                        ;";
        if ($rs = $this->db->query($sql)) {
            if ($rs->num_rows > 0) {
                return $rs;
            } else {
                return false;
            }//at least one record should be returned
        } else {
            return false;
        }
    }

    //END METHOD: getAllEvents()
    //METHOD:    getAllEvents() 

    /**
     * Performs a SELECT query to returns all events from the table. 
     * Name, Sport, Date, Fee columns only.
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
    public function getAllEventsPaginate($offset, $rowsperpage) {
        $sql = "SELECT 
                            event.event_ID ID,
                            event.event_name Name,
                            slu.sport Sport,
                            event.fee Fee,
                            DATE_FORMAT(event.event_date, '%a %D %b') Date,
                            DATE_FORMAT(event.starttime, '%H:%i') Start,
                            DATE_FORMAT(event.endtime, '%H:%i') End
                        FROM
                            event,
                            sportlookup slu
                        WHERE
                            slu.sport_nr = event.sport
                        LIMIT
                            $offset,
                            $rowsperpage
                        ;";
        if ($rs = $this->db->query($sql)) {
            if ($rs->num_rows > 0) {
                return $rs;
            } else {
                return false;
            }//at least one record should be returned
        } else {
            return false;
        }
    }

    //END METHOD: getAllEvents()
    //METHOD:    getRandomEvents() 

    /**
     * Performs a SELECT query to returns random events from the table limited to $number. 
     * Name, Sport, Date, Fee columns only.
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
    public function getRandomEvents($number) {
        $sql = "SELECT 
                            event.event_ID ID,
                            event.event_name Name,
                            slu.sport Sport,
                            event.fee Fee,
                            DATE_FORMAT(event.event_date, '%a %D %b') Date,
                            DATE_FORMAT(event.starttime, '%H:%i') Start,
                            DATE_FORMAT(event.endtime, '%H:%i') End
                        FROM
                            event,
                            sportlookup slu
                        WHERE
                            slu.sport_nr = event.sport
                            AND
                            event.status = '1'
                            order by RAND() limit $number
                        ;";
        if ($rs = $this->db->query($sql)) {
            if ($rs->num_rows > 0) {
                return $rs;
            } else {
                return false;
            }//at least one record should be returned
        } else {
            return false;
        }
    }

    //END METHOD: getRandomEvents()
    //METHOD: deleteRecordbyID($userID)

    /**
     * Performs a DELETE query for a single event ($eventID).  Verifies the
     * event exists before attempting to delete
     * 
     * @param $eventID  String containing ID of events record to be deleted
     */
    public function deleteEventbyID($eventID) {

        if ($this->getFullEventByID($eventID)) { //confirm the event exists before deleting
            $sql = "DELETE from event WHERE event_ID ='$eventID';";
            if ($this->db->query($sql)) {
                return true;
            } else {
                return false;
            } //try to delete the event
        } else {
            return false; //record doesnt exist
        }
    }

    //END METHOD: deleteRecordbyID($userID) 
    //METHOD:    addEvent($postArray)

    /**
     * Adds new Event by $postArray.
     * 
     * @param type $postArray
     * @return boolean
     */
    public function addEvent($adminID, $postArray) {

        //get the values entered in the registration form contained in the $postArray argument      
        extract($postArray);
        //add escape to special characters

        $ename = addslashes($ename);
        $location = addslashes($location);
        $fee = addslashes($fee);

        //construct the INSERT SQL                     
        $sql = "INSERT INTO event(admin_ID, event_name, fee, event_date, starttime, endtime, nr_attendees, max_nr_attendees, 
		min_nr_attendees, event_type, recurring, location, sport) VALUES('$adminID', '$ename', '$fee', '$date',
		'$stime', '$etime', '0', '$maxatt', '$minatt', '$etype', '$recurring', '$location', '$sport')";
        //execute the insert query
        //check the insert query worked
        if ($rs = $this->db->query($sql)) {
            //email moderator 
            $subject = "DICE Event Added";

            $message = "
                    <html>
                    <head>
                    <title>Event Added needs approval</title>
                    </head>
                    <body>
                    <p>A new event needs approval before being made public to DICE users</p>
                    <p>Please check the DICE database for a new event made by Event Administrator $adminID.</p>
                    </body>
                    </html>
                    ";

// Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            mail('eoinconway@live.com', $subject, $message, $headers);
            return TRUE;//add successfully
            
        } else {
            return FALSE;
        }
    }

    //END METHOD: addEvent($postArray)
    //METHOD:    updateEvent($postArray)

    /**
     * 
     * @param type $postArray
     * @return boolean
     */
    public function updateEvent($postArray) {

        //get the values entered in the event form contained in the $postArray argument      
        extract($postArray);

        //add escape to special characters
        $ename = addslashes($ename);
        $location = addslashes($location);
        $fee = addslashes($fee);

        //construct the INSERT SQL                     
        $sql = "UPDATE event SET event_name='$ename', fee='$fee', event_date='$date', "
                . "starttime='$stime', endtime='$etime', max_nr_attendees='$maxatt', "
                . "min_nr_attendees='$minatt', event_type='$etype', recurring='$recurring', location='$location', sport='$sport' "
                . "WHERE event_ID='$event_ID'";
        //execute the insert query
        //check the insert query worked
        if ($rs = $this->db->query($sql)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //END METHOD: updateEvent($postArray)
    //METHOD:    checkMaxLimit($event_ID)  
    public function checkMaxLimit($event_ID) {
        $sql = "SELECT * 
                FROM softwareproject.event 
                WHERE nr_attendees < max_nr_attendees
                AND
                event_ID = '$event_ID';";

        if ($rs = $this->db->query($sql)) {
            if ($rs->num_rows === 1) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    //END METHOD: checkMaxLimit($event_ID)
    //METHOD:    incrementAttendees($eventID)

    /**
     * increment Number of Attendees on Event object by value of 1
     * 
     * @param type $eventID
     * @return boolean
     */
    public function incrementAttendees($eventID) {
        $sql = "UPDATE event 
                SET 
                    nr_attendees = nr_attendees + 1
                WHERE
                    event.event_ID = '$eventID';";

        if ($rs = $this->db->query($sql)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //END METHOD: incrementAttendees($eventID) 
    //METHOD:    decrementAttendees($eventID)

    /**
     * decrement Number of Attendees on Event object by value of 1
     * 
     * @param type $eventID
     * @return boolean
     */
    public function decrementAttendees($eventID) {
        $sql = "UPDATE event 
                SET 
                    nr_attendees = nr_attendees - 1
                WHERE
                    event.event_ID = '$eventID';";

        if ($rs = $this->db->query($sql)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //END METHOD: decrementAttendees($eventID) 
    //METHOD: deleteRecordbyID($userID)

    /**
     * Performs a DELETE query for a single event ($eventID).  Verifies the
     * event exists before attempting to delete
     * 
     * @param $eventID  String containing ID of events record to be deleted
     */
    public function archiveEvent($eventID) {

        if ($this->getFullEventByID($eventID)) { //confirm the event exists before deleting
            $sql = "INSERT INTO event_archive
                    SELECT * FROM event
                    WHERE event_ID = $eventID;"; //move copy row to archive table
            if ($this->db->query($sql)) {

                return true;
            } else {
                return false;
            } //try to delete the event
        } else {
            return false; //record doesnt exist
        }
    }

    //END METHOD: deleteRecordbyID($userID)
}
