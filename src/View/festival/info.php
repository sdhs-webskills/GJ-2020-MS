<section id="festival_view">
	<div class="container">
		<h2>축제 상세 정보</h2>
		<div class="head">
			<h3><?= $view->name ?></h3>
			<div class="flex">
				<img src="/getImage/<?= $view->sn."_".$view->no."/".$files[0]->name ?>" alt="">
				<div>
					<p><?= $view->content ?></p>
					<p><span class="btn">지역</span><?= $view->area ?></p>
					<p><span class="btn">장소</span><?= $view->location ?></p>
					<p><span class="btn">기간</span><?= $view->date ?></p>
				</div>
			</div>
			<div class="img-wrap grid">
				<?php foreach ($files as $idx => $v):?>
					<div class="img-box">
						<img src="/getImage/<?= $view->sn."_".$view->no."/".$v->name ?>" alt="">
					</div>
				<?php endforeach ?>
			</div>
		</div>
		<button class="btn open">후기 등록</button>
		<div class="comment">
			<?php foreach ($comments as $key => $comment):?>
				<div class="clear">
					<p><strong><?= $comment->name ?></strong> <span><?= $comment->rating ?></span></p>
					<p><?= $comment->review ?></p>
					<?php if( ss()): ?>
						<a class="right" href="/comment/<?= $comment->idx ?>"><button class="btn">삭제</button></a>
					<?php endif ?>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</section>
<dialog id="comment" class="fcenter" open>
	<form class='clear' action="/comment/<?= $view->idx ?>" method="post">
		<h3>후기등록</h3>
		<div class="row-wrap flex">
			<div class="row">
				<p>이름</p>
				<input type="text" name="name" required>
			</div>
			<div class="row">
				<p>별점</p>
				<input type="number" name="rating" min="1" max="5" value="1" required>
			</div>
		</div>
		<div class="row">
			<p>후기</p>
			<input type="text" name="review" required>
		</div>
		<button class="btn sm">저장</button>
		<button class="btn del ">X</button>
	</form>
</dialog>
<script>
	$(document)
	.on("click",'#festival_view .open',function(){
		$("#comment").css({ display:"flex"});
	})
	.on("click","#comment .del",function(){
		$("#comment").css({ display:"none"});
	})
</script>