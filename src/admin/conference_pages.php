<?php
/********************/
/* Pages management */
/********************/

require_once("../includes/admin_init.php");
require_once("../includes/adminAccount.class.php");
require_once("../includes/pages.class.php");
require_once("../includes/conferencesManagement.class.php");

/* Intitalize and output header */
initHeader("Pages Management");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Let's create an instance of the Pages class, which handles pages with optional content */
$pages = new Pages($adminAccount->getCurrentConference()); 

/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_pages.tpl");


/* On user's attempt to create a new page */
if (isset($_POST["new_page"])) {
 
  /* Check if the entered URL is available */
  $err_url_assigned = !$pages->checkUrlAvailable($_POST["url"]);
  
  /* Check if the entered URL is valid */
  $err_url_invalid = !conferencesManagement::checkUrlValid($_POST["url"]);
  
  /* Check if the entered URL has the right length */
  $err_url_too_short = !conferencesManagement::checkUrlLength($_POST["url"]);
  
  /* Check if Page Title is entered */
  $err_page_title = empty($_POST["title"]);

  /* If the entered URL is OK and Page Title is entered, create a new page */
  if ( !$err_url_assigned &&
       !$err_url_invalid &&
       !$err_url_too_short &&
       !$err_page_title ) {

    $page_id = $pages->addPage($_POST["title"], $_POST["url"]);
    
    header('Location: conference_pages_edit.php?id=' . $page_id);
      
  }
  
}

/* On user's attempt to delete a page */
if (isset($_POST["delete_page"])) {

  /* Delete that page */
  $pages->deletePage($_POST["delete_page"]);
  
  /* Send a success message to the user */
  $msg_delete_success = true;
  
}


/* Lets assign each page's data to the template file */
$result = $pages->getAllPages();
$i = 1;
while ($data = mysqli_fetch_array($result)) {

  /* If even iteration, we need to display different style of table */
  if ($i % 2 == 0) {
    $even = ' class="even"';
  } else {
    $even = '';
  }

  /* Assign data for the loop */
  $tpl->assignLoop(array(
    "PAGES.ID" => $data['id'],
    "PAGES.TITLE" => $data['title'],
    "PAGES.URL" => $data['url'],
    "PAGES.EVEN" => $even,
  ));
  
  /* If current page is Home Page, disable delete button */
  if ($data['id'] == 1) {
    $delete_disabled = true;
  } else {
    $delete_disabled = false;
  }
  
  $tpl->assignIf(array(
    "DELETE_DISABLED_" . $data['id'] => $delete_disabled, 
    "DELETE_ENABLED_" . $data['id'] => !$delete_disabled,
  ));
  
  $i++;

}

$tpl->parseLoop('PAGES');
$tpl->parseIf();


/* Give back the entered values to the form */
$tpl->assignStr(array(
    "INPUT_TITLE" => $_POST["title"], 
    "INPUT_URL" => $_POST["url"],
  ));


/* Detect the actual URL address of currently selected conference */
$tpl->assignStr(array(
    "CONFERENCE_URL_FULL" => $adminAccount->getConferenceURL(),
    "CONFERENCE_URL" => $adminAccount->getCurrentConference(),
  ));

$tpl->parseStr();

/* Parse the error/success message(s) */  
$tpl->assignIf(array(
    "ERR_URL_ASSIGNED" => $err_url_assigned,
    "ERR_URL_INVALID" => $err_url_invalid,
    "ERR_URL_TOO_SHORT" => $err_url_too_short,
    "ERR_PAGE_TITLE" => $err_page_title,
    "MSG_DELETE_SUCCESS" => $msg_delete_success,
  ));
$tpl->parseIf();


/* Output the final HTML code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>