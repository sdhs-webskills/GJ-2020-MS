<section id="festival_calendar">
	<div class="container">
		<div id="date-wrap" class="flex">
			<div class="todayBtn">이번달</div>
			<div class="flex">
				<button class="calendarBtn next">이전달</button>
				<span class="today"></span>
				<button class="calendarBtn prev">다음달</button>
			</div>
			<a href="/festival">축제관리</a>
		</div>
		<table id="calendar-wrap">
			<thead>
				<tr>
					<th>SUN</th>
					<th>MON</th>
					<th>TUE</th>
					<th>WED</th>
					<th>THU</th>
					<th>FRI</th>
					<th>SAT</th>
				</tr>
			</thead>
			<tbody id="calendar">
				
			</tbody>
		</table>
	</div>
</section>
<script>
	const datas = <?= json_encode($view) ?>
</script>
<script src="/js/calendar.js"></script>