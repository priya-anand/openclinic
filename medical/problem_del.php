<?php
/**
 * This file is part of OpenClinic
 *
 * Copyright (c) 2002-2004 jact
 * Licensed under the GNU GPL. For full terms see the file LICENSE.
 *
 * $Id: problem_del.php,v 1.4 2004/06/16 19:11:02 jact Exp $
 */

/**
 * problem_del.php
 ********************************************************************
 * Medical Problem deletion process
 ********************************************************************
 * Author: jact <jachavar@terra.es>
 */

  ////////////////////////////////////////////////////////////////////
  // Checking for post vars. Go back to form if none found.
  ////////////////////////////////////////////////////////////////////
  if (count($_POST) == 0)
  {
    header("Location: ../medical/patient_search_form.php");
    exit();
  }

  ////////////////////////////////////////////////////////////////////
  // Controlling vars
  ////////////////////////////////////////////////////////////////////
  $tab = "medical";
  $nav = "problems";
  $onlyDoctor = false;

  require_once("../shared/read_settings.php");
  require_once("../shared/login_check.php");
  require_once("../classes/Problem_Query.php");
  require_once("../classes/Connection_Query.php"); /* referencial integrity */
  require_once("../classes/DelProblem_Query.php");
  require_once("../lib/error_lib.php");
  require_once("../shared/record_log.php"); // record log

  ////////////////////////////////////////////////////////////////////
  // Retrieving post vars
  ////////////////////////////////////////////////////////////////////
  $idProblem = intval($_POST["id_problem"]);
  $idPatient = intval($_POST["id_patient"]);
  $wording = $_POST["wording"];

  ////////////////////////////////////////////////////////////////////
  // Prevent user from aborting script
  ////////////////////////////////////////////////////////////////////
  $oldAbort = ignore_user_abort(true);

  ////////////////////////////////////////////////////////////////////
  // Delete medical problems connections
  ////////////////////////////////////////////////////////////////////
  $connQ = new Connection_Query();
  $connQ->connect();
  if ($connQ->errorOccurred())
  {
    showQueryError($connQ);
  }

  $numRows = $connQ->select($idProblem);

  $conn = array();
  for ($i = 0; $i < $numRows; $i++)
  {
    $conn[] = $connQ->fetch();
  }
  $connQ->freeResult();

  while ($aux = array_shift($conn))
  {
    if ( !$connQ->delete($idProblem, $aux[1]) )
    {
      $connQ->close();
      showQueryError($connQ);
    }
  }
  $connQ->close();
  unset($connQ);
  unset($conn);

  ////////////////////////////////////////////////////////////////////
  // Delete problem
  ////////////////////////////////////////////////////////////////////
  $problemQ = new Problem_Query();
  $problemQ->connect();
  if ($problemQ->errorOccurred())
  {
    showQueryError($problemQ);
  }

  if (defined("OPEN_DEMO") && !OPEN_DEMO)
  {
    $numRows = $problemQ->select($idProblem);
    if ($problemQ->errorOccurred())
    {
      $problemQ->close();
      showQueryError($problemQ);
    }

    if ( !$numRows )
    {
      $problemQ->close();
      include_once("../shared/header.php");

      echo '<p>' . _("That medical problem does not exist.") . "</p>\n";

      include_once("../shared/footer.php");
      exit();
    }

    $problem = $problemQ->fetch();

    $delProblemQ = new DelProblem_Query();
    $delProblemQ->connect();
    if ($delProblemQ->errorOccurred())
    {
      showQueryError($delProblemQ);
    }

    if ( !$delProblemQ->insert($problem, $_SESSION['userId'], $_SESSION['loginSession']) )
    {
      $delProblemQ->close();
      showQueryError($delProblemQ);
    }
    unset($delProblemQ);
    unset($problem);
  }

  if ( !$problemQ->delete($idProblem) )
  {
    $problemQ->close();
    showQueryError($problemQ);
  }
  $problemQ->close();
  unset($problemQ);

  ////////////////////////////////////////////////////////////////////
  // Record log process
  ////////////////////////////////////////////////////////////////////
  recordLog("problem_tbl", "DELETE", $idProblem);

  ////////////////////////////////////////////////////////////////////
  // Reset abort setting
  ////////////////////////////////////////////////////////////////////
  ignore_user_abort($oldAbort);

  ////////////////////////////////////////////////////////////////////
  // Show success page
  ////////////////////////////////////////////////////////////////////
  $title = _("Delete Medical Problem");
  require_once("../shared/header.php");
  require_once("../medical/patient_header.php");

  $returnLocation = "../medical/problem_list.php?key=" . $idPatient;

  ////////////////////////////////////////////////////////////////////
  // Navigation links
  ////////////////////////////////////////////////////////////////////
  require_once("../shared/navigation_links.php");
  $links = array(
    _("Medical Records") => "../medical/index.php",
    _("Search Patient") => "../medical/patient_search_form.php",
    _("Medical Problems Report") => $returnLocation,
    $title => ""
  );
  showNavLinks($links, "patient.png");
  unset($links);

  showPatientHeader($idPatient);

  echo '<p>' . sprintf(_("Medical problem, %s, has been deleted."), $wording) . "</p>\n";

  echo '<p><a href="' .$returnLocation . '">' . _("Return to Medical Problems List") . "</a></p>\n";

  require_once("../shared/footer.php");
?>