<?php

function getAccess() {
    $getAccess = mysqli_connect(HOST_DB, USERNAME_DB, PASSWORD_DB, DB_NAME);
    return $getAccess;
}

function query($queryData) {
    $receiveData = mysqli_query(getAccess(),$queryData);
    return $receiveData;
}

function fetchQuery($receiveData) {
	$data = mysqli_fetch_array($receiveData);
	return $data;
}

function getTitle($request) {
	$receiveData = query("SELECT name FROM engine where base_path = '$request'");
	while ($data = fetchQuery($receiveData)) {
   		$title = $data['name'];
	}
	echo $title;
	return;
}

function redirect($url) {
   header('Location: '.BASE_URL."/".$url);
}

?>