<?php
/*
 * Huy write
 */
	// controller
	
	class UsersControllersMembers
	{
		var $module;
		var $view;
		function __construct()
		{
			
			$this->module  = 'users';
			$this->view  = 'members';
			include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		}
		function display()
		{
			Security::checkLogin();
			// call models
			$model = new UsersModelsMembers();
			
			$members = $model -> getMembers();
			$count_chidren = $model -> countChildren($_SESSION['userid']);
			include_once 'libraries/tree/tree.php';
			$list = Tree::indentRows($members,1,$_SESSION['userid']);
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/members.php';
		}
		
		/*
		 * This function get info of member
		 * Input: sim_number
		 * Output: html about info of member 
		 * Note: use for ajax;
		 */
		function get_info_member()
		{
			
			$userid = FSInput::get('userid');
			if(!$userid)
			{
				echo "0";
				return ;
			}
			
			$model = new UsersModelsMembers();
			$data = $model -> getMemberById($userid);
			$child = $model -> getChildren($userid);
			$cm_total = $model -> getTotalCommission($userid);
			$total_mload = $model -> getTotalMload($userid);
			$referrer = $model -> getReferrer( $data -> referrer);
			$count_chidren = $model -> countChildren($userid);
			$html = $this -> show_info_member($data,$referrer,$count_chidren,$cm_total);
			$html .= $this -> show_statistics_member($data,$count_chidren,$total_mload);
			echo $html;
			if(!$data)
			{
				echo "0";
				return ;
			}
			
		}
		
		/*
		 * Show info
		 */
		
		function show_info_member($data,$referrer,$count_chidren,$cm_total)
		{
			
			$total_member_7level = 0;
			$total_member_level1 = isset($count_chidren[0][0]) ? $count_chidren[0][0]:0;
			for($i = 0 ; $i < 7; $i ++)
			{
				if(isset($count_chidren[$i][0]))
					$total_member_7level += $count_chidren[$i][0];
			}
			
			// Calculate commission in month current
			$total_commission_in_month = 0;
			$total_commission_receive_in_month = 0;
			
			$total_commission_in_month += @$cm_total -> totalintroducecommission;
			$total_commission_receive_in_month += @$cm_total -> total_paid_introduce;

			$total_commission_in_month += @$cm_total -> totalsalecommission;
			$total_commission_receive_in_month += @$cm_total -> total_paid_sale;

			$total_commission_in_month += @$cm_total ->revenuecompression;
			$total_commission_receive_in_month += @$cm_total -> Total_paid_revenue_compression;
			
			$total_commission_in_month += @$cm_total ->silver;
			$total_commission_receive_in_month += @$cm_total -> total_paid_silver;
			
			$total_commission_in_month += @$cm_total ->silvercompression;
			$total_commission_receive_in_month += @$cm_total -> total_paid_silver_compression;
			
			$total_commission_in_month += @$cm_total ->gold;
			$total_commission_receive_in_month += @$cm_total -> total_paid_gold;
			
			$total_commission_in_month += @$cm_total ->goldcompression;
			$total_commission_receive_in_month += @$cm_total -> total_paid_gold_compression;
			
			$total_commission_in_month += @$cm_total ->incomecompression;
			$total_commission_receive_in_month += @$cm_total -> total_paid_income_compression;
			
			$total_commission_none_receive_in_month = $total_commission_in_month  -  $total_commission_receive_in_month;
			
			// end Calculate commission in month current
			
			$html = "";
			$html .= "<div class='lower-member-infor'>";
			$html .= "<div class='member-infor-inner'>";
			// HEAD			
			$html .= "<div class='member-infor-head'>";
			$html .= "<span>Th&ocirc;ng tin th&agrave;nh vi&ecirc;n c&#7845;p d&#432;&#7899;i</span>";
			$html .= "</div>";
			// END HEAD
			
			// BODY			
			$html .= "<div class='member-infor-body'>";
			$html .= "<table><tr valign='top'>";
						
			// left
			$html .= "<td class='td-left'>";
			$html .= "<ul class='member-infor-body-left'>";
				$html .= "<li>S&#272;T: <span>".$data->sim_number."</span></li>";	
				$html .= "<li>H&#7885; t&ecirc;n: <span>".$data->fname . " ". $data->mname." " . $data -> lname. "</span></li>";	
				$html .= "<li>C&#7845;p &#273;&#7897;: <span>";
				
				$html .=  showLevel(@$data->level);
					
				
				$html .=  "</span></li>";	
				$html .= "<li>S&#7889; th&agrave;nh vi&ecirc;n c&#7845;p 1: <span>".$total_member_level1. "</span></li>";	
				$html .= "<li>S&#7889; TV 7 t&#7847;ng: <span>".$total_member_7level. "</span></li>";	
				$html .= "<li>Ng&#432;&#7901;i gi&#7899;i thi&#7879;u: <span>".$referrer->fname . " ". $referrer->mname." " . $referrer -> lname. "</span></li>";
				$html .= "<li>S&#272;T: ".$referrer -> sim_number. "</li>";		
				$html .= "<li>C&#7845;p &#273;&#7897;: ";
				
				$html .=  showLevel(@$referrer -> level);
				
				$html .=  "</li>";		
			$html .= "</ul>";
			$html .= "</td>";
			
			// right
			$year_current = date("Y");
			$month_current = date("m");
			
			$html .= "<td class='td-right'>";
			$html .= "<ul class='member-infor-body-right'>";
				$html .= "<li>Doanh s&#7889; M-load th&aacute;ng $month_current/$year_current:<br/>&nbsp; <strong>".number_format(@$cm_total -> totalsale ? $cm_total -> totalsale : 0, 0, ',', '.'). "</strong> VND</li>";
				$html .= "<li>Doanh s&#7889; EP th&aacute;ng $month_current/$year_current:<span> <br/>&nbsp; "."Ch&#432;a c&#7853;p nh&#7853;t". "</span></li>";
				$html .= "<li>Doanh s&#7889; gian h&agrave;ng/n&#259;m :<span> <br/>&nbsp;"."Ch&#432;a c&#7853;p nh&#7853;t". "</span></li>";
				$html .= "<li>T&#7893;ng hoa h&#7891;ng th&aacute;ng $month_current/$year_current: <strong> <br/>&nbsp;".number_format($total_commission_in_month, 0, ',', '.'). "</strong> VND</li>";
				$html .= "<li>Hoa h&#7891;ng &#273;&#432;&#7907;c nh&#7853;n th&aacute;ng $month_current/$year_current:  <strong> <br/>&nbsp;".number_format($total_commission_receive_in_month, 0, ',', '.'). "</strong> VND</li>";
				$html .= "<li>Hoa h&#7891;ng ch&#432;a &#273;&#432;&#7907;c nh&#7853;n th&aacute;ng $month_current/$year_current:  <strong> <br/>&nbsp;".number_format($total_commission_none_receive_in_month, 0, ',', '.'). "</strong> VND</li>";
			$html .= "</ul>";
			$html .= "</td>";
			
			$html .= "</tr></table>";
			$html .= "</div>";
			// END BODY
			
			$html .= "</div>";
			$html .= "</div>";
			return $html;
		}
		/*
		 * Show statistics
		 */
		function show_statistics_member($data,$count_chidren,$total_mload)
		{
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
			
			$i = 0;
			
			$html = "";
			$html .= "<div class='lower-member-statistics'>";
			
			// table statistics
			$html .= "<table cellpadding='0' cellspacing='0'>";
			$html .= "	<thead>";
			$html .= "		<tr>";
			$html .= "			<th class='border-r'>C&#7845;p</th>";
			$html .= "			<th class='border-r'>S&#7889; th&agrave;nh vi&ecirc;n</th>";
			$html .= "			<th class='border-r'>Doanh s&#7889; M-load</th>";
			$html .= "			<th>Doanh s&#7889; EP</th>";
			$html .= "		</tr>";
			$html .= "	</thead>";
			$html .= "	<tbody>";
			
			$total_member = 0;
			$total_mload_in_month = 0;
			for($i = 0 ; $i < 7; $i ++) {
				
				$field_mload_level = "level".($i+1)."totalmload"; 
				$mload_level = @$total_mload->$field_mload_level ? $total_mload->$field_mload_level: 0;
				$total_mload_in_month += $mload_level;
				
				$html .= "		<tr class='row" . ($i%2) ."'>";
				$html .= "			<td class='border-r'>". ($i+1) . "</td>";
				$html .= "			<td class='border-r'>".  $count_member_normal[$i]; "</td>";
				$html .= "			<td class='border-r'>". number_format($mload_level, 0, ',', '.') ." </td>";
				$html .= "			<td>"."Ch&#432;a c&#7853;p nh&#7853;t"."</td>";
				$html .= "		</tr>";
			}
			
			$html .= "	</tbody>";
			$html .= "	<tfoot>";
			$html .= "		<tr class='row".($i%2) ."'>";
			$html .= "			<td class='border-r'>"."T&#7893;ng"."</td>";
			$html .= "			<td class='border-r'>" . $total_member_7level_normal. "</td>";
			$html .= "			<td class='border-r'>" . number_format($total_mload_in_month, 0, ',', '.')  ."</td>";
			$html .= "			<td>"."Ch&#432;a c&#7853;p nh&#7853;t"."</td></tr>";
			$html .= "	</tfoot>";
			$html .= "</table>";
			// end table statistics
			
			
			$html .= "</div>";
			return $html;
		}
			
	}
	
?>