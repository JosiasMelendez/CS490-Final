<html>
<head>
  <title>Create a Test</title>
  <meta charset="utf-8"/>
  <link rel="stylesheet" href="test_maker_style.css">
  <script type="text/JavaScript" src="question.js"></script>
</head>
<body>
<div class="split right" id="bank">
Search by keyword: <input type="text" name="keyword" id="keyword" onfocusout="search()"/>
Topic: <select name="topicsearch" id="topicsearch" onchange="search()">
  <option value="None">None</option>
  <option value="Strings">Strings</option>
  <option value="Math">Math</option>
  <option value="Loops">Loops</option>
  <option value="Recursion">Recursion</option>
</select>
Difficulty: <select id="difficulty" name="difficulty" onchange="search()">
    <option value="None">None</option>
    <option value="Easy">Easy</option>
    <option value="Medium">Medium</option>
    <option value="Hard">Hard</option>
</select>     
  <?php
  if (!empty($_POST)) {
    $teacher = $_POST['teacher'];
  }
  else {
    print("Must log in before viewing this page");
    exit();
  }
  $url = "https://web.njit.edu/~jm844/getQuestions.php";
  #$url = "https://web.njit.edu/~jjm72/CS490_beta/big_test3.php";
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
  $ids = "";
  for ($i = 0; $i < sizeof($data); $i++) {
    $diff = $data[$i]->difficulty;
    if ($diff >= 3) {
      $diff = "Hard";
    }
    else if ($diff <= 1) {
      $diff = "Easy";
    }
    else if ($diff == 2) {
      $diff = "Medium";
    }
    $ids .= $data[$i]->qID."~";
    echo '<div id="box'.$data[$i]->qID.'">';
    echo '<p class="questionbank2" id="question'.$data[$i]->qID.'">';
    echo $data[$i]->question;
    echo '<br />';
    echo '<b>Topic</b>: '.$data[$i]->topic.'&nbsp&nbsp&nbsp&nbsp<b>Difficulty</b>: '.$diff;
    echo '</p>';
    echo '<p class="questionbank1"> <input type="button" id="addbutton'.$data[$i]->qID.'"class="questionbank1" onclick="addQuestion(\'question'.$data[$i]->qID.'\')" value="Add"/></p>';
    echo '<br /><br /><br /><br /><br /><br /><br /><br />';
    echo '</div>';
  }
  echo '<input type="hidden" value="'.$ids.'" id="questions" name="questionids"/>';
  curl_close($ch);
  ?>
  <br />
</div>
<div class="split left" id="questionshere">
<form method="post" action="questions_send.php" id="examForm">
    Exam Name: <input type="text" id="examname" name="examname"/>
    <input type="button" value="Submit Exam" onclick="finalCheck()"/>
    Total points: <input type="text" value="0" size="2" id="totalpoints" name="totalpoints" readonly/>
    <input type="text" value="" style="visibility:hidden;" id="questionnames" name="questionnames"/>
    <input type="text" value="" style="visibility:hidden;" id="scoreids" name="scoreids"/>
    <input type="hidden" value="<?php echo $teacher ?>" name="teacher"/>
</form>
<p id="message"></p>
</div>
</body>
</html>
  
  
  