<h2>Registration Successful!</h2>

<p>{STR MSG_NEW_REGISTRATION}</p>
<br />

<h2>Registration Overview</h2>
<div align="center">
  <table>
    {LOOP OVERVIEW}
    <tr>
      <td align="right">
        <b>{OVERVIEW.CAPTION}: </b>
      </td>
      <td>
        {OVERVIEW.DATA}
      </td> 
    </tr>
    {END OVERVIEW}
  </table>
</div>