<h2>List of Registered Participants</h2>

{IF PARTICIPANTS_NOT_FOUND}
<p>
  <img src="../templates/admin/images/icon16_info.png" alt="Information" class="icon" />
  No registered participants found.
</p> 
{END PARTICIPANTS_NOT_FOUND}

{IF PARTICIPANTS_FOUND}
<fieldset>
<legend>List of Participants</legend>
  
  <table>
    <tr>
      <th width="5%" style="text-align: center">#</th>  
      <th width="5%" style="text-align: center">Country</th>  
      <th width="35%">Last and First Name</th>  
      <th width="45%">University</th>  
      <th width="10%" style="text-align: center">Papers</th>
    </tr>

    {LOOP PARTICIPANTS}
    <tr{PARTICIPANTS.EVEN}>
      <td align="center"><b>{PARTICIPANTS.NUM}</b></td>
      <td align="center"><img src="../templates/flags/blank.gif" class="flag flag-{PARTICIPANTS.COUNTRY}" alt="" /></td> 
      <td><a href="conference_participants_detail.php?id={PARTICIPANTS.ID}">{PARTICIPANTS.NAME}</a></td>
      <td>{PARTICIPANTS.UNIVERSITY}</td>
      <td align="center">{PARTICIPANTS.PAPERS}</td>       
    </tr>
    {END PARTICIPANTS}
  </table>
</fieldset>
{END PARTICIPANTS_FOUND}