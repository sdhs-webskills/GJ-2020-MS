<?php 
use src\Core\Route;
$arr = [];

// 로그인 상관없음
$arr[] = ['get','/@View@main'];
$arr[] = ['get','/festival@Festival@Main'];
$arr[] = ['get','/festival/:idx@Festival@Main'];
$arr[] = ['get','/festival/info/:idx@Festival@info'];
$arr[] = ['get','/festival/calendar@Festival@calendar'];
$arr[] = ['post','/comment/:idx@Comment@insert'];
$arr[] = ['get','/download/:type/:fidx/:path@View@download'];
$arr[] = ['get','/getImage/:folder/:name@View@Image'];

if( ss() ){ // 로그인 O
	$arr[] = ['get',"/user/logout@User@logout"];
	$arr[] = ['get',"/festival/create@Festival@Create"];
	$arr[] = ['get',"/festival/modify/:idx@Festival@Modify"];
	$arr[] = ['get','/comment/:idx@Comment@delete'];
	$arr[] = ['post',"/festival/insert@Festival@Insert"];
	$arr[] = ['post',"/festival/update/:idx@Festival@Update"];
}else{ // 로그인 X
	$arr[] = ['get','/login@View@login'];
	$arr[] = ['post','/user/login@User@login'];
}

Route::reg($arr);