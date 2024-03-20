function POSTAjax(n, t, i, r, u, f) {
  $.ajax({
    async: f,
    url: n,
    data: t,
    type: "POST",
    cache: !1,
    beforeSend: function() {
      i()
    },
    success: function(n) {
      r(n)
    },
    error: function() {
      u()
    }
  })
}
gl_lFT = !1;
var gl_CurrColor = 0;

function gotoGallery(n, t, nth, cid) {
  $('.menu-tab .item').removeClass('active');
  $('.menu-tab .item_'+n+'_'+cid).addClass('active');

  is_mobile = $('#is_mobile').val();
  if(is_mobile) {
    popup_gallery_full(n,cid);
  } else {
   n == -1 ? (gl_CurrColor = 0, $(".tabscolor li").first().click()) : n == 1 ? (gl_CurrColor = t, popup_gallery(1,nth,cid)) : popup_gallery(n,nth,cid);
 }

}

function popup_gallery_full(n,cid){
  productID = $('#product_id').val();
  $.ajax({
    url: '/index.php?module=products&view=product&task=gotoSlide&raw=1',
    type : 'POST',
    data: {group_id: cid,productID:productID,type:n },
    cache: false,
    success: function(html){
      $(".popup-content-0").html(html);

      $('.tabs-popup').removeClass('hide');

      $('.tab-popup-content').removeClass('hide');
      $('.popup-content').addClass('hide');
      

      $('body').addClass('overflow-hidden');
      $('.popup-content-0').removeClass('hide');
    }
  })
}


function popup_gallery(n, nth, cid) {

	// console.log(nth);
  if (gl_lFT) {
    var t = {
      productID: $('#product_id').val(),
      imageType: n,
      colorID: gl_CurrColor,
      cid : cid
    };
    POSTAjax("/index.php?module=products&view=product&raw=1&task=popup_gallery", t, function() {}, function(n) {
      if (n != null || n != "") try {
        if (n != null && n != "") {

          $('.tabs-popup').removeClass('hide');
          $('.tab-popup-content').addClass('hide');
          $('.popup-content').addClass('hide');
          $(".slide_FT").html(n);

          // return false;
          close_popup_video();


          gl_CurrColor = 0;
          $("#ajxgallery").remove();
          // $("body").toggleClass("fixbody");
          // $("body").removeClass("fixbody");
          var t = 0,
          i = !1;
          var $fotoramaDiv = $(".fotorama").on("fotorama:show fotorama:load fotorama:fullscreenexit fotorama:fullscreenenter", function(n, r) {
            var f, u;
            $(".caption_ps").hide();
            i || (r.show(0), r.requestFullScreen(), i = !0);
            (n.type == "fotorama:show" || n.type == "fotorama:fullscreenenter") && (f = r.activeFrame.i, (t == 1 || f > 0) && (t = 1, u = $(r.activeFrame.html).find(".fb-like"), u != undefined && setTimeout(function() {
              var n = u.data("url");
              u.replaceWith('<iframe class="like" src="//www.facebook.com/plugins/like.php?href=' + n + '&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=true&amp;height=20&amp;appId=459645584142044" scrolling="no" frameborder="0" style="border:none;overflow:hidden; width:100%;height:20px;" allowTransparency="true"><\/iframe>');
              $(".caption_ps").show()
            }, 1e3)));
            n.type == "fotorama:load" && setTimeout(function() {
              $("div.caption_ps").each(function() {
                var n = $(this).parent().parent().find("img").width() + 2;
                $(this).width(n).fadeIn(300)
              })
            }, 100);
            n.type == "fotorama:fullscreenexit" && ($("body").click(), $("body").css("background-color", "#f6f6f6"), $("body").removeAttr("background-color"), r.destroy(), $(".slide_FT").html(""))
          }).on("fotorama:show", function (n, t) {

            $(".fotorama__html").on("click", function (){
                             // $("body").removeClass('fullscreen');
                             // $("html").removeClass('fullscreen');
                             // $(".fotorama ").hide();
                           });
                        // alert(11);
                      }).fotorama();
          var fotorama = $fotoramaDiv.data('fotorama');
          fotorama.show(nth);
        }
      } catch (r) {} else $(".slide_FT").html("")
    }, function() {}, !0)
  } else $.getScript("/libraries/jquery/fotorama-4.6.4/fotorama.js").done(function() {
    gl_lFT = !0;
    popup_gallery(n,nth,cid)
  })
}

$('.inner-close-tabs-popup').click(function(){
 $("body").removeClass('fullscreen');
 $("html").removeClass('fullscreen');
 $(".fotorama").hide();
 $('.tabs-popup').addClass('hide');
 $('body').removeClass('overflow-hidden');
 $('.tab-popup-content').addClass('hide');
 $('.popup-content').addClass('hide');

 close_popup_video();


})

function close_popup_video(){
 $('.video_popup .video_item_inner_has_img').removeClass('hide');
 $('.video_item_inner_has_yt').html('');
 $('.video_item_inner_has_yt').removeClass('hide');
}

$('.menu-tab .item').click(function(){
  $('.menu-tab .item').removeClass('active');
  $(this).addClass('active');
})