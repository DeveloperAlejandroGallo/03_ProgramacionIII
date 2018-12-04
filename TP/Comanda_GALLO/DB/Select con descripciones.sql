select
p.id
,p.codigo
,m.codigo mesa
,c.descripcion articulo
,e.nombre empleado
,p.cliente
,p.cantidad
,p.importe
,p.foto
,p.estado
,p.estimado
,p.horaInicio
,p.horaFin
from mesas m 
inner join pedidos p on p.idMesa = m.id
inner join carta c on p.idArticulo = c.id
left join empleados e on p.idEmpleado = e.id