<?php 
	require_once(PATH_BASE.'vendor/autoload.php');
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

			$barcode_string  ='230724DN15H0505MCH';

			$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
			$barcode = $generator->getBarcode($barcode_string, $generator::TYPE_CODE_128,1,50);

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
			                    <p class="s5" style="padding-left: 4pt;text-indent: 0pt;line-height: 8pt;text-align: left;">Kim Uyên</p>
			                    <p style="padding-top: 3pt;text-indent: 0pt;text-align: left;"><br/></p>
			                    <p class="s5" style="padding-left: 4pt;padding-right: 9pt;text-indent: 0pt;line-height: 87%;text-align: left;">15 Kỳ Đồng nhà hàng Hai lúa, Phường 9, Quận 3, TP. Hồ Chí Minh</p>
			                </td>
			            </tr>
			            <tr style="height:15pt">
			                <td style="width:288pt;border-top-style:dashed;border-top-width:1pt;border-left-style:solid;border-left-width:2pt;border-bottom-style:dashed;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt" colspan="2">
			                    <p style="text-indent: 0pt;text-align: left;"><br/></p>
			                </td>
			            </tr>
			            <tr style="height:12pt">
			                <td style="width:288pt;border-top-style:dashed;border-top-width:1pt;border-left-style:solid;border-left-width:2pt;border-bottom-style:dashed;border-bottom-width:1pt;border-right-style:solid;border-right-width:2pt" colspan="2">
			                    <p class="s4" style="padding-left: 4pt;text-indent: 0pt;text-align: left;">Nội dung hàng (Tổng SL sản phẩm: 1)</p>
			                </td>
			            </tr>
			            <tr style="height:89pt">
			                <td style="width:288pt;border-top-style:dashed;border-top-width:1pt;border-left-style:solid;border-left-width:2pt;border-bottom-style:solid;border-bottom-width:2pt;border-right-style:solid;border-right-width:2pt" colspan="2">
			                <p class="s5" style="margin-top:10px;  padding-left: 4pt;text-indent: 0pt;line-height: 87%;text-align: left;">1. Máy Tăm Nước Cầm Tay Vệ Sinh Răng Miệng Dung Tích 300ml Fullbox 5 Chế Độ Hàng Chính Hãng,KAW 386F Trắng,SL: 1</p>
			                        <p style="text-indent: 0pt;text-align: left; margin-bottom:15px;"><br/></p>
			                        <p class="s6" style="padding-left: 6pt;padding-right: 1pt;text-indent: 0pt;line-height: 84%;text-align: left;">*Vui lòng giữ sp trong trạng thái nguyên vẹn, Thời hạn bảo hành tính từ ngày giao hàng</p>


			                 </td>
			            </tr>        

			            <tr style="height:189pt">
			                <td style="width:88pt;border-top-style:dashed;border-top-width:1pt;border-left-style:solid;border-left-width:2pt;border-bottom-style:solid;border-bottom-width:2pt;border-right-style:solid;border-right-width:2pt" colspan="1">
			                    
			                    <p style="text-indent: 0pt;text-align: left;"/>
			                        <p class="s8" style="padding-left: 4pt;text-indent: 0pt;text-align: left; margin-top:10px; margin-bottom:5px">Tiền thu Người nhận:</p>
			                        
			                        <p class="s6" style="padding-left: 0;padding-right: 3pt;line-height: 79%;text-align: center;"><span class="s9">0 VND    </span>
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
			            <tr style="height:69pt">
			                <td style="width:19pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
			                    <p class="s5" style="text-indent: 0pt;line-height: 8pt;text-align: left;">1</p>
			                </td>
			                <td style="width:23pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">

			                    <p class="s5" style="padding-left: 1pt;text-indent: 0pt;line-height: 87%;text-align: left;">386F- WH-</p>
			                    <p class="s5" style="padding-left: 1pt;padding-right: 1pt;text-indent: 0pt;line-height: 87%;text-align: left;">00- CEN- 00-</p>
			                    <p class="s5" style="padding-left: 1pt;padding-right: 3pt;text-indent: 0pt;line-height: 8pt;text-align: justify;">001- TAM NUO C</p>
			                </td>
			                <td style="width:78pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
			                    <p class="s5" >Máy Tăm Nước Cầm Tay Vệ Sinh Răng Miệng Dung Tích 300ml Fullbox 5 Chế Độ Hàng Chính Hãng</p>
			                </td>
			                <td style="width:31pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
			                    <p style="text-indent: 0pt;text-align: left;"><br/></p>
			                </td>
			                <td style="width:59pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
			                    <p class="s5" style="padding-left: 1pt;text-indent: 0pt;line-height: 8pt;text-align: left;">KAW 386F Trắng</p>
			                    
			                </td>
			                <td style="width:15pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
			                    <p class="s5" style="padding-right: 7pt;text-indent: 0pt;line-height: 8pt;text-align: center;">1</p>
			                </td>
			                <td style="width:31pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
			                    <p class="s5" style="text-indent: 0pt;line-height: 8pt;text-align: center;">351,500</p>
			                </td>
			                <td style="width:40pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
			                    <p class="s5" style="padding-left: 1pt;text-indent: 0pt;line-height: 8pt;text-align: left;">351,500</p>
			                </td>
			            </tr>
			        </table>
			    </body>
			</html>';

			echo $content;

			die;

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
			$department = FSInput::get('department');
			$storeCode = FSInput::get('storeCode');
			$customerPhone = FSInput::get('customerPhone');
			$customerPhone = FSInput::get('customerPhone');

			$diachinhanhang = FSInput::get('diachinhanhang');

			$tennguoinhan = FSInput::get('tennguoinhan');

			for ($i=1; $i <= $number; $i++) { 
				$productName = FSInput::get('productName'.$i);

				$productCode = FSInput::get('productCode'.$i);

				$soluong = FSInput::get('soluong'.$i);

				$phivanchuyen = FSInput::get('phivanchuyen'.$i);


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


			if($storeName==''){
				$msg = 'Không được để trống tên gian hàng';
				setRedirect($link,$msg,'error');
			}
			if($deliveryPerson==''){
				$msg = 'Không được để trống họ tên nvc giao';
				setRedirect($link,$msg,'error');
			}

			if($department==''){
				$msg = 'Không được để trống bộ phận';
				setRedirect($link,$msg,'error');
			}

			if($storeCode==''){
				$msg = 'Không được để trống mã gian hàng';
				setRedirect($link,$msg,'error');
			}

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

			

			$content = $this->formPdfPrint;
			echo($content);



		
		}
		
		
	}
	
?>