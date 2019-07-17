<?php

define('base_path',$path); //== root path for this
$id_fpr = (isset($_GET['key'])) ? $_GET['key'] : '';
$status_pm= '1';
//Check type of post action

if(isset($_POST['button_edit']))
editDataProcess($status_pm,$val);

if(isset($_POST['procrument']))
procDataProcess($status_pm,$val);

//===This function called when website loaded
function render($opt,$val,$page) {
	switch ($opt) {
		case 'fpr':
			fprData($val);
			break;

		case 'apvfpr':
			apvfprData($val);
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
	 //==Edit this for custom href
		echo "<td><a href=".$_SERVER['REQUEST_URI']."/fpr/".$data['id'].">".$data['project_name']."</a></td>";
		/** end **/
		echo "</td>";
		$num++;
	}
	echo "</table>";
	echo "<td><a href='".$_SERVER['REQUEST_URI']."/add' class='add-icon'>Add Data</a></td>";
}

//===Generate Form to insert new data to database
function fprData($val) {

		$receiveData = query("SELECT * FROM `tb_fpr` where `project_id` = $val");
		while ($data = fetchQuery($receiveData)) {
			$id_fpr = $data['id'];
			$id_project = $data['project_id'];
			$fpr_no = $data['fpr_no'];
			$date = $data['date'];
			$date_reqd = $data['date_reqd'];
			$division = $data['division'];
			$area = $data['area'];
			$reviewed=$data['reviewed'];
			$approved=$data['approved'];

			if($reviewed==0 and $approved == 0){
					$alert = "<div class='alert alert-danger'>
					<strong><center> -- WAITING APPROVAL PM --</center></strong>
					</div>";
			}elseif($reviewed == 1 and $approved ==0){
					$alert = "<div class='alert alert-info'>
					<strong><center>-- WAITING APPROVAL PROC --</center></strong>
					</div>";
			}elseif($reviewed == 0 and $approved ==1){
					$alert = "<div class='alert alert-danger'>
					<strong><center>-- WAITING APPROVAL PM --</center></strong>
					</div>";
			}else {
					$alert = "<div class='alert alert-success'>
					<strong><center>-- APPROVED --</center></strong>
					</div>";
			}
		}

	$num = 1;
	$receiveData = query("SELECT * FROM `tb_fpr` WHERE `project_id`=$val");
	echo "<table border='1'>";
	echo "<tr><th>No.</th>
	<th>FPR No.</th>
	<th>Divisi</th>
	<th>Area</th>
	<th>Date</th>
	<th>Approval&View</th>
	<th>Status</th></tr>";
	while ($data = fetchQuery($receiveData)) {
		echo "<tr>";
		echo "<td>".($num)."</td>";
		echo "<td>".$data['fpr_no']."</td>";
		echo "<td>".$data['division']."</td>";
		echo "<td>".$data['area']."</td>";
		echo "<td>".$data['date']."</td>";
		echo "<td><a href='".BASE_URL."/".base_path."/apvfpr/".$data['id']."' class='btn btn-primary my-2'>APPROVAL & REVIEW</a></td>";
		echo "<td>$alert<td>";

		/** end **/
		echo "</tr>";
		$num++;
}
}

//===Process of insert new data to database
function addDataProcess($project_name,$no_project) {
	$sendData = query("INSERT INTO `tb_project`(`id`, `project_name`, `no_project`) VALUES ('','$project_name','$no_project')");
	if($sendData){
		redirect(base_path);
	}
}

//===Generate Form to edit data in database
function apvfprData($val) {
	$num = 1;
	$receiveData = query("SELECT * FROM tb_fpr_item a INNER JOIN tb_fpr b ON a.fpr_id = $val and a.fpr_id = b.id inner join tb_project c on b.project_id = c.id ");
	echo "<table border='1'>";
	echo " <BR><h2>DATA MATERIAL YANG DIPESAN</h2>";
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
		$no_fpr=$data['fpr_no'];
		$date=$data['date'];
		$project_name=$data['project_name'];

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
		/** end **/
		echo "</td>";
		$num++;
	}
	echo "</table>";

		echo "
			<form action='' method='POST' name='form-add'>
			<h1>No fpr = $no_fpr</h1>
		 <h4>$project_name </h4> <small>Tanggal = $date</small> <br>
		 <div>
				 <input type='submit' name='button_edit' class='btn btn-info btn-xm' value='-.APPROVAL_PM.-'>
				 <input type='submit' name='procrument' class='btn btn-info btn-xm'value='-.PROCRUMENT.-'>
		 </div>
		</form>
		";
}
//===Process of edit data in database
function editDataProcess($status_pm,$val) {
	$sendData = query("UPDATE `tb_fpr` SET `reviewed`='$status_pm' WHERE `tb_fpr`.`id` = '$val'");
	if($sendData){
		echo '<script>alert("Berhasil APPROVED FPR."); document.location="redirect(base_path."/fpr/".$val)"</script>';

	}else{
		echo '<div class="alert alert-warning">Gagal melakukan proses edit data.</div>';
	}

}

//===Process to remove data in database
function procDataProcess($status_pm,$val) {
	$sendData = query( "UPDATE `tb_fpr` SET `approved`='$status_pm' WHERE `tb_fpr`.`id` = '$val'");
	if($sendData){
		echo '<script>alert("Berhasil APPROVED FPR."); document.location="redirect(base_path."/fpr/".$val)"</script>';

	}else{
		echo '<div class="alert alert-warning">Gagal melakukan proses edit data.</div>';
	}
}
?>
