jwplayer.key="XCQDI/1a2ywt0+eCRMvnQ6q+Hu1NkISV4K06Fw==";
$(document).ready( function(){
	run_video();
});
function run_video(){
	var video = $('#video_link').val();
	var img = $('#img_link').val();
	jwplayer("news_video_area_player").setup({
		file: video,
		image: img,
		width: "100%",
		aspectratio: "16:9",
		'modes': [
	        {
	          type: 'html5',
	          config: {
		           'file': video,
		           'provider': 'video'
	          }
	        },
//	        {type: 'flash', src: '/libraries/jquery/jwplayer_6.8/jwplayer.flash.swf'} 
        ],
	});
}


