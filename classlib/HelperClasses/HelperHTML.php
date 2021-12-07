<?php

/*
 * Class: HelperHTML
 * 
 * Automates some common HTML generating tasks
 * 
 */

Class HelperHTML {

    public static function generateTABLE($resultSet) {
        //This STATIC method returns a HTML table as a string
        //It takes one argument - $resultSet which must contain an object
        //of the $resultSet class
        $table = '';  //start with an empty string
        //generate the HTML table
        $i = 0;
        $resultSet->data_seek(0);  //point to the first row in the result set

        $table .= '<table class="table table-hover" border="1">';
        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
            while ($i === 0) {  //trick to generate the HTML table headings
                $table .= '<thead><tr>';
                foreach ($row as $key => $value) {
                    $table .= "<th>$key</th>"; //echo the keys as table headings for the first row of the HTML table
                }
                $table .= '<th></th>';
                $table .= '</tr></thead>';
                $i = 1;
            }

            $table .= '<tr>';
            foreach ($row as $value) {
                $table .= "<td>$value</td>";
            }
            $table .= '<td><a href="' . $_SERVER['PHP_SELF'] . '?pageID=event&eventID=' . $row['ID'] . '" class="btn btn-danger btn-sm" data-toggle="modal">Event Page</a></td>';
            $table .= '</tr>';
        }
        $table .= '</table>';
        return $table;
    }
    
    public static function generateAllEventsTable($resultSet) {
        //This STATIC method returns a HTML table as a string
        //It takes one argument - $resultSet which must contain an object
        //of the $resultSet class
        $table = '';  //start with an empty string
        //generate the HTML table
        $i = 0;
        $resultSet->data_seek(0);  //point to the first row in the result set

        $table .= '<table class="table table-hover" border="1" id="eventsTable">';
        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
            while ($i === 0) {  //trick to generate the HTML table headings
                $table .= '<thead><tr>';
                foreach ($row as $key => $value) {
                    $table .= "<th>$key</th>"; //echo the keys as table headings for the first row of the HTML table
                }
                $table .= '<th></th>';
                $table .= '</tr></thead>';
                $i = 1;
            }

            $table .= '<tr>';
            foreach ($row as $value) {
                $table .= "<td>$value</td>";
            }
            $table .= '<td><a href="' . $_SERVER['PHP_SELF'] . '?pageID=event&eventID=' . $row['ID'] . '" class="btn btn-danger btn-sm" data-toggle="modal">Event Page</a></td>';
            $table .= '</tr>';
        }
        $table .= '</table>';
        return $table;
    }

    public static function generateAdminTABLE($resultSet) {
        //This STATIC method returns a HTML table as a string
        //It takes one argument - $resultSet which must contain an object
        //of the $resultSet class
        $table = '';  //start with an empty string
        //generate the HTML table
        $i = 0;
        $resultSet->data_seek(0);  //point to the first row in the result set

        $table .= '<table class="table table-hover" border="1" id="eventsTable">';
        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
            while ($i === 0) {  //trick to generate the HTML table headings
                $table .= '<thead><tr>';
                foreach ($row as $key => $value) {
                    $table .= "<th>$key</th>"; //echo the keys as table headings for the first row of the HTML table
                }
                $table .= '<th></th>';
                $table .= '<th></th>';
                $table .= '<th></th>';
                $table .= '</tr></thead>';
                $i = 1;
            }

            $table .= '<tr>';
            foreach ($row as $value) {
                $table .= "<td>$value</td>";
            }
            $table .= '<td><a href="' . $_SERVER['PHP_SELF'] . '?pageID=event&eventID=' . $row['ID'] . '" class="btn btn-danger btn-sm" data-toggle="modal">Event Page</a></td>';

            $table .= '<td><a href="' . $_SERVER['PHP_SELF'] . '?pageID=editEvent&eventID=' . $row['ID'] . '" ><i class="fas fa-edit" data-bs-toggle="tooltip" title="Modify" data-original-title="Modify"></i></a></td>';

            $table .= '<td><a href="#myModal" data-bs-toggle="modal" data-id="' . $row['ID'] . '" onclick="confirmDelete(this);"><i class="fas fa-trash-alt" data-bs-toggle="tooltip" title="Delete" data-original-title="Delete"></i></a></td>';

            //<button type="button" class="btn btn-danger" data-id="'.$row['ID'].'" onclick="confirmDelete(this);">Delete</button>
            $table .= '</tr>';
        }
        $table .= '</table>';
        return $table;
    }

    public static function generateEventDetailsCARD($row) {
        //This STATIC method returns a HTML table as a string
        //It takes one argument - $resultSet which must contain an object
        //of the $resultSet class
        $output = "";

        $output .= "<div class='row'>"; //sport and type
        $output .= "<div class='col-xl-6'>";
        $output .= "<p class='text-center'>Sport: " . $row['Sport'] . "</p>";
        $output .= "</div>"; //end sport column
        $output .= "<div class='col-xl-6'>";
        $output .= "<p class='text-center'>Type: " . $row['Type'] . "</p>";
        $output .= "</div>"; //end sport column
        $output .= "</div>"; //row end

        $output .= "<div class='row'>"; //date and time row
        $output .= "<div class='col-xl-6'>";
        $output .= "<p class='text-center'>Date: " . $row['Date'] . "</p>";
        $output .= "</div>"; //end date column
        $output .= "<div class='col-xl-6'>";
        $output .= "<p class='text-center'>Time: " . $row['Start'] . "-" . $row['End'] . "</p>";
        $output .= "</div>"; //end time column
        $output .= "</div>"; //row end

        $output .= "<div class='row' id='attendeesRow'>"; //attendees row
        $output .= "<p class='text-center'>Number of Attendees: " . $row['Attendees'] . "</p>";
        $output .= "<p class='text-center'>Min. Needed: " . $row['Min'] . "</p>";
        $output .= "<p class='text-center'>Max. Accepted: " . $row['Max'] . "</p>";
        $output .= "</div>"; //row end

        $output .= "<div class='row' id='feeRow'>"; //fee row
        $output .= '<p><i>Fee : €' . $row['Fee'] . '</i></p>';
        $output .= "</div>"; //row end
        return $output;


//        $table = '';  //start with an empty string
//        //generate the HTML table
//        $i = 0;
//        $resultSet->data_seek(0);  //point to the first row in the result set
//
//        $table .= '<table class="table table-hover">';
//        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
////            
//            foreach ($row as $key => $value) {
//                $table .= '<tr>';
//                $table .= "<th>$key</th><td>$value</td>";
//                $table .= '</tr>';
//            }
//            
//        }
//        $table .= '</table>';
//        return $table;
    }

    public static function generateEventCARD($row) {
        
        $output = "";

        
        $output .= "<div class = 'card'>";
        $output .= "<div class = 'card-body'>";
        $output .= "<h5 class = 'card-title mb-3'>".$row['Name']."</h5>";
        $output .= "</div>";
        $output .= "<ul class='list-group list-group-flush'>";
        $output .= "<li class='list-group-item card-date'>".$row['Date']." (".$row['Start']." - ".$row['End'].")</li>";
        $output .= "<li class='list-group-item card-sport'>".$row['Sport']."</li>";
        $output .= "<li class='list-group-item'>€".$row['Fee']."</li>";
        $output .= "</ul>";
        $output .= "<div class='card-body'>";
        $output .= '<a href="' . $_SERVER['PHP_SELF'] . '?pageID=event&eventID=' . $row['ID'] .' " class="card-link btn btn-danger btn-sm">Event Page</a>';
        $output .= "</div>";
        $output .= "</div>";
        
        return $output;
    }

    public static function generateArchiveTABLE($resultSet) {
        //This STATIC method returns a HTML table as a string
        //It takes one argument - $resultSet which must contain an object
        //of the $resultSet class
        $table = '';  //start with an empty string
        //generate the HTML table
        $i = 0;
        $resultSet->data_seek(0);  //point to the first row in the result set

        $table .= '<table class="table table-hover" border="1">';
        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
            while ($i === 0) {  //trick to generate the HTML table headings
                $table .= '<thead><tr>';
                foreach ($row as $key => $value) {
                    $table .= "<th>$key</th>"; //echo the keys as table headings for the first row of the HTML table
                }
                $table .= '<th></th>';//archive button column
                $table .= '</tr></thead>';
                $i = 1;
            }

            $table .= '<tr>';
            foreach ($row as $value) {
                $table .= "<td>$value</td>";
            }
            $table .= '<td><a href="#myModal" data-bs-toggle="modal" data-id="' . $row['ID'] . '" class="btn btn-danger btn-sm" onclick="confirmArchive(this);">Archive</a></td>';
            $table .= '</tr>';
        }
        $table .= '</table>';
        return $table;
    }
}
