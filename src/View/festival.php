<section id="festival">
	<div class="container">
		<h2>전북축제</h2>
		<?php if( ss() ): ?>
			<a class="btn" href="/festival_insert">축제등록</a>
		<?php endif ?>
		<table class="table">
			<thead>
				<tr>
					<th>번호</th>
					<th>축제명(사진)</th>
					<th>다운로드</th>
					<th>기간</th>
					<th>장소</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($view as $key => $v): ?>
					<tr>
						<td <?= ss() ? "onClick='location.replace(`/festival_modify/$v->idx`);'" : "" ?> ><?= $v->no ?></td>
						<td class="text-left"><?= $v->name ?><span class="light"><?= $v->len ?></span></td>
						<td>
							<a class="btn" href="/download/tar/<?= $v->idx ?>/<?= $v->sn ?>_<?= $v->no ?>">tar</a>
							<a class="btn" href="/download/zip/<?= $v->idx ?>/<?= $v->sn ?>_<?= $v->no ?>">zip</a>
						</td>
						<td><?= $v->date ?></td>
						<td><?= $v->area ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
		<div class="pagenation flex">
			<a class="arrow btn <?= $idx == 0 ? "hidden" : "" ?>" href="/festival/<?= $idx ?>"> < </a>
			<div class="nation-list">
				<?php for($i=0; $i<$page; $i++): ?>
					<a <?= $i == $idx ? "class='active'" : "" ?> href="/festival/<?= $i+1 ?>"><?= $i+1 ?></a>
				<?php endfor ?>
			</div>
			<a class="arrow btn <?= $idx == $page-1 ? "hidden" : "" ?>" href="/festival/<?= $idx+2 ?>"> > </a>
		</div>
	</div>
</section>