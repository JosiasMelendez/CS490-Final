<html>
<head>
  <title>Exam</title>
  <meta charset="utf-8"/>
  <script type="text/JavaScript" src="testarea.js"></script>
  <link rel="stylesheet" href="exam_take_style.css">
</head>
<body>
<form action="answer_send.php" method="post" id="exam" name="exam">
<?php
if (!empty($_POST)) {
  $examname = $_POST['examname'];
  $student = $_POST['studentname'];
}
else {
  print "POST array is empty";
  exit();
}
$data = array(
  'examname' =>$examname
);
$url = "https://web.njit.edu/~jm844/getExam.php";
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
$ids = "";
$points = "";
echo '<h1>'.$examname.'</h1>';
for ($i = 0; $i < sizeof($data); $i++) {
  $j = $i + 1;
  $ids .= $data[$i]->id."~";
  $points .= $data[$i]->points."~";
  echo '<div class="question">';
  echo '<p>'.$j.'.) '.$data[$i]->question.'</p>';
  echo '</div>';
  echo '<p><b>Points:</b> '.$data[$i]->points.'</p>';
  echo '<textarea onkeydown="tab(this, event)" id="answer'.$data[$i]->id.'" name="answer'.$data[$i]->id.'" form="exam" rows="16" cols="100"></textarea>';
  echo '<br /><br />';
}
curl_close($ch);
echo '<input type="submit" value="Submit Answers"/>';
echo '<input type="text" value="'.$ids.'" style="visibility:hidden;" id="questions" name="questionids"/>';
echo '<input type="text" value="'.$student.'" style="visibility:hidden;" id="studentname" name="studentname"/>';
echo '<input type="text" value="'.$examname.'" style="visibility:hidden;" id="examname" name="examname"/>';
echo '<input type="text" value="'.$points.'" style="visibility:hidden;" id="points" name="points"/>';
?>
</form>
</body>
</html>