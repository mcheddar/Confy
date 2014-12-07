<?php
/******************/
/* Edit page form */
/******************/

require_once("../includes/admin_init.php");
require_once("../includes/adminAccount.class.php");
require_once("../includes/pages.class.php");
require_once("../includes/conferencesManagement.class.php");

/* Intitalize and output header */
initHeader("Pages Management");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Let's create an instance of the Conference class, which handles currently selected conference */
$pages = new Pages($adminAccount->getCurrentConference()); 

/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_pages_edit.tpl");


/* On user's attempt to save changes to the page */
if (isset($_POST["edit_page"])) {
 
  /* Check if the entered URL is available */
  $err_url_assigned = !$pages->checkUrlAvailable($_POST["url"], $_GET["id"]);
  
  /* Check if the entered URL is valid */
  $err_url_invalid = !conferencesManagement::checkUrlValid($_POST["url"]);
  
  /* Check if the entered URL has the right length */
  $err_url_too_short = !conferencesManagement::checkUrlLength($_POST["url"]);
  
  /* Check if Page Title is entered */
  $err_page_title = empty($_POST["title"]);

  /* If the entered URL is OK and Page Title is entered, save changes to the database */
  if ( !$err_url_assigned &&
       !$err_url_invalid &&
       !$err_url_too_short &&
       !$err_page_title ) {

    $page_id = $pages->editPage($_GET["id"], $_POST["title"], $_POST["url"], $_POST["html"]);
    
    /* Send a success message to the user */
    $msg_success = true;
      
  }
  
} else {

  /* Get the page's data */
  $_POST = $pages->getPage($_GET['id']);

}

/* Changing the URL of Home Page is not allowed */
if ($_GET['id'] == 1) {
  $page_homepage = true;
}

$tpl->assignIf(array(
    "PAGE_NORMAL" => !$page_homepage,
    "PAGE_HOMEPAGE" => $page_homepage,
    ));
    
$tpl->parseIf();


/* Give back the data to the form */
$tpl->assignStr(array(
    "INPUT_TITLE" => $_POST["title"], 
    "INPUT_URL" => $_POST["url"],
    "INPUT_HTML" => stripslashes($_POST["html"]),
  ));


/* Detect the URL address where the Confy system is running on and add the URL of the current conference at the end */
$systemURL = substr(currentURL(), 0, strpos(currentURL(), 'admin/'));
$tpl->assignStr(array(
    "SYSTEM_URL" => $systemURL,
    "CONFERENCE_URL" => $adminAccount->getCurrentConference(),
  ));

$tpl->parseStr();

/* Parse the error/success message(s) */  
$tpl->assignIf(array(
    "ERR_URL_ASSIGNED" => $err_url_assigned,
    "ERR_URL_INVALID" => $err_url_invalid,
    "ERR_URL_TOO_SHORT" => $err_url_too_short,
    "ERR_PAGE_TITLE" => $err_page_title,
    "MSG_SUCCESS" => $msg_success,
  ));
$tpl->parseIf();


/* Output the final HTML code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>