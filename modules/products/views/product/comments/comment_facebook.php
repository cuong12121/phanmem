<div id="fb-root"></div>
<script>
	setTimeout(
		function () {
			loadJsAsync("https://apis.google.com/js/plusone.js", function() {
			});
		}, 5000);
	function loadJsAsync(t, e) {
		var n = document.createElement("script");
		n.type = "text/javascript", n.src = t, n.addEventListener("load", function(t) {
			e(null, t)
		}, !1);
		var a = document.getElementsByTagName("head")[0];
		a.appendChild(n)
	}
	setTimeout( function () { 
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));}, 5000)</script>
		<div class="fb-comments" data-href="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" data-width="100%" data-num-posts="10"></div>
		<!-- <script src="https://apis.google.com/js/plusone.js"></script> -->
		<div class="g-comments" data-href="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" data-width="780" data-first_party_property="BLOGGER" data-view_type="FILTERED_POSTMOD"></div>
		<script type="text/javascript">
			window.___gcfg = {lang: 'vi'};
			setTimeout(
				(function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/platform.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				})(), 5000);

			</script>