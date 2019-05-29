<?php
require 'config.php';
require 'function.php';

$request = (isset($_GET['req'])) ? $_GET['req'] : '';
$opt = (isset($_GET['opt'])) ? $_GET['opt'] : '';
$val = (isset($_GET['val'])) ? $_GET['val'] : '';
$page = (isset($_GET['page'])) ? $_GET['page'] : '';
$key = (isset($_GET['key'])) ? $_GET['key'] : '';
$count404 = 0;

/**
 * For Debuging
 */
echo $request;
echo $opt;
echo $val;
echo $key;
echo $page;

$receiveData = query("SELECT config_key FROM base_config where name = 'engine_path'");
while ($data = fetchQuery($receiveData)) {
    $engine_path = $data['config_key'];
}

$receiveData = query("SELECT * FROM engine where status = 'enable'");
while($data = fetchQuery($receiveData)) {
	$path = $data['base_path'];
	$viewsPath = $data['views'];
  $controllerPath = $data['controller'];
  $printPath = $data['print'];
	$status = $data['status'];
	$position = $data['position'];

	if($position == 'landing_page'){
        if(($request == '') || ($request == $path)){
            if($controllerPath!='')require '../'.$engine_path.$path.$controllerPath;
            if($viewsPath!='')require '../'.$engine_path.$path.$viewsPath;
            $count404++;
        }
    } else {
        if($request == $path){
            if($controllerPath!='')require '../'.$engine_path.$path.$controllerPath;
            if($viewsPath!='')require '../'.$engine_path.$path.$viewsPath;
            $count404++;
        }
    }

}

if ($count404 == 0){
    require '../404.html';
}

?>
