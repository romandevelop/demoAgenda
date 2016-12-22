<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>lib/css/materialize.min.css"  media="screen,projection"/>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a href="#test1">Nuevo</a></li>
                    <li class="tab col s3"><a  href="#test2">Contacots</a></li>

                </ul>
            </div>
            <div id="test1" class="col s12">
                <form>
                    <!--<input type="text" id="txtnombre"/>-->
                    <select id="txtnombre">
                        <option>ROMAN</option>
                        <option>PABLO</option>
                    </select>
                    <input type="text" id="txtapellido"/>
                    <input type="text" id="txtmail"/>
                    <input type="text" id="txttelefono"/>
                    <input type="submit" id="btn" class="btn" value="ok"/>
                </form>
            </div>
            <div id="test2" class="col s12">
                <table id="tabla">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Nombre</td>
                            <td>Apellido</td>
                            <td>Mail</td>
                            <td>Telefono</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="tbody">

                    </tbody>
                </table>

            </div>



            <!-- Modal Update -->
            <div id="modalupdate" class="modal">
                <div class="modal-content">
                    <h4>Actualizar</h4>
                    <div class="row">
                        <div class="col s6">
                            ID<input type="text" id="txt0" />
                        </div>
                        <div class="col s6">
                            Nombre <input type="text" id="txt1" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            Apellido <input type="text" id="txt2" />
                        </div>
                        <div class="col s6">
                            Mail <input type="text" id="txt3" />
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col s6">
                            Telefono <input type="text" id="txt4" />                   
                        </div>
                        <div class="col s6">
                            <a id="btactualizar" href="#!" class=" modal-action modal-close waves-effect waves-green btn">Actualizar</a>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                </div>
            </div>



            <!-- Modal DELETE -->
            <div id="modaldelete" class="modal">
                <div class="modal-content">
                    <h4>Eliminar</h4>
                    <p>¿Esta seguro de eliminar el registro?</p>
                    <input type="hidden" id="iddelete">
                </div>
                <div class="modal-footer">
                    <a id="bteliminar" href="#!" class=" modal-action modal-close waves-effect waves-green btn">
                        Eliminar
                    </a>
                </div>
            </div>

        </div>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>lib/js/materialize.min.js"></script>
        <script type="text/javascript">
            $(function () {
                $('ul.tabs').tabs();
                $('.modal').modal();
                $('select').material_select();
                verContactos();

                //__________INSERTAR___________
                $("#btn").click(function (e) {
                    e.preventDefault();
                    var nombre = $("#txtnombre").val();
                    var apellido = $("#txtapellido").val();
                    var mail = $("#txtmail").val();
                    var telefono = $("#txttelefono").val();
                    $.ajax({
                        url: '<?php echo site_url() ?>/inserta',
                        type: 'POST',
                        dataType: 'json',
                        data: {"nombre": nombre, "apellido": apellido,
                            "mail": mail, "telefono": telefono}
                    }).success(function (o) {
                        alert(o.msg);
                        verContactos();
                    }).fail(function () {
                        alert("error");
                    });
                });
                //EVENTO CLIC DEL BOTON CIRCULO EDIT Y DELETE
                $("body").on("click", "#edit", function (e) {
                    e.preventDefault();
                    //SE OBTIENEN LOS DATOS DEL BOTON
                    var datos = $(this).val();
                    var fila = datos.split(",");
                    $("#txt0").val(fila[0]);
                    $("#txt1").val(fila[1]);
                    $("#txt2").val(fila[2]);
                    $("#txt3").val(fila[3]);
                    $("#txt4").val(fila[4]);
                    $("#modalupdate").modal('open');
                });

                $("body").on("click", "#delete", function (e) {
                    e.preventDefault();
                    //SE OBTIENEN LOS DATOS DEL BOTON
                    $("#iddelete").val($(this).val());
                    $("#modaldelete").modal('open');
                });

                //ELIMINAR A UN CONTACTO
                $("#bteliminar").on("click", function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: '<?php echo site_url() ?>/elimina',
                        type: 'post',
                        dataType: 'json',
                        data: {"id": $("#iddelete").val()}
                    }).success(function (e) {
                        verContactos();
                    });
                });
                //ACTUALIZAR A UN CONTACTO
                $("#btactualizar").on("click", function (e) {
                    e.preventDefault();
                    var id = $("#txt0").val();
                    var nombre = $("#txt1").val();
                    var apellido = $("#txt2").val();
                    var mail = $("#txt3").val();
                    var telefono = $("#txt4").val();
                    $.ajax({
                        url: '<?php echo site_url() ?>/actualiza',
                        type: 'post',
                        dataType: 'json',
                        data: {"id": id, "nombre": nombre, "apellido": apellido,
                            "mail": mail, "telefono": telefono}
                    }).success(function (o) {
                        verContactos();
                    });
                });


                //_______________FUNCION VER CONTACTOS_____________

                function verContactos() {
                    var url = "<?php echo site_url() ?>/ver";
                    $("#tbody").empty();
                    $.getJSON(url, function (result) {
                        $.each(result, function (i, o) {
                            var fila = "<tr><td>" + o.id + "</td>";
                            fila += "<td>" + o.nombre + "</td>";
                            fila += "<td>" + o.apellido + "</td>";
                            fila += "<td>" + o.mail + "</td>";
                            fila += "<td>" + o.telefono + "</td>";
                            fila += '<td> <button id="edit" value="' + o.id + "," + o.nombre + "," + o.apellido + "," + o.mail + "," + o.telefono + '" class="btn-floating btn-large waves-effect waves-light blue"><i class="material-icons">edit</i></button>';
                            fila += ' <button id="delete" value="' + o.id + '" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">delete</i></button></td></tr>';
                            $("#tbody").append(fila);
                        });
                    });
                }
            });
        </script>

    </body>
</html>


















