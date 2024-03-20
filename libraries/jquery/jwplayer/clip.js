	videoclip(1);
	$('.video-list').click(function(){
		var number=$(this).attr('title');
		videoclip(number);
	});
	function videoclip(number){
		var lk = $('#video-number-'+number).attr('rel');
		var image=$('#video-number-'+number).attr('lang');
		$('.list-video-estore a').css({'font-weight':'normal'});
		$('#video-number-'+number+' a').css({'font-weight':'bold'});
		var sFlashPlayer28695 = new SWFObject("/libraries/jquery/jwplayer/mediaplayer.swf","playlist","297","243","7");
		sFlashPlayer28695.addParam("allowfullscreen","true");
		sFlashPlayer28695.addParam("wmode","transparent");
		sFlashPlayer28695.addVariable("file",lk);
		sFlashPlayer28695.addVariable("image",image);
		sFlashPlayer28695.addVariable("skin",root+"/libraries/jquery/jwplayer/glow/glow.xml");
		sFlashPlayer28695.addVariable("displayheight","420");
		sFlashPlayer28695.addVariable("width","297");
		sFlashPlayer28695.addVariable("height","243");
		sFlashPlayer28695.addVariable("backcolor","0x00000 0");
		sFlashPlayer28695.addVariable("frontcolor","0xCCCC CC");
		sFlashPlayer28695.addVariable("lightcolor","0x5577 22");
		sFlashPlayer28695.addVariable("shuffle","false");
		sFlashPlayer28695.addVariable("repeat","list");
		sFlashPlayer28695.write("FlashPlayer28695");
	};
	

	
		
	