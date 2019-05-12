<?php
// ===== Note :
// ===== Operation List $opt :
// ===== View ==> opt: 'view'or''
// ===== Add ==> opt: 'add'
// ===== Edit ==> opt: 'edit'
// ===== Remove ==> opt: 'remove'
// ===== Value $val
// ===== Pagination $page
// ===== id project $_GET['key'] or $id_project

define('base_path',$path);
$id_project = (isset($_GET['key'])) ? $_GET['key'] : '';
$fpr_no = (isset($_POST['fpr_no'])) ? $_POST['fpr_no'] : '';
$date = (isset($_POST['date'])) ? $_POST['date'] : '';
$date_reqd = (isset($_POST['date_reqd'])) ? $_POST['date_reqd'] : '';
$division = (isset($_POST['division'])) ? $_POST['division'] : '';
$section = (isset($_POST['section'])) ? $_POST['section'] : '';
$area = (isset($_POST['area'])) ? $_POST['area'] : '';
$reqd_for = (isset($_POST['reqd_for'])) ? $_POST['reqd_for'] : '';
$reviewed = (isset($_POST['reviewed'])) ? $_POST['reviewed'] : '';
$approved = (isset($_POST['approved'])) ? $_POST['approved'] : '';
$proceed = (isset($_POST['proceed'])) ? $_POST['proceed'] : '';

//Check type of post action
if(isset($_POST['button_add']))
addDataProcess($fpr_no,$date,$date_reqd,$division,$section,$area,$reqd_for,$id_project);

if(isset($_POST['button_edit']))
editDataProcess($fpr_no,$date,$date_reqd,$division,$section,$area,$reqd_for,$id_project);

//===This function called when website loaded
function render($id_project,$opt,$val,$page) {
	switch ($opt) {
		case 'add':
			addData();
			break;

		case 'edit':
			editData($val);
			break;

		case 'remove':
			removeData($val);
			break;
		
		default:
			viewData($id_project,$page);
			break;
	}
}

//===View All Data
function viewData($id_project,$page) {
	$num = 1;
	$receiveData = query("SELECT * FROM `tb_fpr` where `project_id` = $id_project");
	echo "<table border='1'>";
	echo "<tr>
		<th>No.</th>
		<th>FPR No.</th>
		<th>Date</th>
		<th>Date Reqd</th>
		<th>Division</th>
		<th>Section</th>
		<th>Area</th>
		<th>Reqd For</th>
		</tr>";
	while ($data = fetchQuery($receiveData)) {
		echo "<tr>";
		echo "<td>".($num)."</td>";
		echo "<td><a href=".BASE_URL."/fpr_item/key-".$data['id'].">".$data['fpr_no']."</a></td>"; //==Edit this for custom href
		echo "<td>".$data['date']."</td>";
		echo "<td>".$data['date_reqd']."</td>";
		echo "<td>".$data['division']."</td>";
		echo "<td>".$data['section']."</td>";
		echo "<td>".$data['area']."</td>";
		echo "<td>".$data['reqd_for']."</td>";
		
		/** Tambah Kode nanti Untuk Role Premission **/
		echo "<td><a href='".$_SERVER['REQUEST_URI']."/edit/".$data['id']."' class='option-icon'>Option</a></td>";
		/** end **/
		echo "</td>";
		$num++;
	}
	echo "</table>";
	echo "<td><a href='".$_SERVER['REQUEST_URI']."/add' class='add-icon'>Add Data</a></td>";
}

///========Beloman

//===Generate Form to insert new data to database
function addData() {
	echo "
		<form action='' method='POST' name='form-add'>
			<div>
				<label>No. Project</label>
		  		<input type='text' name='no_project' placeholder='Please fill this field with new project name' required autofocus>
			</div>
			<div>
				<label>Project Name</label>
			  	<input type='text' name='project_name' placeholder='Please fill this field with new project name' required>
			</div>
			<div>
			  	<input type='submit' name='button_add' value='Create New Project'>
			</div>
		</form>
	";
}

//===Process of insert new data to database
function addDataProcess($project_name,$no_project) {
	$sendData = query("INSERT INTO `tb_project`(`id`, `project_name`, `no_project`) VALUES ('','$project_name','$no_project')");
	if($sendData){
		redirect(base_path);
	}
}

//===Generate Form to edit data in database
function editData($val) {
	$receiveData = query("SELECT * FROM `tb_project`");
	while ($data = fetchQuery($receiveData)) {
		$id = $data['id'];
		$project_name = $data['project_name'];
		$no_project = $data['no_project'];
	}
	echo "
		<form action='' method='POST' name='form-add'>
			<div>
				<label>No. Project</label>
		  		<input type='text' name='no_project' placeholder='Please fill this field with new project name' required autofocus value='".$no_project."'>
			</div>
			<div>
				<label>Project Name</label>
			  	<input type='text' name='project_name' placeholder='Please fill this field with new project name' required value='".$project_name."'>
			</div>
			<div>
				<input type='hidden' name='id_project' value='".$id."'> 
			  	<input type='submit' name='button_edit' value='Update this Project'>
			  	<a href='".BASE_URL."/".base_path."/remove/".$id."' class='remove-link'>Remove</a>
			</div>
		</form>
	";
}

//===Process of edit data in database
function editDataProcess($id_project,$project_name,$no_project) {
	$sendData = query("UPDATE `tb_project` SET `project_name` = '$project_name', `no_project` = '$no_project' WHERE `tb_project`.`id` = $id_project;");
	if($sendData){
		redirect(base_path);
	}
}

//===Process to remove data in database
function removeData($id_project) {
	$sendData = query( "DELETE FROM `tb_project` WHERE `tb_project`.`id` = $id_project");
	if($sendData){
		redirect(base_path);
	}
}	


?>