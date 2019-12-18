<html>
<head>
  <title>Check Submitted Exams</title>
  <meta charset="utf-8"/>
  <link rel="stylesheet" href="confirmation_style.css">
</head>
<body>
<div class="end">
<?php
$url = "https://web.njit.edu/~jm844/updateGrades.php";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
if (!empty($_POST)) {
  $studentID = $_POST['studentname'];
  $examname = $_POST['examname'];
  $questionids = $_POST['questionids'];
  $teacher = $_POST['teacher'];
}
$questionid = substr($questionids, 0, -1);
$qIDs = explode("~", $questionid);
for ($i = 0; $i < sizeof($qIDs); $i++) {
  $gradekey = "grade".$qIDs[$i];
  $commentkey = "comment".$qIDs[$i];
  $functionkey = "function".$qIDs[$i];
  $colonkey = "colon".$qIDs[$i];
  $loopkey = "loop".$qIDs[$i];
  $printkey = "print".$qIDs[$i];
  $tc0key = "0tc".$qIDs[$i];
  $tc1key = "1tc".$qIDs[$i];
  $tc2key = "2tc".$qIDs[$i];
  $tc3key = "3tc".$qIDs[$i];
  $tc4key = "4tc".$qIDs[$i];
  $tc5key = "5tc".$qIDs[$i];
  $data = array(
    'examname' => $examname,
    'studentID' => $studentID,
    'QID' => $qIDs[$i],
    'Function' => $_POST[$functionkey],
    'Colon' => $_POST[$colonkey],
    'Loop' => $_POST[$loopkey],
    'Printreturn' => $_POST[$printkey],
    'Tc0' => $_POST[$tc0key],
    'Tc1' => $_POST[$tc1key],
    'Tc2' => $_POST[$tc2key],
    'Tc3' => $_POST[$tc3key],
    'Tc4' => $_POST[$tc4key],
    'Tc5' => $_POST[$tc5key],
    'Grade' => $_POST[$gradekey],
    'Comment' => $_POST[$commentkey]
  );
  for ($j = 0; $j < 6; $j++) {
    $tcindex = 'Tc'.$j;
    $tcvalue = $data->$tcindex;
    if ($tcvalue == null) {
      $data->$tcindex = -1;
    }
  }
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);
}
if ($result == "false") {
  print "Curl failed";
  exit();
}
$data = json_decode($result);
if ($result == 'Array{"success":"true"}') {
  echo '<p>Exam review submitted successfully</p>';
  echo '<form action="teacher_page.php" method="post">';
  echo '<input type="submit" value="Go to homepage"/>';
  echo '<input type="hidden" value="'.$teacher.'" name="userName"/>';
  echo '</form>';
}
else {
  echo '<p>Something went wrong. Please try to review exam again.</p>';
  echo '<form action="review_exam2.php" method="post">';
  echo '<input type="submit" value="Go back to exam review page"/>';
  echo '<input type="hidden" value="'.$teacher.'" name="teacher"/>';
  echo '</form>';
}
curl_close($ch);
?>
</div>
</body>
</html>