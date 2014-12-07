<h2>Forgotten Password</h2>

{IF RESET_FORM}

<p>Please, enter the e-mail address associated with your user account.</p>

{IF ERR_WRONG_EMAIL}
   <p><img src="../templates/default/images/icon16_error.png" alt="Error" class="icon" />The entered e-mail address could not be found.</p>
{END ERR_WRONG_EMAIL}
<br />
<div align="center">
  <form id="reset_pass_form" action="" method="post">
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
        <td></td>
        <td>
          <input type="submit" name="reset_pass" value="Reset Password" />
        </td>
      </tr>
    </table>
  </form>
</div>

{END RESET_FORM}

{IF RESET_OK}

<p><img src="../templates/default/images/icon16_success.png" alt="Success" class="icon" /><b>Reset successful!</b> The new password has been sent to your e-mail address.</p>

{END RESET_OK}