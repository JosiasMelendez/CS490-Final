function add() {
  var value = parseInt(document.getElementById('caseAmount').value, 10);
  var newvalue = value + 1;
  if (newvalue > 6) {
    document.getElementById('caseAmount').value = "6";
  }
  else {
    document.getElementById('caseAmount').value = newvalue.toString();
    var i;
    for (i = 3; i <= newvalue; i++) {
      var divID = 'tc' + i.toString();
      document.getElementById(divID).style.display = "";
    }
  }
}

function subtract() {
  var value = parseInt(document.getElementById('caseAmount').value, 10);
  var newvalue = value - 1;
  if (newvalue < 2) {
    document.getElementById('caseAmount').value = "2";
  }
  else {
    document.getElementById('caseAmount').value = newvalue.toString();
    var i;
    for (i = 6; i > newvalue; i--) {
      var divID = 'tc' + i.toString();
      document.getElementById(divID).style.display = "none";
    }
  }
}

function constraints() {
  var checkbox = document.getElementById("check");
  var select = document.getElementById("constraint");
  if (checkbox.checked == true) {
    select.style.display = "";
  }
  else {
    select.style.display = "none";
  }
}

function search() {
  var keyword = document.getElementById("keyword1").value;
  keyword = keyword.toLowerCase();
  var topic = document.getElementById("topicsearch1").value;
  var difficulty = document.getElementById("difficulty1").value;
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