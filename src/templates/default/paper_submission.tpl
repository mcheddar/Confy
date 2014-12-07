<script type="text/javascript">
			
	$(document).ready( function() {
        
    $(".delete_link").click( function() {
			var value = $( this ).attr( 'name' );
      jConfirm('Are you sure you really want to delete selected contribution?', 'Delete Paper', function(r) {
			  if( r ) {
          document.forms["delete_paper_form"].delete_paper.value = value;
          document.forms["delete_paper_form"].submit();
        }
			});
		});
  
  });
			
</script>

<h2>My Papers</h2>

{IF MSG_DELETE_SUCCESS}
  <p>
    <img src="../templates/default/images/icon16_success.png" alt="Success" class="icon" />
    The contribution has been deleted successfully.
  </p> 
{END MSG_DELETE_SUCCESS}


{IF PAPERS_NOT_FOUND}
<p>
  <img src="../templates/default/images/icon16_info.png" alt="Information" class="icon" />
  You haven't submitted any papers yet. Please, use the form below to submit a contribution.
</p> 
{END PAPERS_NOT_FOUND}

{IF PAPERS_FOUND}
<table width="100%" class="papers">
  <tr>
    <th width="5%" align="center">#</th>
    <th width="70%">General Info</th>
    <th width="20%" align="center">Time of Submission</th>
    <th width="5%" align="center">Delete</th>
  </tr>
  {LOOP PAPERS}
  <tr{PAPERS.EVEN}>
    <td align="center"><b>{PAPERS.NUM}</b></td>
    <td>
      <b><a href="{PAPERS.URL}">{PAPERS.FILE_NAME}</a></b><br />
      <b>Type: </b> {PAPERS.TYPE}<br />
      <b>Topic: </b> {PAPERS.TOPIC}<br />
      <b>Title: </b> {PAPERS.TITLE}<br />
    </td>
    <td align="center">{PAPERS.DATE}<br />{PAPERS.TIME}</td>
    <td align="center">
    
      {IF DELETE_DISABLED_{PAPERS.ID}}
        <img src="../templates/admin/images/icon32_trash.png" alt="" style="opacity: 0.3;" />
      {END DELETE_DISABLED_{PAPERS.ID}}
        
      {IF DELETE_ENABLED_{PAPERS.ID}}
        <a class="delete_link" name="{PAPERS.ID}" style="cursor:pointer;">
          <img src="../templates/default/images/icon32_trash.png" alt="Delete Paper" title="Delete Paper" /></a>
      {END DELETE_ENABLED_{PAPERS.ID}}

      </td>
  </tr>
  {END PAPERS}
</table>

<form id="delete_paper_form" action="" method="post">
  <input type="hidden" id="delete_paper" name="delete_paper" />
</form>
  
{END PAPERS_FOUND}

<br />
<h2>Paper Submission Form</h2>


{IF SUBMISSION_OPEN}

<p>Please, choose a type and topic of presentation that your are submitting your abstract for and fill in the title of these presentation. It will be helpful for us to build up the programme easier.</p>

<p>
  <img src="../templates/default/images/icon16_info.png" alt="Information" class="icon" />
  <b>Information: </b> deadline for Paper Submission is on <b>{STR SUBMISSION_DEADLINE}</b>.
</p> 

{IF ERROR_TITLE}
  <p>
    <img src="../templates/default/images/icon16_error.png" alt="Error" class="icon" />
    <b>Error: </b> you must fill in the Title of presentation.
  </p> 
{END ERROR_TITLE}

{IF ERROR_TYPE}
  <p>
    <img src="../templates/default/images/icon16_error.png" alt="Error" class="icon" />
    <b>Error: </b> you must choose the Type of presentation.
  </p> 
{END ERROR_TYPE}

{IF ERROR_TOPIC}
  <p>
    <img src="../templates/default/images/icon16_error.png" alt="Error" class="icon" />
    <b>Error: </b> you must choose the Topic of presentation.
  </p> 
{END ERROR_TOPIC}

{IF ERROR_FILE}
  <p>
    <img src="../templates/default/images/icon16_error.png" alt="Error" class="icon" />
    <b>Error: </b> you must select a file to upload.
  </p> 
{END ERROR_FILE}

{IF ERROR_FILE_INVALID}
  <p>
    <img src="../templates/default/images/icon16_error.png" alt="Error" class="icon" />
    <b>Error: </b> uploaded file type is not allowed.
  </p>
{END ERROR_FILE_INVALID}

{IF MSG_UPLOAD_SUCCESS}
  <p>
    <img src="../templates/default/images/icon16_success.png" alt="Success" class="icon" />
    Your paper has been uploaded successfully.
  </p>
{END MSG_UPLOAD_SUCCESS}

<form id="submission_form" action="" method="post" enctype="multipart/form-data">
  <table>
    <tr>
      <td>
        Type of presentation
      </td>
      <td>
        <input type="radio" name="type" id="type-oral" value="oral"{STR ORAL_SELECTED} /> <label for="type-oral">oral presentation</label>
        <input type="radio" name="type" id="type-poster" value="poster"{STR POSTER_SELECTED} /> <label for="type-poster">poster presentation</label>
      </td>
    </tr>
    <tr>
      <td valign="top">
        Topic of presentation
      </td>
      <td>
        {LOOP TOPICS}
        <input type="radio" name="topic" id="topic-{TOPICS.ID}" value="{TOPICS.ID}"{TOPICS.SELECTED} /> <label for="topic-{TOPICS.ID}">{TOPICS.NAME}</label><br />
        {END TOPICS}
      </td>
    </tr>
    <tr>
      <td valign="top">
        Title of presentation
      </td>
      <td>
        <textarea name="title" rows="4" cols="70">{STR INPUT_TITLE}</textarea>
      </td>
    </tr>
    <tr>
      <td valign="top">
        Upload file
      </td>
      <td>
        <input type="file" name="file" size="25" /><br />
        <b>Allowed file types: </b> {STR ALLOWED_FILE_TYPES}.
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <br />
        <div align="center">
          <input type="submit" name="submit_paper" value="Submit Paper" />
        </div>
      </td>
    </tr>
  </table>
</form>
<br /><br />
{STR SUBFORM_NOTES}

{END SUBMISSION_OPEN}

{IF SUBMISSION_CLOSED}
  Sorry, the paper submission form has been closed on {STR SUBMISSION_DEADLINE}.
{END SUBMISSION_CLOSED}