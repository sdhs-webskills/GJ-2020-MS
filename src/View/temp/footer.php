	<fotoer></fotoer>
	<dialog id="dialog" open>
		<div class="del">닫기</div>
		<div class="dialog-body"></div>
	</dialog>
	<script src="/js/jquery-3.5.0.min.js"></script>
	<script>
		const timeoutBtn = async _ =>{
			setTimeout(function(){
				let text =  $(".dialog-body").html();
				if( text == "" ){
					$("#dialog").css({ display:"none"})
					return alert("찾아오시는 길을 표시할 수 없습니다.")
				}else{
					$("#dialog").css({display:"block"});
				}
			},1000);
			$(".dialog-body").empty();
			let location = fetch("/location.php").then( v => v.text() ).then( v => $(".dialog-body").html(v) )
		}
		$(document)
		.on("click",".timeoutBtn",timeoutBtn)
		.on("click","#dialog .del",function(){
			$("#dialog").css({ display:"none"})
		})
	</script>
</body>
</html>