$(document).ready(function() {

	var maxheight=0;
	console.log($('#dashleft').height());
	if($('#dashleft').height()>maxheight) maxheight=$('#dashleft').height();
	if($('#dashmiddle').height()>maxheight) maxheight=$('#dashmiddle').height();
	if($('#dashright').height()>maxheight) maxheight=$('#dashright').height();
	var minheight=$(document).height();
	if(maxheight<minheight)maxheight=minheight;
	$('#dashleft').css({
		'height':maxheight
	});
	$('#dashmiddle').css({
		'height':maxheight
	});
	$('#dashright').css({
		'height':maxheight
	});
	/*
	maxheight-=52;
	$('.rightlist').css({
		'height':maxheight
	});*/

	console.log(maxheight);
	$('.showorder').click(function(){
		var classes = $(this).attr('class').split(" ");
		var theclass=".ordertext";
		theclass+=classes[0].substr(5);
		console.log(theclass);
		$(theclass).css({
			'display':'block'
		});
	});
	$(".ordertext").click(function(){
		$(this).hide();
	});


});
