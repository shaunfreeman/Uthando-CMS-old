<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head"  style="xhtml" />
<link rel="stylesheet" href="templates/_system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/template_css.css" type="text/css" />

<link rel="alternate" title="<?php echo $mainframe->getCfg('sitename');?>" href="index2.php?option=com_rss&amp;no_html=1" type="application/rss+xml" />
<script type="text/javascript" language="javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/md_stylechanger.js"></script>
<link rel="shortcut icon" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/favicon.ico" />
</head>
<body<?php
    if (isset($_COOKIE['fontSize']) && $_COOKIE['fontSize']!='100')
    {
        echo ' style="font-size: '.$_COOKIE['fontSize'].'%"';
    }
    else
    {
        echo ' style="font-size: 100%"';
    }
?>>
<div id="content">
  <div id="line_top"><img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/images/cl.gif" id="cl" alt="-" /></div>
  <div id="left_col">
    <div id="top_logo">
      <h1><?php echo $mainframe->getCfg('sitename');?><span> Corp.</span></h1>
      <img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/images/logo.gif" id="logo" alt="<?php echo $mainframe->getCfg('sitename');?> Corp." title="<?php echo $mainframe->getCfg('sitename');?> Corp." /> </div>
    <div class="mod_user1">
      <jdoc:include type="modules" name="user5" style="xhtml" />
    </div>
    <div class="mod_user2">
      <jdoc:include type="modules" name="user6" style="xhtml" />
    </div>
    <div class="mod_user3">
      <jdoc:include type="modules" name="user7" style="xhtml" />
    </div>
  </div>
  <div id="right_col">
    <jdoc:include type="modules" name="left" style="xhtml" />
    <jdoc:include type="modules" name="right" style="xhtml" />
    <jdoc:include type="modules" name="user1" style="xhtml" />
  </div>
  <div id="main_content">
    <div class="padding">
      <div id="right_top">
        <div id="right_top_left">
          <h2><span>Business corp.</span><br />
            slogan here</h2>
          <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium... <br/>
            <a href="#">READ MORE ABOUT US ...</a></p><img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/images/globe.jpg" id="globe" alt="" style="float:right" />
          <a href="index.php" title="Increase size" onclick="changeFontSize(2);return false;" id="plus"><img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/images/larger.gif" alt="Increase size" title="Increase size" border="0" /></a><a href="index.php" title="Decrease size" onclick="changeFontSize(-2);return false;" id="minus"><img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/images/smaller.gif" alt="Decrease size" title="Decrease size" border="0" /></a><a href="index.php" title="Revert styles to default" onclick="revertStyles(); return false;" id="revert"><img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/images/reset.gif" alt="Revert styles to default" title="Revert styles to default" border="0" /></a></div>
        <div class="both">
          <!--  -->
        </div>
      </div>
      <?php if($this->countModules('top')) : ?>
      <div id="newsflash">
        <jdoc:include type="modules" name="top" style="xhtml" />
      </div>
      <?php endif; ?>
      <jdoc:include type="component" style="xhtml" />
    </div>
  </div>
  <div class="both">
    <!--  -->
  </div>
</div>
<div id="footer">
  <p>Copyright &copy; Your Footer Text
    Goes Here 2006-2007<br />
    <a href="http://www.joomladesigns.co.uk/"> Joomla Templates By JoomlaDesigns.co.uk</a></p>
</div>
<jdoc:include type="modules" name="debug" style="xhtml" />
</body>
</html>
