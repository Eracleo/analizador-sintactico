<?php 
/**
* Construir la TablaLL
*/
class TablaLL
{
    private $primero = array();
    private $siguiente = array();
    private $terminales = array();
    private $noTerminales = array();
    private $tabla = array();
    private $reglas = array();

    public function setPrimero($primero)
    {
        $this->primero = $primero;
    }
    public function setSiguiente($siguiente)
    {
        $this->siguiente = $siguiente;
    }
    public function setTerminales($terminales)
    {
        $this->terminales = $terminales;
    }
    public function setNoTerminales($noTerminales)
    {
        $this->noTerminales = $noTerminales;
    }
    public function setReglas($reglas)
    {
        $this->reglas = $reglas;
    }
    public function getTabla()
    {
        return $this->tabla;
    }
    public function generar()
    {
        foreach ($this->noTerminales as $noTerminales => $noTerminalesValue)
        {
            foreach ($this->terminales as $terminales => $terminalesValue)
            {
                /**
                * 3. Las celdas vacias o no usadas son consideradas como errores
                */
                $this->tabla[$noTerminales][$terminales] = "error";
            }
            $this->tabla[$noTerminales]["$"] = "error";
        }
        foreach ($this->primero as $key => $primero)
        {
            for ($i=0; $i < strlen($primero) ; $i++)
            {
                if(isset($this->noTerminales[$key]))
                {
                    if(!$this->estaCharEnCadena('3',$primero[$i]))
                    {
                        /**
                        * 1. Para cada termina a en Primero(A) agregar
                        * la produción A->c á tabla[A,a]
                        */
                        $this->tabla[$key][$primero[$i]] = $this->producion($key,$primero[$i]);
                    } else {
                        if($this->estaCharEnCadena('$',$this->siguiente[$key]))
                        {
                            /**
                            * 2.1 Si 3 esta en primero(A) y $ en siguiente(A) ENTONCES
                            * se agrega A->3 a tabla[A,$]
                            */
                            $this->tabla[$key]['$'] = $key.substr($this->reglas['0'], 1,1)."3";
                        } else {
                            /**
                            * 2. Si 3 esta en primero(alfa), ENTONCES para cada 
                            * terminal b en siguiente(A) se AGREGA A->alfa a tabla[a,b]
                            */
                            $temp = $this->siguiente[$key];
                            for ($j=0; $j < strlen($this->siguiente[$key]) ; $j++)
                            {
                                $this->tabla[$key][$temp[$j]]=$key.substr($this->reglas['0'], 1,1)."3";
                            }
                        }
                    }
                }
            }
        }
    }
    public function producion($noTerminal,$terminal)
    {
        $temp = "";
        foreach ($this->reglas as $key => $regla)
        {
            if($noTerminal == $regla['0'])
            {
                if($this->estaCharEnCadena($terminal,$regla))
                    return $regla;
                else
                    $temp = $regla;
            }
        }
        return $temp;
    }
    private function estaCharEnCadena($char,$cadena)
    {
        for ($j=0; $j < strlen($cadena) ; $j++)
        {
            if($char == $cadena[$j])
            {
                return 1;
            }
        }
        return 0;
    }
}
 ?>