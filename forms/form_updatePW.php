<?php

?>

<form method="post" action="<?php echo($_SERVER['PHP_SELF'] . '?pageID=profile');?>">
<div class="form-group">
<label for="oldPW">Old Password</label><input type="password" class="form-control" id="oldPW" name="oldPW" title="Enter previously stored password">
<label for="pass1">New Password</label><input required type="password" class="form-control" id="pass1" name="pass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
<label for="pass2">Re-enter Password</label><input required type="password" class="form-control" id="pass2" name="pass-repeat" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must match the above password exactly">
</div>
<button type="submit" class="btn btn-primary mt-3" name="btnUpdatePW">Update</button>
</form>