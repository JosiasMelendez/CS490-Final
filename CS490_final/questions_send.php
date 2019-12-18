<html>
<head>
  <title>Exam Sent</title>
  <link rel="stylesheet" href="confirmation_style.css">
</head>
<body>
<div class="end">
<?php
$url = "https://web.njit.edu/~jm844/addExam.php";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
if (!empty($_POST)) {
  $ids = $_POST['questionnames'];
  $scoreids = $_POST['scoreids'];
  $examname = $_POST['examname'];
  $teacher = $_POST['teacher'];
}
else {
  print "POST array is empty";
  exit();
}
$num = strlen($ids);
$questions = substr($scoreids, 0, -1);
$questionsarray = explode("~", $questions);
for ($i = 0; $i < $num; $i++) {
  $idpoints = $questionsarray[$i];
  $idpoint = explode(":", $idpoints);
  $data = array(
    'examname' => $examname,
    'question' => $idpoint[0],
    'points' => $idpoint[1]
  );
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);
}
if ($result == false) {
  print "Curl failed.";
  exit();
}
if (empty($result)) {
 	print "Nothing in response.";
  exit();
}
$data = json_decode($result);
if ($data->success == "true") {
  echo '<p>Exam received successfully</p>';
  echo '<form action="teacher_page.php" method="post">';
  echo '<input type="submit" value="Go to homepage"/>';
  echo '<input type="hidden" value="'.$teacher.'" name="userName"/>';
  echo '</form>';
}
else if ($data->success == "false") {
  echo '<p>Something went wrong. Please try again</p>';
  echo '<form action="test_maker.php" method="post">';
  echo '<input type="submit" value="Go back to exam builder"/>';
  echo '<input type="hidden" value="'.$teacher.'" name="teacher"/>';
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
