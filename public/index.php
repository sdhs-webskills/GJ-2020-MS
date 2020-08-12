<?php 
define("__FileImage", "../../festivalImages/");
session_start();
require "../lib.php";
require "../web.php";
$xml = simplexml_load_file("xml/festivalList.xml");
for($i=0; $i<count($xml->items->item); $i++){
	$item =  $xml->items->item[$i];
	$folder = str_pad($item->sn,3,0,STR_PAD_LEFT)."_".$item->no;
	if( !is_dir("../../festivalImages/$folder") ){
		mkdir("../../festivalImages/$folder");
	}
	for($idx = 0; $idx<count($item->images->image); $idx++ ){
		if( is_file( __FileImage.$folder."/".$item->images->image[$idx]) ){
			src\Core\DB::exec("INSERT INTO files SET fidx = ?, name = ?",[$item->sn,$item->images->image[$idx]]);
		}
	}
	src\Core\DB::exec("INSERT INTO festivals SET no=?, name=?, area=?, location=?, date=?, content=?",[$item->no,$item->nm,$item->area,$item->location,$item->dt,$item->cn]);
}
src\Core\DB::exec("INSERT INTO users SET id = ?, password = PASSWORD(?), name =?",['admin','admin','관리자']);

src\Core\Route::init();