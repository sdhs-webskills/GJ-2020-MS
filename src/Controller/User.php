<?php
namespace src\Controller;
use src\Core\DB;
class User
{
	function login(){
		$id = htmlspecialchars($_POST['id']);
		$pw = htmlspecialchars($_POST['password']);
		$row = DB::fetch("SELECT * FROM users WHERE id = ? AND password = PASSWORD(?)  ",[$id,$pw]);
		if( $row ){
			$_SESSION['user'] = $row;
			move("/");
		}else{
			back("아이디 또는 비밀번호가 일치하지 않습니다.");
		}

	}
	function logout(){
		unset($_SESSION['user']);
		move("/","로그아웃되었습니다.");
	}
}