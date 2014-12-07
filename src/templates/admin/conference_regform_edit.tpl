<h2>Edit Form Field</h2>
<p>Here you can change the settings of the Form Field.</p>


{IF ERR_FIELD_CAPTION}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />You must enter Field caption.</p>
{END ERR_FIELD_CAPTION}

{IF ERR_DB_COLUMN}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />You must enter DB column name.</p>
{END ERR_DB_COLUMN}

{IF ERR_DB_NOT_AVAIL}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />The entered DB column name is not available. Please, enter another name.</p>
{END ERR_DB_NOT_AVAIL}

{IF ERR_DB_NOT_VALID}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />The entered DB column name is not valid. The only allowed characters are a-z, A-Z, 0-9, -, _.</p>
{END ERR_DB_NOT_VALID}

{IF ERR_POSSIBLE_OPTIONS}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />You must enter at least one option.</p>
{END ERR_POSSIBLE_OPTIONS}

<form id="edit_field_form" action="" method="POST">
  <table>
    <tr>
      <td class="label">Type of field:</td>
      <td>{STR TYPE_NAME}</td>
    </tr>
  
    <tr>
      <td class="label"><label for="caption">Field caption:</label></td>
      <td><input type="text" name="caption" id="caption" size="40" value="{STR INPUT_CAPTION}" /></td>
    </tr>
    
    {IF TYPE_NOT_TITLE_1}
    <tr>
      <td class="label"><label for="db_column">DB column name:</label></td>
      <td><input type="text" name="db_column" id="db_column" size="40" value="{STR INPUT_DB_COLUMN}" /></td>
    </tr>
    {END TYPE_NOT_TITLE_1}
    
    {IF TYPE_CHECK_RADIO}
    <tr>
      <td class="label" valign="top"><label for="options">Possible options:</label></td>
      <td><textarea name="options" id="options" cols="60" rows="4">{STR INPUT_OPTIONS}</textarea><br>Note: separate each option with a comma! Example: Option A, Option B, Option C</td>
    </tr>
    
    <tr>
      <td class="label">Display options in:</td>
      <td>
        <input type="radio" name="display" id="display-row" value="row"{STR DISPLAY_ROW_CHECKED} />
				<label for="display-row">Row</label>  
				<input type="radio" name="display" id="display-col" value="column"{STR DISPLAY_COL_CHECKED} />
				<label for="display-col">Column</label> 
      </td>
    </tr>
    {END TYPE_CHECK_RADIO}
    
    {IF TYPE_NOT_TITLE_2}
    <tr>
      <td class="label">Dependency:</td>
      <td>
        <input type="radio" name="required" id="dep-opt" value="0"{STR DEPENDENCY_OPT_CHECKED} />
				<label for="dep-opt">Optional field</label>  
				<input type="radio" name="required" id="dep-req" value="1"{STR DEPENDENCY_REQ_CHECKED} />
				<label for="dep-req">Required field</label> 
      </td>
    </tr>
    {END TYPE_NOT_TITLE_2}
    <tr>
      <td></td>
      <td><input type="submit" name="edit_field" value="Save changes" /></td>
    </tr>
  </table>
</form>