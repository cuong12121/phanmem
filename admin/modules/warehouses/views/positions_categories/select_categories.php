<!-- HEAD -->
<?php 
	$title = FSText::_('Chọn kho hàng'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('cancel',FSText::_('Thoát'),'','cancel.png'); 
	
?>
<!-- END HEAD-->
<form method="post" name="adminForm" action="index.php?module=products&view=products&task=search">
<div class="filter_area">
	<table>
		<tbody>
			<tr>
				<td align="left">
					Tìm kiếm:
					<input id="search" class="text_area" type="text" value="" name="keysearch">
				</td>
				<td>
					<button onclick="javascript: this.form.submit();">Tìm kiếm</button>
					<button onclick="document.getElementById('search').value=''; this.form.getElementById('filter_state').value='';this.form.submit();">Reset</button>
				</td>
				</tr>
			</tbody>
	</table>
	</div>
</form>	
<!-- BODY-->
	<!--	CONTENT -->
        <ul class='product_categories' >
	 	<?php 
        $num_child = array();
        $parant_close = 0;
	 	$i = 0;
	 	$count_children = 0;
	 	$summner_children = 0;
	 	$id = 0;
	 		
        $total = count($warehouses);
		 	foreach ( $warehouses as $item ) { 
                $class = '';
                $link = FSRoute::_('index.php?module=warehouses&view=positions_categories&task=add').'?warehouses_id='.$item  -> id;
                
		 		$class  .= ' level_'.@$item -> level;
		 		if($i == ($total -1))
		 			  $class .= ' last-item';
		 		
                if(@$item -> level ){
		 			$count_children ++;
		 			if($count_children == $summner_children && $summner_children)
		 				 $class .= ' last-item';

		 			echo "<li class='item $class child_".$item->parent_id."' ><h2 class=\"toolbar\" class='h2_".$item->level."'><a  href='".$link."'  ><span> ".$item -> name."</span></a></h2>  ";
                } else {
                    $count_children = 0;
                    $summner_children = @$item -> children;
                    	echo "<li class='item $class  ' id='pr_".$item -> id."' >";
                        echo "<h2 class='h2_".@$item->level."'><a  class=\"toolbar\"  href='".$link."'  ><span> ".$item -> name."</span></a></h2>  ";
                } 
            ?>
          <?php 
            $num_child[$item->id] = @$item->children ;
            if(@$item->children  > 0){
            	if($item -> level)
                	echo "<ul id='c_".$item->id."' class=' sub-menu wrapper_children wrapper_children_level".$item -> level."' style='display:none' >";
                else 
                	echo "<ul id='c_".$item->id."' class=' sub-menu wrapper_children_level".$item -> level."'>";
            }

            if(@$num_child[$item->parent_id] == 1) 
            {
                if($item->children > 0)
                {
                    $parant_close ++;
                }
                else
                {
                    $parant_close ++;
                    for($i = 0 ; $i < $parant_close; $i++)
                    {
                        echo "</ul>";
                    }
                    $parant_close = 0;
                    $num_child[$item->parent_id]--;
                }
                
                if(( (@$num_child[$item->parent_id] == 0) && (@$item->parent_id >0 ) ) || !$item->children )
                {
                  echo "</li>";
                }
                if(@$num_child[$item->parent_id] >= 1) 
                    $num_child[$item->parent_id]--;
            }   
                
            
            if(isset($num_child[@$item->parent_id] ) && ($num_child[@$item->parent_id] == 1) )
                echo "</ul>";
            if(isset($num_child[@$item->parent_id]) && ($num_child[@$item->parent_id] >= 1) )
                $num_child[$item->parent_id]--;
                  
        }
            ?>
	<!--	end CONTENT -->
</ul>
<style>
	.form_body .tbl_form_contents{
		display: none;
	}
	ul {
	    list-style: outside none none;
	    padding: 0;
	}
	.product_categories{	
		 -moz-columns: 4 auto;
	    float: left;
	    height: auto;
	    padding-left: 20px;
	    width: 100%;
	}
	.product_categories li {
		margin-bottom: 10px;
	}
	.product_categories li a span{
		font-size: 16px;
		color: blue;

	}
	.product_categories .level_0 {
	}
	h2 {
	    margin: 0;
	}	
	.h2_0 a{
	    font-size: 14px;
		color:#333333;
	}
	.sub-menu li {
		margin-left:10px
	}
	 li .toolbar a{
		font-size: 13px;
		color:#333333;
		font-weight: normal;
	}
</style>
<script type='text/javascript'>

function submitbutton(pressbutton,cid) {
		submitform(pressbutton,cid);
}
/**
* Submit the admin form
*/
function submitform(pressbutton,cid){
	if (pressbutton) {
		url_current = window.location.href;
		url_current = url_current.replace('#','');
		if(cid)
			window.location.href=url_current+'&task='+pressbutton+'&cid='+cid;
		else
			window.location.href=url_current+'&task='+pressbutton;
		return;
	}
}
</script>
