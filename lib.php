<?php 
use src\Core\DB;
function autoload($f){ // autoload
	require "$f.php";
}
spl_autoload_register("autoload");
function download($type,$path,$fidx){
	$zip = new ZipArchive;
	$files = DB::fetchAll("SELECT * FROM files where fidx = ?",[$fidx]);
	$res = $zip->open("../Image.".$type,ZIPARCHIVE::CREATE);
	foreach ($files as $key => $file) {
		$zip->addFile("../../$path/".$file->name,$file->name);
	}	
	$zip->close();
	header("Content-type: application/$type");
	header("Content-Disposition: attachment; filename=Image.$type");
	header("Content-length: " . filesize("../Image.$type"));
	header("Pragma: no-cache");
	header("Expires: 0");
	readfile("../Image.$type");
	unlink("../Image.$type");
}
function dataCheck($data){
	$data = array_splice($data,-1,1);
	return $data ? $data : false;
}
function getImage($path){
	$type = preg_replace("/(.*)\.(.*)/","$2", $path);
	header("Content-type: image/$type");
	readfile($path);
}
function trimCheck($arr){
	foreach ($arr as $key => $v) {
		if( gettype($v) == "array" ){
			continue;
		}
		if( trim($v) == "" ){
			back("누락된 항목이 있습니다.");
		}
	}
}
function imageCheck($files){
	if(!$files['size'][0]){
		return;
	}
	for($i=0; $i<count($files['name']); $i++){
		$type = $files['type'][$i];
		$type = explode("/",$type)[1];
		$type = strtolower($type);
		if( $type != "jpg" && $type != "jpeg"  && $type != "png" && $type != "gif"){
			back("이미지 형식이 jpg, png, gif파일만 업로드 가능합니다.");
		}
	}
}
function script($t){ // script
	echo "<script>$t</script>";
}
function alert($t=""){ // alert
	if( !empty($t) ){
		script("alert('$t')");
	}
}
function move($l,$t=""){ // move
	alert($t);
	script("location.replace('$l')");
	exit;
}
function back($t=""){ // back
	alert($t);
	script("history.back()");
	exit;

}
function ss(){ // ss
	return isset($_SESSION['user']) ? $_SESSION['user'] : false;
}
function view($l,$d){ // view
	extract($d);
	require "src/View/temp/header.php";
	require "src/View/$l.php";
	require "src/View/temp/footer.php";
}