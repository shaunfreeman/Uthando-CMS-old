<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<?php defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); ?> 
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->    getTemplate(); ?>/css/template_css.css" rel="stylesheet" type="text/css" media="all" />
  <link rel="shortcut icon" href="<?php echo $mosConfig_live_site;?>/images/favicon.ico" />
	<?php if ( $my->id ) { initEditor(); } mosShowHead(); ?> 
</head>

<body id="normal">

<div id="dTop">

	<div class="center">

		<div class="left"><?php echo $mosConfig_sitename; ?></div>

		<div class="right"><?php mosLoadModules ( 'user4',-1); ?></div>

		<div class="topMenu"><?php mosLoadModules ( 'user3',-2); ?></div>

		<div class="clearer"></div>

	</div>	

</div>

<div id="dFlash">

	<div class="center">
		<?php if(mosCountModules('top')) {mosLoadModules ('top');} ?>
	</div>

</div>

<div id="dMain">

	<div class="center">

<?php if (mosCountModules('left') && mosCountModules('right')) :?>

		<div class="col3">

			<div class="left"><?php mosLoadModules('left',-2); ?></div>
			<div class="mid"><?php mosMainBody(); ?></div>
			<div class="right"><h3>Search</h3><?php mosLoadModules ( 'user4'); ?><?php mosLoadModules('right',-2); ?></div>
			
			<div class="clearer"></div>

		</div>

<?php elseif (mosCountModules('left')) : ?>
		
		<div class="col2">

			<div class="left"><?php mosLoadModules('left',-2); ?></div>
			<div class="mainright"><?php mosMainBody(); ?></div>
			
			<div class="clearer"></div>

		</div>

<?php else : ?>

		<div class="col2">

			<div class="mainleft"><?php mosMainBody(); ?></div>
			<div class="right"><?php mosLoadModules('right',-2); ?></div>
			
			<div class="clearer"></div>

		</div>

<?php endif;?>

	</div>

</div>

<div id="dFooter">

	<div class="center">
		<p>Add Your Footer Text Here
		</p>		
		<a title="Joomla Templates" href="http://www.joomladesigns.co.uk">Joomla 
		Templates</a> By
		<a title="Joomladesigns Joomla Templates" href="http://www.joomladesigns.co.uk">
		Joomladesigns</a></div>

</div>

</body>

</html>