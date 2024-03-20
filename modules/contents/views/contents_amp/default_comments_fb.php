<!-- COMMENT	-->
<div class="fb-comments" data-href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL']; ?>" data-numposts="5" data-width="100%" data-colorscheme="light"></div>

<input type="hidden" value="<?php echo $data->id; ?>" name='data_id' id='data_id'  />
<input type="hidden" value="<?php echo base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL']); ?>" name='data_url' id='data_url'  />
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&appId=814458511908640&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>	
   <!-- Bình luận   -->