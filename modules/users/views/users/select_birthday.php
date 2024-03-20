<span><?php echo FSText::_("Ng&agrave;y"); ?></span>
                        <select name="birth_day">
                            <?php for($i = 1 ; $i < 32 ; $i ++ ) {?>
                                    <?php $check = ($i == FSInput::get('birth_day')) ? "selected='selected'": ""; ?>
                                <option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
                            <?php }?>
                        </select>	
                        
                        <span><?php echo FSText::_("Th&aacute;ng"); ?></span>       
                        <select name="birth_month">
                            <?php for($i = 1 ; $i < 13 ; $i ++ ) {?>
                                <?php $check = ($i == FSInput::get('birth_month')) ? "selected='selected'": ""; ?>
                                <option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
                            <?php }?>
                        </select>	
                        
                        <span><?php echo FSText::_("N&#259;m"); ?></span>     
                        <select name="birth_year">
                            <?php $current_year = date("Y");?>
                                <?php for($i = $current_year ; $i > 1900 ; $i -- ) {?>
                                <?php $check = ($i == FSInput::get('birth_year')) ? "selected='selected'": ""; ?>
                                <option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
                            <?php }?>
                        </select>	