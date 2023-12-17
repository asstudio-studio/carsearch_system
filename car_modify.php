<?php
session_start();
include('header.php');
include_once "db_conn.php";
header("Content-Type: text/html; charset=utf-8");

	$old_CarID = $_GET['CarID'];

    $query = "select * from car where CarID = ?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($old_CarID));
    $result = $stmt->fetchAll();
	
	
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
	
		//error_reporting(E_ERROR | E_PARSE);
		
		if (array_key_exists('send', $_POST)) {
			if('s'== $_SESSION["user_level"]){
				$manufacturer_name = $_POST["manufacturer_name"];
				$manufacturer_address = $_POST["manufacturer_address"];
				$manufacturer_website = $_POST["manufacturer_website"];
				$manufacturer_phone = $_POST["manufacturer_phone"];
				
				$query_update = "update manufacturer set 
					manufacturer_name=? ,manufacturer_address=?,
					manufacturer_website=?,manufacturer_phone=?
					where manufacturer_name = ? ";
				$stmt_update = $db->prepare($query_update);
				$stmt_update->execute(array($manufacturer_name,$manufacturer_address,
				$manufacturer_website,$manufacturer_phone,$old_manufacturer_name));
				
				echo sprintf('<script>alert("更改成功");</script>');
				echo sprintf('<script type="text/JavaScript"> location.href="manufacturer.php"; </script>');
			}
			else{
				echo sprintf('<script>alert("請先登入為管理者");</script>');
				echo sprintf('<script type="text/JavaScript"> location.href="manufacturer.php"; </script>');
			}
		}	

	}
?>

<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
<?php
		echo sprintf('<button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
			onclick=location.href="manufacturer.php";>arrow_back
            </button>');

?>
            <span class="mdc-top-app-bar__title">修改廠商資訊</span>
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
        <h3 class="inline brown-text"> 修改廠商資訊</h3>
    </div>

    <br/>
    <br/>
	<form method="post">
        <table border='1' style='width:70%'>
            <thead>
                <tr>
                <th>廠商名稱</th>
                <th>廠商地址</th>
				<th>廠商網站</th>
				<th>廠商電話</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    for ($i = 0; $i < count($result); $i++) {
                        echo "<tr>";
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="manufacturer_name" value="%s"/></td>', $result[$i]['manufacturer_name']);
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="manufacturer_address" value="%s"/></td>', $result[$i]['manufacturer_address']);
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="manufacturer_website" value="%s"/></td>', $result[$i]['manufacturer_website']);
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="manufacturer_phone" value="%s"/></td>', $result[$i]['manufacturer_phone']);
						echo '<td><button class="btn-floating btn-large waves-effect waves-light green" type="submit" name="send">
                            <i class="material-icons">check</i>
                            </button></td>';
                        echo "</tr>";
                    }
                ?>
				

            </tbody>
        </table>
	</form>
</center>

<?php
include('footer.php');
?>


