<?php
/*
 * Huy write
 */
	// Tính phong thủy cho sim
	
	class Feng_shui
	{
		function search_feng_shui($sodienthoai,$namsinh,$giosinh='',$ngaysinh='',$thangsinh='',$gioitinh){
			$sodienthoai = $this -> convert_to_number($sodienthoai);
			
			$al = $this->convertSolar2Lunar($ngaysinh, $thangsinh, $namsinh, 7.0);
			$year =$al[2];
			$sdt_arr = array();
			$cung_menh = $this -> get_cung_menh($year);
			
			$can_chi =  $this->convertCanChi($al);
			$html = '';
//			$html = $this -> display();
			// Thông tin người cần search
			$html .= $this -> person_info($sodienthoai, $giosinh,$al,$gioitinh,$can_chi);
			
			$html2 = $this -> am_duong_tuong_phoi($sodienthoai,$gioitinh,$can_chi);
			$html3 = $this -> ngu_hanh_ban_menh($sodienthoai,$cung_menh);
			$html4 = $this -> cuu_tinh_do_phap($sodienthoai);
			$html5 = $this -> hanh_que_bat_quai($sodienthoai);
			$html6 = $this -> quan_niem_dan_gian($sodienthoai);
			
			$total_points = $html2['points'] + $html3['points'] + $html4['points'] + $html5['points'] + $html6['points'];
			
			$html7 = $this -> ket_luan($total_points,$sodienthoai);
			
			$html;
			$html .= $html2['html'];
			$html .= $html3['html'];
			$html .= $html4['html'];
			$html .= $html5['html'];
			$html .= $html6['html'];
			$html .= $html7;
			
			return $html;
		}
		
		/*
		 * Tính điểm theo bản mệnh: chỉ lấy được giá trị Min của bản mênh ( do phụ thuộc vào giá trị âm dương của năm, mà điều này ta ko XĐ được )
		 */
		function calculate_point_sim_by_feng_shui($sim_number,$ban_menh){
			$html2 = $this -> am_duong_tuong_phoi_theo_menh($sim_number);
			$html3 = $this -> ngu_hanh_ban_menh_to_point($sim_number,$ban_menh);
			$html4 = $this -> cuu_tinh_do_phap($sim_number);
			$html5 = $this -> hanh_que_bat_quai_to_point($sim_number);
			$html6 = $this -> quan_niem_dan_gian($sim_number);
			
			$total_points = $html2['points'] + $html3['points'] + $html4['points'] + $html5['points'] + $html6['points'];
			return $total_points;
		}
		/*
		 * Thông tin người cần search
		 */
		function person_info($sodienthoai, $giosinh,$al,$gioitinh,$can_chi){
			$ngaysinh = FSInput::get('ngaysinh');
			$thangsinh = FSInput::get('thangsinh');
			$namsinh = FSInput::get('namsinh');
			
			$html = '';
			$html .= '<h3  align="center" style="background:#FF7B1B;color: #FFFFFF;line-height: 40px;">Tra cứu điểm sim phong thủy hợp tuổi, hợp mệnh</h3><br />';
			$html .= '<p align="center">****************************</p><br/>';
			$html .= '- <strong>Số cần xem</strong> :<span class="text-bold text-primary">'.$sodienthoai.'</span><br />';
			$html .= '- <strong>Thân chủ</strong> :<span class="text-bold text-primary">'.$gioitinh.'</span><br />';
			$html .= '- <strong>Ngày tháng năm sinh :</strong><br />';
			$html .= '&nbsp;+&nbsp;<span>Dương lịch</span> : <span class="text-bold text-primary">ngày '.$ngaysinh.' tháng '.$thangsinh.' năm '.$namsinh.'</span><br />';
			$html .= '&nbsp;+&nbsp;<span>Âm lịch</span> : <span class="text-bold text-primary">'.$al[0].'/'.$al[1].'/'.$al[2].'</span>. ';
			$html .= '<span>Theo Can chi </span> :';
			$html .= 'ngày <span class="text-bold text-primary">'.$can_chi[0][0].' '.$can_chi[0][1].'</span> ';
			$html .= 'tháng <span class="text-bold text-primary">'.$can_chi[1][0].' '.$can_chi[1][1].'</span> ';
			$html .= 'năm <span class="text-bold text-primary">'.$can_chi[2][0].' '.$can_chi[2][1].'</span>';
			$html .= '<p align="center">****************************</p>';
			
//			$array = array ('html'=> $html);
			return $html;
		}
		
		/*
		 * 1. 1. Âm dương tương phối:
		 */
		function am_duong_tuong_phoi($sodienthoai,$gioitinh,$can_chi){
		
			 $sim_str = (string)$sodienthoai ;
			 
			 // Tìm tất cả số chẵn và lẻ trong dãy sdt
			 for($i =0 ; $i <  strlen($sim_str); $i++){
			 	 if($sim_str[$i]% 2 == 0){
			 	 	$even[]= $sim_str[$i];
			 	 }else {
			 	 	$odd[]= $sim_str[$i];
			 	 }
			 }
			$html = ''; 
			$html .= '<h3>1. Âm dương tương phối:</h3>'; 
			$html .= 'Âm dương là hai khái niệm để chỉ hai thực thể đối lập ban đầu tạo nên toàn bộ vũ trụ. Ý niệm âm dương đã ăn sâu trong tâm thức người Việt từ ngàn xưa và được phản chiếu rất rõ nét trong ngôn ngữ nói chung và các con số nói riêng. Người xưa quan niệm rằng các số chẵn mang vận âm, các số lẻ mang vận dương.'; 
			$html .= '<table width="100%" cellspacing="0" cellpadding="0" bordercolor="#DADADA" border="1" style="border-collapse:collapse; margin:10px 0;">';
			$html .= '<tr>';
			for($i =0 ; $i <  strlen($sim_str); $i++){
				$html .= '<td  align="center">'.$sim_str[$i].'</td>';
			 }
			$html .= '</tr>';
			$html .= '<tr>';
			for($i =0 ; $i <  strlen($sim_str); $i++){
				if($sim_str[$i]% 2 == 0 )
					$html .= '<td  align="center"> - </td>'; 
				else 
					$html .= '<td  align="center"> + </td>';
				
			 }
			$html .= '</tr>';
			$html .= '</table>';
			$html .= '<h3>1.1:</h3>';
			$html .= '- Dãy số có '.count($even).' số mang vận âm, '.count($odd).' số mang vận dương.<br/>';
			if(count($even) == count($odd) ){
				$html .= '- <span class="text-bold text-primary">Số lượng số mang vận âm dương hoàn toàn cân bằng, dãy số đạt được sự hòa hợp âm dương, rất tốt.</span><br/>';
				$points_1 = 2;
			}else{
				if(abs(count($even) - count($odd)) <= 2 ){
					
					$html .= '- <span class="text-bold text-primary">Số lượng số mang vận âm và dương khá cân bằng, dãy số đạt được sự hòa hợp âm dương, rất tốt.</span><br/>';
					$points_1 = 1;
				}else{
					$html .= '- <span class="text-bold text-primary">Số lượng số mang vận âm dương khá chênh lệch, dãy số chỉ tương đối hòa hợp.</span><br/>';
					$points_1 = 0;
				}
			}
			$html .= '<h3>1.2:</h3>';
			$html .= '-  Thân chủ sinh năm <span class="text-bold text-primary">'.$can_chi[2][0].' '.$can_chi[2][1].'</span>,';
			if($can_chi[2][0] == "Canh" || $can_chi[2][0] == "Nhâm" ||$can_chi[2][0] == "Giáp" ||$can_chi[2][0] == "Bính" ||$can_chi[2][0] == "Mậu" ){
				$html .= 'thuộc tuổi <span class="text-bold text-primary"> Dương '.$gioitinh.'</span><br />';
				$van_tuoi= 1; 
			}else{ 
				$html .= 'thuộc tuổi <span class="text-bold text-primary"> Âm '.$gioitinh.'</span><br />';
				$van_tuoi= 0;
			}
			
			//So sánh tuổi với vận của day số
			
			if (count($even) > count($odd)){
				if($van_tuoi == '1'){
					$html .= '- <span class="text-bold text-primary">Dãy số vượng Âm nên rất tốt với tính Dương của bạn.</span><br/>';
					$points_2 = 1;
				}else{ 
					$html .= '- <span class="text-bold text-primary">Không tốt vì cùng vượng Âm.</span><br/>';
					$points_2 = 0;
				}
			}else if (count($even) < count($odd)){
				if($van_tuoi == '1'){
					$html .= '- <span class="text-bold text-primary">Không tốt vì cùng vượng Dương.</span><br/>';
					$points_2 = 0;
				}else {
					$html .= '- <span class="text-bold text-primary">Dãy số vượng Dương nên rất tốt với tính Âm của bạn.</span><br/>';
					$points_2 = 1;
				}
			}
			else {
				if($van_tuoi == '1'){
					$html .= '- <span class="text-bold text-primary">Dãy số cân bằng âm dương nên cân bằng được một phần cho tính Dương của bạn rất tốt.</span><br/>';
					$points_2 = 0.5;
				}else {
					$html .= '- <span class="text-bold text-primary">Dãy số cân bằng âm dương nên cân bằng được một phần cho tính Dương của bạn rất tốt.</span><br/>';
					$points_2 = 0.5;
				}
			}
			
			$total_points = $points_1 +$points_2;
			
			$array = array ('points' =>$total_points, 'html'=> $html);
			
			return $array;
		}
		
		/*
		 * Tính hiệu số âm dương
		 * Số lẻ + 1, số chắn -1
		 */
		function hieu_am_duong_tuong_phoi($sodienthoai){
			 $count = 0;
			 // Tìm tất cả số chẵn và lẻ trong dãy sdt
			 for($i =0 ; $i <  strlen($sodienthoai); $i++){
			 	 if($sodienthoai[$i]% 2 == 0){
			 	 	$count --;
			 	 }else {
			 	 	$count ++;
			 	 }
			 }
			 return $count;
		}
			 
		
		/*
		 * 1. 1. Âm dương tương phối: // cho sim chỉ tính theo mênh, ko biết số năm. 
		 * Chỉ cần điểm, ko cần HTML
		 * Chú ý: do ko biết năm nên ta chỉ tính được Min cho Loại này
		 */
		function am_duong_tuong_phoi_theo_menh($sodienthoai){
		
			 $sim_str = (string)$sodienthoai ;
			 
			 // Tìm tất cả số chẵn và lẻ trong dãy sdt
			 for($i =0 ; $i <  strlen($sim_str); $i++){
			 	 if($sim_str[$i]% 2 == 0){
			 	 	$even[]= $sim_str[$i];
			 	 }else {
			 	 	$odd[]= $sim_str[$i];
			 	 }
			 }
			$html = ''; 
			$html .= '<h3>1. Âm dương tương phối:</h3>'; 
			$html .= 'Âm dương là hai khái niệm để chỉ hai thực thể đối lập ban đầu tạo nên toàn bộ vũ trụ. Ý niệm âm dương đã ăn sâu trong tâm thức người Việt từ ngàn xưa và được phản chiếu rất rõ nét trong ngôn ngữ nói chung và các con số nói riêng. Người xưa quan niệm rằng các số chẵn mang vận âm, các số lẻ mang vận dương.'; 
			$html .= '<table width="100%" cellspacing="0" cellpadding="0" bordercolor="#DADADA" border="1" style="border-collapse:collapse; margin:10px 0;">';
			$html .= '<tr>';
			for($i =0 ; $i <  strlen($sim_str); $i++){
				$html .= '<td  align="center">'.$sim_str[$i].'</td>';
			 }
			$html .= '</tr>';
			$html .= '<tr>';
			for($i =0 ; $i <  strlen($sim_str); $i++){
				if($sim_str[$i]% 2 == 0 )
					$html .= '<td  align="center"> - </td>'; 
				else 
					$html .= '<td  align="center"> + </td>';
			 }
			$html .= '</tr>';
			$html .= '</table>';
			$html .= '<h3>1.1:</h3>';
			$html .= '- Dãy số có '.count($even).' số mang vận âm, '.count($odd).' số mang vận dương.<br/>';
			if(count($even) == count($odd) ){
				$html .= '- <span class="text-bold text-primary">Số lượng số mang vận âm dương hoàn toàn cân bằng, dãy số đạt được sự hòa hợp âm dương, rất tốt.</span><br/>';
				$points_1 = 2;
			}else{
				if(abs(count($even) - count($odd)) <= 2 ){
					
					$html .= '- <span class="text-bold text-primary">Số lượng số mang vận âm và dương khá cân bằng, dãy số đạt được sự hòa hợp âm dương, rất tốt.</span><br/>';
					$points_1 = 1;
				}else{
					$html .= '- <span class="text-bold text-primary">Số lượng số mang vận âm dương khá chênh lệch, dãy số chỉ tương đối hòa hợp.</span><br/>';
					$points_1 = 0;
				}
			}
			
			//So sánh tuổi với vận của day số
			
			$total_points = $points_1;
			$array = array ('points' =>$total_points, 'html'=> $html);
			return $array;
		}
		
		/*
		 * 2. Ngữ hành bản mệnh
		 */
		function ngu_hanh_ban_menh($sodienthoai,$cung_menh){
			$sim_str = (string)$sodienthoai ;
			//tim số mà trong dãy số nhiều nhất rồi chọn số đó để làm ngũ hành của dãy số
			
			for($i= 0 ; $i < 10 ; $i++){
				$count_char =0;
				$max = 0;
				$count_char = substr_count($sodienthoai, $i);
				$sdt_arr[$i] = $count_char;
//				for($j= 0 ; $j < count($sdt_arr) ; $j++){
				foreach ($sdt_arr as $key=>$val) {
				    if($sdt_arr[$key] > $max){
				            $max= $sdt_arr[$key];
				    }
				}
			}
			
			$sdt_ngu_hanh = array_search($max, $sdt_arr);
			
			//đổi dãy số sang ngũ hành
			$ngu_hanh_cua_ds_arr = array(0=>'Thủy',1=>'Thủy',2=>'Thổ',3	=>'Mộc',4=>'Mộc',5=>'Thổ',6=>'Kim',7=>'Kim',8=>'Thổ',9=>'Hỏa');
			$ngu_hanh_cua_ds =$ngu_hanh_cua_ds_arr[$sdt_ngu_hanh];
			
			// Ngũ hành của tương con số 1 trong dãy sô
			$ngu_hanh_cua_s_arr=array(0=>'Thủy',1=>'Mộc',2=>'Mộc',3=>'Hỏa',4=>'Hỏa',5=>'Thổ',6=>'Thổ',7=>'Kim',8=>'Kim',9=>'Thủy');
			
			//căt 2 số một  thành 1 cặp trong
			$cap_so_arr=array();
			for($k= 0 ; $k < strlen($sim_str)-1 ; $k++){
				$cap_so_arr[$k]= (string)(substr ( $sim_str, $k,2 ));
			}
			
			//đổi các cặp số sang kiểu ngu hanh
			for($m= 0 ; $m < count($cap_so_arr) ; $m++){
				$cap_so= $cap_so_arr[$m];
				$cap_so_theo_ngu_hanh_arr[]=$ngu_hanh_cua_s_arr[$cap_so[0]].'_'.$ngu_hanh_cua_s_arr[$cap_so[1]] ;
			}
			$tuong_sinh_arr =array('Kim_Thủy','Thủy_Mộc','Mộc_Hoả','Hỏa_Thổ','Thổ_Kim');
			$tuong_khac_arr =array('Kim_Mộc','Mộc_Thổ','Thổ_Thủy','Thủy_Hỏa','Hỏa_Kim');
			$dem_ts = 0;
			$dem_tk = 0;
			//Đếm số lượng quan hệ tương sinh
			foreach($cap_so_theo_ngu_hanh_arr as $cap_so_theo_ngu_hanh){
				foreach($tuong_sinh_arr as $tuong_sinh){
					if($cap_so_theo_ngu_hanh == $tuong_sinh){
						$dem_ts++;
					}
				}
		
			}	
			
			//Đếm số lượng quan hệ tương khắc
			foreach($cap_so_theo_ngu_hanh_arr as $cap_so_theo_ngu_hanh){
				foreach($tuong_khac_arr as $tuong_khac){
					if($cap_so_theo_ngu_hanh == $tuong_khac){
						$dem_tk++;
					}
				}
			}			
			
			$html = '';
			$html .= '<h3>2. Ngũ hành bản mệnh:</h3>';
			$html .= 'Theo triết học cổ Trung Hoa, tất cả vạn vật đều phát sinh từ năm nguyên tố cơ bản và luôn luôn trải qua năm trạng thái được gọi là: Mộc, Hỏa, Thổ, Kim và Thủy. hay còn gọi là Ngũ hành. Học thuyết Ngũ hành diễn giải sự sinh hoá của vạn vật qua hai nguyên lý cơ bản Tương sinh và Tương khắc trong mối tương tác và quan hệ của chúng.<br/>';
			$html .= '<h3>2.1. Ngũ hành của thân chủ:</h3>';
			$html .= '- <span class="text-bold text-primary">'.$cung_menh->cung_menh.'</span> ( '.$cung_menh->ngu_hanh.' - '.$cung_menh->giai_nghia .' )<br />';
			$html .= '- Ngũ hành của dãy số :<span class="text-bold text-primary">'.$ngu_hanh_cua_ds.'</span><br />';
			if($ngu_hanh_cua_ds == 'Kim'){
				if($cung_menh->cung_menh =='Thủy'){
					$html .= '- <span class="text-bold text-primary"> Ngũ hành của dãy số tương sinh với ngũ hành của bạn, rất tốt.</span><br />';
					$points_1 = 1;
				}elseif($cung_menh->cung_menh =='Mộc'){
					$html .= '- <span class="text-bold text-primary">Ngũ hành của dãy số tương khắc với ngũ hành của bạn, không tốt.</span><br />';
					$points_1 = 0;
				}else {
					$html .= '- <span class="text-bold text-primary">Ngũ hành của dãy số không sinh không khắc với ngũ hành của thân chủ, chấp nhận được.</span><br />';
					$points_1 = 0.5;
				}
			}elseif ($ngu_hanh_cua_ds == 'Mộc'){
				if($cung_menh->cung_menh =='Hỏa'){
					$html .= '- <span class="text-bold text-primary">Ngũ hành của dãy số tương sinh với ngũ hành của bạn, rất tốt.</span><br />';
					$points_1 = 1;
				}elseif($cung_menh->cung_menh =='Thổ'){
					$html .= '- <span class="text-bold text-primary">Ngũ hành của dãy số tương khắc với ngũ hành của bạn, không tốt.</span><br />';
					$points_1 = 0;
				}else {
					$html .= '- <span class="text-bold text-primary">Ngũ hành của dãy số không sinh không khắc với ngũ hành của thân chủ, chấp nhận được.</span><br />';
					$points_1 = 0.5;
				}
			}elseif ($ngu_hanh_cua_ds == 'Thủy'){
				if($cung_menh->cung_menh =='Mộc'){
					$html .= '- <span class="text-bold text-primary">Ngũ hành của dãy số tương sinh với ngũ hành của bạn, rất tốt.</span><br />';
					$points_1 = 1;
				}elseif($cung_menh->cung_menh =='Hoả'){
					$html .= '- <span class="text-bold text-primary">Ngũ hành của dãy số tương khắc với ngũ hành của bạn, không tốt.</span><br />';
					$points_1 = 0;
				}else {
					$html .= '- <span class="text-bold text-primary">Ngũ hành của dãy số không sinh không khắc với ngũ hành của thân chủ, chấp nhận được.</span><br />';
					$points_1 = 0.5;
				}
			}elseif ($ngu_hanh_cua_ds == 'Hoả'){
				if($cung_menh->cung_menh =='Thổ'){
					$html .= '- <span class="text-bold text-primary">Ngũ hành của dãy số tương sinh với ngũ hành của bạn, rất tốt.</span><br />';
					$points_1 = 1;
				}elseif($cung_menh->cung_menh =='Kim'){
					$html .= '- <span class="text-bold text-primary">Ngũ hành của dãy số tương khắc với ngũ hành của bạn, không tốt.</span><br />';
					$points_1 = 0;
				}else {
					$html .= '- <span class="text-bold text-primary">Ngũ hành của dãy số không sinh không khắc với ngũ hành của thân chủ, chấp nhận được.</span><br />';
					$points_1 = 0.5;
				}
			}elseif ($ngu_hanh_cua_ds == 'Thổ'){
				if($cung_menh->cung_menh =='Kim'){
					$html .= '- <span class="text-bold text-primary">Ngũ hành của dãy số tương sinh với ngũ hành của bạn, rất tốt.</span><br />';
					$points_1 = 1;
				}elseif($cung_menh->cung_menh =='Thủy'){
					$html .= '- <span class="text-bold text-primary">Ngũ hành của dãy số tương khắc với ngũ hành của bạn, không tốt.</span><br />';
					$points_1 = 0;
				}else{
					$html .= '- <span class="text-bold text-primary">Ngũ hành của dãy số không sinh không khắc với ngũ hành của thân chủ, chấp nhận được.</span><br />';
					$points_1 = 0.5;
				}
			}
			$html .= '<h3>2.2. Ngũ hành sinh khắc trong dãy số:</h3>';
			$html .= '- Phân tích dãy số theo thứ tự từ trái sang phải, được các số: <br/>';
			for($i =0 ; $i <  (strlen($sim_str))-1; $i++){
				$html .= $sim_str[$i].' <span class="text-bold text-primary">('.$ngu_hanh_cua_s_arr[$sim_str[$i]].')</span> ,';
			}
			$html .= $sim_str[strlen($sim_str)-1].' <span class="text-bold text-primary">('.$ngu_hanh_cua_s_arr[$sim_str[strlen($sim_str)-1]].')</span><br/>';
			$html .= '- Theo chiều từ trái sang phải (chiều thuận của sự phát triển), xảy ra <span class="text-bold text-primary">'.$dem_ts.'</span> quan hệ tương sinh và <span class="text-bold text-primary">'.$dem_tk.'</span> quan hệ tương khắc. <br/>';
			if($dem_ts == $dem_tk )
				$points_2 =0.5;
			elseif ($dem_ts > 1 && $dem_tk ==0 )
				$points_2 =1;
			else 
				$points_2 =0;
			
			$total = 	$points_1 + $points_2;
			$array = array ('points' =>$total, 'html'=> $html);
			return $array;
		}
		/*
		 * 2. Ngữ hành bản mệnh 
		 */
		function ngu_hanh_ban_menh_to_point($sodienthoai,$ban_menh){
			$sim_str = (string)$sodienthoai ;
			//tim số mà trong dãy số nhiều nhất rồi chọn số đó để làm ngũ hành của dãy số
			
			for($i= 0 ; $i < 10 ; $i++){
				$count_char =0;
				$max = 0;
				$count_char = substr_count($sodienthoai, $i);
				$sdt_arr[$i] = $count_char;
//				for($j= 0 ; $j < count($sdt_arr) ; $j++){
				foreach ($sdt_arr as $key=>$val) {
				    if($sdt_arr[$key] > $max){
				            $max= $sdt_arr[$key];
				    }
				}
			}
			
			$sdt_ngu_hanh = array_search($max, $sdt_arr);
			
			//đổi dãy số sang ngũ hành
			$ngu_hanh_cua_ds_arr = array(0=>'Thủy',1=>'Thủy',2=>'Thổ',3	=>'Mộc',4=>'Mộc',5=>'Thổ',6=>'Kim',7=>'Kim',8=>'Thổ',9=>'Hỏa');
			$ngu_hanh_cua_ds =$ngu_hanh_cua_ds_arr[$sdt_ngu_hanh];
			
			// Ngũ hành của tương con số 1 trong dãy sô
			$ngu_hanh_cua_s_arr=array(0=>'Thủy',1=>'Mộc',2=>'Mộc',3=>'Hỏa',4=>'Hỏa',5=>'Thổ',6=>'Thổ',7=>'Kim',8=>'Kim',9=>'Thủy');
			
			//căt 2 số một  thành 1 cặp trong
			$cap_so_arr=array();
			for($k= 0 ; $k < strlen($sim_str)-1 ; $k++){
				$cap_so_arr[$k]= (string)(substr ( $sim_str, $k,2 ));
			}
			
			//đổi các cặp số sang kiểu ngu hanh
			for($m= 0 ; $m < count($cap_so_arr) ; $m++){
				$cap_so= $cap_so_arr[$m];
				$cap_so_theo_ngu_hanh_arr[]=$ngu_hanh_cua_s_arr[$cap_so[0]].'_'.$ngu_hanh_cua_s_arr[$cap_so[1]] ;
			}
			$tuong_sinh_arr =array('Kim_Thủy','Thủy_Mộc','Mộc_Hoả','Hỏa_Thổ','Thổ_Kim');
			$tuong_khac_arr =array('Kim_Mộc','Mộc_Thổ','Thổ_Thủy','Thủy_Hỏa','Hỏa_Kim');
			$dem_ts = 0;
			$dem_tk = 0;
			//Đếm số lượng quan hệ tương sinh
			foreach($cap_so_theo_ngu_hanh_arr as $cap_so_theo_ngu_hanh){
				foreach($tuong_sinh_arr as $tuong_sinh){
					if($cap_so_theo_ngu_hanh == $tuong_sinh){
						$dem_ts++;
					}
				}
		
			}	
			
			//Đếm số lượng quan hệ tương khắc
			foreach($cap_so_theo_ngu_hanh_arr as $cap_so_theo_ngu_hanh){
				foreach($tuong_khac_arr as $tuong_khac){
					if($cap_so_theo_ngu_hanh == $tuong_khac){
						$dem_tk++;
					}
				}
		
			}			
			
			if($ngu_hanh_cua_ds == 'Kim'){
				if($ban_menh =='Thủy'){
					$points_1 = 1;
				}elseif($ban_menh =='Mộc'){
					$points_1 = 0;
				}else {
					$points_1 = 0.5;
				}
			}elseif ($ngu_hanh_cua_ds == 'Mộc'){
				if($ban_menh =='Hỏa'){
					$points_1 = 1;
				}elseif($ban_menh =='Thổ'){
					$points_1 = 0;
				}else {
					$points_1 = 0.5;
				}
			}elseif ($ngu_hanh_cua_ds == 'Thủy'){
				if($ban_menh =='Mộc'){
					$points_1 = 1;
				}elseif($ban_menh =='Hoả'){
					$points_1 = 0;
				}else {
					$points_1 = 0.5;
				}
			}elseif ($ngu_hanh_cua_ds == 'Hoả'){
				if($ban_menh =='Thổ'){
					$points_1 = 1;
				}elseif($ban_menh =='Kim'){
					$points_1 = 0;
				}else {
					$points_1 = 0.5;
				}
			}elseif ($ngu_hanh_cua_ds == 'Thổ'){
				if($ban_menh =='Kim'){
					$points_1 = 1;
				}elseif($ban_menh =='Thủy'){
					$points_1 = 0;
				}else{
					$points_1 = 0.5;
				}
			}
			if($dem_ts == $dem_tk )
				$points_2 =0.5;
			elseif ($dem_ts > 1 && $dem_tk ==0 )
				$points_2 =1;
			else 
				$points_2 =0;
			
			$total = 	$points_1 + $points_2;
			$array = array ('points' =>$total, 'html'=> '');
			return $array;
		}
		/*
		 * 3. Cửu tinh đồ pháp
		 */
		function cuu_tinh_do_phap($sodienthoai){
			$sim_str = (string)$sodienthoai ;
			$count_char_8= substr_count($sim_str, '8');
			$html = '';
			$html .= '<h3>3. Cửu tinh đồ pháp:</h3>';
			$html .= 'Chúng ta đang ở thời kỳ Hạ Nguyên, vận 8 (từ năm 2004 - 2023) do sao Bát bạch quản nên số 8 là vượng khí. Sao Bát Bạch nhập Trung cung của Cửu tinh đồ, khí của nó có tác dụng mạnh nhất và chi phối toàn bộ địa cầu.<br/>';
			$html .= '<table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center"><img alt="Logo Phong Thủy" src= '.URL_ROOT.'modules/sims/assets/images/sonban.gif></td></tr></table>';
			if($count_char_8){
				$html .= '-	Trong dãy số cần biện giải có <span class="text-bold text-primary">'.$count_char_8.'</span> số 8, dãy số nhận được vận khí tốt từ sao Bát Bạch.<br/>';	
				$points = 0.5 * $count_char_8;
			}else{ 
				$html .= '-	Trong dãy số cần biện giải có <span class="text-bold text-primary">0</span> số 8, dãy số nhận không được vận khí tốt từ sao Bát Bạch.<br/>';
				$points = 0;
			}
			$array = array ('points' =>$points, 'html'=> $html);
			return $array;
		}
		/*
		 * 4. Hành quẻ bát quái:
		 */
		function hanh_que_bat_quai($sodienthoai){
			// cắt 10 số cuối
			$rest = substr($sodienthoai, -10);

			//căt 5 số đầu và cuối rồi đổi sang string
			$first_numbers = (string)(substr ( $rest, -10,5 ));
			$last_numbers = (string)(substr ( $rest, -5,5 ));
			
			//tính tổng 5 số đầu và 5 sô cuối
			$total_first = 0;
			$total_last = 0;
			for($i =0 ; $i <  strlen($first_numbers); $i++){
				$total_first += $first_numbers[$i];
			}
			for($j =0 ; $j <  strlen($last_numbers); $j++){
				$total_last += $last_numbers[$j];
			}
			
			//Tính quái Thượng và quái Hạ
			$tuong_que   = array(0=>'Khôn',1=>'Càn',2=>'Đoài',3=>'Ly',4=>'Chấn',5=>'Tốn',6=>'Khảm',7=>'Cấn');
			$quai_thuong = $tuong_que[$total_first%8];
			$quai_ha     = $tuong_que[$total_last%8];
			$to_hop_the_arr =array(1=>array(0=>'Càn',1=>'Càn'),2=>array(0=>'Khôn',1=>'Khôn'),3=>array(0=>'Khảm',1=>'Chấn'),4=>array(0=>'Cấn',1=>'Khảm'),5=>array(0=>'Khảm',1=>'Càn'),
								   6=>array(0=>'Càn',1=>'Khảm'),7=>array(0=>'Khôn',1=>'Khảm'),8=>array(0=>'Khảm',1=>'Khôn'),9=>array(0=>'Tốn',1=>'Càn'),10=>array(0=>'Càn',1=>'Đoài'),
								   11=>array(0=>'Khôn',1=>'Càn'),12=>array(0=>'Càn',1=>'Khôn'),13=>array(0=>'Càn',1=>'Ly'),14=>array(0=>'Ly',1=>'Càn'),15=>array(0=>'Khôn',1=>'Cấn'),
								   16=>array(0=>'Chấn',1=>'Khôn'),17=>array(0=>'Đoài',1=>'Chấn'),18=>array(0=>'Cấn',1=>'Tốn'),19=>array(0=>'Khôn',1=>'Đoài'),20=>array(0=>'Tốn',1=>'Tốn'),
								   21=>array(0=>'Ly',1=>'Chấn'),22=>array(0=>'Cấn',1=>'Ly'),23=>array(0=>'Cấn',1=>'Khôn'),24=>array(0=>'Khôn',1=>'Chấn'),25=>array(0=>'Càn',1=>'Chấn'),
								   26=>array(0=>'Chấn',1=>'Càn'),27=>array(0=>'Cấn',1=>'Chấn'),28=>array(0=>'Đoài',1=>'Tốn'),29=>array(0=>'Khảm',1=>'Khảm'),30=>array(0=>'Ly',1=>'Ly'),
								   31=>array(0=>'Đoài',1=>'Cấn'),32=>array(0=>'Chấn',1=>'Tốn'),33=>array(0=>'Càn',1=>'Cấn'),34=>array(0=>'Chấn',1=>'Càn'),35=>array(0=>'Ly',1=>'Khôn'),
								   36=>array(0=>'Khôn',1=>'Ly'),37=>array(0=>'Tốn',1=>'Ly'),38=>array(0=>'Ly',1=>'Đoài'),39=>array(0=>'Khảm',1=>'Cấn'),40=>array(0=>'Cấn',1=>'Đoài'),
								   41=>array(0=>'Cấn',1=>'Đoài'),42=>array(0=>'Tốn',1=>'Chấn'),43=>array(0=>'Đoài',1=>'Càn'),44=>array(0=>'Càn',1=>'Tốn'),45=>array(0=>'Đoài',1=>'Khôn'),
								   46=>array(0=>'Khôn',1=>'Tốn'),47=>array(0=>'Đoài',1=>'Khảm'),48=>array(0=>'Khảm',1=>'Tốn'),49=>array(0=>'Đoài',1=>'Ly'),50=>array(0=>'Ly',1=>'Tốn'),
								   51=>array(0=>'Chấn',1=>'Chấn'),52=>array(0=>'Cấn',1=>'Cấn'),53=>array(0=>'Tốn',1=>'Cấn'),54=>array(0=>'Chấn',1=>'Đoài'),55=>array(0=>'Chấn',1=>'Ly'),
								   56=>array(0=>'Ly',1=>'Cấn'),57=>array(0=>'Tốn',1=>'Tốn'),58=>array(0=>'Đoài',1=>'Đoài'),59=>array(0=>'Tốn',1=>'Khảm'),60=>array(0=>'Khảm',1=>'Đoài'),
								   61=>array(0=>'Tốn',1=>'Đoài'),62=>array(0=>'Chấn',1=>'Cấn'),63=>array(0=>'Khảm',1=>'Ly'),64=>array(0=>'Ly',1=>'Khảm'));
			$so_que = array_search(array(0=>$quai_thuong,1=>$quai_ha), $to_hop_the_arr);
			if(!isset($so_que)) 
				$so_que = 0;
			$que_chu = $this -> get_que($so_que);
			$que_ho = $this -> get_que(isset($que_chu->que_ho)?$que_chu->que_ho:0);
								   
			$html = '';
			$html .= '<h3>4. Hành quẻ bát quái:</h3>';
			$html .= 'Theo lý thuyết Kinh Dịch, mỗi sự vật hiện tượng đều bị chi phối bởi các quẻ trùng quái, trong đó quẻ Chủ là quẻ đóng vai trò chủ đạo, chi phối quan trọng nhất đến sự vật, hiện tượng đó. Bên cạnh đó là quẻ Hỗ, mang tính chất bổ trợ thêm.<br/>';
			$html .= '<h3>4.1. Quẻ chủ:</h3>';
			$html .= '- Quẻ chủ của dãy số là quẻ số <span class="text-bold text-primary">'.@$que_chu->que_so.'</span> | <span class="text-bold text-primary">'.@$que_chu->ten_goi.'</span><br/>';
			$html .= '- Quẻ kết hợp bởi nội quái là <span class="text-bold text-primary">'.$quai_ha.'</span> và ngoại quái là <span class="text-bold text-primary">'.$quai_thuong.'</span><br/>';
			$html .= '- <strong> Ý nghĩa</strong>  : '.@$que_chu->dien_giai.'<br/>';
			$html .= '- <strong> Nhận xét</strong> : '.@$que_chu->ket_luan.'<br/>';
			$html .= '<p align="center">';
			$html .= '<b>Quẻ chủ</b><br/>';
			$html .= '(Quẻ số '.$so_que.')<br/>';
			$html .= '<img src="'.URL_ROOT.(@$que_chu->image).'" alt ="'.@$que_chu->ten_goi.'"><br/>';
			$html .= '<b>'.@$que_chu->ten_goi.'</b><br/>';
			$html .= '</p>';
			$html .= '<h3>4.2. Quẻ Hỗ:</h3>';
			$html .= '- Quẻ Hỗ được tạo thành từ quẻ thượng là các hào 5,4,3 của quẻ chủ, quẻ hạ là các hào 4,3,2 của quẻ chủ.<br/>';
			$html .= '- Đây là quẻ số <span class="text-bold text-primary"> '.@$que_ho->que_so.'</span> | <span class="text-bold text-primary">'.@$que_ho->ten_goi.'</span><br/>';
			$html .= ' - '.@$que_ho->ket_hop_cua.'<br/>';
			$html .= '- <b>Ý nghĩa</b> : '.@$que_ho->dien_giai.'<br/>';
			$html .= '- <b>Nhận xét</b> :'.@$que_ho->ket_luan.'<br/>';
			$html .= '<p align="center">';
			$html .= '<b>Quẻ chủ</b><br/>';
			$html .= '(Quẻ số '.@$que_ho->que_so.')<br/>';
			$html .= '<img src="'.URL_ROOT.(@$que_ho->image).'" alt ="'.@$que_ho->ten_goi.'"><br/>';
			$html .= '<b>'.@$que_ho->ten_goi.'</b><br/>';
			$html .= '</p>';
			
			$points_chu = @$que_chu->diem;
			$points_ho = @$que_ho->diem;
			$points = $points_chu + $points_ho;
			
			$array = array ('points' =>$points, 'html'=> $html);
			return $array;
		}	
		/*
		 * 4. Hành quẻ bát quái (chỉ tính điểm):
		 */
		function hanh_que_bat_quai_to_point($sodienthoai){
			// cắt 10 số cuối
			$rest = substr($sodienthoai, -10);

			//căt 5 số đầu và cuối rồi đổi sang string
			$first_numbers = (string)(substr ( $rest, -10,5 ));
			$last_numbers = (string)(substr ( $rest, -5,5 ));
			
			//tính tổng 5 số đầu và 5 sô cuối
			$total_first = 0;
			$total_last = 0;
			for($i =0 ; $i <  strlen($first_numbers); $i++){
				$total_first += $first_numbers[$i];
			}
			for($j =0 ; $j <  strlen($last_numbers); $j++){
				$total_last += $last_numbers[$j];
			}
			
			//Tính quái Thượng và quái Hạ
			$tuong_que   = array(0=>'Khôn',1=>'Càn',2=>'Đoài',3=>'Ly',4=>'Chấn',5=>'Tốn',6=>'Khảm',7=>'Cấn');
			$quai_thuong = $tuong_que[$total_first%8];
			$quai_ha     = $tuong_que[$total_last%8];
			$to_hop_the_arr =array(1=>array(0=>'Càn',1=>'Càn'),2=>array(0=>'Khôn',1=>'Khôn'),3=>array(0=>'Khảm',1=>'Chấn'),4=>array(0=>'Cấn',1=>'Khảm'),5=>array(0=>'Khảm',1=>'Càn'),
								   6=>array(0=>'Càn',1=>'Khảm'),7=>array(0=>'Khôn',1=>'Khảm'),8=>array(0=>'Khảm',1=>'Khôn'),9=>array(0=>'Tốn',1=>'Càn'),10=>array(0=>'Càn',1=>'Đoài'),
								   11=>array(0=>'Khôn',1=>'Càn'),12=>array(0=>'Càn',1=>'Khôn'),13=>array(0=>'Càn',1=>'Ly'),14=>array(0=>'Ly',1=>'Càn'),15=>array(0=>'Khôn',1=>'Cấn'),
								   16=>array(0=>'Chấn',1=>'Khôn'),17=>array(0=>'Đoài',1=>'Chấn'),18=>array(0=>'Cấn',1=>'Tốn'),19=>array(0=>'Khôn',1=>'Đoài'),20=>array(0=>'Tốn',1=>'Tốn'),
								   21=>array(0=>'Ly',1=>'Chấn'),22=>array(0=>'Cấn',1=>'Ly'),23=>array(0=>'Cấn',1=>'Khôn'),24=>array(0=>'Khôn',1=>'Chấn'),25=>array(0=>'Càn',1=>'Chấn'),
								   26=>array(0=>'Chấn',1=>'Càn'),27=>array(0=>'Cấn',1=>'Chấn'),28=>array(0=>'Đoài',1=>'Tốn'),29=>array(0=>'Khảm',1=>'Khảm'),30=>array(0=>'Ly',1=>'Ly'),
								   31=>array(0=>'Đoài',1=>'Cấn'),32=>array(0=>'Chấn',1=>'Tốn'),33=>array(0=>'Càn',1=>'Cấn'),34=>array(0=>'Chấn',1=>'Càn'),35=>array(0=>'Ly',1=>'Khôn'),
								   36=>array(0=>'Khôn',1=>'Ly'),37=>array(0=>'Tốn',1=>'Ly'),38=>array(0=>'Ly',1=>'Đoài'),39=>array(0=>'Khảm',1=>'Cấn'),40=>array(0=>'Cấn',1=>'Đoài'),
								   41=>array(0=>'Cấn',1=>'Đoài'),42=>array(0=>'Tốn',1=>'Chấn'),43=>array(0=>'Đoài',1=>'Càn'),44=>array(0=>'Càn',1=>'Tốn'),45=>array(0=>'Đoài',1=>'Khôn'),
								   46=>array(0=>'Khôn',1=>'Tốn'),47=>array(0=>'Đoài',1=>'Khảm'),48=>array(0=>'Khảm',1=>'Tốn'),49=>array(0=>'Đoài',1=>'Ly'),50=>array(0=>'Ly',1=>'Tốn'),
								   51=>array(0=>'Chấn',1=>'Chấn'),52=>array(0=>'Cấn',1=>'Cấn'),53=>array(0=>'Tốn',1=>'Cấn'),54=>array(0=>'Chấn',1=>'Đoài'),55=>array(0=>'Chấn',1=>'Ly'),
								   56=>array(0=>'Ly',1=>'Cấn'),57=>array(0=>'Tốn',1=>'Tốn'),58=>array(0=>'Đoài',1=>'Đoài'),59=>array(0=>'Tốn',1=>'Khảm'),60=>array(0=>'Khảm',1=>'Đoài'),
								   61=>array(0=>'Tốn',1=>'Đoài'),62=>array(0=>'Chấn',1=>'Cấn'),63=>array(0=>'Khảm',1=>'Ly'),64=>array(0=>'Ly',1=>'Khảm'));
			$so_que = array_search(array(0=>$quai_thuong,1=>$quai_ha), $to_hop_the_arr);
			if(!isset($so_que)) 
				$so_que = 0;
			
			// mảng quẻ hỗ trợ ko vào db
			$array_que = array(
				'1' => array('1', '1'),
				'2' => array('2', '1'),
				'3' => array('23', '0'),
				'4' => array('24', '0'),
				'5' => array('38', '0'),
				'6' => array('37', '0'),
				'7' => array('24', '1'),
				'8' => array('23', '1'),
				'9' => array('38', '0'),
				'10' => array('37', '0.5'),
				'11' => array('54', '1'),
				'12' => array('53', '0'),
				'13' => array('44', '1'),
				'14' => array('43', '0.5'),
				'15' => array('40', '0.5'),
				'16' => array('39', '1'),
				'17' => array('53', '0'),
				'18' => array('54', '0'),
				'19' => array('24', '1'),
				'20' => array('23', '0.5'),
				'21' => array('39', '0'),
				'22' => array('40', '1'),
				'23' => array('2', '0'),
				'24' => array('2', '0.5'),
				'25' => array('53', '0'),
				'26' => array('54', '1'),
				'27' => array('2', '1'),
				'28' => array('1', '0.5'),
				'29' => array('27', '0'),
				'30' => array('28', '0.5'),
				'31' => array('44', '1'),
				'32' => array('43', '1'),
				'33' => array('44', '0'),
				'34' => array('43', '1'),
				'35' => array('39', '1'),
				'36' => array('40', '0'),
				'37' => array('64', '1'),
				'38' => array('63', '0'),
				'39' => array('39', '0'),
				'40' => array('63', '1'),
				'41' => array('24', '0'),
				'42' => array('23', '1'),
				'43' => array('1', '0.5'),
				'44' => array('1', '0'),
				'45' => array('1', '0.5'),
				'46' => array('54', '1'),
				'47' => array('37', '0'),
				'48' => array('38', '0.5'),
				'49' => array('44', '0.5'),
				'50' => array('43', '1'),
				'51' => array('39', '0.5'),
				'52' => array('40', '0'),
				'53' => array('64', '1'),
				'54' => array('63', '0'),
				'55' => array('28', '1'),
				'56' => array('28', '0'),
				'57' => array('38', '0'),
				'58' => array('37', '1'),
				'59' => array('27', '0'),
				'60' => array('27', '0.5'),
				'61' => array('27', '1'),
				'62' => array('28', '0'),
				'63' => array('64', '1'),
				'64' => array('63', '0'),
			
			);
			$que_chu = isset($array_que[$so_que])?$array_que[$so_que]:array('0','0');
			$que_ho = isset($array_que[$que_chu[0]])?$array_que[$que_chu[0]]:array('0','0');
			$point_chu = $que_chu[1];
			$point_ho = $que_ho[1];
			$point = $point_chu + $point_ho;
			
			$array = array ('points' =>$point, 'html'=> '');
			return $array;
		}	
		
		function quan_niem_dan_gian($sodienthoai){
			$sim_str = (string)$sodienthoai ;
			$tong_nut = 0;
			for($i =0 ; $i <  strlen($sim_str); $i++){
					$tong_nut += $sim_str[$i];
			}
			$tong_nut = substr($tong_nut, -1);
			$sim = $this -> get_sims($sodienthoai);
			
			$html = '';
			$html .= '<h3>5. Quan niệm dân gian:</h3>';
			
			if ($tong_nut == 0|| $tong_nut == 1 || $tong_nut == 2 || $tong_nut == 3 || $tong_nut == 4){
				$html .= '- Tổng số nút của dãy số:<span class="text-bold text-primary">'.$tong_nut.'</span>  - <span class="text-bold text-primary">Số nước quá thấp, dãy số chưa thực sự đẹp.</span>  <br />';
				$points = 0;
			}elseif ($tong_nut == 5|| $tong_nut == 6 || $tong_nut == 7) {
				$html .= '- Tổng số nút của dãy số:<span class="text-bold text-primary">'.$tong_nut.'</span> - <span class="text-bold text-primary">Số nước bình thường.</span><br />';
				$points = 0.5;
			}else{
					$html .= '- Tổng số nút của dãy số:<span class="text-bold text-primary">'.$tong_nut.'</span> - <span class="text-bold text-primary">Số nước cao, dãy số đẹp.</span> <br />';
				$points = 1;
			}
			if($sim){
				$html .= '- Loại sim : <strong>'.$sim->category_name.'</strong>';
			}
			$array = array ('points' =>$points, 'html'=> $html);
			
			return $array;
			
		}
		function ket_luan($total_points,$sodienthoai){
			$sim = $this -> get_sims($sodienthoai);
			if($sim){
				if(isset($sim) && $sim -> is_own == 1 ){
					if($total_points < 5){
						$total_points += 2;
					}elseif(5 <= $total_points  && $total_points <= 7){
						$total_points += 1.5;
					}elseif ($total_points < 8){
						$total_points += 1;
					}
				}
			}
			$html = '';
			$html .= '<div align="center" style="font-size:20px">KẾT LUẬN:</div>';
			$html .= '<p align="center">Tổng điểm là :<span class="text-bold text-danger" style="font-size:15px;"> '.$total_points.' / 10 </span>điểm';
			if($total_points < 5){
				$html .= '<p class="text-bold text-primary" align="center">Sim có điểm phong thủy không thực sự đẹp. Bạn nên chọn một số có điểm phong thủy tốt hơn.</p>';
			}elseif(5 <= $total_points && $total_points <= 7){
				$html .= '<p class="text-bold text-primary" align="center">Sim có điểm phong thủy bình thường. Sẽ đẹp hơn nếu bạn tham khảo thêm những số khác.</p>';
			}elseif(7 < $total_points && $total_points < 9){
				$html .= '<p class="text-bold text-primary" align="center">Sim có điểm phong thủy khá đẹp, chúc mừng bạn</p>';
			}elseif(9 <= $total_points && $total_points <= 10){
				$html .= '<p class="text-bold text-primary" align="center">Sim có điểm phong thủy rất đẹp, chúc mừng bạn.</p>';
			}
			return  $html;
			
		}
		function count_chars_unicode($str, $x = false) {
		    $tmp = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
		    foreach ($tmp as $c) {
		        $chr[$c] = isset($chr[$c]) ? $chr[$c] + 1 : 1;
		    }
		    return is_bool($x)
		        ? ($x ? $chr : count($chr))
		        : $chr[$x];
		}
		function INT($d) {
		    return floor($d);
		}
				
		function jdFromDate($dd, $mm, $yy) {
		    $a = $this->INT((14 - $mm) / 12);
		    $y = $yy + 4800 - $a;
		    $m = $mm + 12 * $a - 3;
		    $jd = $dd + $this->INT((153 * $m + 2) / 5) + 365 * $y + $this->INT($y / 4) - $this->INT($y / 100) + $this->INT($y / 400) - 32045;
		    if ($jd < 2299161) {
		        $jd = $dd + $this->INT((153* $m + 2)/5) + 365 * $y + $this->INT($y / 4) - 32083;
		    }
		    return $jd;
		}
		
		function jdToDate($jd) {
		    if ($jd > 2299160) { // After 5/10/1582, Gregorian calendar
		        $a = $jd + 32044;
		        $b = $this->INT((4*$a+3)/146097);
		        $c = $a - $this->INT(($b*146097)/4);
		    } else {
		        $b = 0;
		        $c = $jd + 32082;
		    }
		    $d = $this->INT((4*$c+3)/1461);
		    $e = $c - $this->INT((1461*$d)/4);
		    $m = $this->INT((5*$e+2)/153);
		    $day = $e - $this->INT((153*$m+2)/5) + 1;
		    $month = $m + 3 - 12*$this->INT($m/10);
		    $year = $b*100 + $d - 4800 + $this->INT($m/10);
		    //echo "day = $day, month = $month, year = $year\n";
		    return array($day, $month, $year);
		}
		
		function getNewMoonDay($k, $timeZone) {
		    $T = $k/1236.85; // Time in Julian centuries from 1900 January 0.5
		    $T2 = $T * $T;
		    $T3 = $T2 * $T;
		    $dr = M_PI/180;
		    $Jd1 = 2415020.75933 + 29.53058868*$k + 0.0001178*$T2 - 0.000000155*$T3;
		    $Jd1 = $Jd1 + 0.00033*sin((166.56 + 132.87*$T - 0.009173*$T2)*$dr); // Mean new moon
		    $M = 359.2242 + 29.10535608*$k - 0.0000333*$T2 - 0.00000347*$T3; // Sun's mean anomaly
		    $Mpr = 306.0253 + 385.81691806*$k + 0.0107306*$T2 + 0.00001236*$T3; // Moon's mean anomaly
		    $F = 21.2964 + 390.67050646*$k - 0.0016528*$T2 - 0.00000239*$T3; // Moon's argument of latitude
		    $C1=(0.1734 - 0.000393*$T)*sin($M*$dr) + 0.0021*sin(2*$dr*$M);
		    $C1 = $C1 - 0.4068*sin($Mpr*$dr) + 0.0161*sin($dr*2*$Mpr);
		    $C1 = $C1 - 0.0004*sin($dr*3*$Mpr);
		    $C1 = $C1 + 0.0104*sin($dr*2*$F) - 0.0051*sin($dr*($M+$Mpr));
		    $C1 = $C1 - 0.0074*sin($dr*($M-$Mpr)) + 0.0004*sin($dr*(2*$F+$M));
		    $C1 = $C1 - 0.0004*sin($dr*(2*$F-$M)) - 0.0006*sin($dr*(2*$F+$Mpr));
		    $C1 = $C1 + 0.0010*sin($dr*(2*$F-$Mpr)) + 0.0005*sin($dr*(2*$Mpr+$M));
		    if ($T < -11) {
		        $deltat= 0.001 + 0.000839*$T + 0.0002261*$T2 - 0.00000845*$T3 - 0.000000081*$T*$T3;
		    } else {
		        $deltat= -0.000278 + 0.000265*$T + 0.000262*$T2;
		    };
		    $JdNew = $Jd1 + $C1 - $deltat;
		    //echo "JdNew = $JdNew\n";
		    return $this->INT($JdNew + 0.5 + $timeZone/24);
		}
		
		function getSunLongitude($jdn, $timeZone) {
		    $T = ($jdn - 2451545.5 - $timeZone/24) / 36525; // Time in Julian centuries from 2000-01-01 12:00:00 GMT
		    $T2 = $T * $T;
		    $dr = M_PI/180; // degree to radian
		    $M = 357.52910 + 35999.05030*$T - 0.0001559*$T2 - 0.00000048*$T*$T2; // mean anomaly, degree
		    $L0 = 280.46645 + 36000.76983*$T + 0.0003032*$T2; // mean longitude, degree
		    $DL = (1.914600 - 0.004817*$T - 0.000014*$T2)*sin($dr*$M);
		    $DL = $DL + (0.019993 - 0.000101*$T)*sin($dr*2*$M) + 0.000290*sin($dr*3*$M);
		    $L = $L0 + $DL; // true longitude, degree
		    //echo "\ndr = $dr, M = $M, T = $T, DL = $DL, L = $L, L0 = $L0\n";
		    // obtain apparent longitude by correcting for nutation and aberration
		    $omega = 125.04 - 1934.136 * $T;
//		    $L = $L - 0.00569 - 0.00478 * Math.sin($omega * $dr);
		    $L = $L*$dr;
		    $L = $L - M_PI*2*($this->INT($L/(M_PI*2))); // Normalize to (0, 2*PI)
		    return $this->INT($L/M_PI*6);
		}
		
		function getLunarMonth11($yy, $timeZone) {
		    $off = $this->jdFromDate(31, 12, $yy) - 2415021;
		    $k = $this->INT($off / 29.530588853);
		    $nm = $this->getNewMoonDay($k, $timeZone);
		    $sunLong = $this->getSunLongitude($nm, $timeZone); // sun longitude at local midnight
		    if ($sunLong >= 9) {
		        $nm = $this->getNewMoonDay($k-1, $timeZone);
		    }
		    return $nm;
		}
		
		function getLeapMonthOffset($a11, $timeZone) {
		    $k = $this->INT(($a11 - 2415021.076998695) / 29.530588853 + 0.5);
		    $last = 0;
		    $i = 1; // We start with the month following lunar month 11
		    $arc = $this->getSunLongitude($this->getNewMoonDay($k + $i, $timeZone), $timeZone);
		    do {
		        $last = $arc;
		        $i = $i + 1;
		        $arc = $this->getSunLongitude($this->getNewMoonDay($k + $i, $timeZone), $timeZone);
		    } while ($arc != $last && $i < 14);
		    return $i - 1;
		}
		
		/* Comvert solar date dd/mm/yyyy to the corresponding lunar date */
		function convertSolar2Lunar($dd, $mm, $yy, $timeZone) {
				
		    $dayNumber = $this->jdFromDate($dd, $mm, $yy);
		    $k = $this->INT(($dayNumber - 2415021.076998695) / 29.530588853);
		    $monthStart = $this->getNewMoonDay($k+1, $timeZone);
		    if ($monthStart > $dayNumber) {
		        $monthStart = $this->getNewMoonDay($k, $timeZone);
		    }
		    $a11 = $this->getLunarMonth11($yy, $timeZone);
		    $b11 = $a11;
		    if ($a11 >= $monthStart) {
		        $lunarYear = $yy;
		        $a11 = $this->getLunarMonth11($yy-1, $timeZone);
		    } else {
		        $lunarYear = $yy+1;
		        $b11 = $this->getLunarMonth11($yy+1, $timeZone);
		    }
		    $lunarDay = $dayNumber - $monthStart + 1;
		    $diff = $this->INT(($monthStart - $a11)/29);
		    $lunarLeap = 0;
		    $lunarMonth = $diff + 11;
		    if ($b11 - $a11 > 365) {
		        $leapMonthDiff = $this->getLeapMonthOffset($a11, $timeZone);
		        if ($diff >= $leapMonthDiff) {
		            $lunarMonth = $diff + 10;
		            if ($diff == $leapMonthDiff) {
		                $lunarLeap = 1;
		            }
		        }
		    }
		    if ($lunarMonth > 12) {
		        $lunarMonth = $lunarMonth - 12;
		    }
		    if ($lunarMonth >= 11 && $diff < 4) {
		        $lunarYear -= 1;
		    }
		    return array($lunarDay, $lunarMonth, $lunarYear, $lunarLeap);
		}
		
		/* Convert a lunar date to the corresponding solar date */
		function convertLunar2Solar($lunarDay, $lunarMonth, $lunarYear, $lunarLeap, $timeZone) {
		    if ($lunarMonth < 11) {
		        $a11 = $this->getLunarMonth11($lunarYear-1, $timeZone);
		        $b11 = $this->getLunarMonth11($lunarYear, $timeZone);
		    } else {
		        $a11 = $this->getLunarMonth11($lunarYear, $timeZone);
		        $b11 = $this->getLunarMonth11($lunarYear+1, $timeZone);
		    }
		    $k = $this->INT(0.5 + ($a11 - 2415021.076998695) / 29.530588853);
		    $off = $lunarMonth - 11;
		    if ($off < 0) {
		        $off += 12;
		    }
		    if ($b11 - $a11 > 365) {
		        $leapOff = $this->getLeapMonthOffset($a11, $timeZone);
		        $leapMonth = $leapOff - 2;
		        if ($leapMonth < 0) {
		            $leapMonth += 12;
		        }
		        if ($lunarLeap != 0 && $lunarMonth != $leapMonth) {
		            return array(0, 0, 0);
		        } else if ($lunarLeap != 0 || $off >= $leapOff) {
		            $off += 1;
		        }
		    }
		    $monthStart = $this->getNewMoonDay($k + $off, $timeZone);
		    return $this->jdToDate($monthStart + $lunarDay - 1);
		}
		function convertCanChi($al){
			$can_nam   = '';
			$chi_nam   ='';
			$can_thang ='';
			$chi_thang ='';
			$can_ngay  ='';
			$chi_ngay  ='';
			switch (($al[2] +6)%10){
				case 0:
					$can_nam = 'Giáp';
				break;
				case 1:
					$can_nam = 'Ất';
				break;
				case 2:
					$can_nam = 'Bính';
				break;
				case 3:
					$can_nam = 'Đinh';
				break;
				case 4:
					$can_nam = 'Mậu';
				break;
				case 5:
					$can_nam = 'Kỉ';
				break;
				case 6:
					$can_nam = 'Canh';
				break;
				case 7:
					$can_nam = 'Tân';
				break;
				case 8:
					$can_nam = 'Nhâm';
				break;
				case 9:
					$can_nam = 'Qúy';
				break;
			}
			switch (($al[2] +8)%12){
				case 0:
					$chi_nam = 'Tý';
				break;
				case 1:
					$chi_nam = 'Sửu';
				break;
				case 2:
					$chi_nam = 'Dần';
				break;
				case 3:
					$chi_nam = 'Mão';
				break;
				case 4:
					$chi_nam = 'Thìn';
				break;
				case 5:
					$chi_nam = 'Tỵ';
				break;
				case 6:
					$chi_nam = 'Ngọ';
				break;
				case 7:
					$chi_nam = 'Mùi';
				break;
				case 8:
					$chi_nam = 'Thân';
				break;
				case 9:
					$chi_nam = 'Dậu';
				break;
				case 10:
					$chi_nam = 'Tuất';
				break;
				case 11:
					$chi_nam = 'Hợi';
				break;
			}
			switch(($al[2]*12+$al[1]+3)%10){
				case 0:
					$can_thang = 'Giáp';
				break;
				case 1:
					$can_thang = 'Ất';
				break;
				case 2:
					$can_thang = 'Bính';
				break;
				case 3:
					$can_thang = 'Đinh';
				break;
				case 4:
					$can_thang = 'Mậu';
				break;
				case 5:
					$can_thang = 'Kỉ';
				break;
				case 6:
					$can_thang = 'Canh';
				break;
				case 7:
					$can_thang = 'Tân';
				break;
				case 8:
					$can_thang = 'Nhâm';
				break;
				case 9:
					$can_thang = 'Qúy';
				break;
			}
			switch ($al[1]){
				case 1:
					$chi_thang = 'Dần';
				break;
				case 2:
					$chi_thang = 'Mão';
				break;
				case 3:
					$chi_thang = 'Thìn';
				break;
				case 4:
					$chi_thang = 'Tỵ';
				break;
				case 5:
					$chi_thang = 'Ngọ';
				break;
				case 6:
					$chi_thang = 'Mùi';
				break;
				case 7:
					$chi_thang = 'Thân';
				break;
				case 8:
					$chi_thang = 'Dậu';
				break;
				case 9:
					$chi_thang = 'Tuất';
				break;
				case 10:
					$chi_thang = 'Hợi';
				break;
				case 11:
					$chi_thang = 'Tý';
				break;
				case 12:
					$chi_thang = 'Sử';
				break;
			}
			switch (($al[0]+9) % 10){
				case 0:
					$can_ngay = 'Giáp';
				break;
				case 1:
					$can_ngay = 'Ất';
				break;
				case 2:
					$can_ngay = 'Bính';
				break;
				case 3:
					$can_ngay = 'Đinh';
				break;
				case 4:
					$can_ngay = 'Mậu';
				break;
				case 5:
					$can_ngay = 'Kỉ';
				break;
				case 6:
					$can_ngay = 'Canh';
				break;
				case 7:
					$can_ngay = 'Tân';
				break;
				case 8:
					$can_ngay = 'Nhâm';
				break;
				case 9:
					$can_ngay = 'Qúy';
				break;
			}
			switch (($al[0]+1) % 12){
				case 0:
					$chi_ngay = 'Tý';
				break;
				case 1:
					$chi_ngay = 'Sử';
				break;
				case 2:
					$chi_ngay = 'Dần';
				break;
				case 3:
					$chi_ngay = 'Mão';
				break;
				case 4:
					$chi_ngay = 'Thìn';
				break;
				case 5:
					$chi_ngay = 'Tỵ';
				break;
				case 6:
					$chi_ngay = 'Ngọ';
				break;
				case 7:
					$chi_ngay = 'Mùi';
				break;
				case 8:
					$chi_ngay = 'Thân';
				break;
				case 9:
					$chi_ngay = 'Dậu';
				break;
				case 10:
					$chi_ngay = 'Tuất';
				break;
				case 11:
					$chi_ngay = 'Hợi';
				break;
			}
			$can_chi_ngay  = array($can_ngay,$chi_ngay);
			$can_chi_thang =	array($can_thang,$chi_thang);
			$can_chi_nam   =	array($can_nam,$chi_nam);
			$can_chi = array($can_chi_ngay,$can_chi_thang,$can_chi_nam);
			return $can_chi;
		}
		
		/************ SELECT DB *********/
		function get_cung_menh($year) {
			if (! $year)
				return "";
			$query = " SELECT id,nam,nam_am_lich,ngu_hanh,giai_nghia,cung_menh
							FROM fs_ngu_hanh  
							WHERE nam = $year ";
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getObject ();
			return $result;
		}
		function get_que($so_que) {
			if(!isset($so_que))
				$so_que = 0;
			$query = " SELECT *
							FROM  fs_que
							WHERE que_so = $so_que ";
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getObject ();
			return $result;
		}
		function get_sims($sodienthoai) {
			$query = " SELECT *
							FROM  fs_sims
							WHERE number = $sodienthoai ";
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getObject ();
			return $result;
		}
		function convert_to_number($sim_number){
		$sim_number = str_replace(',','' , trim($sim_number));
		$sim_number = str_replace('+84','' , trim($sim_number));
		$sim_number = str_replace(' ','' , $sim_number);
		$sim_number = str_replace('.','' , $sim_number);
		$sim_number = intval($sim_number);
		$sim_number = '0'.$sim_number;
		return $sim_number;
	}
	}
	
?>
