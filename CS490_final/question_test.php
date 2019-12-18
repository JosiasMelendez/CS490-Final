<?php
$url = "https://web.njit.edu/~jm844/getQuestions.php";
#$url = "https://web.njit.edu/~jjm72/CS490_beta/big_test4.php";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
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
for ($i = 0; $i < sizeof($data); $i++) {
  echo '<p id="question'.$data[$i]->qID.'id">'.$data[$i]->qID.'</p>';
  echo '<p id="question'.$data[$i]->qID.'">';
  echo $data[$i]->question;
  echo '<br /><br />';
  echo '<b>Topic</b>: '.$data[$i]->topic.'<br /><b>Difficulty</b>: '.$data[$i]->difficulty;
  echo '</p>';
  echo '<p> <input type="button" id="addbutton'.$data[$i]->qID.'" onclick="addQuestion(\'question'.$data[$i]->qID.'\')" value="Add"/></p>';
  echo '<br /><br /><br /><br /><br /><br /><br />';
}
?>