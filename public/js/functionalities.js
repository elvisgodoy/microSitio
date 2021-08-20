// script close alert
$(document).ready(function () {
    $(".mi_checkbox").change(function () {
        var role = $(this).prop("checked") == true ? 1 : 0;
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/usuarios/updateRoleUser",
            data: { role: role, id: id },
            success: function (data) {
                $("#resp" + id).html(data.var);
                $("#role" + id).html(data.user);
                // la pantalla al ser pequeñas las columnas se convierten en hijos por ser responsive y el cambio de role no se ve ejemplificado en pantalla si no se recarla la pantalla
                // location.reload();
                // $(".child").load("/resources/views/auth/login.login .child li");
            },
        });
    });

    // boton para abrir y cerrar sidebar
    $("#menu-toggle").on("click", function () {
        $("#content-wrapper").toggleClass("toggled");
    });

    // modal informacion
    $(document).on("click", "#btnModalInfo", function () {
        var empresa = $(this).data("emp");
        var correo = $(this).data("ema");
        var sitio = $(this).data("web");
        $("#ruta").attr("href", sitio);
        $("#empresa").text(empresa);
        $("#correo").text(correo), $("#sitio").text(sitio);
    });

    // mostrar logo/foto
    (function () {
        function filePreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $("#imagePreview").html(
                        "<img src='" + e.target.result + "' width='100'/>"
                    );
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#photo").change(function () {
            filePreview(this);
        });
    })();
});

//modal borrar
var urlname = window.location.protocol + "//" + window.location.host;
function showModalDeleteJs(id, name, goToFunction) {
    document.getElementById("modalDelete").innerHTML = `
    <div class="modal fade" id="modal_show_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content ">
                <div class="modal-body bg-gray centerf">
                    <h5>Seguro que decea eliminar el registro <b>${name}</b></h5>
                </div>
                <div class="modal-footer centerf">
                    <a type="button" class="btn btn-danger" data-dismiss="modal">No, cerrar</a>
                    <a type="button" href="${urlname}${goToFunction}${id}"  class="btn btn-success">Si, Eliminar</a>
                </div>
            </div>
        </div>
    </div>
    `;

    $("#modal_show_delete").modal("show");
}

// funcion para agregar nueva empresa
function add_new_type(combo, empresa, url, myModal) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    if (empresa.value != "") {
        $.ajax({
            type: "POST",
            url: url,
            data: "name=" + empresa.value,
            success: function (data) {
                $(combo).html(data);
            },
        });
        empresa.value = "";
        $(myModal).modal("hide");
    }
}
