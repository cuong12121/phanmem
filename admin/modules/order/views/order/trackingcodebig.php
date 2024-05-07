<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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
    .code{
        font-size: 130px;
    }
</style>
<table>
        <tr>
            <th>STT</th>
            <th>Tracking code </th>
            
        </tr>



        <?php 
            // echo "<pre>";
            //     var_dump($info_data);
            // echo "</pre>";
            // die;
        	if(!empty($info_data->data)){
        		$dem =0;

        		foreach ($info_data->data as $key => $value) {
        			$dem++;


        			
        ?>

        <tr>
            <td><?= $dem ?></td>
            <td><span class="code"><?= $value->tracking_code  ?></span></td>
           
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

    <script>
        $(document).ready(function(){
            // Function to load realtime data
            function loadRealtimeData(){
                $.ajax({
                    url: 'https://dienmayai.com/rediss.php', // Đường dẫn tới tập tin PHP xử lý dữ liệu
                    type: 'GET',
                    success: function(response){

                        if(response==1){

                            window.location.reload()
                        }
                        console.log(1);

                       
                    }
                });
            }

            // Load realtime data initially
            loadRealtimeData();

            // Load realtime data every 5 seconds
            setInterval(function(){
                loadRealtimeData();
            }, 2000);
        });
    </script>