@extends ('inicio')
@section('contenido')

<div class="resultado">
    <h4> Acción: {{$rsidata['simbolo']}} </h4>
    <h4> Valor relativo: {{$rsidata['accion']}} </h4>
    <h4> {{$rsidata['comentario']}} </h4>
    <img src="../img/{{$rsidata['status']}}.png" alt="">
    
</div>

@endsection
<script>
    

</script>