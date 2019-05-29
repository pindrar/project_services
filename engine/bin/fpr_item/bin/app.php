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
$size = (isset($_POST['size'])) ? $_POST['size'] : '';
$unit_price = (isset($_POST['unit_price'])) ? $_POST['unit_price'] : '';
$amount = (isset($_POST['amount'])) ? $_POST['amount'] : '';


//Check type of post action
if(isset($_POST['button_add']))
addDataProcess($material_code,$qty,$unit,$description,$size,$unit_price,$amount,$id_fpr);

if(isset($_POST['button_edit']))
editDataProcess($material_code,$qty,$unit,$description,$size,$unit_price,$amount,$id_fpr,$val);

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
		<th>Size</th>
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
		echo "<td>".$data['size']."</td>";
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
			<label>Material Code</label>
				<input type='text' name='material_code' placeholder='Please fill this field with New Material Code' required autofocus>
		</div>
		<div>
			<label>QTY</label>
				<input type='text' name='qty' placeholder='Please fill this field with new Quantity' required>
		</div>
		<div>
			<label>UnitD</label>
				<input type='text' name='unit' placeholder='Please fill this field with new Unit' required>
		</div>
		<div>
			<label>Discription</label>
				<textarea type='text' name='description' placeholder='Please fill this field with new discription' required> </textarea>
		</div>
		<div>
			<label>Size</label>
				<input type='text' name='size' placeholder='Please fill this field with new Size' required>
		</div>
		<div>
			<label>Unit Price</label>
				<input type='text' name='unit_price' placeholder='Please fill this field with new Unit Price' required>
		</div>
		<div>
			<label>Amount</label>
				<input type='text' name='amount' placeholder='Please fill this field with new Amount' required>
		</div>

				<input type='submit' name='button_add' value='Create New Fpr Item'>
		</div>
	</form>
";
}

//===Process of insert new data to database
function addDataProcess($material_code,$qty,$unit,$description,$size,$unit_price,$amount,$id_fpr) {
	$sendData = query("INSERT INTO `tb_fpr_item`(`id`,`fpr_id`,`material_code`, `qty`, `unit`, `description`, `size`, `unit_price`, `amount`) VALUES ('','$id_fpr','$material_code','$qty','$unit','$description','$size','$unit_price','$amount')");
	if($sendData){
		redirect(base_path."/key-".$id_fpr);
	}
}

//===Generate Form to edit data in database
function editData($val) {
	$receiveData = query("SELECT * FROM `tb_fpr_item` where `id` = $val");
	while ($data = fetchQuery($receiveData)) {
		$id=$data['id'];
		$material_code = $data['material_code'];
		$qty = $data['qty'];
		$unit = $data['unit'];
		$description = $data['description'];
		$size = $data['size'];
		$unit_price = $data['unit_price'];
		$amount = $data['amount'];
	}
	echo "
		<form action='' method='POST' name='form-add'>

		<div>
			<label>Material Code</label>
				<input type='text' name='material_code' placeholder='Please fill this field with New Material Code' required autofocus value='".$material_code."'>
		</div>
		<div>
			<label>QTY</label>
				<input type='text' name='qty' placeholder='Please fill this field with new Quantity' required value='".$qty."'>
		</div>
		<div>
			<label>UnitD</label>
				<input type='text' name='unit' placeholder='Please fill this field with new Unit' required value='".$unit."'>
		</div>
		<div>
			<label>Discription</label>
				<input type='text' name='description' placeholder='Please fill this field with new discription' required value='".$description."'>
		</div>
		<div>
			<label>Size</label>
				<input type='text' name='size' placeholder='Please fill this field with new Size' required value='".$size."'>
		</div>
		<div>
			<label>Unit Price</label>
				<input type='text' name='unit_price' placeholder='Please fill this field with new Unit Price' required value='".$unit_price."'>
		</div>
		<div>
			<label>Amount</label>
				<input type='text' name='amount' placeholder='Please fill this field with new Amount' required value='".$amount."'>
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
function editDataProcess($material_code,$qty,$unit,$description,$size,$unit_price,$amount,$id_fpr,$val) {

	$sendData = query("UPDATE `tb_fpr_item` SET `material_code`='$material_code',`qty`='$qty',`unit`='$unit',`description`='$description',`size`='$size',`unit_price`='$unit_price',`amount`='$amount' WHERE `tb_fpr_item`.`id` = $val;");
	if($sendData){
		redirect(base_path."/key-".$id_fpr);
	}
}

//===Process to remove data in database
function removeData($val) {
	$sendData = query( "DELETE FROM `tb_fpr_item` WHERE `tb_fpr_item`.`id` = $val");
	if($sendData){
		redirect(base_path."/key-".$id_fpr);
	}
}
?>
