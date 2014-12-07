  <script type="text/javascript">
			
			$(document).ready( function() {
        
        $("#new_conference").click( function() {
					jConfirm('Are you sure you really want to create a new conference?', 'New conference', function(r) {
						if( r ) document.forms["new_conference_form"].submit();
					});
				});
        
			});
			
		</script>


<p>Please, enter the URL address for a new conference page.</p>
<p><img src="../templates/admin/images/icon16_warning.png" alt="Warning" class="icon" />Notice: You <b>will not be able</b> to change this setting in the future.</p>
<br /><br />

{IF ERR_URL_ASSIGNED}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />The entered URL address is already taken. Please, enter another URL address.</p>
{END ERR_URL_ASSIGNED}

{IF ERR_URL_TOO_SHORT}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />The entered URL address is invalid. URL address must be from 1 to 30 characters long.</p>
{END ERR_URL_TOO_SHORT}

{IF ERR_URL_INVALID}
  <p><img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />The entered URL address is invalid. The only allowed characters are a-z, A-Z, 0-9, -.</p>
{END ERR_URL_INVALID}

<form id="new_conference_form" action="" method="post">
  <table>
    <tr>
      <td class="label"><label for="url">URL address:</label></td>
      <td>
        {STR CURRENT_URL} <input type="text" name="url" id="url" maxlength="30" size="30" value="{STR INPUT_URL}" /> 
        <input type="button" id="new_conference" value="Create Conference" />
      </td>
    </tr>
  </table>
  <input type="hidden" name="new_conference" />
</form>