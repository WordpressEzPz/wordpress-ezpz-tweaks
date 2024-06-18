<?php
use EZPZ_TWEAKS\Engine\Settings\Render;
use EZPZ_TWEAKS\Engine\Settings\Register;
use EZPZ_TWEAKS\Engine\Settings\Settings;

(new Register)->init();
$page = 'wpezpz-tweaks';

?>
<?php require_once( EZPZ_TWEAKS_PLUGIN_ROOT . 'backend/views/header.php' ); ?>
<div class="ezpz-full-w ezpz-header-breadcrumb">
	<a><?php _e('Dashboard'); ?></a>
	<span> / </span>
	<?php
		$tab = Settings::get_first_tab($page);
	if (!empty($tab)) {
		echo '<a href="' . admin_url('admin.php?page=' . $page . '&tab=' . $tab['id']) . '" class="ezpz-breadcrumb-last">' . $tab['title'] . '</a>';
	}
	?>
</div>
<div class="ezpz-full-w ezpz-tweaks-tabs">


	<!-- Start tabs -->
	<?php
	Render::navigation( $page );
	$form   = 'wpezpz-tweaks_options_'.(empty($_GET['tab'])?'customizing-branding':$_GET['tab']);
    
	?>

	<!-- End tabs -->

</div>
<p style="position:relative;top:24px;margin: 0 8px;">
<?php echo ezpz_option_dropdown();//functions.php ?>
<input type="hidden" name="ezpz_nonce" form="<?php echo $form; ?>" value="<?php echo wp_create_nonce('Acti0n_Save_0pti0n'); ?>"/>
</p>
<div class="ezpz-tweaks-tabs ezpz-tweaks-tabs-content">
	<?php 	Render::tabs( $page ); ?>
</div>
