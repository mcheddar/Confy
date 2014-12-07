{IF ERR_FILE_MISSING}
  <p>
    <img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />
    <b>Error: </b> you must select a file to upload.
  </p> 
{END ERR_FILE_MISSING}

{IF ERR_FILE_INVALID}
  <p>
    <img src="../templates/admin/images/icon16_error.png" alt="Error" class="icon" />
    <b>Error: </b> uploaded file type is not allowed.
  </p>
{END ERR_FILE_INVALID}

{IF MSG_SUCCESS}
  <p>
    <img src="../templates/admin/images/icon16_success.png" alt="Success" class="icon" />
    The image has been updated successfully.
  </p>
{END MSG_SUCCESS}


<h2>Update Conference Logo</h2>
<img src="../conferences/{STR CONFERENCE_URL}/images/logo.jpg" width="215" alt="" border="0" />
<p>
  Please, select a file to upload from your computer.<br />
  <b>Allowed file type: </b> jpg<br />
  <b>Recommended image width: </b> 215 px
</p>
<br>
<form action="" method="post" enctype="multipart/form-data">
  <table>
    <tr>
      <td class="label"><label for="file">Select Image:</label></td>
      <td>
        <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
        <input type="file" name="file" id="file" size="25" />
        <input type="submit" name="upload_logo" value="Upload Image" />
      </td>
    </tr>
  </table>
</form>
<br />
<hr />


<h2>Update Panorama</h2>
<img src="../conferences/{STR CONFERENCE_URL}/images/panorama.jpg" width="768" alt="" border="0" />
<p>
  Please, select a file to upload from your computer.<br />
  <b>Allowed file type: </b> jpg<br />
  <b>Recommended image width: </b> 768 px
</p>
<br>
<form action="" method="post" enctype="multipart/form-data">
  <table>
    <tr>
      <td class="label"><label for="file">Select Image:</label></td>
      <td>
        <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
        <input type="file" name="file" id="file" size="25" />
        <input type="submit" name="upload_panorama" value="Upload Image" />
      </td>
    </tr>
  </table>
</form>
<br />
<hr />


<h2>Update Website Background</h2>
<img src="../conferences/{STR CONFERENCE_URL}/images/bcg.png" height="200" alt="" border="0" />
<p>
  Please, select a file to upload from your computer.<br />
  <b>Allowed file type: </b> png<br />
</p>
<br>
<form action="" method="post" enctype="multipart/form-data">
  <table>
    <tr>
      <td class="label"><label for="file">Select Image:</label></td>
      <td>
        <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
        <input type="file" name="file" id="file" size="25" />
        <input type="submit" name="upload_bcg" value="Upload Image" />
      </td>
    </tr>
  </table>
</form>
<br />
<hr />


<h2>Update Website Favicon</h2>
<img src="../conferences/{STR CONFERENCE_URL}/images/favicon.ico" alt="" border="0" />
<p>
  Please, select a file to upload from your computer.<br />
  <b>Allowed file type: </b> ico<br />
  <b>Required image dimensions: </b> 16x16 px
</p>
<br>
<form action="" method="post" enctype="multipart/form-data">
  <table>
    <tr>
      <td class="label"><label for="file">Select Image:</label></td>
      <td>
        <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
        <input type="file" name="file" id="file" size="25" />
        <input type="submit" name="upload_favicon" value="Upload Image" />
      </td>
    </tr>
  </table>
</form>
<br />
<hr />


<h2>Update Website Colors</h2>
<p>
  The form below will allow you to customize website colors. Please, fill in the color name, or HEX value.
</p>
<br>
<form action="" method="post">
  <table style="width: auto;">
    <tr>
      <td class="label"><label for="app_body_background">Body Background:</label></td>
      <td>
        <input type="text" name="app_body_background" id="app_body_background" size="6" value="{STR APP_BODY_BACKGROUND}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_BODY_BACKGROUND}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_body_text">Body Text Color:</label></td>
      <td>
        <input type="text" name="app_body_text" id="app_body_text" size="6" value="{STR APP_BODY_TEXT}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_BODY_TEXT}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_main_background">Main Background:</label></td>
      <td>
        <input type="text" name="app_main_background" id="app_main_background" size="6" value="{STR APP_MAIN_BACKGROUND}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_MAIN_BACKGROUND}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_lines_top">Line Color #1:</label></td>
      <td>
        <input type="text" name="app_lines_top" id="app_lines_top" size="6" value="{STR APP_LINES_TOP}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_LINES_TOP}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_lines_bottom">Line Color #2:</label></td>
      <td>
        <input type="text" name="app_lines_bottom" id="app_lines_bottom" size="6" value="{STR APP_LINES_BOTTOM}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_LINES_BOTTOM}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_h2_line">Title Underline Color:</label></td>
      <td>
        <input type="text" name="app_h2_line" id="app_h2_line" size="6" value="{STR APP_H2_LINE}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_H2_LINE}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_a_link">Hyperlink Color:</label></td>
      <td>
        <input type="text" name="app_a_link" id="app_a_link" size="6" value="{STR APP_A_LINK}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_A_LINK}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_a_hover">Hyperlink Hover Color:</label></td>
      <td>
        <input type="text" name="app_a_hover" id="app_a_hover" size="6" value="{STR APP_A_HOVER}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_A_HOVER}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_table_1">Table Cell #1:</label></td>
      <td>
        <input type="text" name="app_table_1" id="app_table_1" size="6" value="{STR APP_TABLE_1}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_TABLE_1}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_table_2">Table Cell #2:</label></td>
      <td>
        <input type="text" name="app_table_2" id="app_table_2" size="6" value="{STR APP_TABLE_2}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_TABLE_2}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_table_head">Table Header:</label></td>
      <td>
        <input type="text" name="app_table_head" id="app_table_head" size="6" value="{STR APP_TABLE_HEAD}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_TABLE_HEAD}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_table_head_text">Table Header Text:</label></td>
      <td>
        <input type="text" name="app_table_head_text" id="app_table_head_text" size="6" value="{STR APP_TABLE_HEAD_TEXT}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_TABLE_HEAD_TEXT}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_table_border">Table Border:</label></td>
      <td>
        <input type="text" name="app_table_border" id="app_table_border" size="6" value="{STR APP_TABLE_BORDER}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_TABLE_BORDER}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_menu_mainitem_bcg">Menu Main Item Background:</label></td>
      <td>
        <input type="text" name="app_menu_mainitem_bcg" id="app_menu_mainitem_bcg" size="6" value="{STR APP_MENU_MAINITEM_BCG}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_MENU_MAINITEM_BCG}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_menu_mainitem_bcg_hover">Menu Main Item Background Hover:</label></td>
      <td>
        <input type="text" name="app_menu_mainitem_bcg_hover" id="app_menu_mainitem_bcg_hover" size="6" value="{STR APP_MENU_MAINITEM_BCG_HOVER}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_MENU_MAINITEM_BCG_HOVER}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_menu_mainitem_text">Menu Main Item Text:</label></td>
      <td>
        <input type="text" name="app_menu_mainitem_text" id="app_menu_mainitem_text" size="6" value="{STR APP_MENU_MAINITEM_TEXT}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_MENU_MAINITEM_TEXT}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_menu_mainitem_text_hover">Menu Main Item Text Hover:</label></td>
      <td>
        <input type="text" name="app_menu_mainitem_text_hover" id="app_menu_mainitem_text_hover" size="6" value="{STR APP_MENU_MAINITEM_TEXT_HOVER}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_MENU_MAINITEM_TEXT_HOVER}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_menu_subitem_bcg">Menu Subitem Background:</label></td>
      <td>
        <input type="text" name="app_menu_subitem_bcg" id="app_menu_subitem_bcg" size="6" value="{STR APP_MENU_SUBITEM_BCG}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_MENU_SUBITEM_BCG}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_menu_subitem_bcg_hover">Menu Subitem Background Hover:</label></td>
      <td>
        <input type="text" name="app_menu_subitem_bcg_hover" id="app_menu_subitem_bcg_hover" size="6" value="{STR APP_MENU_SUBITEM_BCG_HOVER}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_MENU_SUBITEM_BCG_HOVER}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_menu_subitem_text">Menu Subitem Text:</label></td>
      <td>
        <input type="text" name="app_menu_subitem_text" id="app_menu_subitem_text" size="6" value="{STR APP_MENU_SUBITEM_TEXT}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_MENU_SUBITEM_TEXT}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_menu_subitem_text_hover">Menu Subitem Text Hover:</label></td>
      <td>
        <input type="text" name="app_menu_subitem_text_hover" id="app_menu_subitem_text_hover" size="6" value="{STR APP_MENU_SUBITEM_TEXT_HOVER}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_MENU_SUBITEM_TEXT_HOVER}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td class="label"><label for="app_menu_subitem_border">Menu Subitem Border:</label></td>
      <td>
        <input type="text" name="app_menu_subitem_border" id="app_menu_subitem_border" size="6" value="{STR APP_MENU_SUBITEM_BORDER}" />
      </td>
      <td>
        <div class="display-color" style="background: {STR APP_MENU_SUBITEM_BORDER}">&nbsp;</div>
      </td>
    </tr>
    
    <tr>
      <td colspan="3" align="center"><input type="submit" name="update_colors" value="Save Changes" /></td>
    </tr>
  </table>
</form>