<section id="festival_modify" class="festival_crud">
	<div class="container">
		<form action="/festival_modify/<?= $view->idx ?>" method="post" enctype="multipart/form-data">
			<h2>축제관리</h2>
			<div class="row">
				<p>축제명</p>
				<input type="text" name="title" value="<?= $view->name ?>" required>
			</div>
			<div class="row-wrap flex">
				<div class="row">
					<p>지역</p>
					<input type="text" name="area" value="<?= $view->area ?>" required>
				</div>
				<div class="row">
					<p>기간</p>
					<input type="text" name="date" required value="<?= $view->date ?>" placeholder="yyyy-mm-dd ~ yyyy-mm-dd">
				</div>
			</div>
			<div class="row">
				<p>장소</p>
				<input type="text" name="location" value="<?= $view->location ?>" required>
			</div>
			<div class="row">
				<div class="img-container flex">
					<?php foreach ($files as $key => $file):?>
						<div class="img-box">
							<img src="/getImage/<?= $view->sn ?>_<?= $view->no ?>/<?= $file->name ?>" alt="#">
							<input type="checkbox" name="check[]" value="<?= $file->idx ?>" >
						</div>
					<?php endforeach ?>
				</div>
				<p class="con">체크한 이미지는 수정시 사라집니다.</p>
			</div>
			<div class="row">
				<p>축제 사진</p>
				<input type="file" multiple name="file[]" accept="image/*">
			</div> 
			<button>수정하기</button>
		</div>
	</form>
</section>