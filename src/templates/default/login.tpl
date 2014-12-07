<h2>Log In</h2>

<p>Don't have an account yet? <a href="registration-form.html">Register Online</a>.</p>

{IF ERR_INVALID_PASSWORD}
   <p><img src="../templates/default/images/icon16_error.png" alt="Error" class="icon" />Wrong E-mail and Password combination. Please, try again.</p>
{END ERR_INVALID_PASSWORD}
<br />
<div align="center">
  <form id="login_form" action="" method="post">
    <table>
      <tr>
        <td>
          <label for="email">E-mail Address: </label>
        </td>
        <td>
          <input type="text" name="email" id="email" value="{STR INPUT_EMAIL}" />
        </td>
      </tr>
      <tr>
        <td>
          <label for="password">Password: </label>
        </td>
        <td>
          <input type="password" name="password" id="password" />
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <span style="font-size: 80%"><a href="forgotten-password.html">Forgotten password?</a></span><br />
          <input type="submit" name="login" value="Log in" />
        </td>
      </tr>
    </table>
  </form>
</div>