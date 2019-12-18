<html>
<head>
  <title>Check Exam Results</title>
  <link rel="stylesheet" href="review_style.css">
  <meta charset="utf-8"/>
</head>
<body>
<h1>Exams Submitted</h1>
<?php
if (!empty($_POST)) {
  $student = $_POST['studentid1'];
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
echo '<p>Here are tests you have submitted and are now graded.</p>';
echo '<form action="see_results2.php" method="post" id="exam" name="exam">';
for ($i = 0; $i < sizeof($data->hasTaken); $i++) {
  echo '<div class="tests">';
  echo $data->hasTaken[$i];
  echo '<br /><br />';
  echo '<button name="examname" type="submit" value="'.$data->hasTaken[$i].'">Review this exam</button>';
  echo '<br /><br />';
  echo '</div>';
}
?>
<input type="hidden" name="studentid1" value="<?php echo $student ?>"/>
</form>
</body>
</html>  