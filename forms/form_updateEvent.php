<?php
//
extract($row);

            $sportTable = new SportTable($this->db);
            $sportList = array();
            $i = 1;  //array index
            if ($rs = $sportTable->getAllRecords()) {
                while ($row = $rs->fetch_assoc()) {
                    $sportList[$i] = $row['sport'];   //build an array of sport names $sportList
                    $i++;
                }     
            } else {
                echo 'err';
            }
            
            $recurringTable = new RecurringTable($this->db);
            $recurringList = array();
            $i = 1;  //array index
            if ($rs = $recurringTable->getAllRecords()) {
                while ($row = $rs->fetch_assoc()) {
                    $recurringList[$i] = $row['recurring_type'];//build an array of recurring types $recurringList
                    $i++;
                }     
            } else {
                echo 'err';
            }
            
            $eventTypeTable = new EventTypeTable($this->db);
            $eventTypeList = array();
            $i = 1;  //array index
            if ($rs = $eventTypeTable->getAllRecords()) {
                while ($row = $rs->fetch_assoc()) {
                    $eventTypeList[$i] = $row['Type'];//build an array of event types $eventTypeList
                    $i++;
                }     
            } else {
                echo 'err';
            }
            
            
?>

<script>

            function validateForm(){
                var ename_val = document.getElementById("ename").value;
                var location_val = document.getElementById("location").value;//REMEMBER .VALUE
                var minatt_val = document.getElementById("minatt").value;
                var maxatt_val = document.getElementById("maxatt").value;


                if (validate_req() == true && enameLength(ename_val) == true && locationLength(location_val) == true && maxCheck(minatt_val, maxatt_val) == true) {
                    
                    return true;
                }
                else return false;

            }

            function validate_req(){

                var ename_val = document.getElementById("ename").value;

                if (ename_val == null || ename_val == ""){
                    alert("Please enter an event name");
                    return false; 
                }

                var location_val = document.getElementById("location").value;

                if (location_val == null || location_val == ""){
                    alert("Please enter a location");
                    return false; 
                }

                var stime_val = document.getElementById("stime").value;

                if (stime_val == null || stime_val == ""){
                    alert("Please enter a start time");
                    return false; 
                }

                var etime_val = document.getElementById("etime").value;

                if (etime_val == null || etime_val == ""){
                    alert("Please enter an end time");
                    return false; 
                }

                var minatt_val = document.getElementById("minatt").value;

                if (minatt_val == null || minatt_val == ""){
                    alert("Please enter a minimum number of attendees");
                    return false;
                }

                else return true;

                var maxatt_val = document.getElementById("maxatt").value;

                if (maxatt_val == null || maxatt_val == ""){
                    alert("Please enter a maximum number of attendees");
                    return false;
                }

                else return true;
            }


            function enameLength(ename){
                if (ename.length > 30){
                    alert("Name can be max 30 characters");
                    return false;
                }
                else return true;
            }

            function locationLength(location){
                if (location.length > 30){
                    alert("Location must be max 30 characters");
                    return false;
                }
                else return true;
            }


            function maxCheck(minatt, maxatt){
                var minatt_num = parseInt(minatt, 10);
                var maxatt_num = parseInt(maxatt, 10);

                if (minatt_num >= maxatt_num){
                    alert("Max must be greater than min");
                    return false;
                }
                else return true;
            }

        </script>

        
        
        
            <form id="updateForm" method="post" onSubmit="return validateForm();" action="<?php echo($_SERVER['PHP_SELF'] . '?pageID=editEvent&eventID='. $_GET['eventID']); ?>">
                
            <label>Event ID:</label><input required type="text"  readonly value="<?php echo $event_ID;?>" name="event_ID">
                    
            <label for="ename" hidden>Event Name:</label>
            <input required type="text" value="<?php echo $ename;?>" id="ename" name="ename" class="form-control" placeholder="Event Name">
               
            
            <label for="location" hidden>Location:</label>
            <input required type="text" value="<?php echo $location;?>" id="location" name="location" class="form-control" placeholder="Location">
                
    
            <label for="sport" hidden>Sport:</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Sport</span>
                </div>
                <select id="sport" name="sport" class="form-control form-select">
                    <?php
                //build a list of the counties as options from the $countyList array
                foreach($sportList as $key=>$value){
                    $option = '<option value="'.$key.'"';
                    if ($sport == $key){
                        $option .= ' selected';
                    }
                    $option .= '>'.$value.'</option>';
                    echo $option;  
                }
                ?>
                    
                    //<?php
//                //build a list of the counties as options from the $countyList array
//                foreach($sportList as $key=>$value){
//                    echo '<option value="'.$key.'">'.$value.'</option>';  
//                }
//                ?>
<!--                    <option value="12" <?php //if ($sport == '12') { echo 'selected'; } ?>>Other</option> -->
                </select>
            </div>
                    
                    
            <label for="etype" hidden>Event Type:</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Event Type</span>
                </div>
                <select id="etype" name="etype" class="form-control form-select">
                    <?php
                //build a list of the counties as options from the $countyList array
                foreach($eventTypeList as $key=>$value){
                    $typeOption = '<option value="'.$key.'"';
                    if ($etype == $key){
                        $typeOption .= ' selected';
                    }
                    $typeOption .= '>'.$value.'</option>';
                    echo $typeOption;    
                }
                ?>
                </select>
            </div>
                    
                
            <label for="date">Date:</label>
            <input type="date" value="<?php echo $edate;?>" id="date" name="date" class="form-control">
                
                         
            <label for="stime">Start Time:</label>
            <input value="<?php echo $stime;?>" type="time" id="stime" name="stime" class="form-control">


            <label for="etime">End Time:</label>
            <input value="<?php echo $etime;?>" type="time" id="etime" name="etime" class="form-control">
           
                        
            <label for="fee">Fee:</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">€</span>
                </div>
                <input value="<?php echo $fee;?>" type="number" step="any" id="fee" name="fee" class="form-control">
            </div>
                
          
            <label for="minatt">Min. Attendees:</label>
            <input value="<?php echo $minatt;?>" type="number" min="1" id="minatt" name="minatt" class="form-control">


            <label for="maxatt">Max. Attendees:</label>
            <input value="<?php echo $maxatt;?>" type="number" min="1" id="maxatt" name="maxatt" class="form-control">
                    
                
            <label for="recurring">Recurring:</label>
            <select value="<?php echo $recurring;?>" id="recurring" name="recurring" class="form-control">
                <?php
                //build a list of the counties as options from the $countyList array
                foreach($recurringList as $key=>$value){
                    $recOption = '<option value="'.$key.'"';
                    if ($recurring == $key){
                        $recOption .= ' selected';
                    }
                    $recOption .= '>'.$value.'</option>';
                    echo $recOption;    
                }
                ?>
            </select>
                
                
            <button type="submit" class="btn btn-primary" name="btnSaveUpdate" value='updateEvent'>Save Update</button>
            <button type="submit" class="btn btn-primary" name="btnCancelUpdate" value='cancelUpdateEvent'>Cancel</button>

            </form>
        