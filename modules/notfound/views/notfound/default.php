<?php
  // header('Location:'.URL_ROOT, true, 301);
//  exit();
?>
<div>
  <br/><br/>
	<center><img class="img-responsive" src="<?php echo URL_ROOT.'images/404.png';?>" style="margin: 0px auto;">
  </center>
  <br/><br/>
</div>
<script>
setTimeout(function () {
   window.location.href = "/"; //will redirect to your blog page (an ex: blog.html)
}, 3000); //will call the function after 2 secs.
</script>	