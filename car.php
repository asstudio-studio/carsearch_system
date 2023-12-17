<?php
    session_start();
    include('header.php');
    include_once "carsearch_db_conn.php";
    $_SESSION["edit_mode"] = false;
    if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true){
        //echo 'user_id:'.$_SESSION["user_id"].'</br>';
        //echo 'username:'.$_SESSION["username"].'</br>';
    }
?>
<?php
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
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                    onclick=location.href="index.php">arrow_back
            </button>
            <span class="mdc-top-app-bar__title">車輛列表</span>
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
<!--    <br/>-->

    <div class="row">
        <h3 class="inline brown-text"> 查詢資料</h3>
        <form class="inline col s5 offset-s7 " action="" method="post" style=''>
            <div class="row inline">
                <div class="input-field col s7">
                    <i class="material-icons prefix ">search</i>
                    <input id="textarea1" placeholder="查詢車輛" class="materialize-textarea" type="text" name="searchWord"></input>
                    <label for="textarea1">查詢</label>

                </div>
<!--                <p></p>-->
<!--                <input class="inline btn waves-effect waves-light btn-small margin5 vertical-center red lighten-3" type="submit"  name="submit" value="查詢">-->
                <div class="input-field col s2">
                    <!--                    <input class="inline btn waves-effect waves-light btn-small margin5 red lighten-3 " type="submit"  name="submit" value="查詢">-->
                    <button class="btn waves-effect waves-light gray lighten-3" type="submit" name="action">查詢
                    </button>
                </div>
            </div>
           
        </form>
    </div>
    
<!--    <br/>-->
        <table class="table2">
            <thead class="thead2">
                <tr>
                <th>汽車編號</th>
                <th>商店</th>
                <th>名字</th>
                <th>排氣量</th>
                <th>價格</th>
				<th>網址</th>
				<th>修改</th>
                </tr>
            
            </thead>
            <tbody class="tbody2">
                <?php
                    $searchWord='';
                    error_reporting(E_ERROR | E_PARSE);
                    if(isset($_POST['searchWord'])){
                        $searchWord=$_POST['searchWord'];
                    }
					//$query = ("select instructor_id,instructor_name,instructor_count,department_name,department_website,(select count(*) as teach_count
					//																					from course
					//																					where instructor.instructor_id = course.instructor_id) as teach_count                                                                   
					//			from instructor natural join department
					//			where instructor.instructor_name like ? order by department_name, teach_count desc");
					//, (select count(*) as car_count from car natural join carbrand group by Brand) as car_count
                    $query = ("select *
								from car natural join carbrand
								where car.Name like ? order by CarID asc");
                    $stmt = $db->prepare($query);
                    $stmt->execute(array('%'.$searchWord.'%'));
                    $result = $stmt->fetchAll();
					
                    for ($i = 0; $i < count($result); $i++) {
                        //echo '<form action="courseInfo.php". method="post">';
                        echo '<tr>';
                        echo '<td>' . $result[$i]['CarID'] . "</td>";
                        echo '<td>' . $result[$i]['AreaCode'] . "</td>";
                        echo '<td> ' . $result[$i]['Name'] . "</td>";
						echo '<td> ' . $result[$i]['Displacement'] . "</td>";
						echo '<td> ' . $result[$i]['Price'] . "</td>";
						echo '<td> <a href="'.$result[$i]['Website'].'" >' . $result[$i]['Website'] . "</a></td>";
						if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true &&$_SESSION["user_level"] == 's'){
							echo '<td> <a class="waves-effect waves-light btn red lighten-3" href="update1.php?CarID='.$result[$i]['CarID'].'">修改</a></td>';
						}//修改欄位id
						//echo '<td> ' . $result[$i]['car_count'] . "</td>";
                        //$query = ("select count(rating), avg(rating) from rating where course_id = ?");
                        //$stmt = $db->prepare($query);
                        //$stmt->execute(array($result[$i]['course_id']));
                        //$rating = $stmt->fetchAll();
                        //if($rating[0]['count(rating)']==0){
                        //    echo '<td>尚未評分</td>';
                        //}
                        //else{
                        //    echo '<td> ' . number_format($rating[0]['avg(rating)'], 1, '.', '') . "</td>";
                        //}
                        //echo sprintf('<input type="hidden" name="courseId" value="%s">',$result[$i]['course_id']);
                        //echo '<td><a class="waves-effect waves-light btn red lighten-3" href="courseInfo.php?course_id='.$result[$i]['course_id'].'">更多資訊</a></td>';
                        echo "</tr>";
                        echo "</form>";
                    }
                ?>
            </tbody>
        </table>
        <br>
    <br>
    <br>
<!--        <a class="waves-effect waves-light btn-small margin5" onclick=location.href="index.php">回到標題</a>-->
<!--        </form>-->
        <form method="post">

<!--        --><?php
//        if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true && $_SESSION["user_level"]=='s'){
//            echo '<a class="waves-effect waves-light btn-small margin5" onclick=location.href="courseAdd.php">新增課程</a>';
//        }
//        ?>


<!--        <form  method="post">-->
<!--            --><?php
//            if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true){
//                echo '<input type="submit" name="logOut"
//                            class="btn waves-effect waves-light btn-small margin5" value="登出" />';
//            }
//            ?>
<!--        </form>-->

        <?php
        if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true) {
            if ($_SESSION["user_level"] == 's') {
                echo '<div class="fixed-action-btn">
                       <a class="btn-floating btn-large green"  onclick=location.href="caradd.php">
                         <i class="large material-icons">add</i>
                        </a>
                       
                    </div>';
            }
        }
        ?>
			<br/>
			<br/>
            <a class="waves-effect waves-light btn-small margin5 gray lighten-1" onclick=location.href="store.php">商店列表</a>
            <a class="waves-effect waves-light btn-small margin5 gray lighten-1" onclick=location.href="carbrand.php">品牌列表</a>
			<!--<a class="waves-effect waves-light btn-small margin5 gray lighten-1" onclick=location.href="update.php">修改資料</a>-->
			<br/>
			<br/>
			<a class="waves-effect waves-light btn-small margin5 gray lighten-1" onclick=location.href="index.php">回到首頁</a>


</center>



