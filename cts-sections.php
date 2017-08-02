<?php /* ADD SETTING FORM START */?>
<div class='status'><p><?php if($result)echo $result; ?></p></div>
<div class="full-row bord1">
<form action=''  class='cts-add-setting-form' method='POST'>
	<fieldset>
		<label>Name</label><input type='text' name='cts-section-name' id='cts-section-name' placeholder='Section Name' value='<?php echo $name; ?>' />
	</fieldset>
	<fieldset>
		<label>Key </label><input type='text' name='cts-section-key' id='cts-section-key' readonly value='<?php echo $key; ?>' /><span class='help-popup-container'><span class='help' data='key'>?</span><span class='help-text' id='key'>Send this key to get all seeting values for this section.</span></span>
	</fieldset>
	<fieldset>
		<label>Description</label><textarea name='cts-section-description' id='cts-section-description' placeholder='Section Description'><?php echo $description; ?></textarea>
	</fieldset>	
	
	<fieldset>
		<input type='hidden' id='cts-section-id' name='cts-section-id' value='<?php echo $secsid; ?>'/>
		<input class='button button-primary button-large' type='submit' name='submit' id='submit' value="Save"/>
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action']==1){ ?>
			&nbsp;<a class='button button-primary button-large' href='<?php echo 'admin.php?page=cts-add-section'; ?>'>Add new</a>
		<?php } ?>
	</fieldset>
</form>
<?php  ?>
<div id='cts-field-list'>
	<table cellspacing='0'>
		<tr><th>Name</th><th>Key</th><th>Description</th><th>Action</th></tr>
		<?php $cts_sections=get_sections();
			foreach($cts_sections as $cts_section){?>
				<tr><td><?php echo $cts_section->name; ?></td><td><input type='text' value='<?php echo $cts_section->key; ?>' readonly /></td><td><?php echo $cts_section->description; ?></td><td><a href='<?php echo 'admin.php?page=cts-add-section&action=1&secsid='.$cts_section->id; ?>' class='cts-edit'>Edit</a> <a href='<?php echo 'admin.php?page=cts-add-section&action=0&secsid='.$cts_section->id; ?>' class='cts-delete'>Delete</a></td></tr>				
			<?php }
		?>
	</table>
</div>
<?php ?>
</div>
<?php /* ADD SETTING FORM START */?>