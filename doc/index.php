<?php
/**
 * This file is part of OpenClinic
 *
 * Copyright (c) 2002-2004 jact
 * Licensed under the GNU GPL. For full terms see the file LICENSE.
 *
 * $Id: index.php,v 1.5 2004/06/20 12:06:06 jact Exp $
 */

/**
 * index.php
 ********************************************************************
 * Home page of documentation project
 ********************************************************************
 * Author: jact <jachavar@terra.es>
 */

  /*if (count($_GET) == 0 || !isset($_GET['tab']) || !isset($_GET['nav']))
  {
    header("Location: ../index.php");
    exit();
  }
  header("Location: book-manual_usuario.htm#" . $_GET['tab'] . "-" . $_GET['nav']);*/

  $tab = "doc";

  require_once("../shared/read_settings.php");

  ////////////////////////////////////////////////////////////////////
  // XHTML Start (XML prolog, DOCTYPE, title page and meta data)
  ////////////////////////////////////////////////////////////////////
  $title = _("OpenClinic Help");
  require_once("../shared/xhtml_start.php");
?>

<style type="text/css" title="<?php echo STYLE_NAME; ?>">
<!--
<?php require_once("../css/style.php"); ?>
-->
</style>

<script type="text/javascript" src="../scripts/pop_window.js" defer="defer"></script>
</head>
<body>

<!-- Header -->
<div id="header">
  <div id="subHeader">
    <span class="headerTitle"><?php echo _("OpenClinic Help"); ?></span>

    <div id="headerInformation">
      <a href="#" onclick="window.close(); return false;"><?php echo _("Close Window"); ?></a>
    </div><!-- End #headerInformation -->
  </div><!-- End #subHeader -->

  <div id="sourceForgeLinks">
    &nbsp;
  </div><!-- End #sourceForgeLinks -->
</div><!-- End #header -->
<!-- End Header -->

<!-- Side Bar -->
<div id="sideBar">
  <div class="linkList">
    <span class="selected"><?php echo _("Help Topic"); ?></span>
    <span class="noPrint"> | </span>
    <a href="#"><?php echo _("Help Topic"); ?></a>
  </div><!-- End .linkList -->

  <div id="sideBarLogo">
    <p>
      <a href="http://openclinic.sourceforge.net">
        <img src="../images/openclinic-2.png" width="130" height="29" alt="<?php echo _("Powered by OpenClinic"); ?>" title="<?php echo _("Powered by OpenClinic"); ?>" />
      </a>
    </p>

    <p>
      <a href="http://www.coresis.com">
        <img src="../images/thank.png" width="65" height="30" alt="OpenClinic Logo thanks to Coresis" title="OpenClinic Logo thanks to Coresis" /><img src="../images/coresis.png" width="65" height="30" alt="OpenClinic Logo thanks to Coresis" title="OpenClinic Logo thanks to Coresis" />
      </a>
    </p>

    <p>
      <a href="http://sourceforge.net">
        <img src="../images/sf-logo.png" width="130" height="37" alt="SourceForge.net Logo"  title="SourceForge.net Logo" />
      </a>
    </p>

    <p>
      <a href="http://www.php.net">
        <img src="../images/php-logo.gif" alt="Powered by PHP" title="Powered by PHP" width="90" height="33" />
      </a>
    </p>

    <p>
      <a href="http://www.mysql.com">
        <img src="../images/mysql-logo.png" alt="Works with MySQL" title="Works with MySQL" width="84" height="44" />
      </a>
    </p>

    <p>
      <a href="http://validator.w3.org/check/referer">
        <img src="../images/valid-xhtml11.png" alt="Valid XHTML 1.1" title="Valid XHTML 1.1" width="88" height="31" />
      </a>
    </p>
  </div><!-- End #sidebarLogo -->
</div><!-- End #sideBar -->
<!-- End Side Bar -->

<!-- Main Zone -->
<div id="mainZone">

<h3><?php echo _("Sample Help Page:"); ?></h3>

<?php print_r($_GET); // debug ?>

<?php require_once("../shared/footer.php"); ?>