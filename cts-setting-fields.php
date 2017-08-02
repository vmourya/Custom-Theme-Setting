<?php /* ADD SETTING FORM START */?>

<div class='status'><p><?php if($result)echo $result; ?></p></div>
<div class="full-row">
<?php if(!empty($sections)){ ?>
<form action=''  class='cts-add-setting-form' method='POST'>
	<fieldset>
		<label>Name *</label><input type='text' name='cts-name' id='cts-name' placeholder='Setting Name' value='<?php echo $name; ?>' />
	</fieldset>
	<fieldset>
		<label>Key </label><input type='text' name='cts-key' id='cts-key' readonly value='<?php echo $key; ?>' /><span class='help-popup-container'><span class='help' data='key'>?</span><span class='help-text' id='key'>Send this key to get value for this setting.</span></span>
	</fieldset>
	<fieldset>
		<label>Type</label>
		<div class='types-container'>
			<div>
				<input type='radio' name='cts-type' id='cts-text-type' value='1' checked='checked' <?php echo $type==1 ? 'checked="checked"' : ''; ?> />
				<label class='type' for='cts-text-type'>Single line text</label>
			</div>
			
			<div>
				<input type='radio' name='cts-type' id='cts-textarea-type' value='2' <?php echo $type==2 ? 'checked="checked"' : ''; ?> />
				<label class='type' for='cts-textarea-type'>Multi line text</label>
			</div>
			<div>
				<input type='radio' name='cts-type' id='cts-editor-type' value='3'  <?php echo $type==3 ? 'checked="checked"' : ''; ?> />
				<label class='type' for='cts-editor-type'>Text editor</label>
			</div>
			<div>
				<input type='radio' name='cts-type' id='cts-image-type' value='4' <?php echo $type==4 ? 'checked="checked"' : ''; ?> />
				<label class='type' for='cts-image-type'>Image</label>
			</div>
			<div>
				<input type='radio' name='cts-type' id='cts-file-type' value='5' <?php echo $type==5 ? 'checked="checked"' : ''; ?> />
				<label class='type' for='cts-file-type'>File</label>
			</div>

		</div>
	</fieldset>	
	<fieldset>
		<label>Description</label>
		<textarea name='cts-description' id='cts-description' placeholder='Setting Description'><?php echo $description; ?></textarea>
	</fieldset>	
	<fieldset>
		<label>Section *</label>
		<select name='cts-section' id='cts-section' >
			<option value='0'>Select Section</option>
			<?php foreach($sections as $section){ ?>
				<option value='<?php echo $section->id; ?>' <?php echo ($sid==$section->id)? 'selected="selected"' :''; ?>><?php echo $section->name; ?></option>
			<?php } ?>	
		</select>
	</fieldset>
	<fieldset>
		<input type='hidden' id='cts-id' name='cts-id' value='<?php echo $ctsid; ?>'/>
		<input class='button button-primary button-large' type='submit' name='submit' id='submit' value="Save"/>
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action']==1){ ?>
			&nbsp;<a class='button button-primary button-large' href='<?php echo 'admin.php?page=cts-add-setting'; ?>'>Add new</a>
		<?php } ?>
	</fieldset>
</form>
<div id='cts-field-list'>
	<table cellspacing='0'>
		<tr><th>Name</th><th>Key</th><th>Section</th></th><th>Type</th><th>Description</th><th>Action</th></tr>
		<?php $cts_settings=get_setting();
			$ccount=1;
			foreach($cts_settings as $setting){?>
				<?php
					if($setting->type==1){
						$type='Single Line Text';
					}elseif($setting->type==2){
						$type='Multi Line Text';
					}elseif($setting->type==3){
						$type='Text Editor';
					}elseif($setting->type==4){
						$type='Image';
					}elseif($setting->type==5){
						$type='File';
					}else{
						$type='Unknown';
					}
				?>
				<?php $section_name=get_sections($setting->section_id);?>
				<tr><td><?php echo $setting->name; ?></td><td><input type='text' value='<?php echo $setting->key; ?>' readonly /></td><td><?php echo $section_name[0]->name; ?></td><td><?php echo $type ; ?></td><td><?php echo $setting->description; ?></td><td><a href='<?php echo 'admin.php?page=cts-add-setting&action=1&ctsid='.$setting->id; ?>' class='cts-edit'>Edit</a> <a href='<?php echo 'admin.php?page=cts-add-setting&action=0&ctsid='.$setting->id; ?>' class='cts-delete'>Delete</a></td></tr>				
			<?php $ccount++; }
		?>
	</table>
</div>
<?php }else{ ?>
	<a class='button button-primary button-large' href='<?php echo 'admin.php?page=cts-add-section'; ?>'>Please Add section first.</a>
<?php } ?>
</div>

<?php /* ADD SETTING FORM START */?>