<?php

require 'vendor/autoload.php';

// use Picqer\Barcode\BarcodeGeneratorHTML;

// // Tạo đối tượng BarcodeGeneratorHTML
// $generator = new BarcodeGeneratorHTML();

$barcode_string  ='230724DN15H0505MCH';



$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
$barcode = $generator->getBarcode($barcode_string, $generator::TYPE_CODE_128,1,50);
?>

<!DOCTYPE  html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                                <img src="images/logo1.png" width="115" height="36" alt="" style="-aw-left-pos:0pt; -aw-rel-hpos:column; -aw-rel-vpos:paragraph; -aw-top-pos:0pt; -aw-wrap-type:inline">
                            </td>
                            <td style="width:100%; text-align:right; padding-right:15px">
                                <img src="<?= 'data:image/png;base64,' . base64_encode($barcode) ?>">
                                 <p>Mã đơn hàng: <b><?= $barcode_string ?></b></p>    
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
                    <p class="s5" style="padding-left: 4pt;text-indent: 0pt;line-height: 87%;text-align: left;">107/10 Liên khu 4-5, Phường Bình Hưng Hòa B, Quận Bình Tân, TP. Hồ Chí Minh</p>
                    <p style="padding-top: 4pt;text-indent: 0pt;text-align: left;"><br/></p>
                    <p class="s5" style="padding-left: 4pt;text-indent: 0pt;text-align: left;">SĐT: 84862046599</p>
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
</html>