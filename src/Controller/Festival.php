<?php 
namespace src\Controller;
use src\Core\DB;
class Festival
{
	function insert(){
		trimCheck($_POST);
		extract($_POST);
		$files = $_FILES['file'];
		$no = DB::fetch("SELECT no FROM festivals order by idx desc limit 1",[])->no+1;
		if(!preg_match("/^([0-9]{4}(-[0-9]{2}){2} ~ [0-9]{4}(-[0-9]{2}){2})$/",$date)){
			back("축제 기간의 입력 형식을 지켜주세요.");
		}
		imageCheck($files);
		DB::exec("INSERT INTO festivals SET no=?,name=?,area=?,location=?,date=?",[$no,$title,$area,$location,$date]);
		$idx = DB::last();
		$sn = str_pad($idx,3,"0",STR_PAD_LEFT);
		$path = $sn."_".$no;
		if( !is_dir("../../festivalImages/$path") ){
			mkdir("../../festivalImages/$path");
		}
		if($files['size'][0]){
			for($i=0; $i<count($files['name']); $i++){
				$type = explode("/",$files['type'][$i])[1];
				$name = $files['name'][$i];
				$tmp_name = $files['tmp_name'][$i];
				DB::exec("INSERT INTO files SET fidx=?, name=?",[$idx,$i.".".$type]);
				move_uploaded_file($tmp_name,"../../festivalImages/$path/$i.$type");
			}
		}
		move("/festival");
	}
	function modify($data){
		$idx = $data[1];
		$row = DB::fetch("SELECT *FROM festival_view WHERE idx = $idx",[]);		
		if( !$row ){
			back("존재하지 않는 게시글입니다.");
		}
		$path = $row->sn."_".$row->no;
		trimCheck($_POST);
		$files = $_FILES['file'];
		extract($_POST);
		if(!preg_match("/^([0-9]{4}(-[0-9]{2}){2} ~ [0-9]{4}(-[0-9]{2}){2})$/",$date)){
			back("축제 기간의 입력 형식을 지켜주세요.");
		}
		DB::exec("UPDATE festivals SET name=?,area=?,location=?,date=? WHERE idx = $idx",[$title,$area,$location,$date]);
		if( isset($check) ){
			foreach ($check as $key => $v) {
				$row = DB::fetch("SELECT * FROM files where idx = $v",[]);
				unlink("../../festivalImages/$path/".$row->name);
				DB::exec("DELETE FROM files WHERE idx = $v",[]);
			}
		}
		if($files['size'][0]){
			$len = count($files['name']);
			$num = 0;
			$i = 0;
			while($len > $i){
				echo "#!";
				$type = explode("/",$files['type'][$num])[1];
				if( is_file("../../festivalImages/$path/$i.$type") ){
					$len++;
					$i++;
					continue;
				}
				$name = $files['name'][$num];
				$tmp_name = $files['tmp_name'][$num];
				DB::exec("INSERT INTO files SET fidx=?, name=?",[$idx,$i.".".$type]);
				move_uploaded_file($tmp_name,"../../festivalImages/$path/$i.$type");
				$i++;
				$num++;
			}
		}
		move("/festival");
	}
}