<?php
class Sims {
	/*
	 * CHi được phép 4 số cuối = nhau. Nếu 5 số cuối = nhau là loại
	 */
	function check_type_tu_quy($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
		$sort_sim = substr ( $sim, - 5 );
		for($i = 1; $i < 4; $i ++) {
			if ($key) {
				if ($sort_sim [$i] != $key)
					return false;
			}
			if ($sort_sim [$i] != $sort_sim [$i + 1])
				return false;
		}
		if($sort_sim[0] == $sort_sim[1])
			return false;
		return true;
	}
	/*
	 * Tứ quý giữa
	 */
	function check_type_tu_quy_giua($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
		$sort_sim = $sim;
		$count_repeat = 0;
		$current_number = null;

		// duyệt các số trước số cuối ( 7 số)
		if ($key) {
			for($i = 0; $i < strlen($sort_sim); $i ++) {
				if ($sort_sim [$i] == $key) {
					$count_repeat ++;
					if ($count_repeat == 4){
						if($sort_sim [$i + 1] != $key && $i != (strlen($sort_sim)-1) )
							return true;
					}
						
				} else {
					$count_repeat = 1;
				}
			}
		} else {
			for($i = 0; $i < strlen($sort_sim); $i ++) {
				if ($sort_sim [$i] == $current_number) {
					$count_repeat ++;
					if ($count_repeat == 4){
						if($sort_sim [$i + 1] != $current_number &&  $i != (strlen($sort_sim)-1))
							return true;
					}
				} else {
					$current_number = $sort_sim [$i];
					$count_repeat = 1;
				}
			}
		}
		return false;
	}
	
	/*
	 * CHi được phép 5 số cuối = nhau. Nếu 6 số cuối = nhau là loại
	 */
function check_type_ngu_quy($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
		$count_repeat = 0;
		$current_number = null;

		// duyệt các số trước số cuối ( 7 số)
		if ($key) {
			for($i = 0; $i < strlen($sim); $i ++) {
				if ($sim [$i] == $key) {
					$count_repeat ++;
					// kiem tra nếu số lặp > 5
					if ($count_repeat == 5){
						if(@$sim [$i+1] != $key){
							return true;
						}
					}
				} else {
					$count_repeat = 1;
				}
			}
		} else {
			for($i = 0; $i < strlen($sim); $i ++) {
				 
				if ($sim [$i] == $current_number) {
					$count_repeat ++;
					if ($count_repeat == 5){
						if(@$sim [$i+1] != $current_number){
							return true;
						}
					}
				} else {
					$current_number = $sim [$i];
					$count_repeat = 1;
				}
			}
		}
		return false;
	}
	function check_type_luc_quy($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
		$count_repeat = 0;
		$current_number = null;

		// duyệt các số trước số cuối ( 7 số)
		if ($key) {
			for($i = 0; $i < strlen($sim); $i ++) {
				if ($sim [$i] == $key) {
					$count_repeat ++;
					// kiem tra nếu số lặp > 5
					if ($count_repeat == 6){
//						if(@$sim [$i+1] != $key){
							return true;
//						}
					}
				} else {
					$count_repeat = 1;
				}
			}
		} else {
			for($i = 0; $i < strlen($sim); $i ++) {
				 
				if ($sim [$i] == $current_number) {
					$count_repeat ++;
					if ($count_repeat == 6){
//						if(@$sim [$i+1] != $current_number){
							return true;
//						}
					}
				} else {
					$current_number = $sim [$i];
					$count_repeat = 1;
				}
			}
		}
		return false;
	}
	/*
	 * Lộc phát
	 * Những Sim có tận cùng là 68, 86, 688, 866, 6888, 8666 ; 689;  hoặc trong dãy số có 
	 *	chứa liền 689689; 168168;368368; 696969; 898989;  686868 hoặc  868686  liền nhau.
	 */
	function check_type_loc_phat($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
		
		// mảng chứa các số đặc biệt ở vị trí cuối cùng
		$array_end = array ('68', '86', '688', '866', '6888', '8666', '689' );
		// mảng chứa các số đặc biệt ở vị trí bất kì
		$array_full = array ('689689', '168168', '368368', '696969', '898989', '686868', '868686' );
		foreach ( $array_end as $item ) {
			$sort_sim = substr ( $sim, 0 - strlen ( $item ) );
			if ($sort_sim == $item)
				return true;
		}
		foreach ( $array_full as $item ) {
			if (strpos ( $sim, $item ) !== false)
				return true;
		}
	}
/*
	 * Sim số tiến
	 * Là sim có các cặp số tiến đều ( vd: 01.02.03, 10.20.30, 53.63.73), 
	 *	Hoặc trong dãy số có 6 số cuối mà số đằng trước nhỏ hơn số đằng sau tính từ trái qua phải
	 * Key: bao nhiêu số tiến (ở đuôi). Key >= 3, chỉ dùng cho check sim đơn. Bỏ key đi sẽ check cả đơn và kép
	 */
	function check_type_so_tien($sim, $key = 0,$price = 0) {
		if($this -> check_type_so_tien_don($sim,$key,$price))
			return true;
		if($this -> check_type_so_tien_doi($sim,$key,$price))
			return true;
		return false;
	}
	
	/*
	 * Sim số tiến
	 * Là sim có các cặp số tiến đều ( vd: 01.02.03, 10.20.30, 53.63.73), 
	 *	Hoặc trong dãy số có 6 số cuối mà số đằng trước nhỏ hơn số đằng sau tính từ trái qua phải
	 * Key: bao nhiêu số tiến (ở đuôi). Key >= 3, chỉ dùng cho check sim đơn. Bỏ key đi sẽ check cả đơn và kép
	 */
	function check_type_so_tien_full($sim, $key = 0,$price = 0) {
		if (!$sim)
			return false;
		if(!$key){
			$leng = 3;
		}else{
			$leng = $key;
		}
		
		// 6 số cuối tiến đều
		$sort_sim = substr ( $sim, (0-(int)$leng) );
		$count = 0;
		$between = 0;
		for($i = 0; $i < ($leng -1); $i ++){
			if(!$between)
				$between = $sort_sim[$i+1] > $sort_sim[$i] ? $sort_sim[$i+1] - $sort_sim[$i]:0;
			if($sort_sim[$i] == ($sort_sim[$i+1] - $between)){
				$count ++ ;
			}else 
				$count = 0;
		}	
		if($count == ($leng-1)){
			if(!$key) // nếu không có key, cứ 3 số cuối tiến là được
				return true;
			else{     // nếu có key ta cần set:chỉ 3 số cuối tiến là ok, nhưng 4 số là ko được
				if($sim[strlen($sim)-$leng-1] + $between != $sim[strlen($sim)-$leng])
					return true;
			}
		}
		if(!$key){ // key==null: se set cap so tien
			// cặp số tiến
			for($i = 0; $i < (strlen($sim) - 4); $i ++){
				if($sim[$i] ==  $sim[$i + 2] && $sim[$i] ==  $sim[$i + 4]){
					if(($sim[$i+1] > $sim[$i-1]) && ($sim[$i+1] - $sim[$i-1]) == ($sim[$i+3] - $sim[$i+1]) )
						return true;
					if(($sim[$i+3] > $sim[$i+1]) && ($sim[$i+3] - $sim[$i+1]) == ($sim[$i+5] - $sim[$i+3]) )
						return true;
							
//					if( ($sim[$i-1] +1 ) == $sim[$i+1] &&  ($sim[$i+1] +1 ) == $sim[$i+3] )
//						return true;
//					if( ($sim[$i+1] +1 ) == $sim[$i+3] &&  ($sim[$i+3] +1 ) == $sim[$i+5] )
//						return true;
				}
			}
		}
		return false;
	}
	/*
	 * Sim số tiến đơn
	 *	Hoặc trong dãy số có 6 số cuối mà số đằng trước nhỏ hơn số đằng sau tính từ trái qua phải
	 * Key: bao nhiêu số tiến (ở đuôi). Key >= 3, chỉ dùng cho check sim đơn. Bỏ key đi sẽ check cả đơn và kép
	 */
	function check_type_so_tien_don($sim, $key = 0,$price = 0) {
		if (!$sim)
			return false;
		if(!$key){
			$leng = 3;
		}else{
			$leng = $key;
		}
		
		// 6 số cuối tiến đều
		$sort_sim = substr ( $sim, (0-(int)$leng) );
		$count = 0;
		$between = 0;
		for($i = 0; $i < ($leng -1); $i ++){
			if(!$between)
				$between = $sort_sim[$i+1] > $sort_sim[$i] ? $sort_sim[$i+1] - $sort_sim[$i]:0;
			if($sort_sim[$i] == ($sort_sim[$i+1] - $between)){
				$count ++ ;
			}else 
				$count = 0;
		}	
		if($count == ($leng-1)){
			if(!$key) // nếu không có key, cứ 3 số cuối tiến là được
				return true;
			else{     // nếu có key ta cần set:chỉ 3 số cuối tiến là ok, nhưng 4 số là ko được
				if($sim[strlen($sim)-$leng-1] + $between != $sim[strlen($sim)-$leng])
					return true;
			}
		}
		return false;
	}
/*
	 * Sim số tiến đôi
	 * Là sim có các cặp số tiến đều ( vd: 01.02.03, 10.20.30, 53.63.73), 
	 *	Hoặc trong dãy số có 6 số cuối mà số đằng trước nhỏ hơn số đằng sau tính từ trái qua phải
	 * Key: bao nhiêu cặp số tiến (ở đuôi).
	 */
	function check_type_so_tien_doi($sim, $key = 0,$price = 0) {
		if (!$sim)
			return false;
		if(!$key){
			$leng = 3;
		}else{
			$leng = $key;
		}
		
		if($leng == 3){ // 3 cặp cuối tiến ( tính cả 3 cặp số đuôi và ko đuôi
			// cặp số tiến
			for($i = 0; $i < (strlen($sim) - 4); $i ++){
				if($sim[$i] ==  $sim[$i + 2] && $sim[$i] ==  $sim[$i + 4]){
					if(($sim[$i+1] > $sim[$i-1]) && ($sim[$i+1] - $sim[$i-1]) == ($sim[$i+3] - $sim[$i+1]) )
						return true;
					if(($sim[$i+3] > $sim[$i+1]) && ($sim[$i+3] - $sim[$i+1]) == ($sim[$i+5] - $sim[$i+3]) )
						return true;
				}
			}
		}elseif($leng == 2){ // 2 cặp cuối tiến
			$sort_sim = substr ( $sim, -4 );
			// cặp số tiến
			
			if($sort_sim[0] ==  $sort_sim[2] && $sort_sim[1] <  $sort_sim[3])
				return true;
			if($sort_sim[1] ==  $sort_sim[3] && $sort_sim[0] <  $sort_sim[2])		
				return true;
		}
		return false;
	}
	/*
	 * Sim số sảnh
	 */
	function check_type_so_sanh($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
		
		// 4 số cuối tiến đều
		$sort_sim = substr ( $sim, -4 );
		$count = 0;
		for($i = 0; $i < 3; $i ++){
			if($sort_sim[$i] == ($sort_sim[$i+1] - 1)){
				$count ++ ;
			}else 
				$count = 0;
		}	
		if($count == 3)
			return true;
		
		// cặp số tiến
		for($i = 0; $i < (strlen($sim)-1); $i ++){
			if($sim[$i] == ($sim[$i+1] - 1)){
				$count ++ ;
				if($count == 5)
					return true;
			}else 
				$count = 0;
		}	
		return false;
	}
	/*
	 * Thần tài ông địa
	 * Những Sim có tận cùng là 39, 79, 38, 78,3878; 7878;  ;  hoặc trong dãy số có 3 trong 4 cặp số 38; 78; 39; 79 đứng liền nhau
	 */
	function check_type_than_tai_ong_dia($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
		
		// mảng chứa các số đặc biệt ở vị trí cuối cùng
		$array_end = array (39, 79, 38, 78,3878, 7878);
		foreach ( $array_end as $item ) {
			$sort_sim = substr ( $sim, 0 - strlen ( $item ) );
			if ($sort_sim == $item)
				return true;
		}
		// 3 số kề nhau thuộc nhóm số (38, 78, 39, 79 )
		// đoạn này chưa kiểm tra được nếu số dạng 380387839 tức là số 38 đứng đầu nhưng không được duyệt
		$array_full = array ('38', '78', '39', '79');
		foreach ( $array_full as $item ) {
			if (strpos ( $sim, $item ) !== false){
				$pos = strpos ( $sim, $item );
				$sort_sim = substr ( $sim, ($pos+2) );
				foreach ( $array_full as $item ) {
					if (strpos ( $sort_sim, $item ) === 0){
						$sort_sim = substr ( $sort_sim, 2 );
						foreach ( $array_full as $item ) {
							if (strpos ( $sort_sim, $item ) === 0){
								return true;						
							}
						}				
					}
				}				
			}
		}
		return false;
	}
	
	/*
	 * Check sim tam hoa
	 * Là những Sim có 3 và chỉ 3 số cuối giống nhau ( Not 0902225.555 -> đây là SIm tứ quý chứ ko phải tam hoa )
	 */
function check_type_tam_hoa($sim, $key = null,$price = 0) {
		if (! $sim)
			return false;
		$sort_sim = substr ( $sim, - 4 );
		for($i = 1; $i < 3; $i ++) {
			if ($key || $key === '0' ) {
				if ($sort_sim [$i] != $key)
					return false;
			}
			if ($sort_sim [$i] != $sort_sim [$i + 1])
				return false;
		}
		if($sort_sim[0] == $sort_sim[1])
			return false;
		return true;
	}
	
	/*
	 * Tam hoa kép: chưa làm
	 */
	function check_type_tam_hoa_kep($sim, $key = '',$price = 0) {
		return false;
		if (! $sim)
			return false;
		$sort_sim = substr ( $sim, - 4 );
		for($i = 1; $i < 3; $i ++) {
			if ($key) {
				if ($sort_sim [$i] != $key)
					return false;
			}
			if ($sort_sim [$i] != $sort_sim [$i + 1])
				return false;
		}
		if($sort_sim[0] == $sort_sim[1])
			return false;
		return true;
	}
	/*
	 * Sim Taxi Cặp 3: Là những Sim có 6 số cuối trong đó có 3 số giống nhau từng đôi 1 
	 */
	function check_type_taxi_cap_3($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
		$sort_sim1 = substr ( $sim, -6,3 );
		$sort_sim2 = substr ( $sim, -3,3 );
		if($sort_sim1 != $sort_sim2)
			return false;
		if($sort_sim1[0] == $sort_sim1[2] )
			return false;
		return true;
	}
	/*
	 * Sim Taxi Cặp 2: Là những Sim có 6 số cuối trong đó có 3 số giống nhau từng đôi 1 
	 */
	function check_type_taxi_cap_2($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
		for($i = 0; $i < 6; $i ++){
			$long_sim = substr ( $sim, (-$i - 6),6 );	
			$sort_sim1 = substr ( $long_sim, -6,2 );
			$sort_sim2 = substr ( $long_sim, -4,2 );
			$sort_sim3 = substr ( $long_sim, -2,2 );
			if($sort_sim1 == $sort_sim2 && $sort_sim1 == $sort_sim3  ){
				// bỏ trùng với loại sim lục quý
				if($sort_sim1[0] != $sort_sim1[1] )
					return true;	
			}
		}
		return false;
	}
	/*
	 * sim số lặp: tránh trùng với taxi cặp 2
	 */
	function check_type_so_lap($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
		$sort_sim1 = substr ( $sim, -6,2 );
		$sort_sim2 = substr ( $sim, -4,2 );
		$sort_sim3 = substr ( $sim, -2,2 );
		// bỏ lặp với sim taxi cặp 2
		if($sort_sim2 == $sort_sim3 && $sort_sim1 != $sort_sim2){
			// tránh với sim tứ quý
			if($sort_sim3[0] != $sort_sim3[1])
				return true;
		}
		return false;
	}
	/*
	 * sim số kép: tránh trùng với số tứ quý 
	 */
	function check_type_so_kep($sim, $key = '',$price = 0) {
		if($this -> check_type_so_kep_2($sim, $key, $price))
			return true;
		if($this -> check_type_so_kep_3($sim, $key, $price))
			return true;
		return false;
	}
	/*
	 * sim số kép: tránh trùng với số tứ quý , kép 3
	 */
	function check_type_so_kep_2($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
		$sort_sim = substr ( $sim, -4 );
		$pre_sort_sim = substr ( $sim, -6 );
		if($sort_sim[0] == $sort_sim[1] && $sort_sim[2] == $sort_sim[3] && $sort_sim[1] != $sort_sim[2]){
			if($pre_sort_sim[0] == $pre_sort_sim[1])
				return false;
			else
				return true;
		}
			
		return false;
	}
	/*
	 * sim số kép 3: tránh trùng với số lục quý, tứ quý 
	 * key: aabbcc hay aabbaa
	 */
	function check_type_so_kep_3($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
		$sort_sim = substr ( $sim, -6 );
		if($key == 'aabbcc'){
			if($sort_sim[0] == $sort_sim[1] && $sort_sim[2] == $sort_sim[3] && $sort_sim[4] == $sort_sim[5]  && $sort_sim[1] != $sort_sim[2]  && $sort_sim[3] != $sort_sim[4] && $sort_sim[1] != $sort_sim[4]  )
				return true;
		}elseif($key == 'aabbaa'){
			if($sort_sim[0] == $sort_sim[1] && $sort_sim[2] == $sort_sim[3] && $sort_sim[4] == $sort_sim[5]  && $sort_sim[1] != $sort_sim[2]  && $sort_sim[3] != $sort_sim[4] && $sort_sim[1] == $sort_sim[4]  )
				return true;
		}else{
			if($sort_sim[0] == $sort_sim[1] && $sort_sim[2] == $sort_sim[3] && $sort_sim[4] == $sort_sim[5]  && $sort_sim[1] != $sort_sim[2]  && $sort_sim[3] != $sort_sim[4] )
				return true;
		}
		return false;
	}
	/*
	 * sim số gánh:
	 * 1. Số gánh đơn: Chỉ đơn giản là trong dãy số có ba số cuối tạo thành kiểu biểu trưng aba và ab ba. VD: 098 xxx x282
		2. Số gánh kép bằng: Trong bộ năm số cuối có 2 số giống nhau và có giá trị bằng nhau đối xứng qua một số có dạng ab-c-ab. VD: 098 xxx 12412
		3. Số gánh kép tiến: Trong bộ năm số cuối có hai số giống nhau nhưng có giá trị tãng dần đối xứng qua một số có dạng ab-c-ba (Điều kiện ab<ba). VD: 12421
		4. Số gánh kép lùi: Ngược lại với số gánh kép tiến. VD: 21412
		5. Số Taxi: Là trường hợp bộ gánh được lặp lại lớn hơn một lần đối với trường hợp gánh đơn có dạng aba aba. VD: 282 282
		6.Số gánh tam: Bộ bảy số cuối có 3 số giống nhau đối xứng qua một số và cũng gồm gánh tiến và gánh lùi có dạng abc d abc.
		7. Số gánh tứ: Thường rất hiếm và có dạng abcd e abcd, đồng thời cũng được chia thành gánh tiến và gánh lùi.
	 */
	function check_type_so_ganh($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
		// gánh đơn
		$sort_sim = substr ( $sim, -3 );
		if($sort_sim[0] == $sort_sim[2] && $sort_sim[2] != $sort_sim[1]){
			return true;
		}
		// gánh kép
		$sort_sim = substr ( $sim, -5 );
		$sort_sim1 = substr ( $sort_sim, 0,2 );
		$sort_sim2 = substr ( $sort_sim, 3,2 );
		// gánh kép bằng
		if($sort_sim1 == $sort_sim2)
			return true;
		// gánh kép đảo	
		if($sort_sim1[0] == $sort_sim2[1] && $sort_sim1[1] == $sort_sim2[0] && $sort_sim1[0] != $sort_sim1[1])
			return true;
		
		// gánh tam
		$sort_sim = substr ( $sim, -7 );
		$sort_sim1 = substr ( $sort_sim, 0,3 );
		$sort_sim2 = substr ( $sort_sim, 4,3 );
		// gánh tam bằng
		if($sort_sim1 == $sort_sim2)
			return true;
		// gánh tam đảo	
		if($sort_sim1[0] == $sort_sim2[2] && $sort_sim1[1] == $sort_sim2[1] && $sort_sim1[2] == $sort_sim2[0] && $sort_sim1[0] != $sort_sim1[1])
			return true;
			
		// gánh tứ: hiếm không làm
		return false;
	}
	
	function check_type_so_dao($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
			
		// đảo 2
		$sort_sim = substr ( $sim, -4 );
		$sort_sim1 = substr ( $sort_sim, 0,2 );
		$sort_sim2 = substr ( $sort_sim, 2,2 );
		// tránh trùng sim tứ quý
		if($sort_sim1[0] == $sort_sim2[1] && $sort_sim1[1] == $sort_sim2[0] && $sort_sim1[0] != $sort_sim1[1])
			return true;
		
		// đảo 3
		$sort_sim = substr ( $sim, -6 );
		$sort_sim1 = substr ( $sort_sim, 0,3 );
		$sort_sim2 = substr ( $sort_sim, 3,3 );
		// tránh trùng sim lục quý
		if($sort_sim1[0] == $sort_sim2[2] && $sort_sim1[1] == $sort_sim2[1] && $sort_sim1[2] == $sort_sim2[0] && ($sort_sim1[0] != $sort_sim1[1] || $sort_sim1[0] != $sort_sim1[2]))
			return true;
			
		// đảo 4: hiếm, ko phải check nhiều
		$sort_sim = substr ( $sim, -8 );
		$sort_sim1 = substr ( $sort_sim, 0,4 );
		$sort_sim2 = substr ( $sort_sim, 4,4 );
		if($sort_sim1[0] == $sort_sim2[3] && $sort_sim1[1] == $sort_sim2[2] && $sort_sim1[2] == $sort_sim2[1] && $sort_sim1[3] == $sort_sim2[0] )
			return true;
			
		return false;
	}
	/*
	 * Có 2 dạng: 19xx,20xx và dd/mm/yy
	 * Chưa test
	 */
function check_type_nam_sinh($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
			
		// 1930 -> year + 3
		$year = date('Y');
		$sort_sim = substr ( $sim, -4 );
		if($sort_sim >= 1930 && $sort_sim <= ($year +3) )
			return true;
		$sort_sim = substr ( $sim, -6 );
		$s_day =  substr ( $sort_sim, 0,2 );
		$s_month =  substr ( $sort_sim, 2,2 );
		$s_year =  substr ( $sort_sim, 4,2 );
//		if($s_year >= 30 || $s_year <= ( date('Y') +3) ){
		if($s_year >= 30 && $s_year <= 99 ){
			if($s_month > 0 && $s_month <=12){
				if($s_day > 0 && $s_day <=31){
					if(checkdate($s_month, $s_day, '19'.$s_year))
						return true;
				}	
			}			
		}
		return false;
	}
	
	/*
	 * Số cổ:
	 * 0912*; 0913* ; 0918*; 0919* ; 0903*; 0909*; 0908*; 0905*; 0904*; 0989*; 0983
	 */
	function check_type_so_co($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
		
		// mảng chứa đầu số
		$array_filter = array ('0912', '0913', '0918', '0919', '0903', '0909', '0908' ,'0905','0904','0989' ,'0983');
		foreach ( $array_filter as $item ) {
			if (strpos ( $sim, $item ) === 0)
				return true;
		}
	}
	/*
	 * Sim siêu vip
	 * Là những sim có giá trên 100 triệu
	 */
	function check_type_sieu_vip($sim, $key = '',$price = 0) {
		if (! $sim || !$price)
			return false;
		if($price >= 100000000)
			return true;
		return false;
	}
	/*
	 * Sim  vip
	 * Là những sim có giá trên 10 triệu
	 */
	function check_type_sim_vip($sim, $key = '',$price = 0) {
		if (! $sim || !$price)
			return false;
		if($price < 100000000 && $price >= 10000000)
			return true;
		return false;
	}
	/*
	 * Sim  bình dân
	 * Là những sim có giá trên 10 triệu
	 */
	function check_type_binh_dan($sim, $key = '',$price = 0) {
		if (! $sim)
			return false;
		if($price <= 3000000)
			return true;
		return false;
	}
	/*
	 * Nhà mạng
	 */
	function check_manu($sim, $first_toll) {
		if (! $sim || !$first_toll)
			return false;
		$array_first_toll = explode('-',$first_toll);	
		if(!count($array_first_toll))
			return false;
			
		foreach($array_first_toll as $item){
			if(!$item)
				continue;
			if (strpos ( $sim, $item ) === 0)
				return true;	
		}
		return false;
	}
}
?>