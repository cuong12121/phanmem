
<style>
    .tong{
        font-weight: bold;
    }
</style>

<div id="page-wrapper" class="page-wrapper-small" style="min-height: 537px;">
    <div class="form_head">
        <div id="wrap-toolbar" class="wrap-toolbar">
            <div class="fl">
                <h1 class="page-header">
                    Lợi nhuận gian hàng 
                    
                    <?php 
                    
                    
                        if(!empty($_SESSION[$this -> prefix.'text0']) && !empty($_SESSION[$this -> prefix.'text1'])){
                            
                            $from =  date('d/m/Y', strtotime($_SESSION[$this -> prefix.'text0']));
                    
                            $to   =  date('d/m/Y', strtotime($_SESSION[$this -> prefix.'text1']));
                    ?>
                    
                    
                    
				
                    từ ngày <?= $from ?> đến ngày <?= $to ?>
                    
                    <?php 
                        }
                    ?>
                </h1>
                <!--end: .page-header -->
                <!-- /.row -->    
            </div>
           
            <div class="clearfix"></div>
        </div>
        <!--end: .wrap-toolbar-->
    </div>
    <!--end: .form_head-->
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" action="https://test.dienmayai.com/admin/products/api" name="adminForm" method="post">
                <div class="filter_area">
                    <div class="row">
                        <input type="hidden" name="text_count" value="2">			
                        <div class="fl-left pd-15">	
                            <input type="text" placeholder="Tên gian hàng" name="keysearch" id="search" value="<?= !empty($_SESSION[$this -> prefix.'keysearch'])?$_SESSION[$this -> prefix.'keysearch']:'' ?>" class="form-control fl-left">
                            
                            
                            
                            <span class="input-group-btn fl-left" style="margin-left: -2px;">
                            <!--<button onclick="this.form.submit();" class="btn btn-search btn-default" type="button">-->
                            <!--<i class="fa fa-search"></i>-->
                            <!--</button>-->
                            </span>
                        </div>
                        <div class="fl-left pd-15">
                            <input type="text" placeholder="Địa chỉ" name="address" id="address" value="<?= !empty($_SESSION[$this -> prefix.'address'])?$_SESSION[$this -> prefix.'address']:'' ?>" class="form-control fl-left">
                        </div>
                        <div class="fl-left pd-15">
                            <input type="date" placeholder="Từ ngày" class="form-control hasDatepicker" autocomplete="off" name="text0" id="text0" value="<?= !empty($_SESSION[$this -> prefix.'text0'])?$_SESSION[$this -> prefix.'text0']:'' ?>">			
                        </div>
                        <div class="fl-left pd-15">
                            <input type="date" placeholder="Đến ngày" class="form-control hasDatepicker" autocomplete="off" name="text1" id="text1" value="<?= !empty($_SESSION[$this -> prefix.'text1'])?$_SESSION[$this -> prefix.'text1']:'' ?>">			
                        </div>
                        <div class="fl-left">				
                            <button class="btn btn-outline btn-primary" type="submit">Tìm kiếm</button>	
                            <button class="btn btn-outline btn-primary" onclick="document.getElementById('search').value='';				document.getElementById('text0').value=''; 				document.getElementById('text1').value=''; 				this.form.getElementById('filter_state').value='';this.form.submit();">Reset</button>
                        </div>
                        <input type="hidden" name="filter_count" value="4">			
                       
                       
                    </div>
                </div>
                <div class="dataTable_wrapper">
                    <table style="width: 100%;" id="dataTables-example" class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="title 1">Stt</th>
                                <th class="title 1">Mã gian</th>
                                <th class="title 1">Tên gian</th>
                                <th class="title 2" width="15%">Địa chỉ</th>
                                <th class="title 2">NVKD quản lý</th>
                               
                                <th class="title 1">Doanh số bán </th>
                                <th class="title 1">Doanh số trả lại</th>
                                <th class="title 1">Doanh thu thuần</th>
                                <th class="title 1">Giá vốn hàng bán </th>
                                <th class="title 1">Giá vốn hàng trả lại </th>
                                <th class="title 1">Chi phí đóng gói </th>
                                <th class="title 1">Chi phí sàn </th>
                                <th class="title 1">Chi phí quảng cáo </th>
                                <th class="title 1">Chi phí khác </th>
                                <th class="title 1">Lợi nhuận tạm tính </th>

                                <th class="title 2">Số ngày đang tính <?=$count_result ?> </th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="tong"></tr>
                            <?php 
                            $totalrevenue  = $totalnet_revenue = $totalcost = $totalreturn_cost = $totalpackaging_cost = $totalshipping_cost = $totalads_cost = $totalother_cost = $totalgross_profit =  $totalreturn_revenue = 0;
                            // echo "<pre>";
                            //   print_r($result);
                            // echo "</pre>";
                            
                            // die();
                            if(!empty($result) && count($result)>0){
                            $dem = 0;
                            
                
                            foreach($result as  $value){
                                $dem++;
                                
                            ?>
                            <tr class="row0">
                                <td><?=$dem  ?></td>
                                <td><?=$value['code']  ?></td>
                                <td><?=$value['name']  ?></td>
                                <td><?=$value['address']  ?></td>
                                <td><?=$value['manager_staff'] ?></td>
                                <td><?=$value['revenue']  ?></td>
                                <td><?=$value['return_revenue']  ?></td>
                                <td><?=$value['net_revenue']  ?></td>
                                <td><?=$value['cost']  ?></td>
                                <td><?=$value['return_cost']  ?></td>
                                <td><?=$value['packaging_cost']  ?></td>
                                <td><?=$value['shipping_cost']  ?></td>
                                <td><?=$value['ads_cost']  ?></td>
                                <td><?=$value['other_cost']  ?></td>
                                <td><?=$value['gross_profit']  ?></td>
                                <?php
                                
                                    $totalrevenue +=  intval( str_replace('.', '', $value['revenue']));
                                    $totalreturn_revenue +=  intval( str_replace('.', '', $value['return_revenue']));
                                    
                                    $totalnet_revenue +=  intval( str_replace('.', '', $value['net_revenue']));
                                    $totalcost += intval( str_replace('.', '', $value['cost']));
                                    $totalreturn_cost +=  intval( str_replace('.', '', $value['return_cost']));
                                    $totalpackaging_cost +=  intval( str_replace('.', '', $value['packaging_cost']));
                                    $totalshipping_cost +=  intval( str_replace('.', '', $value['shipping_cost']));
                                    $totalads_cost +=  intval( str_replace('.', '', $value['ads_cost']));
                                    $totalother_cost +=  intval( str_replace('.', '', $value['other_cost']));
                                    $totalgross_profit +=  intval( str_replace('.', '', $value['gross_profit']));
                                 
                                 ?>
                                
                                <?php 
                                
                                    if($count_result>1 && !empty($from) && !empty($to)){
                                ?>
                                
                                 <td><?= $from ?> đến ngày <?= $to ?></td>
                                
                                
                                <?php }else{ ?>
                                
                                <td><?=$value['created_at']  ?></td>
                                
                                <?php
                                }
                                ?>
                                 <td><a href="/admin/product/shop-detail/<?= $value['id']  ?>?date=<?= date("Y-m-d", strtotime($value['created_at'])) ?>">Xem</a></td>
                            <?php     
                                }
                                
                                ?>
                                
                               
                                
                                
                            </tr>
                            
                            <?php
                                }   
                            ?>
                            <tr class="row99">
                                <td></td>
                                <td></td>
                                <td>Tổng</td>
                                <td></td>
                                <td></td>
                                <td><?=  str_replace(',', '.', number_format($totalrevenue, 0))  ?></td>
                                <td> <?=    str_replace(',', '.', number_format($totalreturn_revenue, 0)) ?></td>
                                <td><?=  str_replace(',', '.', number_format($totalnet_revenue, 0))  ?></td>
                                <td><?=  str_replace(',', '.', number_format($totalcost, 0))  ?></td>
                                <td><?=  str_replace(',', '.', number_format($totalreturn_cost, 0))  ?></td>
                                <td><?=  str_replace(',', '.', number_format($totalpackaging_cost, 0))  ?></td>
                                <td><?=  str_replace(',', '.', number_format($totalshipping_cost, 0))  ?></td>
                                <td><?=  str_replace(',', '.', number_format($totalads_cost, 0))  ?></td>
                                <td><?=  str_replace(',', '.', number_format($totalother_cost, 0))  ?></td>
                                <td><?=  str_replace(',', '.', number_format($totalgross_profit, 0))  ?></td>
                                <td></td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <!--<nav aria-label="Page navigation">-->
                    <!--    <div style="text-align: center; font-weight: bold; margin-top: 30px;"><font>Tổng</font> : <span style="color:red">[120838]</span> </div>-->
                    <!--    <ul class="pagination">-->
                    <!--        <li><a class="title_pagination">Trang</a></li>-->
                    <!--        <li><a title="Page 1" class="current">[1]</a></li>-->
                    <!--        <li><a title="Page 2" href="https://test.dienmayai.com/admin/order/upload?page=2">2</a></li>-->
                    <!--        <li><a title="Page 3" href="https://test.dienmayai.com/admin/order/upload?page=3">3</a></li>-->
                    <!--        <li><a title="Page 4" href="https://test.dienmayai.com/admin/order/upload?page=4">4</a></li>-->
                    <!--        <li><a title="Page 5" href="https://test.dienmayai.com/admin/order/upload?page=5">5</a></li>-->
                    <!--        <li><a title="Page 6" href="https://test.dienmayai.com/admin/order/upload?page=6">6</a></li>-->
                    <!--        <b>..</b> -->
                    <!--        <li><a aria-label="Previous" title="Next page" href="https://test.dienmayai.com/admin/order/upload?page=2">›</a></li>-->
                    <!--        <li><a aria-label="Next" title="Last page" href="https://test.dienmayai.com/admin/order/upload?page=2417">»</a></li>-->
                    <!--    </ul>-->
                    <!--</nav>-->
                    <input type="hidden" value="" name="sort_field"><input type="hidden" value="asc" name="sort_direct"><input type="hidden" value="products" name="module"><input type="hidden" value="apipd" name="view"><input type="hidden" value="51" name="total"><input type="hidden" value="0" name="page"><input type="hidden" value="" name="field_change"><input type="hidden" value="" name="task"><input type="hidden" value="0" name="boxchecked"><input type="hidden" value="0" name="page"><input type="hidden" value="0" name="limit">
                </div>
            </form>
        </div>
        <script>
        
            var div_or = $('.row99').html();
            
            $('.tong').html(div_or);
            
            $('.row99').html('');
            $(function() {
            
            	$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
            	$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
            });
        </script>
        <style type="text/css">
            .note-top{
            color: red;
            font-size: 16px;
            margin-bottom: 15px;
            text-align: center;
            }
        </style>
    </div>
    <!-- /#page-wrapper -->
</div>