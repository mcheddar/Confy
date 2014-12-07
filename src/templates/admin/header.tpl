<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>{STR PAGE_TITLE} - confy Administration</title>
  
  <link href="../templates/admin/style.css" rel="stylesheet" type="text/css" />
  <link href="../templates/flags/flags.css" rel="stylesheet" type="text/css" />
  <link href="../includes/cleditor/jquery.cleditor.css" rel="stylesheet" type="text/css" />
  
  <link rel="shortcut icon" href="../templates/admin/images/favicon.ico" />
  
  <script type="text/javascript" src="../includes/js/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="../includes/js/jquery.alerts.js"></script>

  <script type="text/javascript" src="../includes/tiny_mce/tiny_mce.js"></script>

  <script type="text/javascript">
    tinyMCE.init({
        mode : "exact",
        elements : "input",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr",
        theme_advanced_buttons4 : "cite,abbr,acronym,|,visualchars,nonbreaking",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",

        // Example content CSS (should be your site CSS)
        content_css : "../templates/default/style.css",
    });
  </script>
    
  <script type="text/javascript">
    $(function() {
        $(window).bind("resize", function() {
            $('#bcg-left').toggle($(this).width() >= 1024); 
            $('#bcg-right').toggle($(this).width() >= 1024);
            $('#content').height($('#main').height());
            $('#menu').height($('#main').height());
            $('#bcg-left').height($('#main').height());
            $('#bcg-right').height($('#main').height()); 
        }).trigger("resize");
    });
  </script>
  
  </head>
  <body>
      <div id="bcg-right"></div>
      <div id="bcg-left"></div>
      <div id="main">
        <div id="menu">
          <div id="menu-upper-line"></div>
          <a href="index.php"><img src="../templates/admin/images/logo.jpg" width="220" height="151" alt="" border="0" /></a>
          <div id="menu-select-conf">
            <form action="" method="POST">
              <select name="conference_select" style="width: 180px;" onchange="this.form.submit()">
                {IF CONFERENCES_FOUND}
                  <option disabled="disabled" selected="selected">select conference...</option>
                  {LOOP CONFERENCES_LIST}
                    <option value="{CONFERENCES_LIST.URL}"{CONFERENCES_LIST.SELECTED}>{CONFERENCES_LIST.TITLE}</option>
                  {END CONFERENCES_LIST}
                {END CONFERENCES_FOUND}
                
                {IF CONFERENCES_NOT_FOUND}
                  <option disabled="disabled">No conferences found.</option>
                {END CONFERENCES_NOT_FOUND}
              </select>
            </form>
          </div>
          <ul>
            <li class="nadpis">Administration</li>
            <li><a href="index.php">Home</a></li>
            <li><a href="conference_new.php">New Conference</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="logout.php">Log out</a></li>
            {IF CONFERENCE_SELECTED}
              <li class="nadpis">{STR CONFERENCE_TITLE}</li>
              <li><a href="conference_dashboard.php">Dashboard</a></li>
              <li><a href="conference_configuration.php">Configuration</a></li>
              <li><a href="conference_appearance.php">Appearance</a></li>
              <li><a href="conference_messages.php">Messages & E-mails</a></li>
              <li><a href="conference_menu.php">Menu Management</a></li>
              <li><a href="conference_pages.php">Pages Management</a></li>
              <li><a href="conference_regform.php">Registration Form</a></li>
              <li><a href="conference_subform.php">Submission Form</a></li>
              <li><a href="conference_participants.php">Participants</a></li>
              <li><a href="conference_contributions.php">Contributions</a></li>
              <li><a href="conference_mail.php">Mass Message</a></li>
            {END CONFERENCE_SELECTED}
          </ul>
        </div>
        <div id="content">
          <div id="content-upper-line"></div>
          <div id="content-text">
            <h1>{STR PAGE_TITLE}</h1>