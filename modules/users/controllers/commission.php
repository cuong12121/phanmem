<?php
/*
 * Huy write
 */
	// controller
	
	class UsersControllersCommission
	{
		var $module;
		var $view;
		function __construct()
		{
			
			$this->module  = 'users';
			$this->view  = 'commission';
			include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		}
		function display()
		{
			Security::checkLogin();
			$model = new UsersModelsCommission();
			
			$data_userhistory = $model -> getTotalCommission(); // userhistory
			$total_cm_current = $this -> get_total_commission_current($data_userhistory);
			include 'modules/'.$this->module.'/models/users.php';
			$model2 = new UsersModelsUsers();
			$user  = $model2 -> getMember();
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/commission.php';
		}
		
		/*
		 * Show detail one commission type
		 * Include simple commission: gold, silver, passive, introduce
		 */
		function detail()
		{
			Security::checkLogin();
			$type = FSInput::get('type');
			switch ($type)
			{
				case 'introduce':
					$tablename = 'fs_ch_introduce';	
					$cm_name = 'Gi&#7899;i thi&#7879;u';
					$add_field_name = 'S&#7889; th&#224;nh vi&#234;n';	
					$add_field_prefix = 'level';	
					$add_field_suffix = 'usercount';	
					$commission_field_prefix = 'level';
					$commission_field_suffix = 'totalic';
					$reason_non_receive = 'Ch&#432;a &#273;&#7911; doanh s&#7889; M-load ho&#7863;c ch&#432;a &#273;&#7911; th&agrave;nh vi&ecirc;n &#7903; c&#7845;p 1!';
					
					break;
					
				case 'passive':
					$tablename = 'fs_ch_sale';	
					$cm_name = 'Th&#7909; &#273;&#7897;ng';
					$add_field_name = 'D.s&#7889; Mload';	
					$add_field_prefix = 'level';	
					$add_field_suffix = 'totalmload';	
					$commission_field_prefix = 'level';
					$commission_field_suffix = 'totalsc';	
					$reason_non_receive = 'Ch&#432;a &#273;&#7911; doanh s&#7889; M-load ho&#7863;c ch&#432;a &#273;&#7911; th&agrave;nh vi&ecirc;n &#7903; c&#7845;p 1!';
					break;
					
				case 'gold':
					$tablename = 'fs_ch_gold';	
					$cm_name = 'Gold';
					$add_field_name = 'Th&#224;nh vi&#234;n Gold';	
					$add_field_prefix = 'level';	
					$add_field_suffix = 'usercount';	
					$commission_field_prefix = 'level';
					$commission_field_suffix = 'total_gold';	
					$reason_non_receive = 'Ch&#432;a &#273;&#7911; doanh s&#7889; M-load ho&#7863;c ch&#432;a &#273;&#7911; th&agrave;nh vi&ecirc;n &#7903; c&#7845;p 1!';
					break;
					
				case 'silver':
					$tablename = 'fs_ch_silver';	
					$cm_name = 'Silver';
					$add_field_name = 'Th&#224;nh vi&#234;n Silver';	
					$add_field_prefix = 'level';	
					$add_field_suffix = 'usercount';	
					$commission_field_prefix = 'level';
					$commission_field_suffix = 'total_silver';	
					$reason_non_receive = 'Ch&#432;a &#273;&#7911; doanh s&#7889; M-load ho&#7863;c ch&#432;a &#273;&#7911; th&agrave;nh vi&ecirc;n &#7903; c&#7845;p 1!';
					break;
					
				default:
					$tablename = 'fs_ch_introduce';	
					$cm_name = 'Gi&#7899;i thi&#7879;u';
					$add_field_prefix = 'level';	
					$add_field_suffix = 'usercount';	
					$reason_non_receive = 'Ch&#432;a &#273;&#7911; doanh s&#7889; M-load ho&#7863;c ch&#432;a &#273;&#7911; th&agrave;nh vi&ecirc;n &#7903; c&#7845;p 1!';
					break;
					
			}
			
			$model = new UsersModelsCommission();
			$data_userhistory = $model -> getTotalCommission();
			$data_specific = $model -> getDataTable($tablename);
			
			// commission person
			include 'modules/'.$this->module.'/models/users.php';
			$model2 = new UsersModelsUsers();
			$user  = $model2 -> getMember();
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		
		/*
		 * Show detail session in month.
		 */
		function detail2()
		{
			Security::checkLogin();
			
			$type = FSInput::get('type');
			switch ($type)
			{
				case 'introduce':
					$tablename = 'fs_ct_introduce';	
					$cm_name = 'Gi&#7899;i thi&#7879;u';
					
					break;
					
				case 'passive':
					$tablename = 'fs_ct_sale';	
					$cm_name = 'Th&#7909; &#273;&#7897;ng';
					break;
					
				case 'gold':
					$tablename = 'fs_ct_gold';	
					$cm_name = 'Gold';
					break;
					
				case 'silver':
					$tablename = 'fs_ct_silver';	
					$cm_name = 'Silver';
					break;
					
				default:
					$tablename = 'fs_ct_introduce';	
					$cm_name = 'Gi&#7899;i thi&#7879;u';
					break;
					
			}
			
			$model = new UsersModelsCommission();
			$data_userhistory = $model -> getTotalCommission();
			
			// get Data from fs_ct_typecommission
			$data_ct_typecommission = $model -> get_data_ct_cm($tablename);
			$total = $model -> get_total_ct_cm($tablename);
			$pagination = $model -> get_pagination_ct_cm($total);
			
			
			
			// commission person
			include 'modules/'.$this->module.'/models/users.php';
			$model2 = new UsersModelsUsers();
			$user  = $model2 -> getMember();

			include 'modules/'.$this->module.'/views/'.$this->view.'/detail2.php';
		}
		
		
		/*
		 * Calculate total of commission at current.
		 */
		function get_total_commission_current($data_userhistory)
		{
			$total_cm_current  = @$data_userhistory -> totalpaidcommission  ? $data_userhistory -> totalpaidcommission: 0; 
			if(!$total_cm_current)
			{
				$total_cm_current = 0;
				$total_cm_current += @$data_userhistory -> total_paid_introduce;
				$total_cm_current += @$data_userhistory -> total_paid_sale;
				$total_cm_current += @$data_userhistory -> total_paid_silver;
				$total_cm_current += @$data_userhistory -> total_paid_gold;
			}
			return $total_cm_current;
		}
		
		
		/*******************  COMMON AJAX FOR COMMISSION ****************/
	
		/*
		 * load form commission 
		 */
		function ajax_load_commission()
		{
			$type = FSInput::get('type');
			switch ($type)
			{
				case 'introduce':
					$cm_type = 'introduce';	
					$cm_name = 'Gi&#7899;i thi&#7879;u';	
					$cm_field_total = 'totalintroducecommission';
					$cm_field_receive = 'total_paid_introduce';
					$reason_non_receive = 'Ch&#432;a &#273;&#7911; doanh s&#7889; M-load ho&#7863;c ch&#432;a &#273;&#7911; th&agrave;nh vi&ecirc;n &#7903; c&#7845;p 1!';
					break;
					
				case 'passive':
					$cm_type = 'passive';	
					$cm_name = 'Th&#7909; &#273;&#7897;ng';	
					$cm_field_total = 'totalsalecommission';
					$cm_field_receive = 'total_paid_sale';
					$reason_non_receive = 'Ch&#432;a &#273;&#7911; doanh s&#7889; M-load ho&#7863;c ch&#432;a &#273;&#7911; th&agrave;nh vi&ecirc;n &#7903; c&#7845;p 1!';
					break;
					
				case 'gold':
					$cm_type = 'gold';	
					$cm_name = 'Gold';	
					$cm_field_total = 'gold';
					$cm_field_receive = 'total_paid_gold';
					$reason_non_receive = 'Ch&#432;a &#273;&#7911; doanh s&#7889; M-load ho&#7863;c ch&#432;a &#273;&#7911; th&agrave;nh vi&ecirc;n &#7903; c&#7845;p 1!';
					break;
					
				case 'silver':
					$cm_type = 'silver';	
					$cm_name = 'Silver';	
					$cm_field_total = 'silver';
					$cm_field_receive = 'total_paid_silver';
					$reason_non_receive = 'Ch&#432;a &#273;&#7911; doanh s&#7889; M-load ho&#7863;c ch&#432;a &#273;&#7911; th&agrave;nh vi&ecirc;n &#7903; c&#7845;p 1!';
					break;
					
				default:
					$cm_type = 'introduce';	
					$cm_name = 'Gi&#7899;i thi&#7879;u';	
					$cm_field_total = 'totalintroducecommission';
					$cm_field_receive = 'total_paid_introduce';
					$reason_non_receive = 'Ch&#432;a &#273;&#7911; doanh s&#7889; M-load ho&#7863;c ch&#432;a &#273;&#7911; th&agrave;nh vi&ecirc;n &#7903; c&#7845;p 1!';
					break;
					
			}
			
			
			
			$html = "";
			
			$html .=  "<div class='form_user_head'>";
			$html .=  "					<div class='form_user_head_l'>";
			$html .=  "						<div class='form_user_head_r'>";
			$html .=  "							<div class='form_user_head_c'>";
			$html .=  "								<span>Th&#7889;ng k&ecirc; hoa h&#7891;ng ".$cm_name." c&aacute;c th&aacute;ng </span>";
			$html .=  "								<div >&#272;&#417;n v&#7883; t&iacute;nh : VND</div>";
			$html .=  "							</div>					";
			$html .=  "						</div>					";
			$html .=  "					</div>					";
			$html .=  "				</div>	";
			$html .=  "				<div class='form_user_footer_body'>	";
			$html .=  "<table cellpadding='6' cellspacing='0'>";
			$html .= "<tr >";
			$html .= "							<td class='td-left tbl_head'>Th&aacute;ng</td>";
			$html .= "<td class='td-left tbl_head'>T&#7893;ng hoa h&#7891;ng </td>";
			$html .= "<td class='td-left tbl_head'>Hoa h&#7891;ng &#273;&#432;&#7907;c nh&#7853;n </td>";
			$html .= "<td class='td-left tbl_head'>Hoa h&#7891;ng ch&#432;a &#273;&#432;&#7907;c nh&#7853;n </td>";
			$html .= "<td class='td-right tbl_head'>&nbsp </td>";
			$html .= "	</tr>";
			echo $html;
			echo $this -> ajax_show_commission($cm_name, $cm_type, $cm_field_total, $cm_field_receive, $pos_start = 7,$reason_non_receive);
			echo "</table>";
			echo "</div>";
//			echo  " <script type='text/javascript'>
//						$(document).ready(function(){
//						
//						for(i = 8; i < 17; i ++)
//						{
//							console.log('red');
//							tooltipId = '#tooltip-target-'+i;
//							$(tooltipId).ezpz_tooltip();	
//						}
//						});
//						</script>
//						";
			
		}
		
		/*
		 * Show content
		 * cm_total : data from table fs_usershistory
		 * cm_type: type of commisstion. Ex: introduce, gold...
		 * cm_name: to display
		 * cm_field_total: total of commission with this type
		 * cm_field_receiver: commission is received.
		 * pos_start: position of row0. To use for load Tooltip when id = 1
		 */
		
		function ajax_show_commission($cm_name, $cm_type, $cm_field_total, $cm_field_receiver, $pos_start = 7,$reason_non_receive="")
		{
			// get Model	
			$model = new UsersModelsCommission();
			$data_userhistory = $model -> ajax_getTotalCommissionInMonths($cm_field_total, $cm_field_receiver);
			
			$html = "";
			$count_non_receive = 0;
			for($i = 0; $i < count($data_userhistory) ; $i ++ ) {
				$item = $data_userhistory[$i];
				
				$commission_total = @$item->$cm_field_total ? $item->$cm_field_total : 0;
				$commission_receive = @$item->$cm_field_receiver ? $item->$cm_field_receiver : 0;
				$commission_non_receive = $commission_total - $commission_receive;
				$link = Route::_('index.php?module=users&view=commission&task=detail2&type='.$cm_type.'&year='.$item->year.'&month='.$item->month.'&Itemid=27');
				
				$html .= "<tr>";
				$html .= "<td class='td-left'>";
				$html .= $item -> month .'/' . $item -> year;
				$html .= "</td>";
				
				$html .= "<td class='td-left'> ";
				$html .= format_money($commission_total);
				$html .= "</td>";
				
				$html .= "<td class='td-left'>";
				$html .= format_money($commission_receive);
				$html .= "</td>";
				
				$html .= "<td class='td-left'>";
				$html .= format_money($commission_non_receive);
				
				// TOOLTIP				
				if(($commission_non_receive) > 0) {
					$count_non_receive++;
					$html .= 	"<div id='tooltip-target-".($i+$count_non_receive)."' class ='reason-target' onmouseover='javascript:$(this).ezpz_tooltip();' >";
					$html .= 		"<img src='images/reason.jpg' /><span class='red' > L&yacute; do </span>";
					$html .= 	"</div>";
					$html .= 	"<div id='tooltip-content-".($i+$count_non_receive)."' class='reason-content tooltip-content' >";
					$html .= 		"<p class='reason-content-head'>";
					$html .= 			"B&#7841;n ch&#432;a &#273;&#432;&#7907;c nh&#7853;n hoa h&#7891;ng b&#7903;i v&igrave;:";
					$html .= 		"</p>";
					$html .= 		"<p class='reason-content-body'>";
					$html .= 			$reason_non_receive;
					$html .= 		"</p>";
					$html .= 	"</div>";
					
				}
				// end TOOLTIP		
				
				
				$html .= "</td>";
				
				$html .= "<td class='td-right'>";
				$html .= "<a href='$link' > Chi ti&#7871;t th&#225;ng ";
				$html .= "</td>";
				$html .= "</tr>";
				
				
			}
			return $html;
			
		}
		
	}
	
?>
