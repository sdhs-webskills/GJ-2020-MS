<section id="festival_insert" class="festival_crud">
	<div class="container">
		<form action="/festival/insert" method="post" enctype="multipart/form-data">
			<h2>축제관리</h2>
			<div class="row">
				<p>축제명</p>
				<input type="text" name="title" required>
			</div>
			<div class="row-wrap flex">
				<div class="row">
					<p>지역</p>
					<input type="text" name="area" required>
				</div>
				<div class="row">
					<p>기간</p>
					<input type="text" name="date" required placeholder="yyyy-mm-dd ~ yyyy-mm-dd">
				</div>
			</div>
			<div class="row">
				<p>장소</p>
				<input type="text" name="location" required>
			</div>
			<div class="row">
				<p>축제 사진</p>
				<input type="file" multiple name="file[]" accept="image/*">
			</div>
			<button>저장</button>
		</div>
	</form>
</section>