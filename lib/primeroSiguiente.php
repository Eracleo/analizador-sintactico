<?php 
/**
* Entoncar los Conjuntos Primero y Siguiente
*/
class PrimeroSiguiente
{
    private $reglas = array();
    private $primero = array();
    private $siguiente = array();
    private $terminales = array();
    private $noTerminales = array();
    private $axioma = "";

    public function setReglas($pReglas)
    {
        $this->reglas = $pReglas;
    }
    public function getReglas()
    {
        return $this->reglas;
    }
    public function getPrimero()
    {
        unset($this->primero['3']);
        return $this->primero;
    }
    public function getSiguiente()
    {
        return $this->siguiente;
    }
    public function getTerminales()
    {
        unset($this->terminales['3']);
        return $this->terminales;
    }
    public function getNoTerminales()
    {
        return $this->noTerminales;
    }
    public function getAxioma()
    {
        return $this->axioma;
    }
    private function eliminarDublicadosEnArray($e = 'p')
    {
        if($e=='p')
        {
            foreach ($this->primero as $key => $primero)
            {
                $this->primero[$key] = $this->eliminarDublicadosEnCadena($primero);
            }
        } else {
            foreach ($this->siguiente as $key => $siguiente)
            {
                $this->siguiente[$key] = $this->eliminarDublicadosEnCadena($siguiente);
            }
        }
    }
    private function eliminarDublicadosEnCadena($cadena)
    {
        $sinDuplicados = '';
        for ($i=0; $i < strlen($cadena) ; $i++)
        {
            if(!$this->estaCharEnCadena($cadena[$i],$sinDuplicados))
            {
                $sinDuplicados .=$cadena[$i];
            }
        }
        return $sinDuplicados;
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
    public function esTerminal($simbolo)
    {
        if(isset($this->terminales[$simbolo]))
            return 1;
        else
            return 0;
    }
    private function simbolos()
    {

        // No terminales
        foreach ($this->reglas as $key => $regla)
        {
            $this->noTerminales[$regla['0']] = $regla['0'];
            $this->primero[$regla['0']] = '#';//Primero
            $this->siguiente[$regla['0']] = '';//Siguiente
        }
        foreach ($this->reglas as $key => $regla) 
        {
            for ($i=2; $i < strlen($regla); $i++)
                if(!isset($this->noTerminales[$regla[$i]]))
                {
                    $this->terminales[$regla[$i]] = $regla[$i];
                    /**
                    * 1. Si x es un simbolo terminal entonces
                    * primero(x) = {x}
                    */
                    $this->primero[$regla[$i]] = $regla[$i];
                }
        }
    }
    public function primero()
    {
        $this->simbolos();

        foreach ($this->noTerminales as $key => $value)
        {
            /**
            * 3.1 Si X es un simbolo no terminal y X -> Y1,Y2,...,YK
            * es una producción entonces 1<=i<=k / Y1,Y2,...,YK
            * sean todos no terminales
            */
            $this->primero[$key] = $this->primeroNoTerminales($key);
        }
        $this->eliminarDublicadosEnArray();
    }
    public function primeroNoTerminales($noTerminal,$anterior="#")
    {
        if($this->primero[$noTerminal] == '#')
        {
            $primeroNoTerminal = "";
            $temp = array($noTerminal=>$noTerminal);
            foreach ($this->reglas as $key => $regla)
            {
                if($noTerminal==$regla['0'] )
                {
                    /**
                    * 3.2.- primero(Y1),primero(Y2),...,primero(Yj-1) contenga todos 3,
                    * se añade todos los simbolos no nulos de Primero(Yj) a primero(X)
                    * finalmente, si 3 está en primero(Yj)
                    * entonce se añade 3 a primero(X)
                    */
                    if(isset($this->terminales[$regla['2']]))
                    {
                        $primeroNoTerminal .= $this->primero[$regla['2']];
                    }
                    else
                    {
                        if($regla['2']!=$anterior)
                        {
                            $primeroNoTerminal .= $this->primeroNoTerminales($regla['2'],$noTerminal);
                        } else{
                            $primeroNoTerminal ="";
                        }
                    }
                    $temp[$regla['2']] = $regla['2'];
                }
            }
            return $primeroNoTerminal;
        } else 
        {
            return $this->primero[$noTerminal];
        }
    }
    public function siguiente()
    {
        $j = 1;
        $longitud = 0;
        $temp = array();
        foreach ($this->reglas as $key => $regla)
        {
            /**
            * 1. $ Está es siguiente (s) 
            * donde S es el axioma (Estado Inicial)
            */
            if($j < 2)
            {
                $this->siguiente[$regla['0']] = '$';
                $this->axioma = $regla['0'];
                $j++;
            }
            $longitud = strlen($regla);
            for ($i=2 ; $i < $longitud ; $i++)
            {
                if(isset($this->noTerminales[$regla[$i]]))
                {
                    if($longitud > ($i+1))
                    {
                        /**
                        * 2.- Si existe A->aBC ENTONCES todo lo que
                        * está en primero(C) excepto 3, esta en siguiente(B)
                        */
                        $this->siguiente[$regla[$i]] .= $this->sinVacio('3',$this->primero[$regla[$i+1]]);
                        if($this->estaCharEnCadena('3',$this->primero[$regla[$i+1]]))
                        {
                            /**
                            * 3.1.- Si existe A->aBC y primero(C) contiene 3 ENTONCES
                            * todo lo que está en siguiente(A) esta en siguiente(B)
                            */
                            $this->siguiente[$regla[$i]] .= $this->siguiente[$regla['0']];
                        }
                    } else{
                        /**
                        * 3.2.- Si existe A->aC ENTONCES todo lo que está en
                        * siguiente(A) esta en siguiente(B)
                        */
                        $this->siguiente[$regla[$i]] .= $this->siguiente[$regla['0']];
                    }
                }
            }
        }
        $this->eliminarDublicadosEnArray('s');
    }
    private function sinVacio($char,$cadena)
    {
        return str_replace($char, '', $cadena);
    }
}
 ?>