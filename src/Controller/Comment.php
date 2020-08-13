<?php 
namespace src\Controller;
use src\Core\DB;
class Comment
{
	function insert($data){ // insert
		extract($_POST);
		$data  = dataCheck($data);
		$idx = $data[0];
		self::getFestival($idx);
		DB::exec("INSERT INTO comments SET fidx=?,name=?,review=?,rating=?",[
			 htmlspecialchars($idx),
			 htmlspecialchars($name),
			 htmlspecialchars($review),
			 htmlspecialchars($rating)
		]);
		back();
	}
	function delete($data){ // delete
		$data = dataCheck($data);
		$idx = $data[0];
		$row = DB::exec("DELETE FROM comments WHERE idx = ?",[$idx]);
		back();
	}
	function getFestival($idx){ // getFestival
		$row = DB::fetch("SELECT * FROM festival_view WHERE idx = $idx",[]);
		if( $row ){
			return $row;
		}else{
			back("존재하지 않는 게시글에 댓글을 달수 없습니다.");
		}
	}
}