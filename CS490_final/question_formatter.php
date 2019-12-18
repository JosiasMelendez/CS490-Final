<html>
<head>
  <title>Question Confirmation</title>
  <link rel="stylesheet" href="confirmation_style.css">
</head>
<body>
<div class="end">
<?php
$url = "https://web.njit.edu/~jm844/addQuestion.php";
#$url = "https://web.njit.edu/~jjm72/CS490_beta/big_test2.php";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
if (!empty($_POST)) {
  $check = $_POST['check'];
  $constraint = $_POST['constraint'];
  $constraint1 = $_POST['constraint1'];
  $teacher = $_POST['userName'];
	$function = $_POST['function'];
	$question = $_POST['question'];
  $topic = $_POST['topic'];
  $difficulty = $_POST['difficulty'];
  $tc0 = $_POST['testcase0'];
  $tc0out = $_POST['testcase0out'];
  $tc1 = $_POST['testcase1'];
  $tc1out = $_POST['testcase1out'];
  $tc2 = $_POST['testcase2'];
  $tc2out = $_POST['testcase2out'];
  $tc3 = $_POST['testcase3'];
  $tc3out = $_POST['testcase3out'];
  $tc4 = $_POST['testcase4'];
  $tc4out = $_POST['testcase4out'];
  $tc5 = $_POST['testcase5'];
  $tc5out = $_POST['testcase5out'];
}
else {
  print "Array is empty";
  exit();
}
if ($tc0 == null || $tc0out == null) {
  $testcase0 = "null";
}
else {
  $testcase0 = $tc0."~".$tc0out;
}
if ($tc1 == null || $tc1out == null) {
  $testcase1 = "null";
}
else {
  $testcase1 = $tc1."~".$tc1out;
}
if ($tc2 == null || $tc2out == null) {
  $testcase2 = "null";
}
else {
  $testcase2 = $tc2."~".$tc2out;
}
if ($tc3 == null || $tc3out == null) {
  $testcase3 = "null";
}
else {
  $testcase3 = $tc3."~".$tc3out;
}
if ($tc4 == null || $tc4out == null) {
  $testcase4 = "null";
}
else {
  $testcase4 = $tc4."~".$tc4out;
}
if ($tc5 == null || $tc5out == null) {
  $testcase5 = "null";
}
else {
  $testcase5 = $tc5."~".$tc5out;
}

if ($difficulty == "easy") {
  $difficulty = 1;
}
else if ($difficulty == "medium") {
  $difficulty = 2;
}
else if ($difficulty == "hard") {
  $difficulty = 3;
}

if ($check != "on") {
  $constraint = "null";
}
$data = array(
  'printreturn' => $constraint1,
  'loop' => $constraint,
  'question' => $question,
  'function' => $function,
  'topic' => $topic,
  'difficulty' => $difficulty,
  'testcase0' => $testcase0,
  'testcase1' => $testcase1,
  'testcase2' => $testcase2,
  'testcase3' => $testcase3,
  'testcase4' => $testcase4,
  'testcase5' => $testcase5
);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
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
  echo '<p>Question received successfully</p>';
  echo '<form action="teacher_page.php" method="post">';
  echo '<input type="submit" value="Go to homepage"/>';
  echo '<input type="hidden" value="'.$teacher.'" name="userName"/>';
  echo '</form>';
}
else if ($data->success == "false") {
  echo '<p>Something went wrong. Please try again</p>';
  echo '<form action="question_maker.php" method="post">';
  echo '<input type="submit" value="Go back to question builder"/>';
  echo '<input type="hidden" value="'.$teacher.'" name="userName"/>';
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