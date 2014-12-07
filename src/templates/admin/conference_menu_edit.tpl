<h2>Edit Menu Item</h2>
<p>Here you can change the settings of the Menu Item.</p>


{IF ERR_ITEM_CAPTION}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />You must enter Item caption.</p>
{END ERR_ITEM_CAPTION}

<form id="edit_item_form" action="" method="POST">
  <table>
    <tr>
      <td class="label"><label for="caption">Item caption:</label></td>
      <td><input type="text" name="caption" id="caption" size="40" value="{STR INPUT_CAPTION}" /></td>
    </tr>
    <tr>
      <td class="label"><label for="link">Item links to:</label></td>
      <td>
        {IF ITEM_NORMAL}
        <select name="link">
            <option value="0">(nowhere)</option>
          {LOOP PAGES_SELECT}
            <option value="{PAGES_SELECT.ID}"{PAGES_SELECT.SELECTED}>{PAGES_SELECT.TITLE}</option>
          {END PAGES_SELECT}
        </select>
        {END ITEM_NORMAL}
        
        {IF ITEM_SPECIAL}
          {STR ITEM_SPECIAL_LINK}
        {END ITEM_SPECIAL}
      </td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" name="edit_item" value="Save changes" /></td>
    </tr>
  </table>
</form>