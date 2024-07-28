<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
 <style type="text/css">
    table, th, td{
        border:1px solid #868585;
    }
    table{
        border-collapse:collapse;
        width:100%;
    }
    th, td{
        text-align:left;
        padding:10px;
    }
    table tr:nth-child(odd){
        background-color:#eee;
    }
    table tr:nth-child(even){
        background-color:white;
    }
    table tr:nth-child(1){
        background-color:skyblue;
    }

    .error{
        color: red;
    }
    .form-search{
        display: flex;
    }
    #tags{
        margin-right: 15px;
        height: 30px;
        font-size: 20px;
    }
    .return a{
        color: red !important;
    }

    @media only screen and (min-width: 601px) {
        .mobile{
            display: none;
        }
    }        
    @media only screen and (max-width: 600px) {
        #tags {
            margin-right: 15px;
            height: 50px;
            font-size: 26px;
        }

    }
</style>

<table class="table-responsive">
        <tr>
            <th>STT</th>
            <th>File PDF</th>
            <th>File Excel </th>
            <th>ID đơn hàng</th>
            <th>Mã vận đơn  file pdf</th>
            <th width="200px">Mã sku  file pdf</th>

            <th>Mã vận đơn  file excel</th>
            <th width="200px">Mã sku  file excel</th>

            <th>Mã vận đơn đúng file excel</th>
            <th width="200px">Mã sku đúng file excel</th>

            <th>Sàn </th>
            <th>Ngày kiểm tra </th>
            
            <th>Sửa </th>

           
        </tr>



        <?php 

            $dem = 0;
            $now = date("d/m/Y");

            function sortString($str)
                {
                    $val = explode(',', $str);

                   // $result = implode(',', $val);
                    sort($val);

                   $result = implode(',', $val);

                    return  $result;
            }

            function convert_unique($str1)
            {
                $ar1 = explode(',', $str1);
                $ar1 = array_unique($ar1);


                $results = implode(',', $ar1);

                return $results;
            }

            function convertContentCheck($content){

                if(empty($b[0])){
                 preg_match_all('/[A-Z-0-9]{1}[A-Za-z0-9]{1}[A-Za-z0-9]{1}[A-Za-z0-9]{1}+-[A-Za-z0-9][A-Za-z0-9]+-[A-Za-z0-9][A-Za-z0-9]+-[A-Za-z0-9][A-Za-z0-9][A-Za-z0-9]+-[A-Za-z0-9][A-Za-z0-9]+-[A-Za-z0-9][A-Za-z0-9][0-9]/', $content, $b);
                }

                // if(empty($b[0])){
                //     preg_match_all('/[A-Z-0-9]{1}[A-Za-z0-9]{1}[A-Za-z0-9]{1}[A-Za-z0-9]{1}+\s*-\s*[A-Za-z0-9][A-Za-z0-9]+\s*-\s*[A-Za-z0-9][A-Za-z0-9]+\s*-\s*[A-Za-z0-9][A-Za-z0-9][A-Za-z0-9]+\s*-\s*[A-Za-z0-9][A-Za-z0-9]+\s*-\s*[[0-9]{1,3}|0]/', $content, $b);
                // }

                // if(empty($b[0])){
                //     preg_match_all('/[A-Z-0-9]{1}[A-Za-z0-9]{1}[A-Za-z0-9]{1}[A-Za-z0-9]{1}+\s*-\s*[A-Za-z0-9][A-Za-z0-9]+\s*-\s*[A-Za-z0-9][A-Za-z0-9]+\s*-\s*[A-Za-z0-9][A-Za-z0-9][A-Za-z0-9]+\s*-\s*[A-Za-z0-9][A-Za-z0-9]+\s*-\s*[[0-9]{1,2}|0]/', $content, $b);
                // }

                
                if(empty($b[0])){
                    preg_match_all('/[A-Z-0-9]{1}[A-Za-z0-9]{1}[A-Za-z0-9]{1}[A-Za-z0-9]{1}+\s*-\s*[A-Za-z0-9][A-Za-z0-9]+-+\s[A-Za-z0-9][A-Za-z0-9]+\s*-\s*[A-Za-z0-9][A-Za-z0-9][A-Za-z0-9]+\s*-\s*[A-Za-z0-9][A-Za-z0-9]+\s*-\s*[A-Za-z0-9][A-Za-z0-9][0-9]/', $content, $b);
                }

                
                // xóa khoảng trắng trong chuỗi trả về của hàm trên
                $b = array_map(function($match) {
                    return preg_replace('/\s+/', '', $match);
                }, $b);


                return $b;

            }   

            function array_diff_ar($str1, $str2)
            {
                $ar1 = explode(',', trim($str1));


                $ar2 = explode(',', trim($str2));

                $result = [];
                foreach ($ar1 as $value) {
                    if (!in_array($value, $ar2)) {
                        $result[] =   !empty(convertContentCheck($value)[0][0])?$value:$value.'<span style="color:red">(không đúng mã sku theo quy định)</span>' ;
                    }
                }

                $results = implode(',', $result);


                
                return $results;
            }


            // echo "<pre>";
            //     var_dump($info_data);
            // echo "</pre>";
            // die;
        	if(!empty($result)){
        		

        		foreach ($result as $key => $value) {

                    $dem++;

                $file_pdf_rep = explode(',', $value->pdf_link);

                $file_pdf_rep1 = [];

                for ($i=0; $i < count($file_pdf_rep) ; $i++) { 
                  
                    $link_pdf = 'https://'.DOMAIN.'/'.str_replace('pdft', 'pdf', $file_pdf_rep[$i]);

                    if($i>0){

                        $link_pdf_v =  str_replace('pdft', 'pdf', $file_pdf_rep[0]);

                        $path = str_replace(basename($link_pdf_v), '', $link_pdf_v);

                        $basename = str_replace('pdft', 'pdf',  substr($file_pdf_rep[$i], 1));

                        $link_pdf = 'https://'.DOMAIN.'/'.$path.$basename;

                    }
                    $link_pdf_href = '<a href="'.$link_pdf.'" target="blank">'.basename($link_pdf).'</a>';
                     array_push($file_pdf_rep1, $link_pdf_href);

                }

        ?>

        <tr>
            <?php
            $define_platform[1] = 'lazada';
            $define_platform[2] = 'shopee';
            $define_platform[9] = 'tiktok';
            $define_platform[8] = 'best';
            $define_platform[10] = 'viettel';
            $define_platform[11] = 'shopee ngoài';
            $define_platform[4] = 'lex ngoài';
            ?>

            <td><?= $dem  ?></td>

            <td><?=  implode('<br>', $file_pdf_rep1)   ?></td>

            <?php 

                 $link_ex_href = '<a href="https://'.DOMAIN.'/'.$value->excel_link.'" target="blank">'.basename($value->excel_link).'</a>';
            ?>
            
            <td><?=    $link_ex_href  ?></td>
            <td><?= $value->record_id  ?></td>
            <td  <?= !empty($value->er_mvd)?'class="error"':''  ?> ><?=  str_replace(',', '<br>', $value->mvd_pdf)   ?></td>
            <td <?=!empty($value->er_sku)?'class="error"':''?> ><?= str_replace(',', '<br>', sortString(convert_unique($value->sku_pdf)))   ?></td>

            <td><?=  str_replace(',', '<br>', $value->mvd_ex)   ?></td>
            <td><?= str_replace(',', '<br>', convert_unique($value->sku_ex))   ?></td>

            <td><?=  str_replace(',', '<br>', $value->er_mvd)   ?></td>
            <td><?= str_replace(',', '<br>', array_diff_ar($value->sku_ex,$value->sku_pdf))   ?></td>
  
            <td><?= $define_platform[$value->platform_id]?></td>
            <td><?= date("d/m/Y", strtotime($value->created_at));  ?></td>
            <td></td>

           
        </tr>

        <?php 

        	}
        	}
        ?>
       
    </table>

    <?php 
       
        $get_page =!empty($_GET['page'])?$_GET['page']:1
        
    ?>

    <nav aria-label="Page navigation example">
        <ul class="pagination">

            <?php 

                if($get_page !=1):
            ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= intval($get_page)-1 ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <?php
                endif;
            ?>

            <?php 
                for ($i = $get_page; $i < 3+intval($get_page); $i++) :
            ?>

            <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
          

            <?php 
            endfor;    
            ?>


            <li class="page-item">
                <a class="page-link" href="?page=<?= intval($get_page)+3 ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>