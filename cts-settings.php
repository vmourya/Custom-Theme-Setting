<?php  /* All fields added by admin as Custom Theme Setting field will show below */ ?>
<div class='cts-setting-value'>
	<div class='width-800'>
		<?php if(isset($result)) echo $result; ?>
		<?php
			$sections=get_sections();
			$scount=1;
			if(!empty($sections)){
		?>
		<!--a class='button button-primary button-large save-all-form' href='javascript:void(0)'>Save all</a -->
		<?php 
			foreach($sections as $section){
			$cts_settings=get_section_fields($section->id);?>
		<?php if(!empty($cts_settings)){?>
			<form action='<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>' id='cts-setting-value-form-<?php echo $scount; ?>' name='cts-setting-value-form-<?php echo $scount; ?>' method='POST' enctype="multipart/form-data" class='cts-setting-value-form'>
			<fieldset>
				<span class='section-title' data='title-<?php echo $scount; ?>'><img src='<?php echo CTS_DIR .'cts-files/images/arrow.png' ?>' /><?php echo $section->name; ?></span><input class='button button-primary button-large' type='submit' id='submit' name='submit' value='Save' />
			</fieldset>
			<div class='section-fields' id='title-<?php echo $scount; ?>'>
				<?php foreach($cts_settings as $cts_setting){ ?>
					<fieldset>
						<label for='<?php echo $cts_setting->key; ?>'><?php echo $cts_setting->name; ?></label>
						<?php 
							$type=$cts_setting->type; 
							$val=stripslashes($cts_setting->value);
							$key=$cts_setting->key;
							switch($type){
								case 1:
								echo '<input type="text" id="'. $key .'" name="'. $key .'" value='. $val .' >';
								break;
								
								case 2:
								echo '<textarea id="'. $key .'" name="'. $key .'" >'. $val .'</textarea>';
								break;
								
								case 3:
								echo '<textarea class="text-editor" id="'. $key .'" name="'. $key .'">'. $val .'</textarea>';
								break;
								
								case 4:
								echo '<input class="cts-image" accept=".jpg,.png,.gif" type="file" id="'. $key .'" name="'. $key .'" value="'. $val .'" />';
								if($val){
									$src=$val;
								}else{
									$src='#';
								}
								echo '<img id="'. $key .'-img" src="'. $src .'" />';
								break;
								
								case 5:
								echo '<input class="cts-file" type="file" id="'. $key .'" name="'. $key .'" value="'. $val .'" />';
								break;						
							} 
						?>	
					</fieldset>	
				<?php } ?>	
				</div>
				</form>
			<?php }?>
		
		<?php $scount++;} ?>
		<div class="clear"></div>
		<!--a class='button button-primary button-large save-all-form' href='javascript:void(0)'>Save all</a-->
		<?php }else{ ?>
			<a class='button button-primary button-large save-all-form' href='?page=cts-add-section'>Create new section</a>
			<a class='button button-primary button-large save-all-form' href='?page=cts-add-setting'>Create new field</a>
		
		<?php }  ?>
	</div>
	<div class='user-instruction'>
		<p><span>How to use</span></p>
		<table cellspacing='0'>
			<tr>
				<th>Uses</th>
				<th>Php code</th>
				<th>Short code</th>
			</tr>
			<tr>
				<td>Get field value as string</td>
				<td><?php highlight_string('<?php echo cts_setting_value("key"); ?>'); ?></td>
				<td>[cts key=setting-key]</td>
			</tr>
			<tr>
				<td>Get field as an array</td>
				<td><?php highlight_string('<?php $settings= cts_setting("setting-key"); ?>'); ?></td><td></td>
			</tr>
			<tr>
				<td>Get all fields of section </td>
				<td><?php highlight_string('<?php $settings= cts_section_fields("section-key"); ?>'); ?></td>
				<td></td>
			</tr>			
		</table>
	</div>
</div>