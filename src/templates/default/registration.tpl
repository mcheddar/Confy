{IF MODE_REGISTER_H2}
<h2>Online Registration</h2>
{END MODE_REGISTER_H2}

{IF MODE_EDIT_H2}
<h2>Review Registration</h2>
{END MODE_EDIT_H2}

{IF REGISTRATION_OPEN}

<p>
  <img src="../templates/default/images/icon16_info.png" alt="Information" class="icon" />
  <b>Information: </b> deadline for Online Registration is on <b>{STR REGISTRATION_DEADLINE}</b>.
</p> 

{IF ERRORS_OCCURED}
  {LOOP ERRORS}
    <p>
      <img src="../templates/default/images/icon16_error.png" alt="Error" class="icon" />
      <b>Error: </b> field {ERRORS.CAPTION} is required.
    </p> 
  {END ERRORS}
{END ERRORS_OCCURED}

{IF ERROR_EMAIL_INVALID}
  <p>
    <img src="../templates/default/images/icon16_error.png" alt="Error" class="icon" />
    <b>Error: </b> the entered e-mail address is invalid.
  </p>
{END ERROR_EMAIL_INVALID}

{IF ERROR_EMAIL_NOT_AVAIL}
  <p>
    <img src="../templates/default/images/icon16_error.png" alt="Error" class="icon" />
    <b>Error: </b> participant with entered e-mail address is already registered.
  </p>
{END ERROR_EMAIL_NOT_AVAIL}

{IF MSG_EDIT_SUCCESS}
  <p>
    <img src="../templates/default/images/icon16_success.png" alt="Success" class="icon" />
    Your changes have been saved successfully.
  </p>
{END MSG_EDIT_SUCCESS}

<form id="registration_form" action="" method="post">
  <table>
    {LOOP FIELDS}
    <tr>
      <td valign="top">
        {FIELDS.CAPTION}
        {IF FIELD_REQUIRED_{FIELDS.ID}}
          <span style="color: red;">*</span>
        {END FIELD_REQUIRED_{FIELDS.ID}}
      </td>
      <td>
        {FIELDS.FORM}
      </td>
    </tr>
    {END FIELDS}
  </table>
  <span style="color: red;">*</span> = Required Field
  <br /><br />
  {STR REGFORM_NOTES}
  <br /><br />
  <div align="center">
    {IF MODE_REGISTER_SUBMIT}
      <input type="submit" name="submit_register" value="Register" />
    {END MODE_REGISTER_SUBMIT}
    
    {IF MODE_EDIT_SUBMIT}
      <input type="submit" name="submit_edit" value="Save Changes" />
      <input type="hidden" name="action" value="edit" />
    {END MODE_EDIT_SUBMIT}
  </div>
</form>

{END REGISTRATION_OPEN}

{IF REGISTRATION_CLOSED}
  Sorry, the online registration has been closed on {STR REGISTRATION_DEADLINE}.
{END REGISTRATION_CLOSED}