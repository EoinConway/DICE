<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA_Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <!-- extra stylesheets below bootstrap css -->

        <title>View All Events</title>
    </head> 
    <body>
        <div class="container">
            <h1>Event Table</h1>
            <table class="table table-hover">
                <thead>
                    <tr>
                      <th scope="col">Event Name</th>
                      <th scope="col">Sport</th>
                      <th scope="col">Event Type</th>
                      <th scope="col">Fee (€)</th>
                      <th scope="col">Date</th>
                      <th scope="col">Start Time</th>
                      <th scope="col">End Time</th>
                      <th scope="col">Location</th>
                      <th scope="col">Event Administrator</th>
                    </tr>
                </thead>
                <?php
                $conn = mysqli_connect( "localhost", "root", "", "softwareproject" );
                
                if ( !$conn ) {
                    echo 'connection error'.mysqli_connect_error( $conn );
                }
                $sql = "SELECT 
                            event.event_name ename,
                            slu.sport sport,
                            etlu.type etype,
                            event.fee fee,
                            event.event_date edate,
                            CAST(event.starttime AS TIME (0)) starttime,
                            CAST(event.endtime AS TIME (0)) endtime,
                            event.location location,
                            event_admin.first_name eafname,
                            event_admin.last_name ealname
                        FROM
                            event,
                            eventtypelookup etlu,
                            sportlookup slu,
                            event_admin
                        WHERE
                            slu.sport_nr = event.sport
                                AND etlu.type_nr = event.event_type
                                AND event.admin_ID = event_admin.admin_ID
                        ;
                        ";
                
                $result = $conn -> query($sql);
                
                if ($result -> num_rows > 0){
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr style=\"transform: rotate(0);\">
                                <th scope=\"row\"><a href=\"#\" class=\"stretched-link\">"
                                        .$row["ename"].
                                "</a></th><td>"
                                        . $row["sport"].
                                "</td><td>"
                                        . $row["etype"].
                                "</td><td>"
                                        . $row["fee"].
                                "</td><td>"
                                        . $row["edate"].
                                "</td><td>"
                                        . $row["starttime"].
                                "</td><td>"
                                        . $row["endtime"].
                                "</td><td>"
                                        . $row["location"].
                                "</td><td>"
                                        . $row["eafname"]." ".$row["ealname"].
                                "</td><tr>";
                    }
                }

                ?>
                <tbody>
                    
                </tbody>
                
                
                
            </table>
            
    
        </div><!-- container -->
        <script src="../js/jquery.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <!-- extra scripts below -->
    </body>
</html>

<?php



?>