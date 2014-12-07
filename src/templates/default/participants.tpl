<h2>Regular Participants</h2>

{IF REGULARS_FOUND}
<table width="100%">
  {LOOP REGULAR}               
  <tr>
    <td align="center">{REGULAR.NUM}</td>
    <td width="50" align="center">
      <img src="../templates/flags/blank.gif" class="flag flag-{REGULAR.COUNTRY}" alt="" border="0" />
    </td>
    <td align="right" style="padding-right: 5px;">{REGULAR.TITLE}</td>
    <td>{REGULAR.LAST_NAME}</td>
    <td>{REGULAR.FIRST_NAME}</td>
    <td>{REGULAR.UNIVERSITY}</td>
  </tr>
  {END REGULAR}
</table>
{END REGULARS_FOUND}

{IF REGULARS_NOT_FOUND}
  <p>No regular participants found.</p>
{END REGULARS_NOT_FOUND}

<br />
<h2>Accompanying Persons</h2>

{IF ACCOMPS_FOUND}
<table width="100%">
  {LOOP ACCOMP}
  <tr>
    <td align="center">{ACCOMP.NUM}</td>
    <td width="50" align="center">
      <img src="../templates/flags/blank.gif" class="flag flag-{ACCOMP.COUNTRY}" alt="" />
    </td>
    <td align="right" style="padding-right: 5px;">{ACCOMP.TITLE}</td>
    <td>{ACCOMP.LAST_NAME}</td>
    <td>{ACCOMP.FIRST_NAME}</td>
  </tr>
  {END ACCOMP}
</table>
{END ACCOMPS_FOUND}

{IF ACCOMPS_NOT_FOUND}
  <p>No accompanying persons found.</p>
{END ACCOMPS_NOT_FOUND}
