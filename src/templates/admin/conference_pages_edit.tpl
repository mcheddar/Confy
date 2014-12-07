<h2>Edit Page</h2>
<p>Here you can fill the page with an optional content.</p>

{IF MSG_SUCCESS}
  <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />Your changes have been saved successfully.</p>
{END MSG_SUCCESS}

{IF ERR_PAGE_TITLE}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />You must enter Page Title.</p>
{END ERR_PAGE_TITLE}

{IF ERR_URL_ASSIGNED}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />The entered URL address is already taken. Please, enter another URL address.</p>
{END ERR_URL_ASSIGNED}

{IF ERR_URL_TOO_SHORT}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />The entered URL address is invalid. URL address must be from 1 to 30 characters long.</p>
{END ERR_URL_TOO_SHORT}

{IF ERR_URL_INVALID}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />The entered URL address is invalid. The only allowed characters are a-z, A-Z, 0-9, -.</p>
{END ERR_URL_INVALID}


<form id="edit_page_form" action="" method="POST">
  <table>
    <tr>
      <td class="label"><label for="title">Page Title:</label></td>
      <td><input type="text" name="title" id="title" size="40" value="{STR INPUT_TITLE}" /></td>
    </tr>
    <tr>
      <td class="label"><label for="url">URL address:</label></td>
      <td>
        {IF PAGE_NORMAL}
          {STR SYSTEM_URL}{STR CONFERENCE_URL}/<input type="text" name="url" id="url" maxlength="30" size="30" value="{STR INPUT_URL}" />.html
        {END PAGE_NORMAL}
        
        {IF PAGE_HOMEPAGE}
          {STR SYSTEM_URL}{STR CONFERENCE_URL}/{STR INPUT_URL}.html
          <input type="hidden" name="url" id="url" value="{STR INPUT_URL}" />
        {END PAGE_HOMEPAGE}
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <br /><br />
        <textarea name="html" id="input" rows="30" cols="80">{STR INPUT_HTML}</textarea>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="submit" name="edit_page" value="Save Changes" />
      </td>
    </tr>
  </table>
</form>