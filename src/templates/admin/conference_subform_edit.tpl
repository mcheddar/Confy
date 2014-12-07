<h2>Edit Topic</h2>
<p>Here you can change the title of the selected topic.</p>

{IF ERR_TOPIC_TITLE}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />You must enter Topic Title.</p>
{END ERR_TOPIC_TITLE}


<form id="edit_topic_form" action="" method="POST">
  <table>
    <tr>
      <td class="label"><label for="topic">Topic Title:</label></td>
      <td><input type="text" name="topic" id="topic" size="70" value="{STR INPUT_TOPIC}" /></td>
    </tr>
    <tr>
      <td><input type="submit" name="edit_topic" value="Save changes" /></td>
    </tr>
  </table>
</form>