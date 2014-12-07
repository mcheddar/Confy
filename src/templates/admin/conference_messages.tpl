{IF MSG_SUCCESS}
  <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />Your changes have been saved successfully.</p>
{END MSG_SUCCESS}

<form id="conference_messages_form" action="" method="POST">
  
  <h2>Message: Successful Registration</h2>
  <p>Fill in the text of message shown to participant after successful registration.</p>
  <br>
  <table>
    <tr>
      <td class="label" valign="top"><label for="msg_new_registration">Text:</label></td>
      <td><textarea name="msg_new_registration" id="msg_new_registration" rows="15" cols="70">{STR MSG_NEW_REGISTRATION}</textarea></td>
    </tr>
  </table>
  <br />
  <hr />
  
  
  <h2>E-mail: Successful Registration</h2>
  <p>Fill in the subject and text of e-mail that is sent to participant after successful registration.</p>
  <br>
  
  <table>
    <tr>
      <td class="label"><label for="email_new_registration_subject">Subject:</label></td>
      <td><input type="text" name="email_new_registration_subject" id="email_new_registration_subject" size="80" value="{STR EMAIL_NEW_REGISTRATION_SUBJECT}" /></td>
    </tr>
    <tr>
      <td class="label" valign="top"><label for="email_new_registration_text">Text:</label></td>
      <td><textarea name="email_new_registration_text" id="email_new_registration_text" rows="15" cols="70">{STR EMAIL_NEW_REGISTRATION_TEXT}</textarea></td>
    </tr>
  </table>
  <br />
  <hr />
  
  
  <h2>E-mail: Change of Registration</h2>
  <p>Fill in the subject and text of e-mail that is sent to participant when the registration is changes.</p>
  <br>
  
  <table>
    <tr>
      <td class="label"><label for="email_change_registration_subject">Subject:</label></td>
      <td><input type="text" name="email_change_registration_subject" id="email_change_registration_subject" size="80" value="{STR EMAIL_CHANGE_REGISTRATION_SUBJECT}" /></td>
    </tr>
    <tr>
      <td class="label" valign="top"><label for="email_change_registration_text">Text:</label></td>
      <td><textarea name="email_change_registration_text" id="email_change_registration_text" rows="15" cols="70">{STR EMAIL_CHANGE_REGISTRATION_TEXT}</textarea></td>
    </tr>
  </table>
  <br />
  <hr />
  
  
  <h2>E-mail: Reset Password</h2>
  <p>Fill in the subject and text of e-mail that is sent to participant when the password is reset.</p>
  <br>
  
  <table>
    <tr>
      <td class="label"><label for="email_new_password_subject">Subject:</label></td>
      <td><input type="text" name="email_new_password_subject" id="email_new_password_subject" size="80" value="{STR EMAIL_NEW_PASSWORD_SUBJECT}" /></td>
    </tr>
    <tr>
      <td class="label" valign="top"><label for="email_new_password_text">Text:</label></td>
      <td><textarea name="email_new_password_text" id="email_new_password_text" rows="15" cols="70">{STR EMAIL_NEW_PASSWORD_TEXT}</textarea></td>
    </tr>
  </table>
  <br />
  <hr />
  
  <h2>E-mail: New Contribution</h2>
  <p>Fill in the subject and text of e-mail that is sent to participant when a new contribution is submitted.</p>
  <br>
  
  <table>
    <tr>
      <td class="label"><label for="email_new_contribution_subject">Subject:</label></td>
      <td><input type="text" name="email_new_contribution_subject" id="email_new_contribution_subject" size="80" value="{STR EMAIL_NEW_CONTRIBUTION_SUBJECT}" /></td>
    </tr>
    <tr>
      <td class="label" valign="top"><label for="email_new_contribution_text">Text:</label></td>
      <td><textarea name="email_new_contribution_text" id="email_new_contribution_text" rows="15" cols="70">{STR EMAIL_NEW_CONTRIBUTION_TEXT}</textarea></td>
    </tr>
  </table>
  <br />
  <hr />
  
  <h2>E-mail: Contribution Deleted</h2>
  <p>Fill in the subject and text of e-mail that is sent to participant when a contribution is deleted.</p>
  <br>
  
  <table>
    <tr>
      <td class="label"><label for="email_delete_contribution_subject">Subject:</label></td>
      <td><input type="text" name="email_delete_contribution_subject" id="email_delete_contribution_subject" size="80" value="{STR EMAIL_DELETE_CONTRIBUTION_SUBJECT}" /></td>
    </tr>
    <tr>
      <td class="label" valign="top"><label for="email_delete_contribution_text">Text:</label></td>
      <td><textarea name="email_delete_contribution_text" id="email_delete_contribution_text" rows="15" cols="70">{STR EMAIL_DELETE_CONTRIBUTION_TEXT}</textarea></td>
    </tr>
  </table>
  <br /><br />
  
  
  
  <div align="center">
    <input type="submit" name="change_messages" value="Confirm all changes" />
  </div>

</form>