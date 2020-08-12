<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<title>전북 축제 On!</title>
	<link rel="stylesheet" href="/css/common.css">
</head>
<body>
	<header>
		<div class="header-box">
			<div class="head">
				<div class="container clear">
					<ul class="menu flex right">
						<li><a href="#">전라북도청</a></li>
						<?php if(ss() ): ?>
							<li><a href="/user/logout">로그아웃</a></li>
						<?php else: ?>
						<li><a href="/login">로그인</a></li>
							<li><a href="#">회원가입</a></li>
						<?php endif ?>
						<li>
							<a href="#">언어선택</a>
							<ul class="sub">
								<li>한국어</li>
								<li>English</li>
								<li>中文(简体)</li>
							</ul>
						</li>
					</ul>
				</div>			
			</div>
			<div class="body">
				<div class="container flex">
					<h1 class="logo"><a href="#">전북 축제 On!</a></h1>
					<nav>
						<ul class="menu flex">
							<li><a href="/">HOME</a></li>
							<li><a href="#">전북 대표 축제</a></li>
							<li><a href="/festival">축제 정보</a></li>
							<li><a href="#">축제 일정</a></li>
							<li><a href="sub2.html">환율안내</a></li>
							<li>
								<a href="#">종합지원센터</a>
								<ul class="sub">
									<li><a href="#">- 공지사항</a></li>
									<li><a href="#">- 센터 소개</a></li>
									<li><a href="#">- 관광정보 문의</a></li>
									<li><a href="#">- 공공 데이터 개방</a></li>
									<li><a href="#" class="timeoutBtn">- 찾아오시는 길</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</div>
	</header>