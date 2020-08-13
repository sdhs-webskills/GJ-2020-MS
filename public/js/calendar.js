let calendar = $("#calendar")[0],
today = new Date(),
date = new Date(today);
// setting 
datas.map( data => {
	let date = data.date.split("~").map( date => date.trim() );
	data.date = date;
	return data;
})
.filter( data => data.date.length == 2 )
.map( data => {
	let year = data.date[0].substr(0,4);
	if( data.date[1].length == 5 ){
		 data.date[1] = year+"."+data.date[1]
	}
	data.date = data.date.map( date => new Date(date) );
	return data;
} );

function init(){ // init
	BuildCalendar();
	Event();
}
function Event(){ // Event
	$(document)
	.on("click",".calendarBtn",function(){ // 월 변경
		let month = date.getMonth();
		month += $(this).is(".next") ? -1 : 1;
		date.setMonth(month);
		BuildCalendar();
	})
	.on("click",".todayBtn",function(){ // 현째 날짜로 돌아가기
		date = new Date(today);
		BuildCalendar();
	})
}
function BuildCalendar(){ // BuildCalendar
	$(calendar).empty(); // 초기화 
	let
	max = 42,
	cut = 1,
	row = calendar.insertRow(),
	prevMonthDate = new Date(date.getFullYear(),date.getMonth(),0),
	LastDate = new Date(date.getFullYear(),date.getMonth()+1,0).getDate();
	$(".today").html(date.getFullYear()+"년"+(date.getMonth()+1)+"월")
	if( prevMonthDate.getDay() != 6 ){
		for(let prevDay = prevMonthDate.getDate()-date.getDay(); prevDay<=prevMonthDate.getDate(); prevDay++,cut++){ // 이전달 날짜 생성
			let cell = row.insertCell();
		}
	}
	for(let Day = 1; Day<=LastDate; Day++,cut++){ // 이번달 날짜 생성
		let 
		cell = row.insertCell(),
		cDate = new Date(date.getFullYear(),date.getMonth(),Day);
		if( cut%7 == 0 ) row = calendar.insertRow();
		$(cell).attr("data-day",Day);
		if( date.getFullYear() == today.getFullYear() && date.getMonth() == today.getMonth() && Day == today.getDate() ){
			$(cell).addClass("high").attr("data-day",`Today - ${Day}`);
		}
		datas.filter( data => data.date[0] <= cDate && cDate <= data.date[1] ).forEach( data => {
			console.log(data);
			$(cell).append(`<p><a href="/festival/info/${data.idx}">${data.name}</a></p>`)
		} )
	}
	for(let nextDay = 1; cut<=max; nextDay++,cut++){ // 다음달 날짜 생성
		let cell = row.insertCell();
		if( cut%7 == 0 ) row = calendar.insertRow();
	}
}
init();