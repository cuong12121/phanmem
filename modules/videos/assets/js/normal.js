$('#one_video_play_area .video_item_inner_has_img').click(function(){
    var img_video = $(this).find('img');
    var link_video = img_video.attr('link-video');
    var video = '<iframe src="'+ link_video +'"></iframe>';
    $(this).html('<iframe src="'+link_video+'?rel=0&autoplay=1" width="100%" height="300" frameborder="0" allowfullscreen="false">');
    $(this).removeClass('video_item_inner_has_img');
});


function reload_video(link_video){
    var video = '<iframe src="'+ link_video +'"></iframe>';
    $('#one_video_play_area .video_item_inner').html('<iframe src="'+link_video+'?rel=0&autoplay=1" width="100%" height="200" frameborder="0" allowfullscreen="false">');
    $('#one_video_play_area .video_item_inner').removeClass('video_item_inner_has_img');
}
