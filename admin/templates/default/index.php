<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, height=device-height,  initial-scale=1.0, user-scalable=no;user-scalable=0;"/>
    <meta name="description" content="">
    <meta name="author" content="">
    <?php
    $seo_title = $tmpl -> get_variables('seo_title');
    if( $seo_title ) { ?>
       <title><?php echo $seo_title.' - CMS Delectech'; ?></title>
   <?php } else {
       ?>
       <title>TTPOperate</title>
   <?php } ?>
   <style>
    :root{
      --main-color: #288ad6;
      --green-color: #104e34;
      --extra-color: #313e4b;    
      --black-color: #23232B;
      --blue-color: #288ad6;  
  }
</style>


   <link rel="shortcut icon" href="<?php echo URL_ADMIN; ?>templates/default/images/favicon_ttp.ico"/>
   <!-- Bootstrap Core CSS -->
   <link href="<?php echo URL_ADMIN; ?>templates/default/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

   <!-- MetisMenu CSS -->
   <link href="<?php echo URL_ADMIN; ?>templates/default/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

   <!-- Timeline CSS -->
   <link href="<?php echo URL_ADMIN; ?>templates/default/dist/css/timeline.css" rel="stylesheet">

   <!-- Custom CSS -->
   <link href="<?php echo URL_ADMIN; ?>templates/default/dist/css/sb-admin-2.css?t=<?php echo time(); ?>" rel="stylesheet">

   <!-- Morris Charts CSS -->
   <link href="<?php echo URL_ADMIN; ?>templates/default/bower_components/morrisjs/morris.css" rel="stylesheet">

   <!-- Custom Fonts -->
   <link href="<?php echo URL_ADMIN; ?>templates/default/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

   <!-- DataTables CSS -->
   <!--    <link href="<?php echo URL_ADMIN; ?>templates/default/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">-->

   <!-- DataTables Responsive CSS -->
   <link href="<?php echo URL_ADMIN; ?>templates/default/bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
   <!-- DataTables Responsive CSS -->
   <link rel="stylesheet" href="<?php echo URL_ADMIN; ?>templates/default/css/chosen.css">
   <!-- DataTables Responsive CSS -->
   <link href="<?php echo URL_ADMIN; ?>templates/default/css/styles.css?v=<?php echo time(); ?>" rel="stylesheet">
   <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <title>CMS - Delectech</title>
    <link rel="shortcut icon" href="<?php echo URL_ADMIN; ?>templates/default/images/favicon_ttp.ico"/>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo URL_ADMIN; ?>templates/default/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo URL_ADMIN; ?>templates/default/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo URL_ADMIN; ?>templates/default/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo URL_ADMIN; ?>templates/default/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo URL_ADMIN; ?>templates/default/bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo URL_ADMIN; ?>templates/default/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.css" />


    <!-- DataTables CSS -->
    <!--    <link href="<?php echo URL_ADMIN; ?>templates/default/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">-->
    
    <!-- DataTables Responsive CSS -->
    <link href="<?php echo URL_ADMIN; ?>templates/default/bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="<?php echo URL_ADMIN; ?>templates/default/css/chosen.css">
    <!-- DataTables Responsive CSS -->
    <link href="<?php echo URL_ADMIN; ?>templates/default/css/styles.css?v=<?php echo time(); ?>" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

        <link href="<?php echo URL_ADMIN; ?>templates/default/css/select2-bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo URL_ADMIN; ?>templates/default/css/jquery-confirm.min.css" rel="stylesheet">
        <link href="<?php echo URL_ADMIN; ?>templates/default/css/select2.min.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <!-- <script src="https://malsup.github.com/jquery.form.js"></script>  -->

        <script type="text/javascript" src="<?php echo URL_ADMIN; ?>templates/default/js/jquery-1.11.0.min.js"></script>  
        <script type="text/javascript" src="<?php echo URL_ADMIN; ?>templates/default/js/upload_image.js"></script>    
        
        <script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.js"></script>

        <script type="text/javascript" src="<?php echo URL_ROOT; ?>libraries/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="<?php echo URL_ROOT; ?>libraries/ckeditor/plugins/ckfinder/ckfinder.js"></script>
        <script type="text/javascript">
            CKEDITOR.timestamp = <?php echo time(); ?>;
        </script>

        <script>UPLOADCARE_PUBLIC_KEY = 'b0bd835a4330551312cd';</script>
    </head>
    <?php    $module= FSInput::get('module',1,'text');  ?>
    <?php 
    ?>
    <body>
        <div class="modal-menu-full-screen"></div>
        <div id="wrapper">
            <!-- Navigation -->
            <?php include 'navbar.php'; ?>
            <?php include 'breadcrumbs.php'; ?>

            <div id="page-wrapper" class="<?php if($module != 'home') echo 'page-wrapper-small'; ?>" >
                <?php 
                global $toolbar;
                echo $toolbar->show_head_form();
                echo $main_content; 
                ?>
            </div>
            <!-- /#page-wrapper -->
        </div>
        <div class="clearfix"></div>

        <!-- /#wrapper -->
        <div class="popup-notification">
            Thành công
        </div>
        <div class="go-top scrollToTop" style="display: none;">
            <i class="fa fa-arrow-circle-up"></i>
        </div>
        <!-- jQuery -->
        <script type="text/javascript" src="<?php echo URL_ADMIN; ?>templates/default/js/jquery-confirm.min.js"></script>
        <script type="text/javascript" src="<?php echo URL_ADMIN; ?>templates/default/js/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo URL_ADMIN; ?>templates/default/js/helper.js?t=<?php echo time(); ?>"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo URL_ADMIN; ?>templates/default/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?php echo URL_ADMIN; ?>templates/default/bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
        <script src="<?php echo URL_ADMIN; ?>templates/default/bower_components/raphael/raphael-min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="<?php echo URL_ADMIN; ?>templates/default/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo URL_ADMIN; ?>templates/default/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
        <script src="<?php echo URL_ADMIN; ?>templates/default/bower_components/datatables-responsive/js/dataTables.responsive.js"></script>
        <script>
            $(document).ready(function() {
                $('#dataTables-example1').DataTable({
                    responsive: true,
                    "language": {
                        "lengthMenu": "Hiển thị _MENU_ trên mỗi trang",
                        "zeroRecords": "Không tìm thấy gì - xin lỗi",
                        "info": "Đang ở trang _PAGE_ của _PAGES_",
                        "infoEmpty": "Không có dữ liệu có sẵn",
                        "infoFiltered": "(lọc từ tổng số hồ sơ _MAX_)",
                        "search": "Tìm kiếm nhanh:",
                        paginate: {
                            first:    '«',
                            previous: '‹',
                            next:     '›',
                            last:     '»'
                        },
                    },
                    select: {
                        style: 'multi'
                    },
                    "lengthMenu": [ 10 ,20, 30, 40 , 50],
                    "columnDefs": [
                    { "orderable": false, "targets": 1 }
                    ]
                });

            });
        </script>
        <!-- Custom Theme JavaScript -->
        <script src="<?php echo URL_ADMIN; ?>templates/default/dist/js/sb-admin-2.js"></script>
        <script src="<?php echo URL_ADMIN; ?>templates/default/dist/js/jquery.cookie.js"></script>
        <!-- Custom select chosen.jquery.js -->
        <script src="<?php echo URL_ADMIN; ?>templates/default/js/chosen.jquery.js" type="text/javascript"></script>
        <script type="text/javascript">
            var config = {
              '.chosen-select'           : {no_results_text: "Không tìm thấy "},
              '.chosen-select-deselect'  : {allow_single_deselect:true},
              '.chosen-select-no-single' : {disable_search_threshold:10},
              '.chosen-select-no-results': {no_results_text:"Không tìm thấy "},
              '.chosen-select-width'     : {width:"95%"}
          }
          for (var selector in config) {
              $(selector).chosen(config[selector]);
          }
      </script>
      <script>
    // popover demo
    $("[data-toggle=popover]").popover()
</script>
</body>

</html>
