{IF MSG_SUCCESS}
  <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />Your changes have been saved successfully.</p>
{END MSG_SUCCESS}

{IF ERR_PAGE_TITLE}
    <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />You must enter Page Title.</p>
{END ERR_PAGE_TITLE}

{IF ERR_DATE_FORMAT}
    <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />Wrong date format. Please, use format <b>DD-MM-YYYY HH:MM (24-hour format)</b>.</p>
{END ERR_DATE_FORMAT}

<form id="conference_configuration_form" action="" method="POST">
  
  <h2>General configuration</h2>
  <p>The form below will allow you to customize all the general conference options.</p>
  <br>
  <table>
    <tr>
      <td class="label"><label for="page_title">Page Title:</label></td>
      <td><input type="text" name="page_title" id="page_title" maxlength="30" size="30" value="{STR INPUT_PAGE_TITLE}" /></td>
    </tr>
    <tr>
      <td class="label"><label for="name">Full Name of the Event:</label></td>
      <td><input type="text" name="name" id="name" size="70" value="{STR INPUT_NAME}" /></td>
    </tr>
    <tr>
      <td class="label"><label for="name_subtitle">Subtitle of the Event:</label></td>
      <td><input type="text" name="name_subtitle" id="name_subtitle" size="70" value="{STR INPUT_NAME_SUBTITLE}" /></td>
    </tr>
  </table>
  <br />
  <hr />
  
  
  <h2>&lt;meta&gt; tags</h2>
  <p>Metadata is data (information) about data.<br>
  The <meta> tag provides metadata about the HTML document. Metadata will not be displayed on the page, but will be machine parsable.</p>
  <br>
  
  <table>
    <tr>
      <td class="label"><label for="meta_title">Title:</label></td>
      <td><input type="text" name="meta_title" id="meta_title" size="50" value="{STR INPUT_META_TITLE}" /></td>
    </tr>
    <tr>
      <td class="label"><label for="meta_keywords">Keywords:</label></td>
      <td><input type="text" name="meta_keywords" id="meta_keywords" size="50" value="{STR INPUT_META_KEYWORDS}" /></td>
    </tr>
    <tr>
      <td class="label"><label for="meta_reply_to">Reply To:</label></td>
      <td><input type="text" name="meta_reply_to" id="meta_reply_to" size="50" value="{STR INPUT_META_REPLY_TO}" /></td>
    </tr>
    <tr>
      <td class="label"><label for="meta_category">Category:</label></td>
      <td><input type="text" name="meta_category" id="meta_category" size="50" value="{STR INPUT_META_CATEGORY}" /></td>
    </tr>
    <tr>
      <td class="label"><label for="meta_rating">Rating:</label></td>
      <td><input type="text" name="meta_rating" id="meta_rating" size="50" value="{STR INPUT_META_RATING}" /></td>
    </tr>
    <tr>
      <td class="label"><label for="meta_robots">Robots:</label></td>
      <td><input type="text" name="meta_robots" id="meta_robots" size="50" value="{STR INPUT_META_ROBOTS}" /></td>
    </tr>
    <tr>
      <td class="label"><label for="meta_revisit_after">Revisit After:</label></td>
      <td><input type="text" name="meta_revisit_after" id="meta_revisit_after" size="50" value="{STR INPUT_META_REVISIT_AFTER}" /></td>
    </tr>
  </table>
  <br />
  <hr />
  
  
  <h2>Deadlines</h2>
  <p>Set the deadlines for the online registration and paper submission below. Date format is <b>DD-MM-YYYY HH:MM (24-hour format)</b>.</p>
  <br>
  
  <table>
    <tr>
      <td class="label"><label for="deadline_registration_day">Online Registration:</label></td>
      <td>
        <input type="text" name="deadline_registration_day" id="deadline_registration_day" size="2" maxlength="2" style="width:2em" value="{STR INPUT_DEADLINE_REGISTRATION_DAY}" /> -
        <input type="text" name="deadline_registration_month" id="deadline_registration_month" size="2" maxlength="2" style="width:2em" value="{STR INPUT_DEADLINE_REGISTRATION_MONTH}" /> -
        <input type="text" name="deadline_registration_year" id="deadline_registration_year" size="4" maxlength="4" style="width:3em" value="{STR INPUT_DEADLINE_REGISTRATION_YEAR}" />
        &nbsp;&nbsp;&nbsp;
        <input type="text" name="deadline_registration_hour" id="deadline_registration_hour" size="2" maxlength="2" style="width:2em" value="{STR INPUT_DEADLINE_REGISTRATION_HOUR}" /> :
        <input type="text" name="deadline_registration_min" id="deadline_registration_min" size="2" maxlength="2" style="width:2em" value="{STR INPUT_DEADLINE_REGISTRATION_MIN}" />
      </td>
    </tr>
    <tr>
      <td class="label"><label for="deadline_submission_day">Paper Submission:</label></td>
      <td>
        <input type="text" name="deadline_submission_day" id="deadline_submission_day" size="2" maxlength="2" style="width:2em" value="{STR INPUT_DEADLINE_SUBMISSION_DAY}" /> -
        <input type="text" name="deadline_submission_month" id="deadline_submission_month" size="2" maxlength="2" style="width:2em" value="{STR INPUT_DEADLINE_SUBMISSION_MONTH}" /> -
        <input type="text" name="deadline_submission_year" id="deadline_submission_year" size="4" maxlength="4" style="width:3em" value="{STR INPUT_DEADLINE_SUBMISSION_YEAR}" />
        &nbsp;&nbsp;&nbsp;
        <input type="text" name="deadline_submission_hour" id="deadline_submission_hour" size="2" maxlength="2" style="width:2em" value="{STR INPUT_DEADLINE_SUBMISSION_HOUR}" /> :
        <input type="text" name="deadline_submission_min" id="deadline_submission_min" size="2" maxlength="2" style="width:2em" value="{STR INPUT_DEADLINE_SUBMISSION_MIN}" />
      </td>
    </tr>
  </table>
  <br />
  <hr />
  
  
  <h2>Page Footer</h2>
  <p>Define footer of the page in the form below.</p>
  <textarea name="page_footer" rows="5" cols="80">{STR INPUT_PAGE_FOOTER}</textarea>
  <br /><br />
  <hr />
  
  
  <h2>Conference's E-mail Address</h2>
  <p>Following e-mail address will be shown as a sender of all automatically generated e-mails for the participants.</p>
  <table>
    <tr>
      <td class="label"><label for="conference_email">E-mail Address:</label></td>
      <td><input type="text" name="conference_email" id="conference_email" size="50" value="{STR INPUT_CONFERENCE_EMAIL}" /></td>
    </tr>
  </table>
  <br><br>
  
  
  <div align="center">
    <input type="submit" name="change_configuration" value="Confirm all changes" />
  </div>

</form>