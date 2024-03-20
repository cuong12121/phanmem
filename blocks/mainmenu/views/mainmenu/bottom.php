<?php 
global $tmpl;
$tmpl -> addStylesheet('bottom','blocks/mainmenu/assets/css');
?> 
 <div class="container container-menu-bottom">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle bt-bottom bt-toggle2" data-toggle="collapse" data-target="#nav-bottom" style="background-color: #379748;">
                            <span class="icon-bar" style="background-color: orange"></span>
                            <span class="icon-bar" style="background-color: orange"></span>
                            <span class="icon-bar" style="background-color: orange"></span>
                        </button>
                    </div><!-- end div navbar-header -->
                    <div class="collapse navbar-collapse  menu-bottom" id="nav-bottom">
                        <ul class="nav navbar-nav">
                        	<li><a href='<?php echo URL_ROOT; ?>'  class='item ' ><span> Trang chủ</span></a>  </li>
                        <?php 
						 	// Home
						 	$link_home = URL_ROOT;
						 	?>
						 	
						 	<?php 
						 	$Itemid  = FSInput::get('Itemid'); 
						 	$total = count($list); 
						 	$i = 0;
						 	foreach ( $list as $item ) { 
						 		$class =  $item -> id ==  $Itemid ? 'active':'';
						 		if($i == ($total -1))
						 			  $class .= ' last-item';
						 		if(strpos($item -> link ,'forum') !== false){	  
						 			$link   = FSRoute::_($item -> link);
						 		} else {
						 			$link   = FSRoute::_($item -> link);
						 		}
						 		echo "<li><a href='".$link."'  class='item $class ' ><span> ".$item -> name."</span></a>  </li>";
						 		// sepa
						 		$i ++;
						 	}
						 	?>
                        </ul>
                    </div><!-- end div nav-bottom -->    
            </div><!-- end div container-menu-bottom -->
            
