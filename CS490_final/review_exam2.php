<html>
<head>
  <title>Check Submitted Exams</title>
  <meta charset="utf-8"/>
  <script type="text/Javascript" src="review.js"></script>
  <link rel="stylesheet" href="test_review_style.css">
</head>
<body>
<form action="review_exam3.php" method="post" id="review" name="review">
<p id="message"></p>
<?php
$url = "https://web.njit.edu/~jm844/getGrades.php";
#$url = "https://web.njit.edu/~jjm72/CS490_beta/big_test5.php";
$ch = curl_init($url);
if (!empty($_POST)) {
  $examstudent = $_POST['examstudentname'];
  $teacher = $_POST['teacherid'];
}
else {
  print "Invalid access";
  exit();
}
$examstudentarr = explode("~", $examstudent);
$data = array(
  'studentID' => $examstudentarr[1],
  'examname' => $examstudentarr[0]
);
$examname = $examstudentarr[0];
$studentid = $examstudentarr[1];
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
$url = "https://web.njit.edu/~jm844/getQuestions.php";
#$url = "https://web.njit.edu/~jjm72/CS490_beta/big_test3.php";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result2 = curl_exec($ch);
$data2 = json_decode($result2);
$ids = "";
echo '<div class="toppart"/>';
echo '<h3>Exam Name: '.$examname.'</h3>';
echo '<h3>Student ID: '.$studentid.'</h3>';
echo '</div>';
for ($i = 0; $i < sizeof($data); $i++) {
  $j = $i + 1;
  $ids .= $data[$i]->QID."~";
  $qid = $data[$i]->QID;
  $qindex = 0;
  for ($index = 0; $index < sizeof($data2); $index++) {
    if ($data2[$index]->qID == $qid) {
      $qindex = $index;
      break;
    }
  }
  echo '<div class="questionanswer">';
  echo '<div class="question">';
  echo '<p>'.$j.'.) '.$data[$i]->question.'</p>';
  echo '</div>';
  echo '<p>Answer:</p> <textarea id="ranswer'.$qid.'" name="ranswer'.$qid.'" form="review" rows="10" cols="50" readonly>'.$data[$i]->Answer.'</textarea>';
  echo '<div class="comment">';
  echo '<p>Comment:</p> <textarea id="comment'.$qid.'" name="comment'.$qid.'" form="review" rows="10" cols="50">'.$data[$i]->Comment.'</textarea>';
  echo '</div>';
  echo '<br /><br /><br />';
  echo '</div>';
  echo '<div class="table">';
  echo '<table border="1"><tr><th>Question '.$j.'</th><th>Points Received</th><th>Points Possible</th>';
  for ($j = 0; $j < 6; $j++) {
    $k = $j + 1;
    $tcindex = "Tc".$j;
    $tc = $data[$i]->$tcindex;
    if ($tc === "null" or $tc == -1) {
      continue;
    }
    $testcaseindex = "testcase".$j;
    $testcase = $data2[$qindex]->$testcaseindex;
    if ($testcase === "null") {
      continue;
    }
    echo '<tr><td>Test Case '.$k."\n";
    $testcaseparts = explode("~", $testcase);
    echo '<p>Input: '.$testcaseparts[0]."\n</p>";
    echo '<p>Output: '.$testcaseparts[1]."</p></td>";
    echo '<td><input type="text" value="'.$tc.'" size="3" id="'.$j.'tc'.$qid.'" name="'.$j.'tc'.$qid.'" onfocusout="totalPoints(\''.$j.'tc'.$qid.'\');"/></td>';
    echo '<td>'.round($data[$i]->TcPts, 4).'</td></tr>';
  }
  echo '<tr><td>Function</td>';
  $function = $data[$i]->Function;
  echo '<td><input type="text" value="'.$function.'" size="2" id="function'.$qid.'" name="function'.$qid.'" onfocusout="totalPoints(\'function'.$qid.'\');"/></td>';
  echo '<td>'.$data[$i]->PunctionPoints.'</td></tr>';
  echo '<tr><td>Colon</td>';
  $colon = $data[$i]->Colon;
  echo '<td><input type="text" value="'.$colon.'" size="2" id="colon'.$qid.'" name="colon'.$qid.'" onfocusout="totalPoints(\'colon'.$qid.'\');"/></td>';
  echo '<td>'.$data[$i]->ColonPts.'</td></tr>';
  $loopconstraint = $data[$i]->Loop;
  if ($data[$i]->LoopPts != 0) {
    echo '<tr><td>Loop Constraint</td>';
    echo '<td><input type="text" value="'.$loopconstraint.'" size="2" id="loop'.$qid.'" name="loop'.$qid.'" onfocusout="totalPoints(\'loop'.$qid.'\');"/></td>';
    echo '<td>'.$data[$i]->LoopPts.'</td></tr>';
  }
  else {
    echo '<tr><td>Loop Constraint</td>';
    echo '<td><input type="text" value="0" size="2" id="loop'.$qid.'" name="loop'.$qid.'" onfocusout="totalPoints(\'loop'.$qid.'\');"/></td>';
    echo '<td>'.$data[$i]->LoopPts.'</td></tr>';
  }
  $printreturn = $data[$i]->Printreturn;
  if ($data[$i]->PrintreturnPts != 0) {
    echo '<tr><td>Print/Return Constraint</td>';
    echo '<td><input type="text" value="'.$printreturn.'" size="2" id="print'.$qid.'" name="print'.$qid.'" onfocusout="totalPoints(\'print'.$qid.'\');"/></td>';
    echo '<td>'.$data[$i]->PrintreturnPts.'</td></tr>';
  }
  else {
    echo '<tr><td>Print/Return Constraint</td>';
    echo '<td><input type="text" value="0" size="2" id="print'.$qid.'" name="print'.$qid.'" onfocusout="totalPoints(\'print'.$qid.'\');"/></td>';
    echo '<td>'.$data[$i]->PrintreturnPts.'</td></tr>';
  }
  echo '<tr><td>Total Grade</td>';
  $grade = $data[$i]->Grade;
  echo '<td><input type="text" value="'.$grade.'" size="2" id="grade'.$qid.'" name="grade'.$qid.'" readonly/></td>';
  echo '<td>'.$data[$i]->PointsPossible.'</td></tr>';
  echo '</table>';
  echo '</div>';
  echo '<br /><br /><br /><br /><br /><br /><br /><br />';
}
echo '<br /><br /><input type="submit" value="Submit Reviewed Exam"/>';
echo '<input type="text" value="'.$ids.'" style="visibility:hidden;" id="questions" name="questionids"/>';
echo '<input type="text" value="'.$studentid.'" style="visibility:hidden;" id="studentname" name="studentname"/>';
echo '<input type="text" value="'.$examname.'" style="visibility:hidden;" id="examname" name="examname"/>';
echo '<input type="hidden" value="'.$teacher.'" name="teacher"/>';
?>
</form>
</body>
</html>