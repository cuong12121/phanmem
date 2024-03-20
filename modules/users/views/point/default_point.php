<script src="<?php echo URL_ROOT.'libraries/jquery/thickbox/thickbox.js'; ?>" type="text/javascript" language="javascript" ></script>
<link rel="stylesheet" href="<?php  echo URL_ROOT.'libraries/jquery/thickbox/thickbox.css';?>" />
<div class="view-point-member">
	<div>Số điểm của bạn: <strong class='red'><?php echo $data -> point; ?></strong></div>
	<div>Hạng thẻ: <strong class='red'><?php echo isset($arr_level[$data -> level])? $arr_level[$data -> level] -> name : ''; ?></strong></div>
	<?php if($data -> level < 2){?>
		<?php $level = $data -> level; ?> 
		<?php if($data -> point < $arr_level[$level + 1] -> point){?>
			<div>Số điểm cần thiết để bạn lên hạng tiếp theo: <strong class='red'><?php echo (($arr_level[$level + 1] -> point) - ($data -> point)); ?></strong></div>
		<?php } else {?>
			<div>Bạn đã đạt điểm cần thiết để lên hạng. Hãy liên hệ với Ban quản trị website để yêu cầu</div>
		<?php }?>
	<?php }?>
	<a class="thickbox" href='<?php echo FSRoute::_('index.php?module=users&view=point&task=policy&raw=1');?>' target="_blank" >Tìm hiểu về chính sách điểm, quyền lợi của thành viên iOne</a>
</div>