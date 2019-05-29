<?php
// ===== Note :
// ===== Operation List $opt :
// ===== View ==> opt: 'view'or''
// ===== Add ==> opt: 'add'
// ===== Edit ==> opt: 'edit'
// ===== Remove ==> opt: 'remove'
// ===== Value $val
// ===== Pagination $page

define('base_path',$path); //== root path for this
$id_project = (isset($_POST['id_project'])) ? $_POST['id_project'] : '';
$project_name = (isset($_POST['project_name'])) ? $_POST['project_name'] : '';
$no_project = (isset($_POST['no_project'])) ? $_POST['no_project'] : '';

//Check type of post action
if(isset($_POST['button_add']))
addDataProcess($project_name,$no_project);

if(isset($_POST['button_edit']))
editDataProcess($id_project,$project_name,$no_project);

//===This function called when website loaded
function render($opt,$val,$page) {
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
			viewData($page);
			break;
	}
}

//===View All Data
function viewData($page) {
	$num = 1;
	$receiveData = query("SELECT * FROM `tb_project`");
	echo "<table border='1'>";
	echo "<tr><th>No.</th><th>Project No.</th><th>Project Name</th></tr>";
	while ($data = fetchQuery($receiveData)) {
		echo "<tr>";
		echo "<td>".($num)."</td>";
		echo "<td>".$data['no_project']."</td>";
		echo "<td><a href=".BASE_URL."/fpr/key-".$data['id'].">".$data['project_name']."</a></td>"; //==Edit this for custom href

		/** Tambah Kode nanti Untuk Role Premission **/
		echo "<td><a href='".$_SERVER['REQUEST_URI']."/edit/".$data['id']."' class='option-icon'>Option</a></td>";
		/** end **/
		echo "</td>";
		$num++;
	}
	echo "</table>";
	echo "<td><a href='".$_SERVER['REQUEST_URI']."/add' class='add-icon'>Add Data</a></td>";
}

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
	$receiveData = query("SELECT * FROM `tb_project` where `id`=$val");
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
