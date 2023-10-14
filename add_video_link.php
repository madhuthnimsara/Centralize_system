<?php include('./class.inc.php'); ?>

<?php 
if(isset($_POST['submit'])){
$insertLink=$main->insertVideoLink($_POST);
print_r($insertLink);
}
?>
<h1>Upload your video URL here</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <label for="link">Link:</label>
  <input type="text" id="link" name="link" placeholder="Enter a link..." required ><br>
  <input type="checkbox" name="data[]" value="1" >www.trincomalee.com<br>
   <input type="checkbox" name="data[]" value="2">www.kandy.com<br>
   <input type="checkbox" name="data[]" value="3">www.uk.com<br>
  <button type="submit" name="submit" class="link-button">Submit</button>
</form>
<div><?php if(isset($_SESSION['message'])){ echo $_SESSION['message'];unset($_SESSION['message']);} ?></div>