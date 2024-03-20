<?php 
	$total_member_7level_normal = 0;
	$total_member_7level_silver = 0;
	$total_member_7level_gold = 0;
	$count_member_normal = array(); // total 3 type: normal+gold+silver
	$count_member_silver = array();
	$count_member_gold = array();
	for($i = 0 ; $i < 7; $i ++)
	{
		$count_member_normal[$i] = isset($count_chidren[$i][0])? $count_chidren[$i][0]:0;
		$count_member_silver[$i] = isset($count_chidren[$i][1])? $count_chidren[$i][1]:0;
		$count_member_gold[$i] = isset($count_chidren[$i][2])? $count_chidren[$i][2]:0;
		
		$total_member_7level_normal += $count_member_normal[$i];
		$total_member_7level_silver += $count_member_silver[$i];
		$total_member_7level_gold   += $count_member_gold[$i];

	}
?>
<table cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th class="border-r">C&#7845;p</th>
			<th class="border-r">S&#7889; th&agrave;nh vi&ecirc;n</th>
			<th class="border-r">Th&agrave;nh vi&ecirc;n Silver</th>
			<th>Th&agrave;nh vi&ecirc;n Gold</th>
		</tr>
	</thead>
	<tbody>
	<?php for($i = 0 ; $i < 7; $i ++) {?>
		<tr class="row<?php echo ($i%2); ?>">
			<td class="border-r"><?php echo ($i+1); ?></td>
			<td class="border-r">
				<?php echo $count_member_normal[$i]; ?>
			</td>
			<td class="border-r"><?php echo $count_member_silver[$i]; ?></td>
			<td><?php echo $count_member_gold[$i]; ?></td>
		</tr>
	<?php } ?>
	</tbody>
	<tfoot>
		<tr class="row<?php echo ($i%2); ?>">
			<td class="border-r">T&#7893;ng</td>
			<td class="border-r"><?php echo $total_member_7level_normal; ?></td>
			<td class="border-r"><?php echo $total_member_7level_silver; ?></td>
			<td><?php echo $total_member_7level_gold; ?></td></tr>
	</tfoot>
</table>
