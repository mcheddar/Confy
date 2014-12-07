<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>{STR PAGE_TITLE} - {STR EVENT_TITLE}</title>
    <link href="../templates/default/style.php?conf={STR CONFERENCE_URL}" rel="stylesheet" type="text/css" />
    <link href="../templates/flags/flags.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="../conferences/{STR CONFERENCE_URL}/images/favicon.ico" />
    <meta name="title" content="{STR META_TITLE}" />
  	<meta name="keywords" content="{STR META_KEYWORDS}" />
  	<meta name="reply-to" content="{STR META_REPLY_TO}" />
  	<meta name="category" content="{STR META_CATEGORY}" />
  	<meta name="rating" content="{STR META_RATING}" />
  	<meta name="robots" content="{STR META_ROBOTS}" />
  	<meta name="revisit-after" content="{STR META_REVISIT_AFTER}" />
    <script type="text/javascript" src="../includes/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="../includes/js/jquery.alerts.js"></script>
  </head>
  <body>
    <div align="center">
      <div id="main">
        <div id="banner">
          <img src="../conferences/{STR CONFERENCE_URL}/images/panorama.jpg" width="768" alt="" border="0" />
        </div>
        <table id="header">
          <tr>
            <td valign="middle" width="250">
              <a href="home.html"><img src="../conferences/{STR CONFERENCE_URL}/images/logo.jpg" width="215" alt="{STR EVENT_TITLE}" title="{STR EVENT_TITLE}" border="0" /></a>
            </td>
            <td valign="middle">
              <h1>{STR EVENT_FULLNAME}</h1>
              <div class="subtitle">{STR EVENT_SUBTITLE}</div>
            </td>
          </tr>
        </table>
        <div id="lines"></div>
        <div class="menu" align="center">
      		<ul>
            {LOOP MENU}
              <li><a href="{MENU.URL}">{MENU.CAPTION}</a>
              
              {IF MAIN_TO_MAIN_{MENU.ID}}
                </li>
              {END MAIN_TO_MAIN_{MENU.ID}}
              
              {IF MAIN_TO_SUB_{MENU.ID}}
                <ul>
              {END MAIN_TO_SUB_{MENU.ID}}
              
              {IF SUB_TO_MAIN_{MENU.ID}}
                </li></ul></li>
              {END SUB_TO_MAIN_{MENU.ID}}
                
              {IF SUB_TO_SUB_{MENU.ID}}
                </li>
              {END SUB_TO_SUB_{MENU.ID}}
            {END MENU}
            
            {IF USER_LOGGED}
              <li><a href="#">User Account</a>
                <ul>
                  <li><a href="paper-submission.html">Paper Submission</a></li>
                  <li><a href="registration-edit.html">Review Registration</a></li>
                  <li><a href="change-password.html">Change Password</a></li>
                  <li><a href="log-out.html">Log out</a></li>
                </ul>
              </li>
            {END USER_LOGGED}
            
            {IF USER_NOTLOGGED}
              <li><a href="login.html">Log in</a></li>
            {END USER_NOTLOGGED}
      		</ul>
      	</div>
        <div id="content">