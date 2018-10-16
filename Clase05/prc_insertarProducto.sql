create procedure insertarProducto
(

	vNombre varchar(30) ,
    vPrecio float(17,2) ,
    vTamanio int 
)
begin


	insert into productos (pNombre, Precio, Tamanio) 
    values (vNombre, vPrecio, vTamanio);

end