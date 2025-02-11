
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/estilos.css')}}">
    <title>Inversionito</title>
</head>
<body>
    <div class="titulo">
        <h4>I N V E R S I O N I T O</h4>
        <h6> ANALIZADOR DE VALOR RELATIVO DE ACCIONES</h6>
    </div>
    <div class="encabezado">
    <div class="banner"> <img src="../img/inversionito.jpg" alt=""></div>
    </div>
    <form class="formu" id="myForm" action="" method="get" >
    <input type="text" class="form-control" id="accion" name="nombre" placeholder="Simbolo de la accion"> </input>
    <button id="buscar" type="submit" class="btn btn-primary" value=''>Buscar</button>
    </form>

    @yield ('contenido')

    <script>
        const form= document.getElementById("myForm");
        const input =document.getElementById("accion");

        form.addEventListener ("submit",function (e){
            e.preventDefault();
            const valore=input.value;
            valor=valore.toUpperCase();
            form.action= "/stock/"+encodeURIComponent(valor);
            form.submit();
            console.log (valor);
        } );
        
    </script>
</body>
</html>