<?php  	global $tmpl;
$tmpl -> addScript('vote_result','modules/products/assets/js');
$tmpl -> addScript('jquery.cookie','libraries/jquery');
?>
<div class="prod_vote_result">
	<h4 class="vote_result_title">Đánh giá</h4>
	<div id="voteresult" class="vote_result_list">
		<dl id="vote_grph">
			<dt>Thiết kế</dt>
			<?php $pdesign = $data -> rating_design_sum ? ceil($data -> rating_design_sum /$data -> rating_count_vote): 0 	 	; ?>
			<?php $pfeatures = $data -> rating_features_sum ? ceil($data -> rating_features_sum /$data -> rating_count_vote): 0 ; ?>
			<?php $pperformance = $data -> rating_performance_sum ?	ceil($data -> rating_performance_sum /$data -> rating_count_vote): 0 	?>
			<dd id="vote_grph_design">
				<span class="img">
					<img width="<?php echo $pdesign*10?>%" src="<?php echo URL_ROOT.'modules/products/assets/images/spacer.gif'?>">
				</span>
				<span class="number"><?php echo $pdesign;?></span>
			</dd>
			<dt>Tính năng</dt>
			<dd id="vote_grph_features">
				<span class="img">
					<img width="<?php echo $pfeatures*10?>%" src="<?php echo URL_ROOT.'modules/products/assets/images/spacer.gif'?>">
				</span>
				<span class="number"><?php echo $pfeatures;?></span>
			</dd>
			<dt>Hiệu suất</dt>
			<dd id="vote_grph_performance">
				<span class="img">
					<img width="<?php echo $pperformance*10?>%" src="<?php echo URL_ROOT.'modules/products/assets/images/spacer.gif'?>">
				</span>
				<span class="number"><?php echo $pperformance;?></span>
			</dd>
		</dl>
		<form id="frmVote" name="frmVote" method="post">
			<div id="vote_rate">
				<select id="pDesign" name="pDesign" title="Design">
					<option value="">----</option>
					<?php for($i = 1; $i <= 10;$i ++){?>
						<option><?php echo $i;?></option>
					<?php } ?>
				</select>
				<select id="pFeatures" name="pFeatures" title="Features">
					<option value="">----</option>
					<?php for($i = 1; $i <= 10;$i ++){?>
						<option><?php echo $i;?></option>
					<?php } ?>
				</select>
				<select id="pPerformance" name="pPerformance" title="Performance">
					<option value="">----</option>
					<?php for($i = 1; $i <= 10;$i ++){?>
						<option><?php echo $i;?></option>
					<?php } ?>
				</select>
			</div>
			<div id="vote_submit">
				<span class="number"><?php echo $data -> rating_count_vote;?> lần</span>
				<span class="submit">
					<input id="button_vote" type="button" value="Đánh giá">
					<input type="hidden" name='record_id' id='record_id' value='<?php echo $data -> id;?>'>	
				</span>
				<br class="clear">
			</div>
		</form>
	</div>
</div>