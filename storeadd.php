<?php
	include('header.php');
	include_once "carsearch_db_conn.php";
	session_start();
	if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true){
		//echo 'user_id:'.$_SESSION["user_id"].'</br>';
		//echo 'username:'.$_SESSION["username"].'</br>';
		if($_SESSION['user_level']=='u'){
			echo '<script>alert("請先登入為管理者!");</script>';
			echo '<script>window.location.href="login.php";</script>';
		}
	}else{
		echo '<script>alert("請先登入為管理者!");</script>';
		echo '<script>window.location.href="login.php";</script>';
	}
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		error_reporting(E_ERROR | E_PARSE);
	
		
		$AreaCode = $_POST['AreaCode'];
		$BusinessHour = $_POST['BusinessHour'];
	
		if (empty($AreaCode) || empty($BusinessHour)) {
			//$message = "Variable 'username' is empty.";
			echo "<script>alert('警告：商店位置不能為空');</script>";
		} else {
			$query = "insert into store values(?,?)";
			// $query = "INSERT INTO user (user_id, username, display_name, password, user_level) VALUES (?, ?, ?, ?)";
			//$query2 = "select instructor_id from instructor where instructor_name = ?";
			$stmt = $db->prepare($query);
			try {
				$stmt->execute(array($AreaCode, $BusinessHour));
				echo '<script>alert("新增成功");</script>';
			} catch (Exception $e) {
				echo '<script>alert("新增出了點問題");</script>';
				echo '<script>window.location.href="storeadd.php";</script>';
			}
	
		}
	}
?>

<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                    onclick=location.href="store.php">arrow_back
            </button>
            <span class="mdc-top-app-bar__title">新增商店</span>
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
    <br/>
    <div class="row">
        <form class="col s6 offset-s3" action="" method="post">

            <div class="input-field col s12">
                <input placeholder="輸入商店位置" id="AreaCode" type="text" class="validate" name="AreaCode">
                <label for="AreaCode">商店位置</label>
            </div>

            <div class="input-field col s12">
                <input placeholder="輸入營業時間" id="BusinessHour" type="text" class="validate" name="BusinessHour">
                <label for="BusinessHour">營業時間</label>
            </div>

            <input class=" btn waves-effect waves-light btn-small margin5 gray lighten-3" type="submit"  name="submit" value="新增商店">

        </form>
    </div>
    <br><br><br>






</center>


