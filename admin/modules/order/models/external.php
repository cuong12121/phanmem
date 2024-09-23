<?php 
	require_once(PATH_BASE.'vendor/autoload.php');
	require_once('include/vendor/autoload.php');
	use Mpdf\Mpdf;
	class OrderModelsExternal extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'tags';
			$this -> table_name = 'fs_tags';
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}
		
		function bold($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET is_bold = $value
						WHERE id IN ( $str_ids ) " ;
				// $db->query($sql);
				$rows = $db->affected_rows($sql);
				return $rows;
			}
			// 	update sitemap
			if($this -> call_update_sitemap){
				$this -> call_update_sitemap();
			}
			
			return 0;
		}

		
		function save($row = array(), $use_mysql_real_escape_string = 1){

		
			if (!isset($_SESSION)) {
			    session_start();
			} 
			$link = $_SERVER['HTTP_REFERER'];

			$inputData = $_POST;

			// Lưu dữ liệu nhập liệu vào session
			$_SESSION['input_data'] = $inputData;

			$number = FSInput::get('number');


			$requester = FSInput::get('requester');
			$storeName = FSInput::get('storeName');
			$deliveryPerson = FSInput::get('deliveryPerson');
			// $department = FSInput::get('department');

			$shop_id = FSInput::get('shop_id');

			$warehouse_id = FSInput::get('warehouse_id');

			$house_id = FSInput::get('house_id');


			$customerPhone = FSInput::get('customerPhone');
			
			$diachinhanhang = FSInput::get('diachinhanhang');

			$tennguoinhan = FSInput::get('tennguoinhan');

			$timestamp = time();

			$date=date('Y/m/d');

			$dir = "files/dn/$date";
			if (!file_exists(PATH_BASE.$dir)) {
		        // Nếu đường dẫn không tồn tại, tạo các thư mục con cần thiết
		        mkdir(PATH_BASE.$dir, 0755, true); // 0755 là quyền truy cập, true để tạo các thư mục con nếu cần
		        
		    } 

			for ($i=1; $i <= $number; $i++) { 
				$productName = FSInput::get('productName'.$i);

				$productCode = FSInput::get('productCode'.$i);

				$soluong = FSInput::get('soluong'.$i);

				$phivanchuyen = FSInput::get('phivanchuyen'.$i);

				$skuplhang = FSInput::get('skuplhang'.$i);


				$tongsotiennguoimuathanhtoan = FSInput::get('tongsotiennguoimuathanhtoan'.$i);

				$dongia = FSInput::get('dongia'.$i);

				$thanhtien = FSInput::get('thanhtien'.$i);

				$hotennguoithutien = FSInput::get('hotennguoithutien'.$i);

				if($productName==''){
					$msg = 'Không được để trống tên sản phẩm thứ '.$i;
					setRedirect($link,$msg,'error');
				}

				if($productCode==''){
					$msg = 'Không được để trống mã đơn hàng thứ '.$i;
					setRedirect($link,$msg,'error');
				}

				if($soluong==''){
					$msg = 'Không được để trống Số lượng thứ '.$i;
					setRedirect($link,$msg,'error');
				}

				if($skuplhang==''){
					$msg = 'Không được để trống mã sku phân loại hàng thứ '.$i;
					setRedirect($link,$msg,'error');
				}


				if($phivanchuyen==''){
					$msg = 'Không được để trống Phí vận chuyển thứ '.$i;
					setRedirect($link,$msg,'error');
				}
				if($tongsotiennguoimuathanhtoan==''){
					$msg = 'Không được để trống Tổng số tiền người mua thanh toán thứ '.$i;
					setRedirect($link,$msg,'error');
				}

				if($dongia==''){
					$msg = 'Không được để trống đơn giá thứ '.$i;
					setRedirect($link,$msg,'error');
				}

				if($thanhtien==''){
					$msg = 'Không được để trống thành tiền '.$i;
					setRedirect($link,$msg,'error');
				}

				if($hotennguoithutien==''){
					$msg = 'Không được để trống Họ tên người thu tiền '.$i;
					setRedirect($link,$msg,'error');
				}
			}

			// Giả sử dữ liệu nhập liệu được truyền qua $_POST
			
			if($requester==''){

				$msg = 'Không được để trống họ tên người yêu cầu xuất';

				setRedirect($link,$msg,'error');
				
			}

			$shop_id = FSInput::get('shop_id');

			$warehouse_id = FSInput::get('warehouse_id');

			$house_id = FSInput::get('house_id');

			if($shop_id==0){
				$msg = 'Không được để trống shop';
				setRedirect($link,$msg,'error');
			}

			if($warehouse_id==0){
				$msg = 'Không được để trống kho';
				setRedirect($link,$msg,'error');
			}

			if($house_id==0){
				$msg = 'Không được để trống giờ';
				setRedirect($link,$msg,'error');
			}



			if($storeName==''){
				$msg = 'Không được để trống tên gian hàng';
				setRedirect($link,$msg,'error');
			}
			if($deliveryPerson==''){
				$msg = 'Không được để trống họ tên nvc giao';
				setRedirect($link,$msg,'error');
			}

			// if($department==''){
			// 	$msg = 'Không được để trống bộ phận';
			// 	setRedirect($link,$msg,'error');
			// }

			// if($storeCode==''){
			// 	$msg = 'Không được để trống mã gian hàng';
			// 	setRedirect($link,$msg,'error');
			// }

			if($customerPhone==''){
				$msg = 'Không được để trống số điện thoại khách hàng';
				setRedirect($link,$msg,'error');
			}

			if($diachinhanhang==''){
				$msg = 'Không được để trống địa chỉ nhận hàng';
				setRedirect($link,$msg,'error');
			}

			if($tennguoinhan==''){
				$msg = 'Không được để trống tên người nhận hàng';
				setRedirect($link,$msg,'error');
			}

			$ngay=date('dmY');
			$gio =date('His');
			
		
			$barcode_string  =  $ngay.'DN'.$gio.$shop_id;

			$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
			$barcode = $generator->getBarcode($barcode_string, $generator::TYPE_CODE_128,1,50);

			$pd_name_ar = $td_info_shows = $sum_quantity = $sum_price = [];



			for ($i=1; $i <=$number; $i++) { 

				$pd_info_show =	'<p class="s5" style="margin-top:10px;  padding-left: 4pt;text-indent: 0pt;line-height: 87%;text-align: left;">'.$i.'.'.FSInput::get('productName'.$i).'SL:'.FSInput::get('soluong'.$i).'</p>';
				               
				array_push($pd_name_ar, $pd_info_show);

				$td_info_show = '
					<tr style="height:69pt">
					    <td style="width:19pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
					        <p class="s5" style="text-indent: 0pt;line-height: 8pt;text-align: left;">'.$i.'</p>
					    </td>
					    <td style="width:23pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
					        
					        <p class="s5" style="padding-left: 1pt;padding-right: 1pt;text-indent: 0pt;line-height: 87%;text-align: left;">'.FSInput::get('productCode'.$i).'</p>
					     
					    </td>
					    <td style="width:78pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
					        <p class="s5">'.FSInput::get('productName'.$i).'</p>
					    </td>
					    <td style="width:31pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
					        <p style="text-indent: 0pt;text-align: left;">'.FSInput::get('skuplhang'.$i).' <br></p>
					    </td>
					    <td style="width:59pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
					        <p class="s5" style="padding-left: 1pt;text-indent: 0pt;line-height: 8pt;text-align: left;"></p>
					    </td>
					    <td style="width:15pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
					        <p class="s5" style="padding-right: 7pt;text-indent: 0pt;line-height: 8pt;text-align: center;">'.FSInput::get('soluong'.$i).'</p>
					    </td>
					    <td style="width:31pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
					        <p class="s5" style="text-indent: 0pt;line-height: 8pt;text-align: center;">'.FSInput::get('dongia'.$i).'</p>
					    </td>
					    <td style="width:40pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
					        <p class="s5" style="padding-left: 1pt;text-indent: 0pt;line-height: 8pt;text-align: left;">'. str_replace([',','.'], '', FSInput::get('thanhtien'.$i)).'</p>
					    </td>
					</tr>';

				array_push($td_info_shows, $td_info_show);	

				array_push($sum_quantity, FSInput::get('soluong'.$i));

				array_push($sum_price,str_replace([',','.'], '', FSInput::get('thanhtien'.$i)));

			}

		
			$content = '<!DOCTYPE  html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" lang="vi">
			    <head>
			        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
			        <title>pdf</title>
			        <style type="text/css"> * {margin:0; padding:0; text-indent:0; }
			            .s1 { color: #EE4D2D; font-family:Arial, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 10.5pt; }
			            .s2 { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 9pt; }
			            .s4 { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 7.5pt; }
			            .s5 { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 7.5pt; }
			            .s6 { color: black; font-family:Arial, sans-serif; font-style: italic; font-weight: normal; text-decoration: none; font-size: 6.5pt; }
			            .s7 { color: black; font-family:Arial, sans-serif; font-style: italic; font-weight: normal; text-decoration: none; font-size: 7pt; }
			            .s8 { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 8pt; vertical-align: -2pt; }
			            .s9 { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 16.5pt; vertical-align: 1pt; }
			            h1 { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 10.5pt; }
			            p { color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 9pt; margin:0pt; }
			            table, tbody {vertical-align: top; overflow: visible; }
			        </style>
			    </head>
			    <body>
			        <table style="border-collapse:collapse;margin-left:3.93236pt" cellspacing="0">
			            <tr style="height:60pt">
			                <td style="width:288pt;border-top-style:solid;border-top-width:2pt;border-left-style:solid;border-left-width:2pt;border-bottom-style:dashed;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt" colspan="2">
			                    <p style="text-indent: 0pt;text-align: left;"><br/></p>
			                   
			                        
			                    <table border="0" cellspacing="0" cellpadding="0">
			                        <tr>
			                            <td>
			                                <img src="https://dienmayai.com/images/logo1.png" width="115" height="36" alt="" style="-aw-left-pos:0pt; -aw-rel-hpos:column; -aw-rel-vpos:paragraph; -aw-top-pos:0pt; -aw-wrap-type:inline">
			                            </td>
			                            <td style="width:100%; text-align:right; padding-right:15px">
			                                <img src="data:image/png;base64,' . base64_encode($barcode).'">
			                                 <p>Mã đơn hàng: <b>'.$barcode_string.'</b></p>    
			                            </td>
			                        </tr>
			                    </table>
			                        
			                   
			                   
			                </td>
			            </tr>
			            <tr style="height:70pt">
			                <td style="width:148pt;border-top-style:dashed;border-top-width:1pt;border-left-style:solid;border-left-width:2pt;border-bottom-style:dashed;border-bottom-width:1pt;border-right-style:dashed;border-right-width:1pt">
			                    <p class="s4" style="padding-left: 4pt;text-indent: 0pt;line-height: 8pt;text-align: left;">Từ:</p>
			                    <p class="s5" style="padding-left: 4pt;text-indent: 0pt;line-height: 8pt;text-align: left;">KAW center</p>
			                    <p style="padding-top: 3pt;text-indent: 0pt;text-align: left;"><br/></p>
			                  
			                </td>
			                <td style="width:148pt;border-top-style:dashed;border-top-width:1pt;border-left-style:dashed;border-left-width:1pt;border-bottom-style:dashed;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt">
			                    <p class="s4" style="padding-left: 4pt;text-indent: 0pt;line-height: 8pt;text-align: left;">Đến:</p>
			                    <p class="s5" style="padding-left: 4pt;text-indent: 0pt;line-height: 8pt;text-align: left;">'.$tennguoinhan.'</p>
			                   
			                </td>
			            </tr>
			            <tr style="height:15pt">
			                <td style="width:288pt;border-top-style:dashed;border-top-width:1pt;border-left-style:solid;border-left-width:2pt;border-bottom-style:dashed;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt" colspan="2">
			                    <p style="text-indent: 0pt;text-align: left;"><br/></p>
			                </td>
			            </tr>
			            <tr style="height:12pt">
			                <td style="width:288pt;border-top-style:dashed;border-top-width:1pt;border-left-style:solid;border-left-width:2pt;border-bottom-style:dashed;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt" colspan="2">
			                    <p class="s4" style="padding-left: 4pt;text-indent: 0pt;text-align: left;">Nội dung hàng (Tổng SL sản phẩm:'.array_sum($sum_quantity).')</p>
			                </td>
			            </tr>
			            <tr style="min-height:89pt">

			                <td style="width:288pt;border-top-style:dashed;border-top-width:1pt;border-left-style:solid;border-left-width:2pt;border-bottom-style:solid;border-bottom-width:2pt;border-right-style:solid;border-right-width:2pt" colspan="2">'.implode('', $pd_name_ar).'

			                	
			          
		                        <p style="text-indent: 0pt;text-align: left; margin-bottom:15px;"><br/></p>
		                        <p class="s6" style="padding-left: 6pt;padding-right: 1pt;text-indent: 0pt;line-height: 84%;text-align: left;">*Vui lòng giữ sp trong trạng thái nguyên vẹn, Thời hạn bảo hành tính từ ngày giao hàng</p>
			                </td>
			            </tr>        

			            <tr style="height:189pt">
			                <td style="width:88pt;border-top-style:dashed;border-top-width:1pt;border-left-style:solid;border-left-width:2pt;border-bottom-style:solid;border-bottom-width:2pt;border-right-style:solid;border-right-width:2pt" colspan="1">
			                    
			                    <p style="text-indent: 0pt;text-align: left;"/>
			                        <p class="s8" style="padding-left: 4pt;text-indent: 0pt;text-align: left; margin-top:10px; margin-bottom:5px">Tiền thu Người nhận:</p>
			                        
			                        <p class="s6" style="padding-left: 0;padding-right: 3pt;line-height: 79%;text-align: center;"><span class="s9">'.number_format(array_sum($sum_price), 0, ',', '.').' VND    </span>
			                        <p style="text-indent: 0pt;text-align: left;"><br/></p>
			                        <p class="s4" style="padding-left: 3pt;text-indent: 0pt;line-height: 8pt;text-align: left;">Chỉ dẫn giao hàng: <span class="s5">Không đồng kiểm.</span>
			                    </p>
			                </td>

			                <td style="width:100pt;border-top-style:dashed;border-top-width:1pt;border-left-style:solid;border-left-width:2pt;border-bottom-style:solid;border-bottom-width:2pt;border-right-style:solid;border-right-width:2pt" colspan="1">
			                    
			                    <p style="text-align: right;">
			                        <p class="s4" style="text-align:right; margin-right:10px">Chữ ký người nhận</p>
			                    </p>
			                </td>
			                 

			               
			            </tr>
			        </table>
			        <p style="padding-top: 3pt;text-indent: 0pt;text-align: left;"><br/></p>
			        
			        <h1 style="padding-left: 3pt;text-indent: 0pt;text-align: left;">THÔNG TIN ĐƠN HÀNG</h1>
			        <p style="padding-top: 7pt;padding-left: 3pt;text-indent: 0pt;text-align: left;">OrderSN: 240725FW9RGTHN package 1</p>
			        <p style="text-indent: 0pt;text-align: left;"><br/></p>
			        <table style="border-collapse:collapse;margin-left:0.565008pt;" cellspacing="0" >
			            <tr style="height:24pt">
			                <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
			                    <p class="s4" style="text-indent: 0pt;line-height: 8pt;text-align: left;">#</p>
			                </td>
			                <td style="border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
			                    <p class="s4" style="padding-left: 1pt;text-indent: 0pt;line-height: 8pt;text-align: left;">SKU</p>
			                </td>
			                <td style="width:78pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
			                    <p class="s4" style="padding-left: 1pt;text-indent: 0pt;line-height: 8pt;text-align: left;">Tên sản phẩm</p>
			                </td>
			                <td style="width:31pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
			                    <p class="s4" style="padding-left: 1pt;text-indent: 0pt;line-height: 7pt;text-align: left;">SKU</p>
			                    <p class="s4" style="padding-left: 1pt;padding-right: 10pt;text-indent: 0pt;line-height: 8pt;text-align: left;">phân loại</p>
			                </td>
			                <td style="width:59pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
			                    <p class="s4" style="padding-left: 1pt;text-indent: 0pt;line-height: 8pt;text-align: left;">Phân loại hàng</p>
			                </td>
			                <td style="width:15pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
			                    <p class="s4" style="padding-right: 1pt;text-indent: 0pt;line-height: 8pt;text-align: center;">SL</p>
			                </td>
			                <td style="width:31pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
			                    <p class="s4" style="text-indent: 0pt;line-height: 8pt;text-align: center;">Đơn giá</p>
			                </td>
			                <td style="width:40pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
			                    <p class="s4" style="padding-left: 1pt;padding-right: 15pt;text-indent: 0pt;line-height: 87%;text-align: left;">Thành tiền</p>
			                </td>
			            </tr>
			           	'.implode('',$td_info_shows).'
			        </table>
			    </body>
			</html>';

			

			// tạo file excel


			FSFactory::include_class('excel','excel');

			// $timestamp = time();

			// $date=date('Y/m/d');
			
			$filename = "don_ngoai_$timestamp";

			$excel = FSExcel();

			$excel->set_params(array('out_put_xls'=>PATH_BASE.$dir.'/'.$filename.'.xls','out_put_xlsx'=>PATH_BASE.$dir.'/'.$filename.'.xlsx'));

			$path_excel = $dir.'/'.$filename.'.xls';

			$style_header = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'ffff00'),
				),
				'font' => array(
					'bold' => true,
				)
			);
			$style_header1 = array(
				'font' => array(
					'bold' => true,
				)
			);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(50);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(60);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(60);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(60);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(60);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
			

			$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Mã đơn hàng');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Mã kiện hàng');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Ngày đặt hàng');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Mã vận đơn');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Đơn vị vận chuyển');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'Phương thức giao hàng');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'Loại đơn hàng');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('H1', 'Ngày gửi hàng');
			// $excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'Đơn giá');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('I1', 'Tên sản phẩm');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('J1', 'Cân nặng sản phẩm');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('K1', 'Tổng cân nặng');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('L1', 'Sku phân loại hàng');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('N1', 'Đơn giá');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('O1', 'Số lượng');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('P1', 'Tổng giá bán sản phẩm');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('Q1', 'Tổng giá trị đơn hàng');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('R1', 'Phí vận chuyển dự kiến');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('S1', 'Phí vận chuyển người mua trả');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('T1', 'Phí vận chuyển tài trợ bởi');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('U1', 'Phí trả hàng');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('V1', 'Tổng số tiền người toán');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('W1', 'Phương thức thanh toán');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('X1', 'Phí cố định');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('Y1', 'Phí dịch vụ');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('Z1', 'Phí thanh toán');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('AA1', 'Tiền ký quỹ');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('AB1', 'Người mua');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('AC1', 'Tên người nhận');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('AD1', 'Số điện thoại');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('AE1', 'Tỉnh thành phố');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('AF1', 'Quận huyện');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('AG1', 'Quận');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('AH1', 'Địa chỉ nhận hàng');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('AI1', 'Ghi chú');
			

			for ($keys=1;$keys<=$number; $keys++){
				
				$key = isset($keys)?($keys+1):2;

				$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key,  FSInput::get('productCode'.$keys));
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, FSInput::get('productCode'.$keys));
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $deliveryPerson);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key,  FSInput::get('productName'.$keys));
				$excel->obj_php_excel->getActiveSheet()->setCellValue('J'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('K'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('L'.$key, FSInput::get('skuplhang'.$keys));
				$excel->obj_php_excel->getActiveSheet()->setCellValue('N'.$key, FSInput::get('dongia'.$keys));
				$excel->obj_php_excel->getActiveSheet()->setCellValue('O'.$key, FSInput::get('soluong'.$keys));
				$excel->obj_php_excel->getActiveSheet()->setCellValue('P'.$key, FSInput::get('tongsotiennguoimuathanhtoan'.$keys));
				$excel->obj_php_excel->getActiveSheet()->setCellValue('Q'.$key, FSInput::get('tongsotiennguoimuathanhtoan'.$keys));
				$excel->obj_php_excel->getActiveSheet()->setCellValue('R'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('S'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('T'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('U'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('V'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('W'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('X'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('Y'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('Z'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AA'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AB'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AC'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AD'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AH'.$key, '');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AI'.$key, '');



				// $excel->obj_php_excel->getActiveSheet()->setCellValue('J'.$key, $string_info_extent);
			}

			

			$output = $excel->write_files();


			$path_file =   $output['xls'];

			

			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);			
			// header("Content-type: application/force-download");			
			// header("Content-Disposition: attachment; filename=\"".$filename.'.xls'."\";" );			
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".filesize($path_file));
			// echo $link_excel = URL_ROOT.LINK_AMIN.'/export/excel/'. $filename.'.xls';
			// setRedirect($link_excel);
			// readfile($path_file);

		
			$mpdf = new Mpdf();

			$mpdf->WriteHTML($content);

			

			$mpdf->Output(PATH_BASE.$dir.'/f_'.$timestamp.'.pdf', \Mpdf\Output\Destination::FILE);

			$path_pdf = PATH_BASE.$dir.'/f_'.$timestamp.'.pdf';

			$path_run = "https://drive.dienmayai.com/dn.php?pdf=$path_pdf&excel=$path_excel&house_id=$house_id&warehouse_id=$warehouse_id&shop_id=$shop_id";

			file_get_contents($path_run);

			$_SESSION['input_data'] = '';

			$link = FSRoute::_('index.php?module=order&view=upload');	
			setRedirect($link);	

		
		}
		
		
	}
	
?>