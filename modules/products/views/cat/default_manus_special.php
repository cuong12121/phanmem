<?php
$max = IS_MOBILE?2:4;
?>

<?php 
    for($i = 0 ; $i < count( $array_manu_special) ; $i ++)
    {
         // printr($array_products_special);

        $manu_sp = $array_manu_special[$i];


        if(!count($array_products_special[$manu_sp->id])){
            continue;
        }

        $link_cat = FSRoute::_("index.php?module=products&view=cat&ccode=".$cat -> alias.'&cid='.$cat -> id);
        $link_cat = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link_cat);
        if(!empty($cat->alias1) AND !empty($cat->alias2)){
            $link_cat = str_replace($cat->alias,$cat->alias1.'-'.$manu_sp->alias.'-'.$cat->alias2,$link_cat);
        }else{
            $link_cat = str_replace($cat->alias,$cat->alias.'-'.$manu_sp->alias,$link_cat);
        }

?>

    <div class="manu_products_special">
        <div class="cat_label">
            <div class="manu_products_special_name">
                <?php
                    if(!empty($cat->name1) AND !empty($cat->name2)){ 
                        $cat_name_sp = $cat->name1 .' '.  $manu_sp -> name .' '.$cat->name2;
                    }else{
                        $cat_name_sp = $cat->name .' '.  $manu_sp -> name;
                    }
                ?>
                <a href="<?php echo $link_cat; ?>" title="<?php echo $cat_name_sp ?>">
                    <?php echo $cat_name_sp ?>
                </a>
                 
            </div>
        </div>
        <div class="row product_grid">
            <?php 
                $j = 0;
                foreach($array_products_special[$manu_sp->id] as $item){            
                  include 'default_item.php';
                  $j++;
                }
            ?>		
        </div>
        <div class="clear"></div>
   </div>
<?php 	
} 
?>