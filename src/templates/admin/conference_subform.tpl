<script type="text/javascript">
			
	$(document).ready( function() {
        
    $("#new_topic").click( function() {
 	    jConfirm('Are you sure you really want to add a new topic?', 'New topic', function(r) {
			  if( r ) document.forms["new_topic_form"].submit();
			});
		});
        
    $(".delete_link").click( function() {
			var value = $( this ).attr( 'name' );
      jConfirm('Are you sure you really want to delete selected topic?', 'Delete topic', function(r) {
			  if( r ) {
          document.forms["delete_topic_form"].delete_topic.value = value;
          document.forms["delete_topic_form"].submit();
        }
			});
		});
  
  });
			
</script>


<h2>Add a New Topic</h2>
<p>The form below will allow you to add a new topic of presentation.</p>

{IF ERR_TOPIC_TITLE}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />You must enter Topic Title.</p>
{END ERR_TOPIC_TITLE}

{IF MSG_ADD_SUCCESS}
  <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />The topic has been added successfully.</p>
{END MSG_ADD_SUCCESS}

<form id="new_topic_form" action="" method="POST">
  <table>
    <tr>
      <td class="label"><label for="topic">Topic title:</label></td>
      <td><input type="text" name="topic" id="topic" size="70" value="" /></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="button" id="new_topic" value="Add Topic" /></td>
    </tr>
  </table>
  <input type="hidden" name="new_topic" />
</form>
<br />
<hr />


<h2>Existing Topics</h2>
{IF MSG_DELETE_SUCCESS}
  <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />The topic has been removed successfully.</p>
{END MSG_DELETE_SUCCESS}

{IF TOPICS_FOUND}
<fieldset>
<legend>List of Topics</legend>
  
  <table>
    <tr>
      <th width="85%">Title</th>   
      <th width="15%">Actions</th>
    </tr>

    {LOOP TOPICS}
    <tr{TOPICS.EVEN}>
      <td><a href="conference_subform_edit.php?id={TOPICS.ID}">{TOPICS.TITLE}</a></td>   
      <td>
        <a href="conference_subform_edit.php?id={TOPICS.ID}"><img src="../templates/admin/images/icon32_edit.png" alt="Edit Topic" title="Edit Topic" /></a> 
        <a class="delete_link" name="{TOPICS.ID}" style="cursor:pointer;">
          <img src="../templates/admin/images/icon32_trash.png" alt="Delete Topic" title="Delete Topic" /></a>
      </td>  
    </tr>
    {END TOPICS}
  </table>
  
  <form id="delete_topic_form" action="" method="POST">
    <input type="hidden" id="delete_topic" name="delete_topic" />
  </form>
</fieldset>
{END TOPICS_FOUND}

{IF TOPICS_NOT_FOUND}
  <p>
    <img src="../templates/admin/images/icon16_info.png" alt="Information" class="icon" />
    No topics found. Please, add a new topic using the form above.
  </p> 
{END TOPICS_NOT_FOUND}
<br />
<hr />


<h2>Allowed File Types</h2>
<p>Please, define allowed file types for the papers in the form below. <br />
<b>Note:</b> Separate each file type with a comma. Example: doc, docx, pdf</p>

{IF MSG_FILE_TYPES_SUCCESS}
  <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />Your changes have been saved successfully.</p>
{END MSG_FILE_TYPES_SUCCESS}

<form id="edit_form_file_types" action="" method="post">
  <table>
    <tr>
      <td class="label"><label for="file_types">Allowed file types:</label></td>
      <td><input type="text" name="file_types" id="file_types" size="40" value="{STR SUBFORM_FILE_TYPES}" /></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" name="edit_file_types" value="Save changes" /></td>
    </tr>
  </table>
</form>
<br />
<hr />


<h2>Submission Form Notes</h2>
<p>You can fill any notes related to the submission form below.</p>

{IF MSG_NOTES_SUCCESS}
  <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />Your changes have been saved successfully.</p>
{END MSG_NOTES_SUCCESS}

<form id="edit_form_notes" action="" method="post">
  <textarea name="subform_notes" rows="5" cols="80">{STR SUBFORM_NOTES}</textarea>
  <br />
  <input type="submit" name="edit_subform_notes" value="Save changes" />
</form>