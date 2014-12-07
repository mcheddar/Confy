<script>
   function testRadio(){
    document.getElementById("recipients_list").disabled = !(document.getElementById("recipients-other").checked)
    document.getElementById("recipients_list").enabled = (document.getElementById("recipients-all").checked)
   }
   
   window.onload=testRadio
</script>


  
<h2>Send Mass E-mail</h2>
  <p>The form below will allow you to send a mass e-mail message. You can send the e-mail to all registered participants of the conference, or specify a list of recipients.</p>
  
  {IF MSG_SUCCESS}
    <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />The message has been sent successfully.</p>
  {END MSG_SUCCESS}
  
  {IF ERR_SUBJECT}
      <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />You must enter Message Subject.</p>
  {END ERR_SUBJECT}
  
  {IF ERR_TEXT}
      <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />You must enter Message Text.</p>
  {END ERR_TEXT}
  
  {IF ERR_LIST}
      <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />You must enter List of Recipients.</p>
  {END ERR_LIST}
  
<br>
<form action="" method="post" enctype="multipart/form-data">
  <table>
    <tr>
      <td class="label"><label for="subject">Subject:</label></td>
      <td><input type="text" name="subject" id="subject" size="70" value="{STR INPUT_SUBJECT}" /></td>
    </tr>
    <tr>
      <td class="label" valign="top">Message Text:</td>
      <td><textarea name="text" rows="14" cols="70">{STR INPUT_TEXT}</textarea></td>
    </tr>
    <tr>
      <td class="label"><label for="attachment">Attachment:</label></td>
      <td><input type="file" name="attachment" id="attachment" size="25" /><br /></td>
    </tr>
    <tr>
      <td class="label">Recipients:</td>
      <td>
        <input type="radio" name="recipients" id="recipients-all" onclick="testRadio()" value="0"{STR INPUT_ALL_CHECKED} />
				<label for="recipients-all">All Registered Participants</label>  
				<input type="radio" name="recipients" id="recipients-other" onclick="testRadio()" value="1"{STR INPUT_OTHER_CHECKED} />
				<label for="recipients-other">Other Recipients</label> 
      </td>
    </tr>
    <tr>
      <td class="label" valign="top">List of Recipients:</td>
      <td>
        <textarea name="recipients_list" id="recipients_list" rows="10" cols="40" disabled="disabled">{STR INPUT_RECIPIENTS_LIST}</textarea><br />
        Please, enter each e-mail addres on a new line.
      </td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" name="send_email" value="Send E-mail" /></td>
    </tr>
  </table>
</form>