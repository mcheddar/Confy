<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>confy - Home Page</title>
  <link href="templates/admin/style_homepage.css" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="templates/admin/images/favicon.ico" />
  </head>
  <body>
    <div align="center">
      <div id="main">
        <div class="admin"><a href="admin">Administration</a></div>
        <div id="main-inner">
          {IF CONFERENCES_FOUND}
            {LOOP CONFERENCES}
              <a href="{CONFERENCES.URL}" class="button">{CONFERENCES.NAME}</a><br />
            {END CONFERENCES}
          {END CONFERENCES_FOUND}
          
          {IF CONFERENCES_NOT_FOUND}
            <p>No conferences found.</p> 
          {END CONFERENCES_NOT_FOUND}
        </div>
      </div>
    </div>
  </body>
</html>