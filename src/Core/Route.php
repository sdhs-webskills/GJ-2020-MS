<?php 
namespace src\Core;
class Route
{
	static $POST = [];
	static $GET = [];
	static function init(){
		$get = isset($_GET['url']) ? '/'.$_GET['url'] : '/';
		foreach (self::${$_SERVER['REQUEST_METHOD']} as $key => $v) {
			$v = explode("@", $v);
			$reg = preg_replace("/:([^\/])+/","([^/]+)", $v[0]);
			$reg = preg_replace("/\//","\\/",$reg);
			$reg = "/^".$reg."$/";			
			if( preg_match($reg,$get,$r) ){
				$src = "src\\Controller\\$v[1]";
				$src = new $src();
				$src->{$v[2]}($r);
				exit;
			}
		}
	}
	static function reg($arr){
		foreach ($arr as $key => $v) {
			self::${strtoupper($v[0])}[] = $v[1];
		}
	}
}