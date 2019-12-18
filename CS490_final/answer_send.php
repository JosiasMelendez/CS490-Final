<html>
<head>
  <title>Answers Sent</title>
  <link rel="stylesheet" href="confirmation_style.css">
</head>
<body>
<div class="end">
<?php
if (!empty($_POST)) {
  $studentID = $_POST['studentname'];
  $examname = $_POST['examname'];
  $questionids = $_POST['questionids'];
  $points = $_POST['points'];
}
$url = "https://web.njit.edu/~jm844/gradeExam.php";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
$point = substr($points, 0, -1);
$pointsarray = explode("~", $point);
$questionid = substr($questionids, 0, -1);
$qIDs = explode("~", $questionid);
for ($i = 0; $i < sizeof($qIDs); $i++) {
    $answerkey = "answer".$qIDs[$i];
    $data = array(
      'studentID' =>$studentID,
      'examname' => $examname,
      'questionID' => $qIDs[$i],
      'points' => $pointsarray[$i],
      'answer' => $_POST[$answerkey]
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
}
if ($result == false) {
  print "Curl failed.";
  exit();
}
$data = json_decode($result);
if ($data->success == "true") {
  echo '<p>Exam submitted successfully</p>';
  echo '<form action="student_page.php" method="post">';
  echo '<input type="submit" value="Go to homepage"/>';
  echo '<input type="hidden" value="'.$studentID.'" name=studentid"/>';
  echo '</form>';
}
else if ($data->success == "false") {
  echo '<p>Something went wrong. Please try to submit answers again.</p>';
  echo '<form action="take_exam.php" method="post">';
  echo '<input type="submit" value="Go back to exam"/>';
  echo '<input type="hidden" value="'.$studentID.'" name=studentid"/>';
  echo '</form>';
}
else {
  echo "Something else happened and you shouldn't be seeing this";
}
curl_close($ch);
?>
</div>
</body>
</html>
