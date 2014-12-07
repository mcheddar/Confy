<h2>Change Administrator's Password</h2>
<p>The form below will allow you to change main administrator's password for the confy system.</p>


{IF ERR_PASSWORD_INVALID}
   <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />The old password is invalid. Please, try again.</p>
{END ERR_PASSWORD_INVALID}

{IF ERR_PASSWORD_DIFFERENT}
   <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />You must re-enter the new password for confirmation.</p>
{END ERR_PASSWORD_DIFFERENT}

{IF ERR_PASSWORD_SHORT}
   <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />The new password must be at least 6 characters long.</p>
{END ERR_PASSWORD_SHORT}

{IF MSG_CHANGE_SUCCESS}
  <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />Your password has been changed successfully.</p>
{END MSG_CHANGE_SUCCESS}

<br />
<div align="center">
  <form id="password_change_form" action="" method="post">
    <table>
      <tr>
        <td class="label">
          <label for="password_old">Enter old password: </label>
        </td>
        <td>
          <input type="password" name="password_old" id="password_old" />
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="password_new">Enter new password: </label>
        </td>
        <td>
          <input type="password" name="password_new" id="password_new" />
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="password_new_2">Confirm new password: </label>
        </td>
        <td>
          <input type="password" name="password_new_2" id="password_new_2" />
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <input type="submit" name="change_password" value="Save changes" />
        </td>
      </tr>
    </table>
  </form>
</div>