function totalPoints(scoreId) {  
  var matches = scoreId.match(/(\d+)/g);
  var qid = matches[matches.length - 1];
  var total = 0;
  for (i = 0; i < 6; i++) {
    var tcid = i + "tc" + qid;
    var tc = document.getElementById(tcid);
    if (tc) {
      total += parseFloat(tc.value);
    }
  }
  var functionid = "function" + qid;
  var functioner = document.getElementById(functionid);
  total += parseFloat(functioner.value);
  var colonid = "colon" + qid;
  var colon = document.getElementById(colonid);
  total += parseFloat(colon.value);
  var loopid = "loop" + qid;
  var loop = document.getElementById(loopid);
  if (loop) {
    total += parseFloat(loop.value);
  }
  var printreturnid = "print" + qid;
  var printreturn = document.getElementById(printreturnid);
  total += parseFloat(printreturn.value);
  var totalid = "grade" + qid;
  var pasttotal = document.getElementById(totalid);
  pasttotal.value = Math.round(total * 100) / 100;
}
  