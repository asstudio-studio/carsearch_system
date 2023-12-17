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
            $CarID = $_POST['CarID'];
            $AreaCode = $_POST['AreaCode'];
			$Brand = $_POST['Brand'];
			$Name = $_POST['Name'];
			$Displacement= $_POST['Displacement'];
			$Price = $_POST['Price'];
            
			
			if(empty($Brand) /* or empty($Brand) */ /* or empty($Name) or empty($AreaCode) or empty($Displacement) or empty($Price) */){
                //echo sprintf('<script>alert("警告：有空格沒填東西");location.href="update.php?CarID=%s"</script>');
				echo '<script>alert("有空格沒填東西");</script>';
				echo '<script>window.location.href="update.php";</script>';
            }
            //else{
              //  $query = "select * from car where CarID = ? and AreaCode = ?";
              //  $check = $db->prepare($query);
              //  $check->execute(array($CarID, $AreaCode));
              //  $result = $check->fetchAll();                            
              //  if($check->rowCount() == 0){
				//	echo '<script>alert("請輸入有效的車款");</script>';
                    //echo sprintf('<script>alert("警告：請輸入有效的車款");location.href="update.php?CarID=%s"</script>');
                //}
                else{
                    $query = "update car set  AreaCode = '$AreaCode', Brand = '$Brand', Name = '$Name', Displacement = '$Displacement', Price = '$Price' where car.CarID = '$CarID' ";
                    $stmt = $db->prepare($query);
					
                    //try{
                      //  $stmt->execute(array($CarID, $AreaCode, $Brand, $Name, $Displacement, $Price));
                      //  $query = "update car set CarID = ? where CarID = ?";
                      //  $stmt = $db->prepare($query);
                      //  $stmt->execute(array($CarID, $old_CarID));
                      //  echo sprintf('<script>location.href="update.php?CarID=%s"</script>',$CarID);
                    //}
                    //catch (Exception $e){
					//	echo '<script>alert("fail");</script>';
                        //echo sprintf('<script>alert("警告：查無此學系名稱\n%s");location.href="update.php?CarID=%s"</script>',$e->getMessage());
                    //}

                }
            //}
        }
        elseif (array_key_exists('send', $_POST)) {
            $updateID = $_POST['updateID'];
            //$impression = $_POST['impression'];
            if(empty($updateID)){
               echo '<script>alert("警告：ID不可為空");</script>';
            }
            else{
                $query = "insert into car values(?,?,?,?,?,?)";
                $stmt = $db->prepare($query);
                $stmt->execute(array($CarID, $AreaCode, $Brand, $Name, $Price));
            }
        }
        //else{
          //  $user_id = array_keys($_POST);
         //   $query = "delete from rating where user_id = ? and course_id = ?";
          //  $stmt = $db->prepare($query);
           // $stmt->execute(array($user_id[8],$old_course_id));
            //$count = $stmt->rowCount();
            //header("Refresh:0");
          //  echo sprintf('<script type="text/JavaScript"> location.href="courseInfo.php?course_id=%s"; </script>',$old_course_id);
        //}
    }
	//$old_CarID = $_GET['CarID'];

    $query = "select * from car where car.CarID = ? ";
    $stmt = $db->prepare($query);
    $stmt->execute(array($old_CarID));
    $result = $stmt->fetchAll();

    $query = "select * from store where AreaCode = ?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($old_CarID));
    $result_store = $stmt->fetchAll();

    $query = "select * from carbrand where Brand = ?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($old_CarID));
    $result_carbrand = $stmt->fetchAll();
?>
<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
             <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                    onclick=location.href="car.php">arrow_back
            </button>
            <?php
                //echo '<span class="mdc-top-app-bar__title">'.$result[0]['course_name'].'</span>';
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
				<th>修改</th>
            </tr>
            <?php
				$searchWord='';
                    error_reporting(E_ERROR | E_PARSE);
                    if(isset($_POST['searchWord'])){
                        $searchWord=$_POST['searchWord'];
                    }
				$query = ("select *
								from car natural join carbrand
								where car.Name like ? order by CarID asc");
                    $stmt = $db->prepare($query);
                    $stmt->execute(array('%'.$searchWord.'%'));
                    $result = $stmt->fetchAll();
					
                for ($i = 0; $i < count($result); $i++) {
                    echo "<tr>";
                    
						/* //echo sprintf('<td><input class="materialize-textarea" type="text" name="CarID" value="%s"/></td>', $result[$i]['CarID']);
						echo "<td>" . $result[$i]['CarID'] . "</td>";
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="Brand" value="%s"/></td>', $result[$i]['Brand']);
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="AreaCode" value="%s"/></td>', $result[$i]['AreaCode']);
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="Name" value="%s"/></td>', $result[$i]['Name']);
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="Displacement" value="%s"/></td>', $result[$i]['Displacement']);
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="Price" value="%s"/></td>', $result[$i]['Price']); */
                    
                    
                        echo "<td>" . $result[$i]['CarID'] . "</td>";
                        echo "<td>" . $result[$i]['Brand'] . "</td>";
                        echo "<td>" . $result[$i]['AreaCode'] . "</td>";
                        echo "<td>" . $result[$i]['Name'] . "</td>";
                        echo "<td>" . $result[$i]['Displacement'] . "</td>";
						echo "<td>" . $result[$i]['Price'] . "</td>";
                    //echo '<td> <a class="waves-effect waves-light btn red lighten-3" href="car_modify.php?CarID='.$result[$i]['CarID'].'">修改</a></td>';//修改欄位id
					
                    echo "</tr>";
                }
            ?>
        </table>
        <br>
        <h3 class="change-color-to-gray">販賣商店</h3>
        <table border='1' style='width:70%'>
            <tr>
                <th>所在地區</th>
                <th>營業時間</th>
            </tr>
            <?php
			$searchWord='';
					error_reporting(E_ERROR | E_PARSE);
					if(isset($_POST['searchWord'])){
						$searchWord=$_POST['searchWord'];
					}
			$query = ("select * from store
								where AreaCode like ?");
					$stmt = $db->prepare($query);
					$stmt->execute(array('%'.$searchWord.'%'));
					$result_store = $stmt->fetchAll();
					
                for ($i = 0; $i < count($result_store); $i++) {
                    echo "<tr>";
                    if($edit_mode == true){
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="AreaCode" value="%s"/></td>', $result_store[$i]['AreaCode']);
                        echo sprintf('<td><input class="materialize-textarea" type="text" name="BusinessHour" value="%s"/></td>', $result_store[$i]['BusinessHour']);
                    }
                    else {
                        echo "<td>" . $result_store[$i]['AreaCode'] . "</td>";
                        echo "<td>" . $result_store[$i]['BusinessHour'] . "</td>";
                    }
                    echo "</tr>";
                }
            ?>

        </table>
        <br>
        <h3 class="change-color-to-gray">品牌</h3>
        <table border='1' style='width:70%'>
            <thead>
                <tr>
                    <th>品牌名稱</th>
                    <th>網址</th>
                    <th>發源地</th>
                    <?php
					$searchWord='';
					error_reporting(E_ERROR | E_PARSE);
					if(isset($_POST['searchWord'])){
						$searchWord=$_POST['searchWord'];
					}
					$query = ("select Brand, Website, Location, (select count(*) as car_count
																from car
																where Brand = carbrand.Brand) as car_count
							from carbrand natural join car
							where carbrand.Brand like ? 
							group by Brand
							order by CarID asc");
					$stmt = $db->prepare($query);
					$stmt->execute(array('%'.$searchWord.'%'));
					$result_carbrand = $stmt->fetchAll();
					
						for ($i = 0; $i < count($result_carbrand); $i++) {
							echo "<tr>";
							if($edit_mode == true){
								echo sprintf('<td><input class="materialize-textarea" type="text" name="AreaCode" value="%s"/></td>', $result_store[$i]['Brand']);
								echo sprintf('<td><input class="materialize-textarea" type="text" name="BusinessHour" value="%s"/></td>', $result_store[$i]['Website']);
								echo sprintf('<td><input class="materialize-textarea" type="text" name="BusinessHour" value="%s"/></td>', $result_store[$i]['Location']);
							}
							else {
								echo "<td>" . $result_carbrand[$i]['Brand'] . "</td>";
								echo "<td>" . $result_carbrand[$i]['Website'] . "</td>";
								echo "<td>" . $result_carbrand[$i]['Location'] . "</td>";
							}
							echo "</tr>";
						}
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    //for ($i = 0; $i < count($result_ratings); $i++) {
                    //    $query = "select * from user where user_id = ?";
                    //    $stmt = $db->prepare($query);
                    //    $stmt->execute(array($result_ratings[$i]['user_id']));
                    //    $result = $stmt->fetchAll();
                    //    echo "<tr>";
                    //    echo "<td>" . $result[0]['username'] . "</td>";
                    //    echo sprintf('<td><div class="rating2">
                    //                  <input type="radio" value="5" hidden disabled %s/>
                    //                  <label></label>
                    //                  <input type="radio" value="4" hidden disabled %s/>
                    //                  <label></label>
                    //                  <input type="radio" value="3" hidden disabled %s/>
                    //                  <label></label>
                    //                  <input type="radio" value="2" hidden disabled %s/>
                    //                  <label></label>
                    //                  <input type="radio" value="1" hidden disabled %s/>
                    //                  <label></label>
                    //                  </div></td>',$result_ratings[$i]['rating']==5?"checked":"",$result_ratings[$i]['rating']==4?"checked":"",$result_ratings[$i]['rating']==3?"checked":"",$result_ratings[$i]['rating']==2?"checked":"",$result_ratings[$i]['rating']==1?"checked":"");
                    //    //echo "<td>" . $result_ratings[$i]['rating'] . "</td>";
                    //    echo "<td>" . $result_ratings[$i]['impression'] . "</td>";
                    //    echo "<td>" . $result_ratings[$i]['rating_time'] . "</td>";
                    //    if($edit_mode == true) {
                    //        echo sprintf('<td><button class="btn-floating btn-large waves-effect waves-light red" type="submit" name="%s">
                    //                  <i class="material-icons">delete_forever</i>
                    //                  </button></td>',$result_ratings[$i]['user_id']);
                    //    }
                    //    echo "</tr>";
                    //}
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



