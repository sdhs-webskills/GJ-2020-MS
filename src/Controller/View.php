<?php
namespace src\Controller;
use src\Core\DB;
class View
{
	function main(){
		view("main",[]);
	}
	function login(){
		view("login",[]);
	}
	function festival($data){
		$idx = 0;
		if( count($data) == 2 ){
			$idx = $data[1]-1;
		}
		$pageIdx = $idx*11;
		$arr = (Object)[];
		$arr->view = DB::fetchAll("SELECT * FROM festival_view order by idx desc limit $pageIdx,11 ",[]);
		$arr->idx = $idx;
		$arr->page = ceil(DB::fetchAll("SELECT count(*) count FROM festivals",[])[0]->count/11);
		view("festival",(array)$arr);
	}
	function festival_insert(){
		view("festival_insert",[]);
	}
	function festival_modify($data){
		$idx = $data[1];
		$row = DB::fetch("SELECT *,lpad(idx,3,0) sn FROM festivals WHERE idx = ? ",[$idx]);
		$files = DB::fetchAll("SELECT * FROM files WHERE fidx = ? ",[$idx]);
		if( !$row ){
			back("존재하지 않는 게시글입니다.");
		}
		$arr =  (Object)[];
		$arr->view= $row;
		$arr->files = $files;
		view("festival_modify",(array)$arr);
	}
	function Image($data){
		$folder = $data[1];
		$name = $data[2];
		$path = __FileImage.$folder."/".$name;
		getImage($path);
	}
	function download($data){
		$type = $data[1];
		$fidx = $data[2];
		$path = "festivalImages/".$data[3];
		download($type,$path,$fidx);
		// back();
	}
}