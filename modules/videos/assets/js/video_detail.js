$(document).ready( function(){
	run_video();
});
function run_video(){
		var video = $('#video_link').val();
		var img = $('#img_link').val();
		jwplayer("video_first_area_player").setup({
	        file: video,
	        image: img,
	        width: "100%",
	        aspectratio: "16:10"
	    });
}
