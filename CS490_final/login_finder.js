function changeAction() {
	var myForm = document.getElementById('loginForm');
	var data = new FormData(myForm);
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			var res = this.responseText;
			if (res == "We welcome you!teacher") { 
				document.getElementById('loginForm').action = "teacher_page.php";
				document.getElementById('loginForm').submit();
			}
			else if (res == "We welcome you!student") {
				document.getElementById('loginForm').action = "student_page.php";
				document.getElementById('loginForm').submit();
			}
      else {
        document.getElementById('message').innerHTML = "Username or password incorrect";
      }
		}
	};
	xhr.open("POST", "front_page.php", true);
	xhr.send(data);
}