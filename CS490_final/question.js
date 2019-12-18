var previous = [];
var scoreIds = [];
var realTotal = 0;

function addQuestion(question_id) {
  var split = question_id.split("n");
  if (document.getElementById("addbutton" + split[1]).value == "Add") {
    var element = document.getElementById(question_id);
    var clone = element.cloneNode(true);
    clone.id = question_id + "h";
    document.getElementById("questionshere").appendChild(clone);
    var p = document.createElement("p");
    p.setAttribute("class", "questionbank1");
    p.setAttribute("id", "score" + split[1] + "h");
    var score = document.createElement("input");
    var scoreId = "score" + split[1];
    score.setAttribute("id", scoreId);
    score.setAttribute("type", "text");
    score.setAttribute("size", "2");
    score.setAttribute("maxlength", "2");
    score.setAttribute("class", "questionbank1");
    score.setAttribute("onfocusout", "totalPoints(this.id);");
    p.appendChild(score);
    document.getElementById("questionshere").appendChild(p);
    var p2 = document.createElement("div");
    p2.setAttribute("id", "linebreak" + split[1]);
    for (var i = 0; i < 9; i++) {
      var linebreak = document.createElement("br");
      p2.appendChild(linebreak);
    }
    document.getElementById("questionshere").appendChild(p2);
    document.getElementById("questionnames").value += split[1];
    document.getElementById("addbutton" + split[1]).value = "Remove";
    return;
  }
  if (document.getElementById("addbutton" + split[1]).value == "Remove") {
    var score = document.getElementById("score" + split[1]);
    var total = document.getElementById("totalpoints");
    if (realTotal != 0 && score.value != 0 && score.value != "") {
      var scoreInt = parseInt(score.value, 10);
      realTotal -= scoreInt;
      total.value = realTotal;
      previous["score" + split[1]] = 0;
    }
    var scoreId = "score" + split[1];
    if (scoreIds.length != 0) {
      var index = scoreIds.indexOf(scoreId);
      if (index != -1 ) {
        scoreIds.splice(index, 1);
      }
    }
    var element = document.getElementById("score" + split[1] + "h");
    element.remove();
    element = document.getElementById(question_id + "h");
    element.remove();
    element = document.getElementById("linebreak" + split[1]);
    element.remove();
    var questions = document.getElementById("questionnames").value;
    var newquestions = questions.replace(split[1], "");
    document.getElementById("questionnames").value = newquestions;
    document.getElementById("addbutton" + split[1]).value = "Add";
    return;
  }
}

function totalPoints(scoreId) {
  var total = document.getElementById("totalpoints");
  var score = document.getElementById(scoreId);
  if (!scoreIds.includes(scoreId)) {
    scoreIds.push(scoreId);
  }
  if (typeof previous[scoreId] !== 'undefined') {
    if (realTotal != 0) {
      realTotal -= previous[scoreId];
      total.value = realTotal;
    }
  }
  if (isNaN(score.value) == false && score.value != "") {
    var scoreInt = parseInt(score.value, 10);
    realTotal += scoreInt;
    if (realTotal <= 100) {
      total.value = realTotal;
      document.getElementById("message").innerHTML = "";
    }
    else if (realTotal >= 100) {
      total.value = 100;
      document.getElementById("message").innerHTML = "Total score cannot be over 100";
    }
    previous[scoreId] = scoreInt;
  }
  else {
    if (score.value == "") {
      previous[scoreId] = 0;
    }
    return;
  }
}

function search() {
  var keyword = document.getElementById("keyword").value;
  keyword = keyword.toLowerCase();
  var topic = document.getElementById("topicsearch").value;
  var difficulty = document.getElementById("difficulty").value;
  var stringIds = document.getElementById("questions");
  var stringids1 = stringIds.value.slice(0, stringIds.value.length - 1);
  var ids = stringids1.split("~");
  for (i = 0; i < ids.length; i++) {
    var whole = document.getElementById("box" + ids[i]);
    whole.style.display = "";
  }
  for (i = 0; i < ids.length; i++) {
    var question = document.getElementById("question" + ids[i]);
    var questiontext = question.textContent;
    var qtextarray = questiontext.split("Topic:");
    var qtext = qtextarray[0];
    var s = qtext.search(keyword);
    if (s == -1) {
      var upperkeyword = keyword[0].toUpperCase() + keyword.slice(1);
      var s2 = qtext.search(upperkeyword);
      if (s2 == -1) {
        var whole = document.getElementById("box" + ids[i]);
        whole.style.display = "none";
      }
    }
    var qtextarray2 = qtextarray[1].split("Difficulty:");
    var qtexttopic = qtextarray2[0];
    var qtextdiff = qtextarray2[1];
    var s2 = qtexttopic.search(topic);
    if (s2 == -1 && topic != "None") {
      var whole = document.getElementById("box" + ids[i]);
      whole.style.display = "none";
    }
    var s3 = qtextdiff.search(difficulty);
    if (s3 == -1 && difficulty != "None") {
      var whole = document.getElementById("box" + ids[i]);
      whole.style.display = "none";
    }
  }
}

function finalCheck() {
  var questions = document.getElementById("questionnames");
  var name = document.getElementById("examname").value;
  if (questions.value == "") {
    document.getElementById("message").innerHTML = "No questions have been selected";
  }
  else if (realTotal > 100) {
    document.getElementById("message").innerHTML = "Total score cannot be over 100";
  }
  else if (realTotal == 0) {
    document.getElementById("message").innerHTML = "Exam must have a score";
  }
  else if (name == "") {
    document.getElementById("message").innerHTML = "Please give a name to the exam";
  }
  else {
    var scoreidvalue = "";
    for (var i = 0; i < scoreIds.length; i++) {
      var scoreId = scoreIds[i];
      var scorevalue = previous[scoreId];
      var scoresplit = scoreId.split("e");
      scoreidvalue += (scoresplit[1] + ":" + scorevalue + "~");
    }
    document.getElementById("scoreids").value = scoreidvalue;
    document.getElementById("message").innerHTML = "";
    document.getElementById("examForm").submit();
    document.getElementById("examForm").reset();
  }
}