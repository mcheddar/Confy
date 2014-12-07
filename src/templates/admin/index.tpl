<h2>Welcome to the confy Administration!</h2>

{IF CONFERENCES_NOT_FOUND}
<br />
<p>
  <img src="../templates/admin/images/icon16_info.png" alt="Information" class="icon" />
  No conferences found. Please, start with creating a <a href="conference_new.php">New Conference</a>.
</p> 
{END CONFERENCES_NOT_FOUND}

{IF CONFERENCES_FOUND}
<p>Please, select a conference.</p> 
<br />

<fieldset>
  <legend>List of Conferences</legend>
  <table>
    <tr>
      <th>Manage Conference</th>
    </tr>
    {LOOP CONFERENCES}
    <tr>
      <td><b><a href="index.php?select={CONFERENCES.URL}">{CONFERENCES.NAME}</a></b></td>
    </tr>
    {END CONFERENCES}
  </table>
</fieldset>
{END CONFERENCES_FOUND}