<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head"  style="xhtml" />
<link rel="stylesheet" href="templates/_system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/template_css.css" type="text/css" />

<link rel="alternate" title="<?php echo $mainframe->getCfg('sitename');?>" href="index2.php?option=com_rss&amp;no_html=1" type="application/rss+xml" />
<link rel="shortcut icon" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/favicon.ico" />
</head>
<body>
<div id="wrap">
  <div id="header">
    <div class="inside">
      <h1><a href="index.php" title="Home page | <?php echo $mainframe->getCfg('sitename');?>"><?php echo $mainframe->getCfg('sitename');?></a></h1>
      <h2>The Best Slogan here</h2>
      <jdoc:include type="modules" name="user4" style="xhtml" />
      <jdoc:include type="modules" name="user3" style="xhtml" />
      <div id="pathway">
        <jdoc:include type="module" name="breadcrumbs" />
      </div>
    </div>
  </div>
  <div id="sidebar">
    <div class="inside">
      <jdoc:include type="modules" name="left" style="xhtml" />
    </div>
  </div>
  <div id="main">
    <?php if($this->countModules('right')) : ?>
    <div id="rightcol">
      <div class="inside">
        <jdoc:include type="modules" name="right" style="xhtml" />
        <jdoc:include type="modules" name="user1" style="xhtml" />
        <jdoc:include type="modules" name="user2" style="xhtml" />
      </div>
    </div>
    <?php endif; ?>
    <div id="content" <?php if(!$this->countModules('right')) : ?>style="margin-right:10px;"<?php endif; ?>>
      <div class="inside">
        <jdoc:include type="modules" name="top" style="xhtml" />
        <jdoc:include type="component" style="xhtml" />
      </div>
    </div>
  </div>
  <br id="footerbr" clear="all" />
  <div id="footer">
    <div class="inside">
      <p> Copyright &copy; 2006 Your Company <br />
        <a href="http://www.joomladesigns.co.uk/">Joomladesigns</a> | <a href="http://www.joomladesigns.co.uk/">Joomla Templates</a> </p>
    </div>
  </div>
</div>
</body>
</html>
