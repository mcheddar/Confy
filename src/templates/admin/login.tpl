<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>Log in - confy Administration</title>
  <link href="../templates/admin/style_login.css" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="../templates/admin/images/favicon.ico" />
  </head>
  <body>
    <div align="center">
      <div id="main">
        <div id="main-inner">
          <form action="" method="POST">
            <table>
              <tr>
                <th>Enter password</th>   
              </tr>
              <tr>
                <td>
                  <div class="error">
                    {IF ERR_INVALID_PASSWORD}
                      <img src="../templates/admin/images/icon16_error.png" alt="Error" />Invalid password. Please, try again.
                    {END ERR_INVALID_PASSWORD}
                  </div>
                  <div class="login">
                    <input type="password" name="password" style="font-size: 130%; width: 180px;" />
                    <input type="submit" name="login" value="Log in" style="font-size: 130%" />
                  </div>
                </td>   
              </tr>
            </table>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>