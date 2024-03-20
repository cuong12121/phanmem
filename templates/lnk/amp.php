<?php $Itemid = FSInput::get('Itemid',1,'int');
$link = $_SERVER['REQUEST_URI'];
$link = URL_ROOT.str_replace('.amp','.html',$link);
$tmpl -> addStylesheet('amp');
global $config;
?>

<div class='header_wrapper_wrap'>
	<div class='header_wrapper'>
		
		<div class='header container cls' id="header_inner">
			<div class="header-l">
				<?php if($Itemid == 1){?><h1><?php }?>
				<a href="<?php echo URL_ROOT;?>" title="<?php echo $config['site_name']?>" class='logo' rel="home" >
					<svg class="logo_img_small" height="30px" xmlns="http://www.w3.org/2000/svg" id="a169d186-d2e2-46c4-a424-2c62edc5ef71" data-name="Layer 1" viewBox="0 0 2271.66 442.97"><path d="M-2316.61,58c-173.3,0-231.6,57.54-231.6,221.48S-2489.91,501-2316.61,501-2085,443.49-2085,277.07C-2085,115.53-2143.27,58-2316.61,58ZM-2337.42,195a5.1,5.1,0,0,1,5.14-5.06h34.75a5.1,5.1,0,0,1,5.14,5.06V319.82a5.1,5.1,0,0,1-5.14,5.07h-34.75a5.1,5.1,0,0,1-5.14-5.07Zm45,184.83h-125.81c-5.39-.88-9.35-2.94-9.73-8.33V189.91h45.32V343.38h90.22Zm71.9.78c-3.13,0-11.57-1.3-14.81-8.08l-32.55-70.75a40.17,40.17,0,0,1,0-32.45c3.72-8.68,23.21-50.63,28.93-69.8,2.17-6.11,9.38-9.27,15.3-8.79h40.86l-44.14,88.71L-2176,380.58Z" transform="translate(2548.21 -58.03)" style="fill:#fff"/><path d="M-1731.94,178.13-1836.12,437.3A13.85,13.85,0,0,1-1849,446h-51.26a13.83,13.83,0,0,1-12.85-8.69l-103.83-259.16h67.35a13.86,13.86,0,0,1,12.9,8.81l64.75,165.68,66.15-165.78a13.84,13.84,0,0,1,12.85-8.71Z" transform="translate(2548.21 -58.03)" style="fill:#fff"/><path d="M-1707.4,178.13h51.4a9.83,9.83,0,0,1,9.83,9.83V436.15A9.83,9.83,0,0,1-1656,446h-51.4a9.83,9.83,0,0,1-9.83-9.83V188A9.83,9.83,0,0,1-1707.4,178.13Z" transform="translate(2548.21 -58.03)" style="fill:#fff"/><path d="M-1356.54,186.26v251.6a8.13,8.13,0,0,1-8.13,8.12h-46.4a8.12,8.12,0,0,1-6.41-3.14l-108.46-139.58v134.6a8.13,8.13,0,0,1-8.13,8.12h-53.37a8.13,8.13,0,0,1-8.13-8.12V186.26a8.13,8.13,0,0,1,8.13-8.13h46.4a8.13,8.13,0,0,1,6.41,3.14l108.46,139.59V186.26a8.13,8.13,0,0,1,8.13-8.13h53.37A8.13,8.13,0,0,1-1356.54,186.26Z" transform="translate(2548.21 -58.03)" style="fill:#fff"/><path d="M-1146.47,393.94h-89.24a12.3,12.3,0,0,0-11.51,7.94L-1260.93,438a12.32,12.32,0,0,1-11.51,7.94h-64l107.75-260.25a12.3,12.3,0,0,1,11.37-7.6h53.55a12.31,12.31,0,0,1,11.36,7.59L-1044.3,446h-65.44a12.32,12.32,0,0,1-11.51-7.94L-1135,401.88A12.3,12.3,0,0,0-1146.47,393.94Zm-12.32-55.86-32.3-85.71-32.3,85.71Z" transform="translate(2548.21 -58.03)" style="fill:#fff"/><path d="M-1011.9,178.13h46.45a12.31,12.31,0,0,1,12.31,12.31V385.91h107.56a12.31,12.31,0,0,1,12.31,12.3v35.47A12.31,12.31,0,0,1-845.58,446H-1011.9a12.3,12.3,0,0,1-12.3-12.3V190.44A12.31,12.31,0,0,1-1011.9,178.13Z" transform="translate(2548.21 -58.03)" style="fill:#fff"/><path d="M-566.25,190.44V433.68A12.31,12.31,0,0,1-578.56,446h-40.17a12.3,12.3,0,0,1-9.72-4.75l-107.2-138V433.68A12.31,12.31,0,0,1-748,446h-45a12.31,12.31,0,0,1-12.31-12.3V190.44A12.31,12.31,0,0,1-793,178.13h40.17a12.33,12.33,0,0,1,9.72,4.76l107.2,138V190.44a12.31,12.31,0,0,1,12.31-12.31h45A12.31,12.31,0,0,1-566.25,190.44Z" transform="translate(2548.21 -58.03)" style="fill:#fff"/><path d="M-419.11,348.79-445.66,379v54.66A12.31,12.31,0,0,1-458,446H-503.7A12.31,12.31,0,0,1-516,433.68V190.44a12.31,12.31,0,0,1,12.31-12.31H-458a12.31,12.31,0,0,1,12.31,12.31v99l93.58-107.14a12.34,12.34,0,0,1,9.27-4.21h45.73a12.3,12.3,0,0,1,9.3,20.36l-85,98.26,93.9,129.71a12.3,12.3,0,0,1-10,19.52h-52.24a12.3,12.3,0,0,1-9.89-5Z" transform="translate(2548.21 -58.03)" style="fill:#fff"/></svg>
					<!-- <amp-img src="<?php //echo URL_ROOT.$config['logo_mobile'];?>" alt="<?php //echo $config['site_name']?>" width="36" height="36" ></amp-img> -->
				</a>
				<?php if($Itemid == 1){?></h1><?php }?>

				<div class="regions_search cls">
					<div class="click_search_mobile">
						<svg width="30px" height="30px" aria-hidden="true" data-prefix="far" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-search fa-w-16"><path d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z" class=""></path></svg>
					</div>
				</div>
			</div>

				<div class="shopcart">
					<?php echo $tmpl -> load_direct_blocks('shopcart',array('style'=>'simple')); ?>
				</div>
				<div class="sb-toggle-left navbar-left menu_show" id="click_menu_mobile_code">
					<a href="<?php echo URL_ROOT ?>" class="all-navicon-line">
						<div class="navicon-line navicon-line-1"></div>
						<div class="navicon-line navicon-line-2"></div>
						<div class="navicon-line navicon-line-3"></div>
					</a>
				</div>
		</div>
	</div>	
</div>



<?php if(($Itemid !=1)){?>
	<div class='breadcrumbs'>
		<div class="container">
			<?php  echo $tmpl -> load_direct_blocks('breadcrumbs',array('style'=>'amp')); ?>
		</div>
	</div>
<?php }?>

<div class="main_content container">
	<?php  echo $main_content; ?>
</div>


<footer>
	<div class="container">
		<div class="top-ft cls">
			<div class="top-ft-r">
				<?php echo $tmpl -> load_direct_blocks('mainmenu',array('style'=>'bottommenu','group'=>'19')); 
				?> 
			</div>
		</div>
		<div class="footer_bottom cls">
			<div class="copyright"><?php echo str_replace('font','span',$config['copy_right']);?></div>
			<div class="payment_method">
				<div class="title">Phương thức thanh toán</div>
				<div class="img">
					<amp-img src="<?php echo URL_ROOT.$config['img_payment_method'];?>"alt="Phương thức thanh toán" width="384" height="36"></amp-img>

				</div>
			</div>
			<div class="certi">
				<div class="title">Chứng nhận</div>
				<div class="img">
					<amp-img src="<?php echo URL_ROOT.$config['img_certi'];?>"  alt="Chứng nhận"  width="210" height="36"></amp-img>
				</div>
			</div>
			<div class="footer_bottom2">
				<div class="info_footer">
					<?php echo $config['info_footer']; ?>
				</div>
				<a href="https://delecweb.com/" title="delecweb.com" class="developer" rel="nofollow" target="_blank">Thiết kế web Delectech</a>
			</div>
		</div>
	</footer>