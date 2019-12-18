<html> 
<head>
  <title>Exam</title>
  <link rel="stylesheet" href="review_style.css">
  <meta charset="utf-8"/>
</head>
<body>
<h1>Available Exams</h1>
<?php
if (!empty($_POST)) {
  $student = $_POST['studentid'];
}
$data = array(
  'studentID' => $student
);
$url = "https://web.njit.edu/~jm844/getAvailableExams.php";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
if ($result == false) {
  print "Curl failed.";
  exit();
}
$data = json_decode($result);
echo '<p>Here are tests you have not yet taken.</p>';
echo '<form action="take_exam2.php" method="post" id="exam" name="exam">';
for ($i = 0; $i < sizeof($data->hasNotTaken); $i++) {
  echo '<div class="tests">';
  echo $data->hasNotTaken[$i];
  echo '<br /><br />';
  echo '<button name="examname" type="submit" value="'.$data->hasNotTaken[$i].'">Take this exam</button>';
  echo '<br /><br />';
  echo '</div>';
}
if (sizeof($data->hasNotTaken) == 0) {
  echo 'There are no new exams currently available for taking';
}
?>
<input type="text" value="<?php echo $student ?>" style="visibility:hidden;" id="studentname" name="studentname"/>
</form>
</body>
</html>