<?php
$codprop = $_GET['cod'];
?>
<script>
    $("#formdesp").submit(function (e) {
        e.preventDefault();        

        var f = $(this);
        var formData = new FormData(document.getElementById("formdesp"));
        formData.append("accion", "DespachoAdjunto");

        $.ajax({
            url: "../controller/C_Propuestas.php",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        })
                .done(function (res) {
                    $("#result").html(res);
                });
    });
</script>

<form id="formdesp" name="formdesp" action="#" method="post" enctype="multipart/form-data">
    <div class="col-lg-6" id="result" style="background-color: whitesmoke; padding-top: 10px; padding-bottom: 10px;">
        <input type="file" name="nomarchivo" value="" />     <br/>
        <input type="hidden" name="codprop" value="<?php echo trim($codprop); ?>" /> 
        <input type="submit" value="Subir" class="btn btn-primary btn-sm" />
    </div>    
</form>

