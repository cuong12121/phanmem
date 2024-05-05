<?php 
include_once '../libraries/tree/tree.php';
$list = Tree::indentRows($list);
$root_total = 0;
$root_last = 0;
$url = $_SERVER['REQUEST_URI'];
foreach ($list as $item){
	if(!@$item->parent_id){
		$root_total ++ ;
		$root_last = $item->id;
	}
}
?>
<ul class="nav" id="side-menu" >
    <?php 
    $num_child = array();
    $parant_close = 0;
    // dd($list);
    foreach ($list as $item){
        $array_params  = get_params($item->link);

        $module  = isset($array_params['module'])?$array_params['module']: '';
        $view  = isset($array_params['view'])?$array_params['view']: '';

       

        $module_c = FSInput::get('module');
        $view_c = FSInput::get('view');

        // print_r($item);
        $class = '';
        $collapse = '';
        $icon = '';

        if(!$item-> parent_id) {
            if($item-> module == $module_c) {
                $class .= ' actives ';
            }
        } else {
            if($module == $module_c && $view == $view_c) {
                $item-> name;
                $class .= ' actives ';
            }
        }

        
        if($item->link){
           $link = trim($item->link);
         // if(strpos($url,$link) !== false)
         //    $class .= ' actives ';
           $link = FSRoute::_($link);
       }else{
           $link = "javascript:void(0)";
   // $collapse =  '<span class="fa arrow"></span>';
       }
       if($item->icon){
        $icon = '<i class="'.$item->icon.'"></i> ';
    }
    $has_child = '';
    if($item->children > 0) {
        $class .= 'li_parent';
        $has_child = ' has-child';
    }
    if(!$item-> parent_id){
        ?>
        <li>
            <a id="li_menu_<?php echo $item-> id; ?>" href="<?php echo $link; ?>" class="li_menu_0 header <?php echo $class;?>" >
              <?php echo '<span class="text">'.FSText::_(trim($item->name)).'</span>'; ?>
          </a>
      <?php }else{ ?>
        <li>
            <a id="li_menu_<?php echo $item-> id;?>" href="<?php echo $link; ?>" class="li_menu_1 <?php echo $class;?>" >
                <?php echo $icon; ?>
                <?php echo '<span class="text">'.FSText::_(trim($item->name)).$collapse.'</span>'; ?>
            </a>
        <?php } ?>
        <?php 
        $num_child[$item->id] = $item->children ;
        if($item->children  > 0){
            if(!$item->parent_id) {
                echo "<ul class='nav nav-second-level nav-second-level-".$item-> id."'  >";
            } else {
                echo "<ul class='nav nav-second-level nav-third-level nav-second-level-".$item-> id."'  >";
            }

        }
        if(@$num_child[$item->parent_id] == 1){
           if($item->children > 0){
            $parant_close ++;
        }else{
            $parant_close ++;
            for($i = 0 ; $i < $parant_close; $i++){
             echo "</ul>";
         }
         $parant_close = 0;
         $num_child[$item->parent_id]--;
     }
     if(@$num_child[$item->parent_id] >= 1) 
        $num_child[$item->parent_id]--;
}	
if(isset($num_child[$item->parent_id] ) && ($num_child[$item->parent_id] == 1) )
   echo "</ul>";
if(isset($num_child[$item->parent_id]) && ($num_child[$item->parent_id] >= 1) )
   $num_child[$item->parent_id]--;
echo '</li>';
}
?>

<li>
  <a id="li_menu_500" href="https://dienmayai.com/admin/order/detail" class="li_menu_0 header ">
    <span class="text">Chi tiết đơn hàng</span>          
  </a>
</li>
</ul>
<script>

   $(function(){
      var date = new Date();
      var minutes = 60;
      date.setTime(date.getTime() + (minutes * 60 * 24));
  });

   function myFunction() {
    // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById('myInput');
    filter = input.value.toUpperCase();
    ul = document.getElementById("side-menu");
    li = ul.getElementsByTagName('li');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

$('.li_menu_0').click(function(){
    id_menu = $(this).attr('id');
    nav2 = id_menu.replace('li_menu_','nav-second-level-');
    if($('.'+nav2).hasClass('menu_show')){
    } else {
        $('.nav-second-level').removeClass('menu_show');
    }
    $('.'+nav2).toggleClass('menu_show');
})

$('.li_menu_1').click(function(){
    id_menu = $(this).attr('id');
    nav2 = id_menu.replace('li_menu_','nav-second-level-');
    if($('.'+nav2).hasClass('menu_show')){
    } else {
       $('.nav-third-level').removeClass('menu_show');
   }
   $('.'+nav2).toggleClass('menu_show');
})
</script>


<?php
    /*
         * get Array params
         */
    function get_params($url){
            $url_reduced  = substr($url,10); // width : index.php
            $array_buffer = explode('&',$url_reduced,10);
            $array_params = array();
            for($i  = 0; $i < count($array_buffer) ; $i ++ ){
                $item = $array_buffer[$i];
                $pos_sepa = strpos($item,'=');
                $array_params[substr($item,0,$pos_sepa)] = substr($item,$pos_sepa+1);  
            }
            return $array_params;
        }
        ?>
