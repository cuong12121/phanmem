// var myVideo = document.getElementById("video"); 
// alert(myVideo);
function playPause(id) {
	var myVideo = document.getElementById("video_"+id); 
	//alert(myVideo);
  if (myVideo.paused) 
    myVideo.play(); 
  else 
    myVideo.pause(); 
};

a();
function a(){
	// alert('dd');
	if( $('#bl_video').hasClass("hello") ){
		
		$('#bl_video .btn_play_pause').trigger(click);
	}
}