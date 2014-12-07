<?php
/*********************/
/* Menu item editing */
/*********************/

require_once("../includes/admin_init.php");
require_once("../includes/adminAccount.class.php");
require_once("../includes/pages.class.php");
require_once("../includes/menu.class.php");

/* Intitalize and output header */
initHeader("Menu Management");

/* Lets create an instance of the AdminAccount class, which handles administrator's account */
$adminAccount = new AdminAccount();

/* Let's create an instance of the Pages class, which handles conference's pages */
$pages = new Pages($adminAccount->getCurrentConference()); 

/* Let's create an instance of the Menu class, which handles conference's menu */
$menu = new Menu($adminAccount->getCurrentConference()); 

/* Initialize page's template file */
$tpl = new Template("../templates/admin/conference_menu_edit.tpl");


/* Get the item's data */
$data = $menu->getItem($_GET['id']);

/* On user's attempt to save changes to the menu item */
if (isset($_POST["edit_item"])) {
  
  /* Check if Item Caption is entered */
  $err_item_caption = empty($_POST["caption"]);

  /* If the Item Caption is entered, edit the menu item */
  if ( !$err_item_caption ) {

    /* Edit selected item */
    $menu->editItem($_GET['id'], $_POST["caption"], $_POST["link"]);
    
    /* Redirect user back to Menu Management page */
    header('Location: conference_menu.php');
      
  }
  
} else {

  $_POST['caption'] = $data['caption'];
  $_POST['link'] = $data['link'];

}


/* Give back the entered value to the form */
$tpl->assignStr("INPUT_CAPTION", $_POST["caption"]); 


/* If item has a special link, page selector is disabled and name of the linked page is displayed */
if ($data['special'] == 1) {

  $item_special = true;
  $tpl->assignStr("ITEM_SPECIAL_LINK", $menu->convertSpecialLink($data['link']));
  
} else {

  /* Create a drop down selector of all pages. First get the data. */
  $result = $pages->getAllPages();
  
  /* Then assign each page's data to the selector */
  while ($data_pages = mysqli_fetch_array($result)) {
  
    /* If the page has been already chosen, let it stay this way */
    if ($_POST['link'] == $data_pages['id']) {  
      $selected = ' selected="selected"';
    } else {
      $selected = '';
    }
    
    /* Assign data for the loop */
    $tpl->assignLoop(array(
      "PAGES_SELECT.ID" => $data_pages['id'],
      "PAGES_SELECT.TITLE" => $data_pages['title'],
      "PAGES_SELECT.SELECTED" => $selected,
    ));
  
  }
  
  /* Parse the selector */
  $tpl->parseLoop('PAGES_SELECT');

}


/* Parse the error/success message(s) */  
$tpl->assignIf(array(
    "ERR_ITEM_CAPTION" => $err_item_caption,
    "ITEM_NORMAL" => !$item_special,
    "ITEM_SPECIAL" => $item_special,
  ));
$tpl->parseIf();

/* Parse strings */
$tpl->parseStr();


/* Output the final HTML code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>