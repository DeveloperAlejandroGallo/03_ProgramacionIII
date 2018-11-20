DELIMITER $$
create procedure getComprasUsuarios
(
	id_usuario varchar(30)
)
begin

	select * from usuarios u
	inner join compras c on c.idUsuario = u.email
	inner join productos p on p.id = c.idProducto
	where u.email = id_usuario;

end$$