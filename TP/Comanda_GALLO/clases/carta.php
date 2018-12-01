<?php

class carta
{
	public $id;
 	public $descripcion;
  	public $precio;
	public $sector;
    

	public function verificarArticulo($id)
	{

    $retorno = false;    
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
    $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM carta WHERE id=? ");
    $consulta->execute(array($id));
    $resultado = $consulta->fetchObject('carta'); 
    
    if($resultado != null){
              
        $retorno= true;
    }      

    return $retorno;
    }



	public function InsertarUno()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
                $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into carta (id,descripcion,precio,sector)values(:id,:descripcion,:precio,:sector)");
                $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
                $consulta->bindValue(':descripcion',$this->descripcion, PDO::PARAM_INT);
				$consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
                $consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
               	$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();                       	

	 }


  	public function BorrarId($id)
	 {
	 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from carta 				
				WHERE id=:id");	
				$consulta->bindValue(':id',$id, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
	 }

	
	public function ModificarUno()
	 {

			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update carta 
				set precio='$this->precio'				
				WHERE id='$this->id'");
			return $consulta->execute();

	 }
    
      

  	public static function TraerTodosLosArticulos()
	{   
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM carta");
			$consulta->execute();			
            return  $consulta->fetchAll(PDO::FETCH_CLASS, "carta");           
              
    }	

	public function CalcularImporte($id,$cant)
	{

		$precio = null;
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM carta WHERE id=?");
		$consulta->execute(array($id));			
		$articulo= $consulta->fetchObject('carta');

		if($articulo !=null){

			$precio= $articulo->precio * $cant;
		}
		return $precio;

	}

	public function obtenerPrecio($id)
	{

		$precio = null;
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT precio FROM carta WHERE id=?");
		$consulta->execute(array($id));			
		$articulo = $consulta->fetch(PDO::FETCH_ASSOC);

		if($articulo !=null){

			$precio= $articulo['precio'];
		}
		return $precio;

	}

}




?>