update mesas 
set estado = 'con cliente esperando pedido'			
WHERE id = 6;

update pedidos
set estado = 'listo para servir'
where codigo = '3H11K';


select * from mesas