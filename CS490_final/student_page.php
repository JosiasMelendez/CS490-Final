<html>
<head>
  <title>Student homepage</title>
  <link rel="stylesheet" href="student_style.css">
</head>
<body>
<?php
if (!empty($_POST)) {
  $student = $_POST['userName'];
}
else {
  print("Must log in before viewing this page");
  exit();
}
?>
<h1>Welcome, <?php echo $student ?></h1>
<div class="choice one">
<form action="take_exam.php" method="post" id="studentForm1">
  Take a test assigned by your instructor<br /><br /><input type="submit" value="Select an available test"/>
  <input type="hidden" value="<?php echo $student ?>" id="studentid" name="studentid"/>
</form>
</div>
<div class="choice two">
<form action="see_results.php" method="post" id="studentForm2">
  View your grades on any of your submitted exams<br /><br /><input type="submit" value="See Test Results"/>
  <input type="hidden" value="<?php echo $student ?>" id="studentid1" name="studentid1"/>
</form>
</div>
</body>
</html>