<div class="wrap">
	<h2>Open hybrid settings</h2>
	<form method="post" action="options.php" id="openhybridwordpress_setting_form" enctype="multipart/form-data" >
	   <?php settings_fields('openhybridwordpress_setting_options'); ?>
	   <?php do_settings_sections('open_hybird_wrodpress_settings'); ?>
	   <p class="submit">
	       <input type="submit" name="submit" class="button button-primary" value="Save Changes">
	   </p>
	</form>
</div>