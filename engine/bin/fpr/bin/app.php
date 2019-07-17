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
addDataProcess($fpr_no,$date,$date_reqd,$division,$area,$id_project);

if(isset($_POST['button_edit']))
editDataProcess($fpr_no,$date,$date_reqd,$division,$section,$area,$reqd_for,$id_project,$val);

//===This function called when website loaded
function render($id_project,$opt,$val,$page) {
	switch ($opt) {
		case 'add':
			addData($id_project);
			break;

		case 'edit':
			editData($val);
			break;

		case 'remove':
			removeData($id_project,$val);
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
		<th>Area</th>
		</tr>";
	while ($data = fetchQuery($receiveData)) {
		echo "<tr>";
		echo "<td>".($num)."</td>";
		echo "<td><a href=".BASE_URL."/fpr_item/key-".$data['id'].">".$data['fpr_no']."</a></td>"; //==Edit this for custom href
		echo "<td>".$data['date']."</td>";
		echo "<td>".$data['date_reqd']."</td>";
		echo "<td>".$data['division']."</td>";
		echo "<td>".$data['area']."</td>";

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
function addData($id_project) {
	$receiveData = query("SELECT * FROM `tb_project` where `id`=$id_project");
	while ($data = fetchQuery($receiveData)) {
		$id = $data['id'];
		$project_name = $data['project_name'];
		$no_project = $data['no_project'];
	}
	echo "
		<form action='' method='POST' name='form-add'>
			<div>
				<label>FPR No.</label>
		  		<input type='text' name='fpr_no'  value ='".$no_project."/FPR/' required autofocus>
			</div>
			<div>
				<label>Date</label>
			  	<input type='date' name='date' placeholder='Please fill this field with Date' required>
			</div>
			<div>
				<label>Date ReqD</label>
			  	<input type='date' name='date_reqd' placeholder='Please fill this field with Date ReqD' required>
			</div>
			<div>
				<div class='form-group'>
					<label for='divisi' class='control-label col-sm-2'>Division</label>
					<div class='col-sm-7'>
						<select class='form-control' id='divisi' name='division' required autofocus>
						<option value ='' > - Pilih Division - </option>
						<option value ='ENG'>ENG/Konstruksi</option>
						<option value ='QC'>QC</option>
						<option value ='HSE'>HSE</option>
						<option value ='PC'>PC</option>
						<option value ='HRD'>HRD</option>
						<option value ='AFM'>AFM</option>
						<option value ='PROC'>PROCRUMENT</option>

						</select>
					</div>
				</div>
			</div>

			<div>
				<label>Area</label>
			  	<input type='text' name='area' placeholder='Please fill this field with new Area' required>
			</div>

			<div>
			  	<input type='submit' name='button_add' value='Create New Fpr'>
			</div>
		</form>
	";
}

//===Process of insert new data to database
function addDataProcess($fpr_no,$date,$date_reqd,$division,$area,$id_project) {
	$sendData = query("INSERT INTO `tb_fpr`(`id`, `fpr_no`, `date`,`date_reqd`,`division`,`area`,`reviewed`, `approved`, `proceed`,`project_id`) VALUES ('','$fpr_no','$date','$date_reqd','$division','$area','','','','$id_project')");
	if($sendData){
		redirect(base_path."/key-".$id_project);
	}
}

//===Generate Form to edit data in database
function editData($val) {
	$receiveData = query("SELECT * FROM `tb_fpr` where `id`=$val");
	while ($data = fetchQuery($receiveData)) {
		$id = $data['id'];
		$fpr_no = $data['fpr_no'];
		$date = $data['date'];
		$date_reqd = $data['date_reqd'];
		$division = $data['division'];
		$area = $data['area'];
	}
	echo "
	<form action='' method='POST' name='form-add'>
		<div>
			<label>FPR No.</label>
				<input type='text' name='fpr_no' placeholder='Please fill this field with New No FPR' required autofocus value='".$fpr_no."'>
		</div>
		<div>
			<label>Date</label>
				<input type='date' name='date' placeholder='Please fill this field with Date' required value='".$date."'>
		</div>
		<div>
			<label>Date ReqD</label>
				<input type='date' name='date_reqd' placeholder='Please fill this field with Date ReqD' required value='".$date_reqd."'>
		</div>
		<div>
			<label>Division</label>
				<input type='text' name='division' placeholder='Please fill this field with new Division' required value='".$division."'>
		</div>
		<div>
			<label>Area</label>
				<input type='text' name='area' placeholder='Please fill this field with new Area' required value='".$area."'>
		</div>
		<div>
		<div>
			<input type='hidden' name='id_project' value='".$id."'>
				<input type='submit' name='button_edit' value='Update this Project'>
				<a href='".BASE_URL."/".base_path."/remove/".$id."' class='remove-link'>Remove</a>
		</div>
	</form>
	";
}

//===Process of edit data in database
function editDataProcess($fpr_no,$date,$date_reqd,$division,$section,$area,$reqd_for,$id_project,$val) {
	$sendData = query("UPDATE `tb_fpr` SET `fpr_no`='$fpr_no', `date`='$date', `date_reqd`='$date_reqd', `division`='$division',`area`='$area' WHERE `tb_fpr`.`id` = '$val'");
	if($sendData){
		redirect(base_path."/key-".$id_project);
	}
}

//===Process to remove data in database
function removeData($id_project,$val) {
	$sendData = query( "DELETE FROM `tb_fpr` WHERE `tb_fpr`.`id` = '$val'");
	if($sendData){
		redirect(base_path."/key-".$id_project);
	}
}


?>
