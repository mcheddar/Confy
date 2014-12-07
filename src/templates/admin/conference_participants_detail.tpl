<h2>Registration Details</h2>

<table style="width: auto">
  <tr>
    <th colspan="2">
      {STR PARTICIPANT_NAME}
    </th>
  {LOOP DETAILS}
  <tr>
    <td class="caption">
      <b>{DETAILS.CAPTION}: </b>
    </td>
    <td class="data">
      {DETAILS.DATA}
    </td> 
  </tr>
  {END DETAILS}
</table>
<br />
<hr />


<h2>Contributed Papers</h2>

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
