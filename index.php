<?php
session_start();
include('header.php');
include_once "carsearch_db_conn.php";
header("Content-Type: text/html; charset=utf-8");

if(array_key_exists('logOut', $_POST)) {
    logOut();
}
function logOut() {
    $_SESSION["hasSignedIn"] = false;
    //header("Refresh:1");
}
?>

<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <span class="mdc-top-app-bar__title">車輛搜尋系統</span>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
        </section>
    </div>
</header>

<center>
	<br/>
	<br/>
	<br/>
	<br/>
	<img src="car1-r.png" style="width: 150px">
	<h3 class="brown-text">歡迎來到車輛搜尋系統</h3>
	<form method="post">
		<?php
		if (isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"] == true) {
			echo '<input type="submit" name="logOut"
									class="btn waves-effect waves-light btn-small margin5 gray lighten-3" value="登出" />';
		}
		else{
			echo '<a class="waves-effect waves-light btn-small margin5 gray lighten-3" onclick=location.href="login.php">用戶登入/註冊</a>';
		}
		?>
		<a class="waves-effect waves-light btn-small margin5 gray lighten-3" onclick=location.href="car.php">進入系統</a>
		<?php
		if (isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"] == true && $_SESSION["user_level"] == 's') {
			echo '<a class="waves-effect waves-light btn-small margin5 gray lighten-3" onclick=location.href="userManage.php">管理用戶</a>';
		}
		?>
	</form>
</center>
