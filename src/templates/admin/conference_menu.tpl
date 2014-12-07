<script type="text/javascript">
			
	$(document).ready( function() {
        
    $(".delete_link").click( function() {
			var value = $( this ).attr( 'name' );
      jConfirm('Are you sure you really want to delete selected menu item?', 'Delete menu item', function(r) {
			  if( r ) {
          document.forms["delete_item_form"].delete_item.value = value;
          document.forms["delete_item_form"].submit();
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
    
    $(".moveleft").click( function() {
			var value = $( this ).attr( 'name' );
      document.forms["move_field_form"].move_field.value = value;
      document.forms["move_field_form"].direction.value = 'left';
      document.forms["move_field_form"].submit();
		});
    
    $(".moveright").click( function() {
			var value = $( this ).attr( 'name' );
      document.forms["move_field_form"].move_field.value = value;
      document.forms["move_field_form"].direction.value = 'right';
      document.forms["move_field_form"].submit();
		});
  
  });
			
</script>


<h2>Add a New Menu Item</h2>
<p>The form below will allow you to add a new item to the menu.</p>


{IF ERR_ITEM_CAPTION}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />You must enter Item caption.</p>
{END ERR_ITEM_CAPTION}

{IF MSG_ADD_SUCCESS}
  <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />Item has been successfully created.</p>
{END MSG_ADD_SUCCESS}

<form id="new_item_form" action="" method="POST">
  <table>
    <tr>
      <td class="label"><label for="caption">Item caption:</label></td>
      <td><input type="text" name="caption" id="caption" size="40" value="{STR INPUT_CAPTION}" /></td>
    </tr>
    <tr>
      <td class="label"><label for="link">Item links to:</label></td>
      <td>
        <select name="link">
            <option value="0">(nowhere)</option>
          {LOOP PAGES_SELECT}
            <option value="{PAGES_SELECT.ID}"{PAGES_SELECT.SELECTED}>{PAGES_SELECT.TITLE}</option>
          {END PAGES_SELECT}
        </select>
      </td>
    </tr>
    <tr>
      <td class="label">Type of item:</td>
      <td>
        <input type="radio" name="type" id="type-main" value="0"{STR TYPE_MAIN_CHECKED} />
				<label for="type-main">Main Item</label>  
				<input type="radio" name="type" id="type-sub" value="1"{STR TYPE_SUB_CHECKED} />
				<label for="type-sub">Subitem</label> 
      </td>
    </tr>
    <tr>
      <td class="label"><label for="after">Add after item:</label></td>
      <td>
        <select name="after">
          {LOOP ITEMS_SELECT}
            <option value="{ITEMS_SELECT.ID}"{ITEMS_SELECT.SELECTED}>{ITEMS_SELECT.SUBITEM}{ITEMS_SELECT.CAPTION}</option>
          {END ITEMS_SELECT}
        </select>
      </td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" name="new_item" value="Add Item" /></td>
    </tr>
  </table>
</form>
<br />
<hr />


<h2>Manage Menu</h2>

{IF MSG_DELETE_SUCCESS}
  <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />Item has been removed successfully.</p>
{END MSG_DELETE_SUCCESS}

{IF MSG_HIDE_SUCCESS}
  <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />The item has been hidden.</p>
{END MSG_HIDE_SUCCESS}

{IF MSG_UNHIDE_SUCCESS}
  <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />The item is now visible.</p>
{END MSG_UNHIDE_SUCCESS}

<fieldset>
<legend>List of Items</legend>
  <table>
    <tr>
      <th width="35%">Caption</th>   
      <th width="35%">Item Links to</th>
      <th width="15%">Menu Order</th>
      <th width="15%">Actions</th>
    </tr>

    {LOOP ITEMS}
    <tr{ITEMS.EVEN}>
    
      <td>
        {IF IS_SUBITEM_{ITEMS.ID}}
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {END IS_SUBITEM_{ITEMS.ID}}
        
        {IF IS_MAINITEM_B_{ITEMS.ID}}
          <b>
        {END IS_MAINITEM_B_{ITEMS.ID}}  
        <a href="conference_menu_edit.php?id={ITEMS.ID}">{ITEMS.CAPTION}</a>
        {IF IS_MAINITEM_ENDB_{ITEMS.ID}}
          </b>
        {END IS_MAINITEM_ENDB_{ITEMS.ID}}
      </td>
         
      <td>
        {IF LINK_YES_{ITEMS.ID}}
          <a href="{STR CONFERENCE_URL}/{ITEMS.LINK_URL}.html" target="_blank">{ITEMS.LINK_TITLE}</a>
        {END LINK_YES_{ITEMS.ID}}
        
        {IF LINK_NO_{ITEMS.ID}}
          (nowhere)
        {END LINK_NO_{ITEMS.ID}}
      </td>
      
      <td>
      
        {IF ARROW_UP_DISABLED_{ITEMS.ID}}
          <img src="../templates/admin/images/icon32_up_disabled.png" alt="" />
        {END ARROW_UP_DISABLED_{ITEMS.ID}}
        
        {IF ARROW_UP_ENABLED_{ITEMS.ID}}
          <a class="moveup" name={ITEMS.ID}" style="cursor:pointer;">
            <img src="../templates/admin/images/icon32_up.png" alt="Move Up" title="Move Up" /></a>
        {END ARROW_UP_ENABLED_{ITEMS.ID}}
        
        {IF ARROW_DOWN_DISABLED_{ITEMS.ID}}
          <img src="../templates/admin/images/icon32_down_disabled.png" alt="" />
        {END ARROW_DOWN_DISABLED_{ITEMS.ID}}
        
        {IF ARROW_DOWN_ENABLED_{ITEMS.ID}}
          <a class="movedown" name={ITEMS.ID}" style="cursor:pointer;">
            <img src="../templates/admin/images/icon32_down.png" alt="Move Down" title="Move Down" /></a>
        {END ARROW_DOWN_ENABLED_{ITEMS.ID}}
        
        {IF ARROW_LEFT_DISABLED_{ITEMS.ID}}
          <img src="../templates/admin/images/icon32_left_disabled.png" alt="" />
        {END ARROW_LEFT_DISABLED_{ITEMS.ID}}
        
        {IF ARROW_LEFT_ENABLED_{ITEMS.ID}}
          <a class="moveleft" name={ITEMS.ID}" style="cursor:pointer;">
            <img src="../templates/admin/images/icon32_left.png" alt="Make this Main Item" title="Make this Main Item" /></a>
        {END ARROW_LEFT_ENABLED_{ITEMS.ID}}
        
        {IF ARROW_RIGHT_DISABLED_{ITEMS.ID}}
          <img src="../templates/admin/images/icon32_right_disabled.png" alt="" />
        {END ARROW_RIGHT_DISABLED_{ITEMS.ID}}
        
        {IF ARROW_RIGHT_ENABLED_{ITEMS.ID}}
          <a class="moveright" name={ITEMS.ID}" style="cursor:pointer;">
            <img src="../templates/admin/images/icon32_right.png" alt="Make this Subitem" title="Make this Subitem" /></a>
        {END ARROW_RIGHT_ENABLED_{ITEMS.ID}}
      
      </td>
      
      <td>
        {IF ITEM_HIDDEN_{ITEMS.ID}}
          <a href="conference_menu.php?action=unhide&amp;id={ITEMS.ID}">
            <img src="../templates/admin/images/icon32_unhide.png" alt="Unhide this Item" title="Unhide this Item" /></a>
        {END ITEM_HIDDEN_{ITEMS.ID}}
        
        {IF ITEM_VISIBLE_{ITEMS.ID}}
          <a href="conference_menu.php?action=hide&amp;id={ITEMS.ID}">
            <img src="../templates/admin/images/icon32_hide.png" alt="Hide this Item" title="Hide this Item" /></a>
        {END ITEM_VISIBLE_{ITEMS.ID}}
      
        <a href="conference_menu_edit.php?id={ITEMS.ID}"><img src="../templates/admin/images/icon32_edit.png" alt="Edit Item" title="Edit Item" /></a>
         
        {IF DELETE_DISABLED_{ITEMS.ID}}
          <img src="../templates/admin/images/icon32_trash.png" alt="" style="opacity: 0.3;" />
        {END DELETE_DISABLED_{ITEMS.ID}}
        
        {IF DELETE_ENABLED_{ITEMS.ID}}
          <a class="delete_link" name="{ITEMS.ID}" style="cursor:pointer;">
            <img src="../templates/admin/images/icon32_trash.png" alt="Delete Item" title="Delete Item" /></a>
        {END DELETE_ENABLED_{ITEMS.ID}}
             
      </td>  
    </tr>
    {END ITEMS}
    
  </table>
  <form id="delete_item_form" action="" method="POST">
    <input type="hidden" id="delete_item" name="delete_item" />
  </form>
  
  <form id="move_field_form" action="" method="POST">
    <input type="hidden" id="move_field" name="move_field" />
    <input type="hidden" id="direction" name="direction" />
  </form>
</fieldset>