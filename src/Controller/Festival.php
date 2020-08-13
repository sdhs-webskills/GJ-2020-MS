<?php 
namespace src\Controller;
use src\Core\DB;
class Festival
{
	function Main($data=[]){
		$arr = (Object)[];
		$idx = count($data) == 2 ? $data[1]-1 : 0;
		$pageIdx = $idx*11;
		$arr->view = DB::fetchAll("SELECT * FROM festival_view order by idx desc limit $pageIdx,11 ",[]);
		$arr->idx = $idx;
		$arr->page = ceil(DB::fetchAll("SELECT count(*) count FROM festivals",[])[0]->count/11);
		view("festival",(array)$arr);
	}
	function Create(){
		view("festival/create",[]);
	}
	function Modify($data){
		$data = dataCheck($data);
		$idx = $data[0];
		$arr = (Object)[];
		$arr->view = self::getFestival($idx);
		$arr->files = self::getFile($idx);
		view("festival/modify",(array)$arr);
	}
	function Info($data){
		$data = dataCheck($data);
		$idx = $data[0];
		$arr = (Object)[];
		$arr->view = self::getFestival($idx);
		$arr->files = self::getFile($idx);
		$arr->comments = self::getComment($idx);
		view("festival/info",(array)$arr);
	}
	function calendar(){
		$arr = (Object)[];
		$arr->view = DB::fetchAll("SELECT * FROM festival_view",[]);
		view("festival/calendar",(array)$arr);
	}
	// CRUD 
	function Insert(){
		trimCheck($_POST);
		extract($_POST);
		$files = $_FILES['file'];
		$no = DB::fetch("SELECT no FROM festivals order by idx desc limit 1",[])->no+1;
		self::dateCheck($date);
		imageCheck($files);
		DB::exec("INSERT INTO festivals SET no=?,name=?,area=?,location=?,date=?",[
			htmlspecialchars($no),
			htmlspecialchars($title),
			htmlspecialchars($area),
			htmlspecialchars($location),
			htmlspecialchars($date)
		]);
		$idx = DB::last();
		$sn = str_pad($idx,3,"0",STR_PAD_LEFT);
		$path = $sn."_".$no;
		if( !is_dir(__FileImage.$path) ){
			mkdir(__FileImage.$path);
		}
		if($files['size'][0]){
			for($i=0; $i<count($files['name']); $i++){
				$type = explode("/",$files['type'][$i])[1];
				$name = $files['name'][$i];
				$tmp_name = $files['tmp_name'][$i];
				DB::exec("INSERT INTO files SET fidx=?, name=?",[
					htmlspecialchars($idx),
					htmlspecialchars($i.".".$type)
				]);
				move_uploaded_file($tmp_name,"../../festivalImages/$path/$i.$type");
			}
		}
		move("/festival");
	}
	function Update($data){
		$data = dataCheck($data);
		$idx = $data[0];
		$row = self::getFestival($idx);
		$path = $row->sn."_".$row->no;
		trimCheck($_POST);
		$files = $_FILES['file'];
		extract($_POST);
		self::dateCheck($date);
		DB::exec("UPDATE festivals SET name=?,area=?,location=?,date=? WHERE idx = $idx",[
			htmlspecialchars($title),
			htmlspecialchars($area),
			htmlspecialchars($location),
			htmlspecialchars($date)
		]);
		if( isset($check) ){ // 이미지 지우기
			foreach ($check as $key => $v) {
				$row = DB::fetch("SELECT * FROM files where idx = $v",[]);
				unlink(__FileImage."$path/".$row->name);
				DB::exec("DELETE FROM files WHERE idx = $v",[]);
			}
		}
		if($files['size'][0]){ 
			$len = count($files['name']);
			$num = 0;
			$i = 0;
			while($len > $i){
				$type = explode("/",$files['type'][$num])[1];
				if( is_file(__FileImage."$path/$i.$type") ){ // 이미지 있는지 체크 
					$len++;
					$i++;
					continue;
				}
				$name = $files['name'][$num];
				$tmp_name = $files['tmp_name'][$num];
				DB::exec("INSERT INTO files SET fidx=?, name=?",[
					htmlspecialchars($idx),
					htmlspecialchars($i.".".$type)
				]);
				move_uploaded_file($tmp_name,__FileImage."/$path/$i.$type");
				$i++;
				$num++;
			}
		}
		move("/festival");
	}
	// Setting
	function getFestival($idx){
		$row = DB::fetch("SELECT * FROM festival_view WHERE idx = $idx",[]);
		if( $row ){
			return $row;
		}else{
			back("존재하지 않는 게시글입니다.");
		}
	}
	function getFile($fidx){
		$row = DB::fetchAll("SELECT * FROM files WHERE fidx = $fidx order by idx asc",[]);
		return $row;
	}
	function getComment($fidx){
		$row = DB::fetchAll("SELECT * FROM comments WHERE fidx = $fidx order by idx desc",[]);
		return $row;
	}
	function dateCheck($date){
		if(!preg_match("/^([0-9]{4}(-[0-9]{2}){2} ~ [0-9]{4}(-[0-9]{2}){2})$/",$date)){
			back("축제 기간의 입력 형식을 지켜주세요.");
		}
		$dateArr = explode("~", $date);
		$dateArr[0] = trim($dateArr[0]);
		$dateArr[1] = trim($dateArr[1]);
		foreach ($dateArr as $key => $v) {
			if( !dateCheck($v) ){
				back("날짜 값이 올바르지 않습니다.");
			}
		}
		if( !($dateArr[0] <= $dateArr[1]) ){
			back("시작일이 종료일보다 늦게 될수 없습니다.");
		}
	}
}