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
            <th>Mã vận đơn đúng file excel</th>
            <th>Mã sku đúng file excel</th>
            <th>Sàn </th>
            <th>Ngày kiểm tra </th>
            
            <th>Sửa </th>

           
        </tr>



        <?php 

            $dem = 0;
            $now = date("d/m/Y");
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


                   
                    $file_pdf_rep1[$i] = '<a href='.$link_pdf.'></a>'   ;
                }

                var_dump($file_pdf_rep1);

                    die;
                   
        		
        ?>

        <tr>


            <td><?= $dem  ?></td>

            <td><?=  implode(',', $file_pdf_rep1)   ?></td>
            
            <td><?= $value->excel_link  ?></td>
            <td><?= $value->record_id  ?></td>
            <td><?= $value->mvd_pdf  ?></td>
            <td><?= $value->sku_pdf  ?></td>
  
            <td><?= $value->platform_id ?></td>
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