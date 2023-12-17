<?php
    header("Content-Type: text/html; charset=utf-8");
    include('header.php');
    include_once "carsearch_db_conn.php";
    session_start();
    $edit_mode = true;
    if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true){
        //echo 'user_id:'.$_SESSION["user_id"].'</br>';
        //echo 'username:'.$_SESSION["username"].'</br>';
    }
    $old_CarID = $_GET['CarID'];
	
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        error_reporting(E_ERROR | E_PARSE);
        if (array_key_exists('edit', $_POST)) {
            $edit_mode = true;
        }
        elseif (array_key_exists('view', $_POST)) {
            //$CarID = $_POST['CarID'];
            $AreaCode = $_POST['AreaCode'];
			$Brand = $_POST['Brand'];
			$Name = $_POST['Name'];
			$Displacement= $_POST['Displacement'];
			$Price = $_POST['Price'];
            if( empty($AreaCode) or empty($Brand) or empty($Name) or empty($Displacement) or empty($Price)){
                echo sprintf('<script>alert("警告：有空格沒填東西");location.href="update1.php?CarID=%s"</script>',$old_CarID);
            }
            else{
                $query = "select * from carbrand where Brand = ? ";
                $brand_check = $db->prepare($query);
                $brand_check->execute(array($Brand));
                $brand_result = $brand_check->fetchAll();
                if($brand_check->rowCount() == 0){
                    echo sprintf('<script>alert("警告：請輸入有效的教師姓名與教師所屬學系");location.href="update.php?CarID=%s"</script>',$old_CarID);
                }
                else{
                    $query_update = "update car set 
					CarID=? ,AreaCode=?,
					Brand=?,Name=?,Displacement=?,Price=?
					where CarID = ? ";
				$stmt_update = $db->prepare($query_update);
				$stmt_update->execute(array($old_CarID,$AreaCode,$Brand,$Name,$Displacement,$Price,$old_CarID));
				
				echo sprintf('<script>alert("更改成功");</script>');
				echo sprintf('<script type="text/JavaScript"> location.href="car.php"; </script>');
                }
            }
        }
       
    }
    
	
	$query = ("select *
						from car natural join carbrand
						where car.CarID = ? ");
                    $stmt = $db->prepare($query);
                    $stmt->execute(array($old_CarID));
                    $result = $stmt->fetchAll();
?>
<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                    onclick="location.href='car.php';">arrow_back
					
            </button>
            <?php
                echo '<span class="mdc-top-app-bar__title">'.$result[0]['Name'].'</span>';
            ?>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
        </section>
    </div>
</header>

<center>
    <br/>
    <br/>
    <br/>
    <h3 class="change-color-to-gray">車輛資訊</h3>
    <form method="post">
        <table border='1' style='width:70%' >
            <tr>
                <th>車輛編號</th>
                <th>車輛品牌</th>
                <th>販賣商店</th>
                <th>車輛名稱</th>
                <th>排氣量</th>
                <th>價錢</th>
            </tr>
            <?php
                for ($i = 0; $i < count($result); $i++) {
                    echo "<tr>";
                    if($edit_mode == true){
                        echo "<td>" . $result[$i]['CarID'] . "</td>";
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="Brand" value="%s"/></td>', $result[$i]['Brand']);
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="AreaCode" value="%s"/></td>', $result[$i]['AreaCode']);
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="Name" value="%s"/></td>', $result[$i]['Name']);
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="Displacement" value="%s"/></td>', $result[$i]['Displacement']);
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="Price" value="%s"/></td>', $result[$i]['Price']);
                    }
                    else{
                        echo "<td>" . $result[$i]['CarID'] . "</td>";
                        echo "<td>" . $result[$i]['Brand'] . "</td>";
                        echo "<td>" . $result[$i]['AreaCode'] . "</td>";
                        echo "<td>" . $result[$i]['Name'] . "</td>";
                        echo "<td>" . $result[$i]['Displacement'] . "</td>";
						echo "<td>" . $result[$i]['Price'] . "</td>";
                    }
                    echo "</tr>";
                }
            ?>
       
            </tbody>
        </table>
        <?php
        if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true) {
            if ($_SESSION["user_level"] == 's' ) {
                if($edit_mode == false){
                    echo '<div class="fixed-action-btn">
                  <button class="btn-floating btn-large waves-effect waves-light red" type="submit" name="edit">
                  <i class="material-icons">mode_edit</i>
                  </button>
                  </div>';
                }
                else{
                    echo '<div class="fixed-action-btn">
                  <button class="btn-floating btn-large waves-effect waves-light green" type="submit" name="view">
                  <i class="material-icons">check</i>
                  </button>
                  </div>';
                }
            }
        }
        ?>
    </form>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</center>

<?php
include('footer.php');
?>


