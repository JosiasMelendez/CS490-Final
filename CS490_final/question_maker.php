<html>
<head>
  <title>Make A Question</title>
  <meta charset="utf-8"/>
  <link rel="stylesheet" href="question_style.css">
  <script type="text/JavaScript" src="test_cases.js"></script>
</head>
<body>
<?php
if (!empty($_POST)) {
  $teacher = $_POST['teacher'];
}
else {
  print("Must log in before viewing this page");
  exit();
}
?>
<div class="split left" id="qform">
<form action="question_formatter.php" method="post" id="questionForm">
  <h3>Enter question here</h3>
  <textarea name="question" id="question" form="questionForm" rows="8" cols="50"></textarea>
  <br /><br />
  Function Name: <input type="text" name="function" id="function"/>
  <br /><br />
  Select Topic: 
  <select form="questionForm" name="topic" id="topic">
    <option value="Strings">Strings</option>
    <option value="Math">Math</option>
    <option value="Loops">Loops</option>
    <option value="Recursion">Recursion</option>
  </select>
  <br /><br />
  Constraint:
  <select form="questionForm" id="constraint1" name="constraint1">
    <option value="print">Print</option>
    <option value="return">Return</option>
  </select>
  <br /><br />
  For/While Constraint: <input type="checkbox" id="check" name="check" onclick="constraints()"/>
  <select form="questionForm" id="constraint" name="constraint" style="display:none;">
    <option value="for">For</option>
    <option value="while">While</option>
  </select>  
  <br /><br />
  Select Difficulty:
  <select form="questionForm" id="difficulty" name="difficulty">
    <option value="easy">Easy</option>
    <option value="medium">Medium</option>
    <option value="hard">Hard</option>
  </select>
  <br /><br />
  <b>Note:</b> When entering a string as an input, 
  <br />make sure it is contained within two quotation marks ("").
  <br />Strings in output do not need quotation marks.
  <br /><br />
  Test Cases (2 - 6) :
    <input type="button" onclick="subtract()" value="-"/>
    <input type="text" id="caseAmount" size="1" value="2" readonly/>
    <input type="button" onclick="add()" value="+"/>
    <br /><br />
    Test Case 1 <br/>
    Input: <input type="text" name="testcase0" id="testcase0"/> 
    Output: <input type="text" name="testcase0out" id="testcase0out"/> 
    <br />
    Test Case 2 <br />
    Input: <input type="text" name="testcase1" id="testcase1"/>
    Output: <input type="text" name="testcase1out" id="testcase1out"/> 
    <br />
    <div id="tc3" style="display:none;">
    Test Case 3 <br />
    Input:<input type="text" name="testcase2" id="testcase2"/>
    Output: <input type="text" name="testcase2out" id="testcase2out"/>
    <br />
    </div>
    <div id="tc4" style="display:none;">
    Test Case 4 <br />
    Input: <input type="text" name="testcase3" id="testcase3"/>
    Output: <input type="text" name="testcase3out" id="testcase3out"/>
    <br />
    </div>
    <div id="tc5" style="display:none;">
    Test Case 5 <br />
    Input: <input type="text" name="testcase4" id="testcase4"/>
    Output: <input type="text" name="testcase4out" id="testcase4out"/>
    <br />
    </div>
    <div id="tc6" style="display:none;">
    Test Case 6 <br />
    Input: <input type="text" name="testcase5" id="testcase5"/>
    Output: <input type="text" name="testcase5out" id="testcase5out"/>
    </div>
  <br />
  <input type="submit" value="Submit" name="Submit"/>
  <input type="hidden" value="<?php echo $teacher ?>" name="userName"/>
</form>
</div>
<div class="split right" id="bank">
Search by keyword: <input type="text" name="keyword1" id="keyword1" onfocusout="search()"/>
Topic: <select name="topicsearch1" id="topicsearch1" onchange="search()">
  <option value="None">None</option>
  <option value="Strings">Strings</option>
  <option value="Math">Math</option>
  <option value="Loops">Loops</option>
  <option value="Recursion">Recursion</option>
</select>
Difficulty: <select id="difficulty1" name="difficulty1" onchange="search()">
    <option value="None">None</option>
    <option value="Easy">Easy</option>
    <option value="Medium">Medium</option>
    <option value="Hard">Hard</option>
</select>
<br />
<p id="message"></p>     
<?php
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
    echo '<br /><br /><br /><br /><br /><br /><br /><br />';
    echo '</div>';
  }
  echo '<input type="hidden" value="'.$ids.'" id="questions" name="questionids"/>';
  curl_close($ch);
?>
<br />
</body>
</html>