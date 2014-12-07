<script type="text/javascript">
			
	$(document).ready( function() {
        
    $("#new_page").click( function() {
 	    jConfirm('Are you sure you really want to create a new page?', 'New page', function(r) {
			  if( r ) document.forms["new_page_form"].submit();
			});
		});
        
    $(".delete_link").click( function() {
			var value = $( this ).attr( 'name' );
      jConfirm('Are you sure you really want to delete selected page?', 'Delete page', function(r) {
			  if( r ) {
          document.forms["delete_page_form"].delete_page.value = value;
          document.forms["delete_page_form"].submit();
        }
			});
		});
  
  });
			
</script>


<h2>Create a New Page</h2>
<p>The form below will allow you to create a new page with an optional content.</p>


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


<form id="new_page_form" action="" method="POST">
  <table>
    <tr>
      <td class="label"><label for="title">Page title:</label></td>
      <td><input type="text" name="title" id="title" size="40" value="{STR INPUT_TITLE}" /></td>
    </tr>
    <tr>
      <td class="label"><label for="url">URL address:</label></td>
      <td>{STR CONFERENCE_URL_FULL}/<input type="text" name="url" id="url" maxlength="30" size="30" value="{STR INPUT_URL}" />.html</td>
    </tr>
    <tr>
      <td></td>
      <td><input type="button" id="new_page" value="Create Page" /></td>
    </tr>
  </table>
  <input type="hidden" name="new_page" />
</form>
<br />
<hr />


<h2>Existing Pages</h2>
{IF MSG_DELETE_SUCCESS}
  <p><img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />The page has been removed successfully.</p>
{END MSG_DELETE_SUCCESS}
<fieldset>
<legend>List of Pages</legend>
  
  <table>
    <tr>
      <th width="50%">Title</th>   
      <th width="35%">URL</th>
      <th width="15%">Actions</th>
    </tr>

    {LOOP PAGES}
    <tr{PAGES.EVEN}>
      <td><a href="conference_pages_edit.php?id={PAGES.ID}">{PAGES.TITLE}</a></td>   
      <td><a href="{STR CONFERENCE_URL_FULL}/{PAGES.URL}.html" target="_blank">{STR CONFERENCE_URL}/{PAGES.URL}.html</a></td>
      <td>
        <a href="conference_pages_edit.php?id={PAGES.ID}"><img src="../templates/admin/images/icon32_edit.png" alt="Edit Page" title="Edit Page" /></a> 
      
        {IF DELETE_DISABLED_{PAGES.ID}}
          <img src="../templates/admin/images/icon32_trash.png" alt="" style="opacity: 0.3;" />
        {END DELETE_DISABLED_{PAGES.ID}}
        
        {IF DELETE_ENABLED_{PAGES.ID}}
          <a class="delete_link" name="{PAGES.ID}" style="cursor:pointer;">
            <img src="../templates/admin/images/icon32_trash.png" alt="Delete Page" title="Delete Page" /></a>
        {END DELETE_ENABLED_{PAGES.ID}}
      
      
      </td>  
    </tr>
    {END PAGES}
  </table>
  <form id="delete_page_form" action="" method="POST">
    <input type="hidden" id="delete_page" name="delete_page" />
  </form>
</fieldset>