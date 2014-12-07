<h2>List of Contributed Papers</h2>

{IF PAPERS_NOT_FOUND}
<p>
  <img src="../templates/admin/images/icon16_info.png" alt="Information" class="icon" />
  No contributed papers found.
</p> 
{END PAPERS_NOT_FOUND}

{IF PAPERS_FOUND}
<fieldset>
  <legend>List of Papers</legend>
  <table>
    <tr>
      <th width="5%" style="text-align: center">#</th>
      <th width="70%">General Info</th>
      <th width="25%" style="text-align: center">Time of Submission</th>
    </tr>
    {LOOP PAPERS}
    <tr{PAPERS.EVEN}>
      <td align="center"><b>{PAPERS.NUM}</b></td>
      <td>
        <b><a href="{PAPERS.URL}">{PAPERS.FILE_NAME}</a></b><br />
        <b>Author: </b> <a href="conference_participants_detail.php?id={PAPERS.AUTHOR_ID}">{PAPERS.AUTHOR_NAME}</a><br />
        <b>Type: </b> {PAPERS.TYPE}<br />
        <b>Topic: </b> {PAPERS.TOPIC}<br />
        <b>Title: </b> {PAPERS.TITLE}<br />
      </td>
      <td align="center">{PAPERS.DATE}<br />{PAPERS.TIME}</td>
    </tr>
    {END PAPERS}
  </table>
</fieldset>
{END PAPERS_FOUND}