<?php
// ===== Note :
// ===== Operation List $opt :
// ===== View ==> opt: 'view'or''
// ===== Add ==> opt: 'add'
// ===== Edit ==> opt: 'edit'
// ===== Remove ==> opt: 'remove'
// ===== Value $val
// ===== Pagination $page
// ===== id fpr $_GET['key'] or $id_fpr

define('base_path',$path);
$id_fpr = (isset($_GET['key'])) ? $_GET['key'] : '';
$material_code = (isset($_POST['material_code'])) ? $_POST['material_code'] : '';
$qty = (isset($_POST['qty'])) ? $_POST['qty'] : '';
$unit = (isset($_POST['unit'])) ? $_POST['unit'] : '';
$description = (isset($_POST['description'])) ? $_POST['description'] : '';
$unit_price = (isset($_POST['unit_price'])) ? $_POST['unit_price'] : '';
$amount = (isset($_POST['amount'])) ? $_POST['amount'] : '';


//Check type of post action
if(isset($_POST['button_add']))
addDataProcess($material_code,$qty,$unit,$description,$unit_price,$amount,$id_fpr);

if(isset($_POST['button_edit']))
editDataProcess($material_code,$qty,$unit,$description,$unit_price,$amount,$id_fpr);

//===This function called when website loaded
function render($id_fpr,$opt,$val,$page) {
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
			viewData($id_fpr,$page);
			break;
	}
}

function generateHeader($id_fpr) {
	$receiveData = query("SELECT * FROM `tb_fpr` where `id` = $id_fpr");
	while ($data = fetchQuery($receiveData)) {
		$id_project = $data['project_id'];
		$fpr_no = $data['fpr_no'];
		$date = $data['date'];
		$date_reqd = $data['date_reqd'];
		$division = $data['division'];
		$section = $data['section'];
		$area = $data['area'];
		$reqd_for = $data['reqd_for'];
	}
	
	$receiveData = query("SELECT * FROM `tb_project` where id=$id_project");
	while ($data = fetchQuery($receiveData)) {
		$no_project = $data['no_project'];
		$project_name = $data['project_name'];
	}

	echo "
	<div>
		<span class='title'>Project : </span><span class='title-value'>$project_name</span>
		<span class='title'>No. Project : </span><span class='title-value'>$no_project</span>
	</div>
	<div>
		<span class='title'>FPR No. : </span><span class='title-value'>$fpr_no</span>
		<span class='title'>DATE : </span><span class='title-value'>$date</span>
		<span class='title'>DATE REQ'D : </span><span class='title-value'>$date_reqd</span>
	</div>
	<div>
		<span class='full-width-title'>PERMINTAAN PEMBELIAN SITE</span>
	</div>
	";

}

//===View All Data
function viewData($id_fpr,$page) {
	$num = 1;
	$receiveData = query("SELECT * FROM `tb_fpr_item` where `fpr_id` = $id_fpr");
	echo "<table border='1'>";
	echo "<tr>
		<th>No.</th>
		<th>Material Code</th>
		<th>QTY</th>
		<th>Unit</th>
		<th>Description</th>
		<th>Unit Price</th>
		<th>Amount</th>
		</tr>";
	while ($data = fetchQuery($receiveData)) {
		echo "<tr>";
		echo "<td>".($num)."</td>";
		echo "<td>".$data['material_code']."</td>";
		echo "<td>".$data['qty']."</td>";
		echo "<td>".$data['unit']."</td>";
		echo "<td>".$data['description']."</td>";
		echo "<td>".$data['unit_price']."</td>";
		echo "<td>".$data['amount']."</td>";
		
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