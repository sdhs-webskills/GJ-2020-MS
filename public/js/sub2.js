let json,
scrollData = localStorage.getItem("scroll") || 0;
buttonData = localStorage.getItem("button") || false;
const init = async _ => {
	window.scrollTo(0,scrollData);
	json = await fetch("/restAPI/currentExchangeRate.php").then( v => v.json());
	if( json.statusCd != 200 ){
		return $("#sub2").html(json.statusMsg);
	}
	if( buttonData ){
		listAll();
	}else{
		$(".list").html([...json.items].splice(0,10).map( ({bkpr,cur_nm,cur_unit,deal_bas_r,kftc_bkpr,kftc_deal_bas_r,result,ten_dd_efee_r,ttb,tts,yy_efee_r}) => `
			<tr ${ result == 0 ? "class=active" : "" }>
			<td>${result}</td>
			<td>${cur_unit}</td>
			<td>${ttb}</td>
			<td>${tts}</td>
			<td>${deal_bas_r}</td>
			<td>${bkpr}</td>
			<td>${yy_efee_r}</td>
			<td>${ten_dd_efee_r}</td>
			<td>${kftc_bkpr}</td>
			<td>${kftc_deal_bas_r}</td>
			<td>${cur_nm}</td>
			</tr>
			` ));
	}
	event();
}
function event(){
	$(document)
	.on("scroll",function(){
		setScroll();
		if( $(document).height() == window.scrollY+window.innerHeight ){
			listAll();
		}
	})
	.on("click",".open",function(){
		listAll();
		localStorage.setItem("button",true);
	})	
}
function listAll(){
	$(".list").html([...json.items].map( ({bkpr,cur_nm,cur_unit,deal_bas_r,kftc_bkpr,kftc_deal_bas_r,result,ten_dd_efee_r,ttb,tts,yy_efee_r}) => `
		<tr ${ result == 0 ? "class=active" : "" }>
		<td>${result}</td>
		<td>${cur_unit}</td>
		<td>${ttb}</td>
		<td>${tts}</td>
		<td>${deal_bas_r}</td>
		<td>${bkpr}</td>
		<td>${yy_efee_r}</td>
		<td>${ten_dd_efee_r}</td>
		<td>${kftc_bkpr}</td>
		<td>${kftc_deal_bas_r}</td>
		<td>${cur_nm}</td>
		</tr>
		` ));
}
function setScroll(){
	console.log(window.scrollY,"#1");
	localStorage.setItem("scroll",window.scrollY);
}
init();