<?php
#$url = "https://web.njit.edu/~jjm72/CS490_beta/big_test.php";
$url = "https://web.njit.edu/~jm844/authenticate.php";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
if (!empty($_POST)) {
	$user = $_POST['userName'];
	$pass = $_POST['userPassword'];
}
else {
	print "Post is empty";
	exit();
}
$data = array(
	'userName' => $user,
	'userPassword' => $pass
);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
if ($result == FALSE) {
	print "Curl failed.";
	exit();
}
if (empty($result)) {
 	print "Nothing in response.";
  exit();
}
$data = json_decode($result);
$message = "";
if ($data->db == "true") {
  	$message = "We welcome you!";
}
else {
  	$message = "Who are you?";
}
if ($data->isInstructor == "true") {
  	$message .= "teacher";
}
else if ($data->isInstructor == "false") {
  	$message .= "student";
}
curl_close($ch);
print($message);
exit();
?>