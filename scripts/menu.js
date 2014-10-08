$().ready(function(){
	$('.menu li').hover(
		function(){$('ul', this).css({display:"none"}).stop().slideDown('fast');}
		,function(){$('ul',this).css({display:"block"}).stop().slideUp('fast');}
	);
	$('.menu li li a').css( {backgroundColor: "rgb(0, 52, 78)", color:"#00A5BD"} ).hover(
		function(){
			$(this).stop().animate({backgroundColor: "rgb(50, 102, 156)", color:"White"}, 250);
		},
		function(){
			$(this).stop().animate({backgroundColor: "rgb(0, 52, 78)", color:"#00A5BD"}, 250);
		}
	);
});
