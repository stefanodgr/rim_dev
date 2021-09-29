<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></meta>
      
      <!-- -------------------------------- INCLUSIÓN DE SCRIPTS -------------------------------- -->
      <script type="text/javascript">
        $('#id_inp_usuario').focus();
      </script>
      <!-- -------------------------------------------------------------------------------------- -->
      
  </head>
  <body>
    <div id='box_content'>
      <div id='box_login' class='back_log'>
        <div id='box_datos'>
          <div class='div_login_inp'>
            <div class='div_login_ico ico_user'></div>
            <input type="text" id="id_inp_usuario" class='inp_login' placeholder="Usuario" value='hgonzalez7'>
          </div><br>
          <div class='div_login_inp'>
            <div class='div_login_ico ico_password'></div>
            <input type="password" id="id_inp_password" class='inp_login' placeholder="Contraseña" value='123456'>
          </div>
          <div class='div_login_inp' style="display:none;">
            <div class='div_login_ico ico_passnew'></div>
            <input type="password" id="id_inp_passnew" class='inp_login' placeholder="Repita la contraseña">
          </div>
          <div id='div_error'>
            <label id='id_lbl_error' class="">
              <br>
              <font id='id_txt_error'></font>
              <br>
            </label>
          </div>
          <div class='btn_lg' id='btn_ingresar' onclick="validarLogin();"></div>
          <div class='btn_lg' id='btn_cambiar'  onclick="validarCambio();" style='display:none;'></div>
        </div>
      </div>
      <div id='div_logo_adv'></div>
      <div id='div_login_adv'>
        <p align='justify'><b>Advertencia: </b> El RIM tiene como objetivo llevar el control y registro de las detenciones e incautaciones aplicadas a usuarios involucrados en infracciones y delitos.</p>
        <p align='justify'>El mal uso de esta herramienta acarreará sanciones administrativas, por lo que se exhorta a los usuarios a no facilitar su clave personal ni hacer un uso indebido del sistema.</p>
        <p align='justify'>Al momento de ingresar al sistema usted estará aceptando las normas y sanciones que rigen el uso del mismo.</p>
      </div>
    </div>
  </body>
</html>