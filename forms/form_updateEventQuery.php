<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<form method="post" action="<?php echo($_SERVER['PHP_SELF'] . '?pageID=updateEvent');?>">
<div class="form-group">
<label for="eventID">Event ID:</label>
<input type="text" class="form-control" id="eventID" name="eventID">
</div>
<button type="submit" class="btn btn-primary" name="btnSelectEvent">Submit</button>
</form>

