<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#"
	xmlns:fb="https://www.facebook.com/2008/fbml" itemscope="itemscope"
	itemtype="http://schema.org/WebPage" xml:lang="vi-vn" lang="vi-vn">
<head id="Head1"
	prefix="og: http://ogp.me/ns# fb:http://ogp.me/ns/fb# article:http://ogp.me/ns/article#">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
	.wrapper {
	    margin: 0 auto;
	    max-width: 100%;
	    width: 1000px;
	}
	a {
	    color: #0237a5;
	    text-decoration: none;
	}	
	.parent {
	    margin-top: 20px;
	}
	
	.children {
	    margin-left: 20px;
	    margin-top: 4px;
	}
</style>
</head>
<body>
<div class='wrapper'>
<h2>Các kênh tin RSS</h2>
<br/>
<h3>RSS là gì?</h3>
<div>
	<p>RSS (Really Simple Syndication) Dịch vụ cung cấp thông tin cực kì đơn giản. Dành cho việc phân tán và khai thác nội dung thông tin Web từ xa (ví dụ như các tiêu đề, tin tức). Sử dụng RSS, các nhà cung cấp nội dung Web có thể dễ dàng tạo và phổ biến các nguồn dữ liệu ví dụ như các link tin tức, tiêu đề, và tóm tắt.
	</p>
	<p>
		Một cách sử dụng nguồn kênh tin RSS được nhiều người ưa thích là kết hợp nội dung vào các nhật trình Web (weblogs, hay "blogs"). Blogs là những trang web mang tính các nhân và bao gồm các mẩu tin và liên kết ngắn, thường xuyên cập nhật.
	</p>	
</div>
<h3>Danh mục tin RSS</h3>
<div>
	<p>RSS (Really Simple Syndication) Dịch vụ cung cấp thông tin cực kì đơn giản. Dành cho việc phân tán và khai thác nội dung thông tin Web từ xa (ví dụ như các tiêu đề, tin tức). Sử dụng RSS, các nhà cung cấp nội dung Web có thể dễ dàng tạo và phổ biến các nguồn dữ liệu ví dụ như các link tin tức, tiêu đề, và tóm tắt.
	</p>
	<p>
		Một cách sử dụng nguồn kênh tin RSS được nhiều người ưa thích là kết hợp nội dung vào các nhật trình Web (weblogs, hay "blogs"). Blogs là những trang web mang tính các nhân và bao gồm các mẩu tin và liên kết ngắn, thường xuyên cập nhật.
	</p>	
</div>

<?php $link = URL_ROOT.'trangchu.rss'; ?>
<div class='parent'><a href="<?php echo $link; ?>" title="<?php echo 'Trang chủ'; ?>"><strong><?php echo 'Trang chủ' ; ?></strong> (<?php echo $link; ?>)</a>  </div>
<?php foreach($categories as $item){?>
	<?php $link = URL_ROOT.$item -> alias.'.rss'; ?>
	<?php if($item -> parent_id){?>
		<div class='children'><a href="<?php echo $link; ?>" title="<?php echo $item -> name; ?>"><strong><?php echo $item -> name ; ?></strong> (<?php echo $link; ?>)</a> </div>
	<?php }else{?>
		<div class='parent'><a href="<?php echo $link; ?>" title="<?php echo $item -> name; ?>"><strong><?php echo $item -> name ; ?></strong> (<?php echo $link; ?>)</a>  </div>
	<?php }?>
<?php }?>
</div>
<br/>
<br/>
<br/>
</body>