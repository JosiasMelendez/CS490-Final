<html>
<head>
  <title>Check Exam Results</title>
  <link rel="stylesheet" href="exam_take_style.css">
  <meta charset="utf-8"/>
</head>
<body>
<?php
$url = "https://web.njit.edu/~jm844/getGrades.php";
#$url = "https://web.njit.edu/~jjm72/CS490_beta/big_test5.php";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
if (!empty($_POST)) {
  $studentid = $_POST['studentid1'];
  $examname = $_POST['examname'];
}
$data = array(
  'studentID' => $studentid,
  'examname' => $examname
);
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
echo '<div class="toppart"/>';
echo '<h3>'.$examname.' Results</h3>';
echo '</div>';
$totalpoints = 0;
$totalscore = 0;
for ($i = 0; $i < sizeof($data); $i++) {
  $j = $i + 1;
  $totalpoints += $data[$i]->Grade;
  $totalscore += $data[$i]->PointsPossible;
  $qid = $data[$i]->QID;
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
  echo '<textarea id="ranswer'.$i.'" name="ranswer'.$i.'" rows="10" cols="50" readonly>'.$data[$i]->Answer.'</textarea>';
  echo '<br /><br />';
  echo '<div class="comment">';
  echo '<p>Comments:</p><textarea id="comment'.$i.'" name="comment'.$i.'" rows="10" cols="50" readonly>'.$data[$i]->Comment.'</textarea>';
  echo '</div>';
  echo '</div>';
  echo '<br /><br />';
  echo '<div class="table">';
  echo '<table border="1"><tr><th>Question '.$j.'</th><th>Points Received</th><th>Points Possible</th>';
  for ($j = 0; $j < 6; $j++) {
    $k = $j + 1;
    $tcindex = "Tc".$j;
    $tc = $data[$i]->$tcindex;
    if ($tc === "null" or $tc === -1) {
      continue;
    }
    if (round($tc, 2) == round($data[$i]->TcPts, 2)) {
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
    echo '<td>'.$tc.'</td>';
    echo '<td>'.$data[$i]->TcPts.'</td></tr>';
  }
  if ($data[$i]->Function < $data[$i]->PunctionPoints) {
    echo '<tr><td>Function</td>';
    $function = $data[$i]->Function;
    echo '<td>'.$function.'</td>';
    echo '<td>'.$data[$i]->PunctionPoints.'</td></tr>';
  }
  if ($data[$i]->Colon < $data[$i]->ColonPts) {
    echo '<tr><td>Colon</td>';
    $colon = $data[$i]->Colon;
    echo '<td>'.$colon.'</td>';
    echo '<td>'.$data[$i]->ColonPts.'</td></tr>';
  }
  $loopconstraint = $data[$i]->Loop;
  if ($data[$i]->LoopPts != 0) {
    echo '<tr><td>Loop Constraint</td>';
    echo '<td>'.$loopconstraint.'</td>';
    echo '<td>'.$data[$i]->LoopPts.'</td></tr>';
  }
  $printreturn = $data[$i]->Printreturn;
  if ($data[$i]->printreturnPts != 0) {
    echo '<tr><td>Print/Return Constraint</td>';
    echo '<td>'.$printreturn.'</td>';
    echo '<td>'.$data[$i]->PrintreturnPts.'</td></tr>';
  }
  echo '<tr><td>Total Grade</td>';
  $grade = $data[$i]->Grade;
  echo '<td>'.$grade.'</td>';
  echo '<td>'.$data[$i]->PointsPossible.'</td></tr>';
  echo '</table>';
  echo '</br></br>';
  echo '</div>';
}
echo '<p><b>Final Score:</b> '.$totalpoints.' / '.$totalscore;
?>
<form action="see_results.php" method="post" id="studentForm2">
  <input type="submit" value="Done"/>
  <input type="hidden" value="<?php echo $studentid ?>" name="studentid1"/>
</form>
</body>
</html>
