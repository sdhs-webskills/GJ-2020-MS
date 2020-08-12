<?php 
use src\Core\Route;
Route::reg([
	['get','/@View@main'],
	['get','/login@View@login'],
	['post','/user/login@User@login'],
	['get','/festival@View@festival'],
	['get','/festival/:idx@View@festival'],
	['get','/download/:type/:fidx/:path@View@download'],
	['get','/getImage/:folder/:name@View@Image']
]);
$arr = [];
if( ss() ){
	$arr[] = ['get',"/user/logout@User@logout"];
	$arr[] = ['get',"/festival_insert@View@festival_insert"];
	$arr[] = ['get',"/festival_modify/:idx@View@festival_modify"];
	$arr[] = ['post',"/festival_insert@Festival@insert"];
	$arr[] = ['post',"/festival_modify/:idx@Festival@modify"];
}
Route::reg($arr);