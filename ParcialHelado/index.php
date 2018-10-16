<?php

$pgHeladoCarga = "HeladosCarga.php";
$pgHeladoConsulta = "ConsultarHelado.php";
$pgHeladoVenta = "AltaVenta.php";

echo "
<button id='btnHeladoCarga'>Carga</button>
<button id='btnHeladosConsulta'>Consulta</button>
<button id='btnHeladoVenta'>Venta</button>
<script>
  var btnCarga = document.getElementById('btnHeladoCarga');
  btnCarga.addEventListener('click', function() {
    document.location.href = '". $pgHeladoCarga . "';
  });

  var btnConsulta = document.getElementById('btnHeladosConsulta');
  btnConsulta.addEventListener('click', function() {
    document.location.href = '". $pgHeladoConsulta . "';
  });

  var btnVenta = document.getElementById('btnHeladoVenta');
  btnVenta.addEventListener('click', function() {
    document.location.href = '". $pgHeladoVenta . "';
  });
</script> ";

?>