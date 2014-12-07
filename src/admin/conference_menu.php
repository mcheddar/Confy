<?php
/*******************/
/* Menu management */
/*******************/

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
$tpl = new Template("../templates/admin/conference_menu.tpl");


/* On user's attempt to add a new menu item */
if (isset($_POST["new_item"])) {
  
  /* Check if Item Caption is entered */
  $err_item_caption = empty($_POST["caption"]);

  /* If the Item Caption is entered, add the menu item */
  if ( !$err_item_caption ) {

    /* Add item to the database */
    $menu->addItem($_POST["caption"], $_POST["link"], $_POST["type"], $_POST["after"]);
    
    /* Show user a success message */
    $msg_add_success = true;
      
  }
  
}

/* On user's attempt to delete a menu item */
if (isset($_POST["delete_item"])) {

  /* Delete that item */
  $menu->deleteItem($_POST["delete_item"]);
  
  /* Show user a success message */
  $msg_delete_success = true;
  
}


/* On user's attempt to hide an item */
if (($_GET['action'] == 'hide') && isset($_GET['id'])) {

  /* Hide that item */
  $menu->hideItem($_GET['id']);
  
  /* Show user a success message */
  $msg_hide_success = true;

}


/* On user's attempt to unhide an item */
if (($_GET['action'] == 'unhide') && isset($_GET['id'])) {

  /* Hide that item */
  $menu->unhideItem($_GET['id']);
  
  /* Show user a success message */
  $msg_unhide_success = true;

}

/* On user's attempt to move an item */
if (isset($_POST["move_field"])) {

  if ($_POST['direction'] == 'up') {
    $menu->moveUp($_POST["move_field"]);
  }
  
  if ($_POST['direction'] == 'down') {
    $menu->moveDown($_POST["move_field"]);
  }
  
  if ($_POST['direction'] == 'left') {
    $menu->setAsMain($_POST["move_field"]);
  }
  
  if ($_POST['direction'] == 'right') {
    $menu->setAsSub($_POST["move_field"]);
  }

}


/* Lets assign each items's data to the template file */
$result = $menu->getAllItems();
$i = 1;
while ($data = mysqli_fetch_array($result)) {

  /* If even iteration, we need to display different style of table */
  if ($i % 2 == 0) {
    $even = ' class="even"';
  } else {
    $even = '';
  }
  
  /* There are 4 special items: home page, registration form, list of registered participants and list of submitted papers. */
  if ($data['special'] == 1) {
  
    /* These items are blocked from deleting. */
    $delete_disabled = true;
  
    /* URL is already in our loaded data */
    $page_url = $data['link'];
    
    /* We need to convert the title to nicer form */
    $page_title = $menu->convertSpecialLink($data['link']);
    
    $has_link = true;
  
  /* Normal items are just pages created by user */
  } else {
  
    /* These items are free to delete. */
    $delete_disabled = false;
    
    /* Does this menu item link somewhere? */
    if ($data['link'] > 0) {

      /* We need to load some information about the page this item links to */
      $page_data = $pages->getPage($data['link']);
      $page_url = $page_data['url'];
      $page_title = $page_data['title'];
      
      $has_link = true;
      
    } else {
    
      $has_link = false;

    }
  
  }

  /* Assign data for the loop */
  $tpl->assignLoop(array(
    "ITEMS.ID" => $data['id'],
    "ITEMS.CAPTION" => $data['caption'],
    "ITEMS.LINK_URL" => $page_url,
    "ITEMS.LINK_TITLE" => $page_title,
    "ITEMS.EVEN" => $even,
  ));
  
  /* Check out if the item is visible or hidden */
  if ($data['hidden'] == 1) {
    $item_hidden = true;
    $item_visible = false;
  } else {
    $item_hidden = false;
    $item_visible = true;
  }
  
  /* Is this item a Main Item or Subitem? */
  if ($data['subitem'] == 0) {
    $is_subitem = false;
  } else {
    $is_subitem = true;
  }
  
  /* Is this item the first one in the menu order? */
  $item_first = $menu->isFirst($data['id']);

  /* Is this item the last one in the menu order? */
  $item_last = $menu->isLast($data['id']);
  
  /* Lets assign all these ifs */
  $tpl->assignIf(array(
    "DELETE_DISABLED_". $data['id'] => $delete_disabled,
    "DELETE_ENABLED_". $data['id'] => !$delete_disabled,
    "ARROW_UP_DISABLED_". $data['id'] => $item_first,
    "ARROW_UP_ENABLED_". $data['id'] => !$item_first,
    "ARROW_DOWN_DISABLED_". $data['id'] => $item_last,
    "ARROW_DOWN_ENABLED_". $data['id'] => !$item_last,
    "ARROW_LEFT_DISABLED_". $data['id'] => !$is_subitem,
    "ARROW_LEFT_ENABLED_". $data['id'] => $is_subitem,
    "ARROW_RIGHT_DISABLED_". $data['id'] => $is_subitem,
    "ARROW_RIGHT_ENABLED_". $data['id'] => !$is_subitem,
    "ITEM_HIDDEN_". $data['id'] => $item_hidden,
    "ITEM_VISIBLE_". $data['id'] => $item_visible,
    "IS_SUBITEM_". $data['id'] => $is_subitem,
    "IS_MAINITEM_B_". $data['id'] => !$is_subitem,
    "IS_MAINITEM_ENDB_". $data['id'] => !$is_subitem,
    "LINK_YES_". $data['id'] => $has_link,
    "LINK_NO_". $data['id'] => !$has_link,
  ));
  
  /* If item is the first in the list, we need to disable the right button */
  if ($item_first) {
    $tpl->assignIf(array(
      "ARROW_RIGHT_DISABLED_". $data['id'] => true,
      "ARROW_RIGHT_ENABLED_". $data['id'] => false,
    )); 
  }
  
  $i++;

}

$tpl->parseLoop('ITEMS');
$tpl->parseIf();


/* Give back the entered value to the form */
$tpl->assignStr("INPUT_CAPTION", $_POST["caption"]); 


/* Create a drop down selector of all pages. First get the data. */
$result = $pages->getAllPages();

/* Then assign each page's data to the selector */
while ($data = mysqli_fetch_array($result)) {

  /* If the page has been already chosen, let it stay this way */
  if ($_POST['link'] == $data['id']) {  
    $selected = ' selected="selected"';
  } else {
    $selected = '';
  }
  
  /* Assign data for the loop */
  $tpl->assignLoop(array(
    "PAGES_SELECT.ID" => $data['id'],
    "PAGES_SELECT.TITLE" => $data['title'],
    "PAGES_SELECT.SELECTED" => $selected,
  ));

}

/* Parse the selector */
$tpl->parseLoop('PAGES_SELECT');


/* If Type of the item has been already selected, let it stay that way */
if ($_POST['type'] == 1) {
  $type_main_checked = '';
  $type_sub_checked = ' checked="checked"';
} else {
  $type_main_checked = ' checked="checked"';
  $type_sub_checked = '';
}

/* Assign these checked values to the template file */
$tpl->assignStr(array(
    "TYPE_MAIN_CHECKED" => $type_main_checked,
    "TYPE_SUB_CHECKED" => $type_sub_checked,
  ));
  
$tpl->parseStr();


/* Create a drop down selector of all menu items */
$result = $menu->getAllItems();
while ($data = mysqli_fetch_array($result)) {

  /* Is this item a Main Item or Subitem? */
  if ($data['subitem'] == 0) {
    $subitem = '';
  } else {
    $subitem = '&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  
  /* Has this item been already selected? */
  if ($_POST['after'] == $data['id']) {
    $selected = ' selected="selected"';
  } else {
    $selected = '';
  }
  
  /* Assign data for the loop */
  $tpl->assignLoop(array(
    "ITEMS_SELECT.ID" => $data['id'],
    "ITEMS_SELECT.CAPTION" => $data['caption'],
    "ITEMS_SELECT.SUBITEM" => $subitem,
    "ITEMS_SELECT.SELECTED" => $selected,
  ));

}

/* Parse the selector */
$tpl->parseLoop('ITEMS_SELECT');


/* Detect the actual URL address of currently selected conference */
$tpl->assignStr("CONFERENCE_URL", $adminAccount->getConferenceURL());
$tpl->parseStr();


/* Parse the error/success message(s) */  
$tpl->assignIf(array(
    "ERR_ITEM_CAPTION" => $err_item_caption,
    "MSG_ADD_SUCCESS" => $msg_add_success,
    "MSG_DELETE_SUCCESS" => $msg_delete_success,
    "MSG_HIDE_SUCCESS" => $msg_hide_success,
    "MSG_UNHIDE_SUCCESS" => $msg_unhide_success,
  ));
$tpl->parseIf();


/* Output the final HTML code */
$tpl->output();


/* Intitalize and output footer */
initFooter();

?>