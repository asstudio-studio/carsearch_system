<?php
	include('header.php');
?>
<?php
	include_once "carsearch_db_conn.php";
	session_start();
	if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true){
		if($_SESSION['user_level']=='u'){
			echo '<script>alert("請先登入為管理者!");</script>';
			echo '<script>window.location.href="login.php";</script>';
		}
		//echo 'user_id:'.$_SESSION["user_id"].'</br>';
		//echo 'username:'.$_SESSION["username"].'</br>';
	}else{
		echo '<script>alert("請先登入為管理者!");</script>';
		echo '<script>window.location.href="login.php";</script>';
	}
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		error_reporting(E_ERROR | E_PARSE);
		$CarID = $_POST['CarID'];
		$AreaCode = $_POST['AreaCode'];
		$Brand = $_POST['Brand'];
		$Name = $_POST['Name'];
		$Displacement= $_POST['Displacement'];
		$Price = $_POST['Price'];
		
		$query = "select AreaCode from store where AreaCode = ?";
		$stmt = $db->prepare($query);
		$stmt -> execute(array($AreaCode));
		$result = $stmt -> fetchAll();
		
	
		if (empty($CarID) || empty($AreaCode) || empty($Brand) || empty($Name) || empty($Displacement) || empty($Price)) {
			//$message = "Variable 'username' is empty.";
			echo "<script>alert('警告：有空格沒填東西');</script>";
		}elseif(empty($result)){
			echo '<script>alert("該商店不存在!");</script>';
			echo '<script>window.location.href="caradd.php";</script>';
		} else{
			if(empty($course_status)){
				$course_status = 'off';
			}
	
			$query2 = "insert into car(CarID, Brand, AreaCode  , Name, Displacement, Price) values (?,?,?,?,?,?)";
			//$query2 = "select instructor_id from instructor where instructor_name = ?";
			$stmt2 = $db->prepare($query2);
			try {
				$stmt2 -> execute(array($CarID, $Brand, $AreaCode, $Name, $Displacement, $Price));//, $result[0]['Brand']
				echo '<script>alert("新增成功");</script>';
			}catch (Exception $e) {
				//echo sprintf('<script>alert("已刪除 %s ");</script>',$manufacturer_name);
				//echo sprintf('<script>alert("已刪除%s");</script>', $e);
				echo '<script>alert("沒有這個品牌");</script>';
				echo '<script>window.location.href="caradd.php";</script>';
			}
			
		}
	
		//echo "<script>alert(strval(count($result)))</script>";
	//    echo 'course_id:'.$course_id.'</br>';
	//    echo 'course_status:'.$course_status.'</br>';
	//    echo 'course_name:'.$course_name.'</br>';
	//    echo 'semester:'.$semester.'</br>';
	//    echo 'instructor_name:'.$instructor_name.'</br>';
	//    echo 'department_name:'.$department_name.'</br>';
	//    echo 'course_time:'.$course_time.'</br>';
	//    echo 'course_location:'.$course_location.'</br>';
	//    echo 'instructor_id:'.$result[0]['instructor_id'].'</br>';
	
		
		
	
		
	}
?>


<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                    onclick=location.href="car.php">arrow_back
            </button>
            <span class="mdc-top-app-bar__title">新增車輛</span>
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

            <div class="input-field col s6">
                <input placeholder="輸入車輛編號" id="CarID" type="text" class="validate" name="CarID">
                <label for="CarID">編號</label>
            </div>
            
            <div class="input-field col s12">
                <input placeholder="輸入商店所在地" id="AreaCode" type="text" class="validate" name="AreaCode">
                <label for="AreaCode">商店</label>
            </div>
            
            
           
            
            <div class="row">
                
            </div>

            <div class="input-field col s12">
                <input placeholder="輸入車輛品牌" id="Brand" type="text" name="Brand" class="validate">
                <label for="Brand">品牌名稱</label>
            </div>


            <div class="input-field col s12">
                <input placeholder="輸入車輛名字" id="Name" type="text" name="Name" class="validate">
                <label for="Name">車輛名字</label>
            </div>

            <div class="input-field col s12">
                <input placeholder="輸入車輛排氣量" id="Displacement" name="Displacement" type="text" class="validate">
                <label for="Displacement">排氣量</label>
            </div>
			
			<div class="input-field col s12">
                <input placeholder="輸入車輛價格" id="Price" name="Price" type="text" class="validate">
                <label for="Price">價格</label>
            </div>

            <input class=" btn waves-effect waves-light btn-small margin5" type="submit"  name="submit" value="新增車輛">
           
        </form>
    </div>
    <br><br><br>
</center>



