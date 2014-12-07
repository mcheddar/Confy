<?php
/*******************************/
/* Header and footer functions */
/*******************************/


/* First, we need to include the functions file and some classes */ 
require_once("functions.php");
require_once("template.class.php");
require_once('conference.class.php');
require_once('menu.class.php');
require_once('pages.class.php');
require_once('userAccount.class.php');

/* Performs all necessary actions before we process any page. Second argument is used when page is accessible only by user that is logged in */ 
function initHeader($page_title, $protected = false) {

  /* Let's create an instance of the UserAccount class, which handles all operations with User's account */
  $userAccount = new UserAccount($_GET['conf']);

  /* If the page is protected and user is not logged in, redirect to the Log in page */
  if ($protected && ($userAccount->isLogged() == false)) {

    header('Location: login.html'); 

  }

  /* Intialize the header template */
  $header = new Template("templates/default/header.tpl");
  
  /* Let's create an instance of the Conference class, which handles basic operations with current conference */
  $conference = new Conference($_GET['conf']);
  
  /* Let's create an instance of the Pages class, which handles conference's pages */
  $pages = new Pages($_GET['conf']);
  
  /* Get conference's configuration data form the database */
  $data = $conference->getConfiguration();
  
  /* Assign page title, event titles and meta tags */
  $header->assignStr(array(
    "CONFERENCE_URL" => $_GET['conf'],
    "PAGE_TITLE" => $page_title,
    "EVENT_TITLE" => $data['page_title'],
    "EVENT_FULLNAME" => $data['name'],
    "EVENT_SUBTITLE" => $data['name_subtitle'],
    "META_TITLE" => $data['meta_title'],
    "META_KEYWORDS" => $data['meta_keywords'],
    "META_REPLY_TO" => $data['meta_reply_to'],
    "META_CATEGORY" => $data['meta_category'],
    "META_RATING" => $data['meta_rating'],
    "META_ROBOTS" => $data['meta_robots'],
    "META_REVISIT_AFTER" => $data['meta_revisit_after'],
  ));
  $header->parseStr();
  
  
  /* Let's create an instance of the Menu class, which handles conference's menu */
  $menu = new Menu($_GET['conf']);
  
  /* We're gonna output the menu */
  $result = $menu->getAllItems();
  while ($data = mysqli_fetch_array($result)) {
  
    /* Is this menu item visible? */
    if ($data['hidden'] == '0') {
  
      /* Does this menu item link somewhere? */
      if ($data['link'] == '0') {
  
        $page_url = '#';
  
      } else {
  
        /* If its not a special page, we need to get the URL from the pages table in DB */
        if ($data['special'] == '0') {
        
          /* We need to load some information about the page this item links to */
          $page_data = $pages->getPage($data['link']);
          $page_url = '../' . $_GET['conf'] . '/' . $page_data['url'] . '.html';
          
        } else {
        
          /* If menu links to special page, the URL is already in link variable */
          $page_url = '../' . $_GET['conf'] . '/' . $data['link'] . '.html';
          
        }
  
      }
    
      /* Assign data for the loop */
      $header->assignLoop(array(
        "MENU.ID" => $data['id'],
        "MENU.CAPTION" => $data['caption'],
        "MENU.URL" => $page_url,
      ));
      
      /* We need to find out what type of item is next in the order in the menu, but only if it's visible item */
      $data_next = $menu->getNextVisible($data['id']);
      
      if ($data['subitem'] == 0 && $data_next['subitem'] == 0) {
        $next['main_to_main'] = true;
      }
      
      if ($data['subitem'] == 0 && $data_next['subitem'] == 1) {
        $next['main_to_sub'] = true;
      }
      
      if ($data['subitem'] == 1 && $data_next['subitem'] == 0) {
        $next['sub_to_main'] = true;
      }
      
      if ($data['subitem'] == 1 && $data_next['subitem'] == 1) {
        $next['sub_to_sub'] = true;
      }
      
      /* Lets assign all these ifs */
      $header->assignIf(array(
        "MAIN_TO_MAIN_". $data['id'] => $next['main_to_main'],
        "MAIN_TO_SUB_". $data['id'] => $next['main_to_sub'],
        "SUB_TO_MAIN_". $data['id'] => $next['sub_to_main'],
        "SUB_TO_SUB_". $data['id'] => $next['sub_to_sub'],
      ));
      
      unset($next);
    
    }
  
  }
  
  /* Parse the menu */
  $header->parseLoop('MENU');
  $header->parseIf();
  
  
  /* Parse the User Account Item in the menu */
  if ($userAccount->isLogged()) {
    $user_logged = true;
  }
  
  $header->assignIf(array(
        "USER_LOGGED" => $user_logged,
        "USER_NOTLOGGED" => !$user_logged,
      ));
  $header->parseIf();
  
   
  /* Output header */
  $header->output();

}



/* Performs all necessary actions after we process any page */
function initFooter() {

  /* Let's create an instance of the Conference class, which handles basic operations with current conference */
  $conference = new Conference($_GET['conf']);
  
  /* Get conference's configuration data form the database */
  $data = $conference->getConfiguration();

  /* Initialize, assign, parse and output the footer */
  $footer = new Template("templates/default/footer.tpl");
  
  $footer->assignStr("PAGE_FOOTER", $data['page_footer']);
  $footer->parseStr();
  
  $footer->output();

}


?>