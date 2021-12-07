<?php

?>
<script>

        
</script>


<form method="post" action="<?php echo($_SERVER['PHP_SELF'] . '?pageID=profile');?>">
<div class="form-group">
<label for="newMobile">New Number</label>
<input type="text" class="form-control" id="newMobile" name="newMob" pattern="^08[35-9]{1}[0-9]{7}$" title="Mobile Number Format: 0831234567">
</div>
<button type="submit" class="btn btn-primary mt-3" name="btnUpdateMobile">Update</button>
</form>