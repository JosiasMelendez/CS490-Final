<html>
<head>
  <title>Teacher homepage</title>
  <link rel="stylesheet" href="teacher_style.css">
</head>
<body>
<?php
if (!empty($_POST)) {
  $teacher = $_POST['userName'];
}
else {
  print("Must log in before viewing this page");
  exit();
}
?>
<h1>Welcome, <?php echo $teacher ?> </h1>
<form method="post" id="teacherForm">
  <div class="choice one">
  Create a question and enter it into the question bank<br /><br /><input type="submit" value="Create a question" formaction="question_maker.php"/>
  </div>
  <div class="choice two">
  Create a test out of questions in the question bank<br /><br /><input type="submit" value="Create a test" formaction="test_maker.php"/>
  </div>
  <div class="choice three">
  Review all tests submitted by students<br /><br /><input type="submit" value="Select test to review" formaction="review_exam.php"/>
  </div>
  <input type="hidden" value="<?php echo $teacher ?>" name="teacher"/>
</form>
</body>
</html>