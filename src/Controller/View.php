<?php
namespace src\Controller;
use src\Core\DB;
class View
{
	function main(){ // main
		view("main",[]);
	}
	function login(){ // login
		view("login",[]);
	}
	function Image($data){ // Image
		$folder = $data[1];
		$name = $data[2];
		$path = __FileImage.$folder."/".$name;
		getImage($path);
	}
	function download($data){ // download
		$type = $data[1];
		$fidx = $data[2];
		$path = "festivalImages/".$data[3];
		download($type,$path,$fidx);
	}
}