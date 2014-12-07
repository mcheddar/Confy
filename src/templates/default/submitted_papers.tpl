<h2>Oral Presentations</h2>

{IF ORALS_FOUND}
<ol>
  {LOOP ORAL}               
  <li>
    <strong>{ORAL.TITLE}</strong><br />
    {ORAL.NAME}<br /><br />
  </li>
  {END ORAL}
</ol>
{END ORALS_FOUND}

{IF ORALS_NOT_FOUND}
  <p>No oral presentations found.</p>
{END ORALS_NOT_FOUND}

<br />
<h2>Poster Presentations</h2>

{IF POSTERS_FOUND}
<ol>
  {LOOP POSTER}               
  <li>
    <strong>{POSTER.TITLE}</strong><br />
    {POSTER.NAME}<br /><br />
  </li>
  {END POSTER}
</ol>
{END POSTERS_FOUND}

{IF POSTERS_NOT_FOUND}
  <p>No poster presentations found.</p>
{END POSTERS_NOT_FOUND}