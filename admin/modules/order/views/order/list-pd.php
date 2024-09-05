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

<div id="page-wrapper" class="page-wrapper-small" style="min-height: 110px;">
    <div class="form_head">
        <div id="wrap-toolbar" class="wrap-toolbar">
            <div class="fl">
                <h1 class="page-header">Hệ thống quản lý nội dung (CMS)</h1>
                <!--end: .page-header -->
                <!-- /.row -->    
            </div>
            <div class="clearfix"></div>
        </div>
        <!--end: .wrap-toolbar-->
    </div>
    <!--end: .form_head-->
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
    <div class="form-search">
        <form class="header__search" method="get" action="https://dienmayai.com/admin/order/detail/search" style="display: flex; margin-bottom: 15px;">
            <input type="text" class="input-search ui-autocomplete-input" id="tags" name="search" autocomplete="off" maxlength="100" required="" wfd-id="id0" autofocus=""> 
            <input type="hidden" name="active" value="1">    
            <button type="submit">Bắn đơn </button> 
        </form>
    </div>
    <div class="form-search">
        <form class="header__search" method="get" action="https://dienmayai.com/admin/order/detail/search/package" style="display: flex; margin-bottom: 15px;">
            <select name="name">
                <option value="0">Tên người dùng</option>
                <option value="9">admin</option>
                <option value="83">shop_test</option>
                <option value="152">STACK2</option>
                <option value="151">STACK1</option>
                <option value="150">SMI7</option>
                <option value="149">SMI6</option>
                <option value="148">SMI5</option>
                <option value="147">SMI4</option>
                <option value="146">SMI3</option>
                <option value="145">SMI2</option>
                <option value="141">VOTHINY</option>
                <option value="180">SMI13</option>
                <option value="140">NGUYENTHIHA_KTKMB</option>
                <option value="139">DOQUANGTRUNG_TONG</option>
                <option value="138">BUIDUYPHUC_TONG</option>
                <option value="137">NGUYENTHANHHAI_TONG</option>
                <option value="136">NGUYENTHIVYTHY_TONG</option>
                <option value="135">NGUYENTHITUYET_TONG</option>
                <option value="134">NGUYENTHINGUYEN_TONG</option>
                <option value="133">KIEUTRUNGDUC_TONG</option>
                <option value="246">STARK17</option>
                <option value="131">NGUYENTHIGIANG_TONG</option>
                <option value="130">CAODUYHOAN_TONG</option>
                <option value="129">STACK_GROUP</option>
                <option value="143">SMI1</option>
                <option value="128">TTP_TAPDOAN</option>
                <option value="144">DANGTHIHA_TONG</option>
                <option value="181">NGUYENTHIHAI</option>
                <option value="125">SMI_TONG</option>
                <option value="153">STACK3</option>
                <option value="154">STACK4</option>
                <option value="155">STACK5</option>
                <option value="156">TTP_TAPDOAN1</option>
                <option value="157">TTP_TAPDOAN2</option>
                <option value="158">TTP_TAPDOAN3</option>
                <option value="159">TTP_TAPDOAN4</option>
                <option value="160">TTP_TAPDOAN5</option>
                <option value="161">TTP_TAPDOAN6</option>
                <option value="165">TTP_TAPDOAN9</option>
                <option value="163">TTP_TAPDOAN7</option>
                <option value="164">TTP_TAPDOAN8</option>
                <option value="166">TTP_TAPDOAN10</option>
                <option value="167">SMI20</option>
                <option value="168">TTP_TAPDOAN12</option>
                <option value="169">TTP_TAPDOAN13</option>
                <option value="170">STACK6</option>
                <option value="171">STACK7</option>
                <option value="172">SMI8</option>
                <option value="173">SMI9</option>
                <option value="174">SMI10</option>
                <option value="175">STACK8</option>
                <option value="176">thuphuong_stark</option>
                <option value="177">SMI11</option>
                <option value="178">SMI12</option>
                <option value="179">TRINHTHIKIMANH_TONG</option>
                <option value="189">SMI15</option>
                <option value="206">nguyenthinhungoc_vanhanh</option>
                <option value="182">HOANDUONG</option>
                <option value="183">NGUYENTHIHONGNHUNG_TONG</option>
                <option value="184">NGUYENTHITUYET_1</option>
                <option value="185">SMI14</option>
                <option value="186">TTP_TAPDOAN15</option>
                <option value="187">DIEMXUONG_KTMN</option>
                <option value="188">TTP_TAPDOAN16</option>
                <option value="190">LEQUANGTUYEN1</option>
                <option value="191">TTP_TAPDOAN17</option>
                <option value="214">STACK12</option>
                <option value="192">NGUYENTHINHUNGOC</option>
                <option value="193">PHAMHONGNHUNG</option>
                <option value="194">STACK10</option>
                <option value="195">PHAMLINH</option>
                <option value="196">TRANTHITRANG_TONG</option>
                <option value="197">TUYET123</option>
                <option value="198">DAOTHIHONGNHUNG_TONG</option>
                <option value="201">NGUYENTHITHUYHONG</option>
                <option value="202">STACK11</option>
                <option value="203">SMI16</option>
                <option value="204">NGUYENTHITUYET2</option>
                <option value="205">NGUYENTHITUYET3</option>
                <option value="207">luuhieukhanh_vanhanh</option>
                <option value="208">nguyenthihao_vanhanh</option>
                <option value="209">nguyenthimai_ketoan</option>
                <option value="210">lequangphuc_vanhanh</option>
                <option value="211">nguyenthihuong_kho</option>
                <option value="212">DAOTHIHONGNHUNG_1</option>
                <option value="213">NGUYENTHIHONGLINH_TONG</option>
                <option value="215">STACK13</option>
                <option value="217">SMI17</option>
                <option value="216">BUIDUYPHUC1</option>
                <option value="218">SMI18</option>
                <option value="219">KHANH_XNB</option>
                <option value="220">taikhoankho</option>
                <option value="222">truongphongnhaphang</option>
                <option value="223">kythuat</option>
                <option value="224">nhanvienkho</option>
                <option value="225">tranthingoc</option>
                <option value="226">nguyetluv7</option>
                <option value="240">BUIPHUONG</option>
                <option value="227">kimlamvu_tong</option>
                <option value="228">nguyenthilien</option>
                <option value="229">nguyenthilien1</option>
                <option value="230">BOSINGWA</option>
                <option value="231">SMI19</option>
                <option value="232">huynhminhphat</option>
                <option value="233">dogiang</option>
                <option value="234">ANHCUONG_VSKY</option>
                <option value="236">SMI21</option>
                <option value="235">NGOCANH</option>
                <option value="237">STARK_8</option>
                <option value="238">PHUONG_KTSMI</option>
                <option value="239">thaonp2001</option>
                <option value="241">HOANGVANHOA</option>
                <option value="242">SMI22</option>
                <option value="243">STACK14</option>
                <option value="244">SMI23</option>
                <option value="245">STACK16</option>
                <option value="262">vuitran</option>
                <option value="248">CUONGIT</option>
                <option value="249">minhkt</option>
                <option value="250">CANHMB</option>
                <option value="251">DONGHANGMB</option>
                <option value="252">PHUONGDGMB</option>
                <option value="253">LANDGMB</option>
                <option value="254">LOANDGMB</option>
                <option value="255">CANHDGMB</option>
                <option value="256">TRANGDGMB</option>
                <option value="257">HAIDGMB</option>
                <option value="258">ANHDGMN</option>
                <option value="259">THOADGMN</option>
                <option value="260">THUDGMN</option>
                <option value="261">donghangmn</option>
            </select>
            <label>từ</label>
            <input type="date" class="input-search ui-autocomplete-input" name="date1" autocomplete="off" maxlength="100" required=""> 
            <label>đến</label>
            <input type="date" class="input-search ui-autocomplete-input" name="date2" autocomplete="off" maxlength="100" required=""> 
            <button type="submit">Tìm kiếm </button> 
        </form>
    </div>
    <h2>Danh sách đơn đã đóng mới nhất của  admin</h2>
    <table class="table-responsive">
        <tbody>
            <tr>
                <th>STT</th>
                <th>Tracking code</th>
                <th>Tên sản phẩm </th>
                <th>Tên shop</th>
                <th>Mã shop</th>
                <th>Số lượng</th>
                <th>Id đơn hàng</th>
                <th>Người đánh đơn</th>
                <th>Ngày đánh đơn</th>
                <th>Thời gian đóng đơn hàng</th>
                <th>Thành tiền</th>
                <th>Hoàn đơn</th>
            </tr>
            <tr>
                <td>
                    1                
                    <div class="mobile">
                        <a href="https://dienmayai.com/admin/order/detail/search?search=1470147&amp;active=0" style="color: red">Hoàn đơn</a>
                    </div>
                </td>
                <td>LMP0266043552VNA</td>
                <td>Keo và miếng vá bể bơi-không màu- không size</td>
                <td>KAW MAX - Lazada</td>
                <td>AMS</td>
                <td>1</td>
                <td>243549</td>
                <td>PHUONGDGMB</td>
                <td>28/08/2024</td>
                <td>28/08/2024,01:31:29</td>
                <td>5.211đ</td>
                <td class="return">
                </td>
            </tr>
            
        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
            <li class="page-item"><a class="page-link" href="?page=2">2</a></li>
            <li class="page-item"><a class="page-link" href="?page=3">3</a></li>
            <li class="page-item">
                <a class="page-link" href="?page=4" aria-label="Next">
                <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
    </nav>
</div>