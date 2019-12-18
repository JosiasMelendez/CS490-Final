<html>
<head>
  <title>Check Submitted Exams</title>
  <meta charset="utf-8"/>
  <link rel="stylesheet" href="review_style.css">
</head>
<body>
<h1>Find submitted exam</h1>
<?php
if (!empty($_POST)) {
  $teacher = $_POST['teacher'];
}
else {
  print("Must log in before viewing this page");
  exit();
}
$url = "https://web.njit.edu/~jm844/getStudentIDs.php";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
if ($result == false) {
  print "Curl failed.";
  exit();
}
$data = json_decode($result);
echo '<form action="review_exam2.php" method="post" id="examstudent" name="examstudent">';
$url = "https://web.njit.edu/~jm844/getAvailableExams.php";
for ($i = 0; $i < sizeof($data); $i++) {
  echo '<div class="tests">';
  echo '<h3>'.$data[$i].'</h3>';
  $data2 = array(
    'studentID' => $data[$i]
  );
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data2);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);
  if ($result == false) {
    print "Curl failed.";
    exit();
  }
  $data2 = json_decode($result);
  if (sizeof($data2->hasTaken) == 0) {
    echo "No submitted tests available from this student";
  }
  else {
    echo "Exams available from";
    echo '<br />'; 
    echo "this student for review:";
    echo '<br /><br />';
  }
  for ($j = 0; $j < sizeof($data2->hasTaken); $j++) {
    echo '<button name="examstudentname" type="submit" value="'.$data2->hasTaken[$j].'~'.$data[$i].'">'.$data2->hasTaken[$j].'</button>';
    echo '<br /><br />';
  }
  echo '</div>';
}
?>
<input type="hidden" value="<?php echo $teacher ?>" id="teacherid" name="teacherid"/>
</form>
</body>
</html>