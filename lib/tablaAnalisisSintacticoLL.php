<?php 
/**
* Tabla de analisis sintactico LL
*/
class TablaAnalisisSintacticoLL
{
    private $tablaLL = array();
    private $terminales = array();
    private $cadena = "$";
    private $pila = "$";
    private $aceptado = 0;
    private $axioma = "";
    private $mensaje = array();

    public function setTablaLL($tablaLL)
    {
        $this->tablaLL = $tablaLL;
    }
    public function setCadena($cadena)
    {
        $this->cadena = $cadena."$";
    }
    public function setTerminales($terminales)
    {
        $this->terminales = $terminales;
    }
    public function setAxioma($axioma)
    {
        $this->axioma = $axioma;
    }
    public function getPila($pila)
    {
        $this->pila = $pila."$";
    }
    public function getEstado()
    {
        return $this->aceptado;
    }
    public function getMensaje()
    {
        return $this->mensaje;
    }
    public function generar()
    {
        // Elegir el Primero
        $this->pila = $this->axioma."$";

        $this->aceptado = 1;
        $i = 0;
        while(strlen($this->pila)>1 and $this->aceptado != 0)
        {
            if($this->pila['0'] != $this->cadena['0'])
            {
                if($this->pila['0']=='3') // Cuando es Vacio
                {
                    $this->mensaje[$i]['pila'] = $this->pila;
                    $this->mensaje[$i]['cadena'] = $this->cadena;
                    $this->mensaje[$i]['accion'] = "VACIO";
                    $this->pila = substr($this->pila,1,strlen($this->pila));
                } else 
                {
                    if(isset($this->tablaLL[$this->pila['0']][$this->cadena['0']]))
                    {
                        $regla = $this->tablaLL[$this->pila['0']][$this->cadena['0']];
                        if($regla != 'error')
                        {
                            $this->mensaje[$i]['pila'] = $this->pila;
                            $this->mensaje[$i]['cadena'] = $this->cadena;
                            $this->mensaje[$i]['accion'] = $regla;
                            $this->pila = substr($regla,2,strlen($regla)).substr($this->pila,1,strlen($this->pila));
                        } else{
                            $this->mensaje[$i]['pila'] = $this->pila;
                            $this->mensaje[$i]['cadena'] = $this->cadena;
                            $this->mensaje[$i]['accion'] = 'ERROR';
                            $this->aceptado = 0;
                        }
                    }else{
                        $this->aceptado = 0;
                    }
                }
            } else {
                $this->mensaje[$i]['pila'] = $this->pila;
                $this->mensaje[$i]['cadena'] = $this->cadena;
                $this->mensaje[$i]['accion'] = 'COENCIDEN';
                $this->pila = substr($this->pila,1,strlen($this->pila));
                $this->cadena = substr($this->cadena,1,strlen($this->cadena));
            }
            $i++;
        }
        if(strlen($this->cadena)>1)
            $this->aceptado = 0;

    }
}
 ?>