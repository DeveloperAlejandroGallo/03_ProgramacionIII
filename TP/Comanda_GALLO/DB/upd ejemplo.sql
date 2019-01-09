update mesas 
set estado = 'con cliente esperando pedido'			
WHERE id = 6;

update pedidos
set estado = 'listo para servir'
where codigo = '3H11K';


select * from mesas

select 
'Total Facturado' titulo,
sum(p.importe * p.cantidad) total
from pedidos p 
where p.horaFin is not null
and p.horaInicio >= '2018-12-03 22:20:00' and p.horaFin <= '2018-12-04 03:20:00'



select p.importe, p.cantidad, p.importe * p.cantidad tot from pedidos p where p.horaFin is not null