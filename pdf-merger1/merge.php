<?php

if (isset($_POST['submit'])) {

    $compress = isset($_POST['compress']) ? true : false;


    if ($compress) {
        $output_file = OUTPUT_PATH . 'merged-compressed.pdf';

        $cmd = "gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=$output_file ";
       
    } else {
      
        $output_file = OUTPUT_PATH . 'merged-high-res.pdf';

        $cmd = "gs -q -dNOPAUSE -dBATCH -dPrinted=false -sDEVICE=pdfwrite -dColorConversionStrategy=/LeaveColorUnchanged -dDownsampleMonoImages=false -dDownsampleGrayImages=false -dDownsampleColorImages=false -dAutoFilterColorImages=false -dAutoFilterGrayImages=false -dColorImageFilter=/FlateEncode -dGrayImageFilter=/FlateEncode -dEncodeColorImages=false -dEncodeGrayImages=false -dEncodeMonoImages=false -sOutputFile=$output_file ";
    }


    foreach ($files as $file) {
        $cmd .= " $file";
    }

    // echo $cmd;
    // die;
    shell_exec($cmd);


    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>