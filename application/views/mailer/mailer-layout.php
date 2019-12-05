<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Global Health Alliance</title>
</head>

<body>

  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:2px solid #000000;">
    <tr>
      <td bgcolor="#F0F0F0">
        <table width="500" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">
              <div align="center"><img src="https://courses.ghahealth.com/assets/frontend/img/logo2.png" width="200" height="" /></div>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">
              <div align="center"></div>
            </td>
          </tr>
          <tr>
          <?php if (!isset($view_file) || $view_file === '') {
            show_error('View file not found');
          } else {
            $this->load->view($view_file);
          } ?>
          </tr>
          <tr>
            <td bgcolor="002147">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

</body>

</html>