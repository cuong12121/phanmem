<div class="member_levels">
	<div class="title_member_levels">Tích điểm thành viên</div>
	<?php $point_price = round($price/1000);?>
	<?php foreach ($member_levels as $member_level) { ?>
		<div class="member_lever cls">
			<div class="name">
				<?php echo $member_level-> name; ?>
			</div>
			<div class="save_point">
				<span><?php echo round($point_price * $member_level-> save_point / 100);  ?> điểm</span>(<?php echo $member_level->save_point; ?> % off)
			</div>
		</div>
	<?php } ?>
</div>