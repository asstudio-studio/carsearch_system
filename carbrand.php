<?php
	include('header.php');
	include_once "carsearch_db_conn.php";
	session_start();
?>

<?php
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		//echo array_keys($_POST)[1];
		if(strpos(array_keys($_POST)[1], 'delete') !== false){
			$user_id = array_keys($_POST)[1];
			$query = "delete from user where user_id = ?";
			$stmt = $db->prepare($query);
			$stmt->execute(array(intval(substr($user_id,6))));
			//header("Refresh:0");
			echo sprintf('<script type="text/JavaScript"> location.href="userManage.php"; </script>');
		}
	}
?>
<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"
                    onclick=location.href="car.php">arrow_back
            </button>
            <span class="mdc-top-app-bar__title">品牌列表</span>
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
        <h3 class="inline brown-text"> 品牌列表</h3>
        <form class="inline col s5 offset-s7 " method="post" >
            <div class="row inline">
                <div class="input-field col s8">
                    <i class="material-icons prefix ">search</i>
                    <input id="textarea1" placeholder="查詢品牌"  class="materialize-textarea" type="text" name="searchWord"></input>
                    <label for="icon_prefix2">查詢</label>
                </div>
                <div class="input-field col s2">
<!--                    <input class="inline btn waves-effect waves-light btn-small margin5 red lighten-3 " type="submit"  name="submit" value="查詢">-->
                    <button class="btn waves-effect waves-light gray lighten-3" type="submit" name="action">查詢
<!--                        <i class="material-icons right">send</i>-->
                    </button>
                </div>
            </div>

    </div>

    <br/>
    <br/>
    <form method="post">
        <table class="table2">
            <thead class="thead2">
            <tr>
                <th>品牌名稱</th>
                <th>品牌網址</th>
				<th>品牌發源地</th>
				<th>數量</th>	
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
				
				//$query = ("select * from carbrand
				//				where Brand like ?");
				$query = ("select Brand, Website, Location, (select count(*) as car_count
																from car
																where Brand = carbrand.Brand) as car_count
							from carbrand
							where Brand like ? 
							order by car_count asc");
				$stmt = $db->prepare($query);
				$stmt->execute(array('%'.$searchWord.'%'));
				$result = $stmt->fetchAll();
				
				for ($i = 0; $i < count($result); $i++) {
					echo '<tr>';
					echo '<td>' . $result[$i]['Brand'] . "</td>";
					//echo '<td> ' . $result[$i]['department_website'] . "</td>";
					echo '<td> <a href="'.$result[$i]['Website'].'" >' . $result[$i]['Website'] . "</a></td>";
					echo '<td>' . $result[$i]['Location'] . "</td>";
					echo '<td> ' . $result[$i]['car_count'] . "</td>";
				}
            ?>
            </tbody>
        </table>
    </form>
    <br>
    <br>
    <br>
    <a class="waves-effect waves-light btn-small margin5 gray lighten-3" onclick=location.href="index.php">回到首頁</a>

</center>
<?php
if(isset($_SESSION["hasSignedIn"]) && $_SESSION["hasSignedIn"]==true){
    //echo 'user_id:'.$_SESSION["user_id"].'</br>';
    //echo 'username:'.$_SESSION["username"].'</br>';
    if($_SESSION['user_level']=='s'){
        echo '<div class="fixed-action-btn">
                <a class="btn-floating btn-large red"  onclick=location.href="carbrandadd.php">
                    <i class="large material-icons">add</i>
                </a>
            </div>';
    }
}
?>
