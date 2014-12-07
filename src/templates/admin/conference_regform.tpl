<script type="text/javascript">
			
	$(document).ready( function() {
        
    $(".delete_link").click( function() {
			var value = $( this ).attr( 'name' );
      jConfirm('Are you sure you really want to delete selected form field?<br><br><img src="../templates/admin/images/icon16_warning.png" alt="Warning" class="icon" /><b>Warning</b><br>All the registration data from this field will be lost!', 'Delete form field', function(r) {
			  if( r ) {
          document.forms["delete_field_form"].delete_field.value = value;
          document.forms["delete_field_form"].submit();
        }
			});
		});
    
    $(".moveup").click( function() {
			var value = $( this ).attr( 'name' );
      document.forms["move_field_form"].move_field.value = value;
      document.forms["move_field_form"].direction.value = 'up';
      document.forms["move_field_form"].submit();
		});
    
    $(".movedown").click( function() {
			var value = $( this ).attr( 'name' );
      document.forms["move_field_form"].move_field.value = value;
      document.forms["move_field_form"].direction.value = 'down';
      document.forms["move_field_form"].submit();
		});
  
  });
			
</script>


{IF MSG_WARNING}
  <p><img src="../templates/admin/images/icon16_warning.png" alt="Warning" class="icon" /><b>Warning: registered participants found!</b> It is strictly not recommended to modify anything on this page, otherwise you may cause fatal data loss.</p><br>
{END MSG_WARNING}


<h2>Add a New Field</h2>
<p>Please, select in the form below the type of field you want to add.</p>


<form id="new_field_form" action="" method="post">
  <table>
    <tr>
      <td class="label">Type of field:</td>
      <td>
        <select name="type">
          <option value="text">Text field</option>
          <option value="textarea">Textarea</option>
          <option value="radio">Radio buttons</option>
          <option value="checkbox">Checkboxes</option>
          <option value="country_select">Country selection drop-down box</option>
          <option value="title">Title</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="label"><label for="after">Add after field:</label></td>
      <td>
        <select name="after">
          {LOOP FIELDS_SELECT}
            <option value="{FIELDS_SELECT.ID}">{FIELDS_SELECT.CAPTION}</option>
          {END FIELDS_SELECT}
        </select>
      </td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" name="new_field" value="Add Field" /></td>
    </tr>
  </table>
</form>
<br />
<hr />


<h2>Manage Fields</h2>

{IF MSG_DELETE_SUCCESS}
  <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />Field has been removed successfully.</p>
{END MSG_DELETE_SUCCESS}

<fieldset>
<legend>List of Fields</legend>
  <table>
    <tr>
      <th width="20%">Caption</th>   
      <th width="45%">Field</th>
      <th width="15%">DB column name</th>
      <th width="10%">Field order</th>
      <th width="10%">Actions</th>
    </tr>

    {LOOP FIELDS}
    <tr{FIELDS.EVEN}>
    
      <td>
        {FIELDS.CAPTION}
      </td>
         
      <td>
        {FIELDS.FORM}
      </td>
      
      <td>
        {FIELDS.DB_COLUMN}
      </td>
      
      <td>
        
        {IF ARROW_UP_DISABLED_{FIELDS.ID}}
          <img src="../templates/admin/images/icon32_up_disabled.png" alt="" />
        {END ARROW_UP_DISABLED_{FIELDS.ID}}
        
        {IF ARROW_UP_ENABLED_{FIELDS.ID}}
          <a class="moveup" name={FIELDS.ID}" style="cursor:pointer;">
            <img src="../templates/admin/images/icon32_up.png" alt="Move Up" title="Move Up" /></a>
        {END ARROW_UP_ENABLED_{FIELDS.ID}}
        
        {IF ARROW_DOWN_DISABLED_{FIELDS.ID}}
          <img src="../templates/admin/images/icon32_down_disabled.png" alt="" />
        {END ARROW_DOWN_DISABLED_{FIELDS.ID}}
        
        {IF ARROW_DOWN_ENABLED_{FIELDS.ID}}
          <a class="movedown" name={FIELDS.ID}" style="cursor:pointer;">
            <img src="../templates/admin/images/icon32_down.png" alt="Move Down" title="Move Down" /></a>
        {END ARROW_DOWN_ENABLED_{FIELDS.ID}}
                
      </td>
      
      <td>

        {IF EDIT_DISABLED_{FIELDS.ID}} 
          <img src="../templates/admin/images/icon32_edit.png" alt="" style="opacity: 0.3;" />
        {END EDIT_DISABLED_{FIELDS.ID}} 
        
        {IF EDIT_ENABLED_{FIELDS.ID}} 
          <a href="conference_regform_edit.php?id={FIELDS.ID}">
            <img src="../templates/admin/images/icon32_edit.png" alt="Edit Field" title="Edit Field" /></a>
        {END EDIT_ENABLED_{FIELDS.ID}} 
        
        {IF DELETE_DISABLED_{FIELDS.ID}}
          <img src="../templates/admin/images/icon32_trash.png" alt="" style="opacity: 0.3;" />
        {END DELETE_DISABLED_{FIELDS.ID}}
        
        {IF DELETE_ENABLED_{FIELDS.ID}}
          <a class="delete_link" name="{FIELDS.ID}" style="cursor:pointer;">
            <img src="../templates/admin/images/icon32_trash.png" alt="Delete Item" title="Delete Item" /></a>
        {END DELETE_ENABLED_{FIELDS.ID}}
      </td>  
    </tr>
    {END FIELDS}
    
  </table>
  <form id="delete_field_form" action="" method="POST">
    <input type="hidden" id="delete_field" name="delete_field" />
  </form>
  
  <form id="move_field_form" action="" method="POST">
    <input type="hidden" id="move_field" name="move_field" />
    <input type="hidden" id="direction" name="direction" />
  </form>
</fieldset>
<br />
<hr />


<h2>Registration Notes</h2>
<p>You can fill any notes related to the registration form below.</p>

{IF MSG_NOTES_SUCCESS}
  <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />Your changes have been saved successfully.</p>
{END MSG_NOTES_SUCCESS}

<form id="edit_form_notes" action="" method="post">
  <textarea name="regform_notes" rows="5" cols="80">{STR REGFORM_NOTES}</textarea>
  <br />
  <input type="submit" name="edit_regform_notes" value="Save Changes" />
</form>
