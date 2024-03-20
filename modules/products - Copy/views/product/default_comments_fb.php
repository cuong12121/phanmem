<!-- COMMENT	-->

<div class="fb-comments" data-href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-numposts="5" data-width="100%" data-colorscheme="light" data-order-by="reverse_time"></div>
<input type="hidden" value="<?php echo $data->id; ?>" name='data_id' id='data_id'  />
<input type="hidden" value="<?php echo base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" name='data_url' id='data_url'  />
