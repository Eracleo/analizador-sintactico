<?php 
/**
* IR_A - Analizador sintáctico LR
*/
class Clausura
{
    private $items = array();
    private $reglas = array();
    private $cerradura = array();

    public function setItems($items = null)
    {
        if (!is_null($items)) 
        {
            $this->items = $items;
        }
    }
    public function setReglas($reglas = null)
    {
        if (!is_null($reglas)) 
        {
            $this->reglas = $reglas;
        }
    }
    public function getItems()
    {
        return $this->items;
    }
    public function getCerradura()
    {
        return $this->cerradura;
    }
    public function clausura()
    {
        /**
        * 1. Todo elemento de I  se añade a Clausura(I).
        */
        $this->cerradura = array();
        foreach ($this->items as $key => $value)
        {
            $this->cerradura[$value] = 1;
        }
        /**
        * Si  A→α.Bβ  está en Clausura(I) y
        *  B→γ  es una producción, entonces añádase 
        *  el elemento B→.γ  a  Clausura(I), si aun no esta incluido. 
        * Se aplica esta regla hasta que no se pueda añadir 
        * mas elementos a Clausura(I).
        */
        $temp = array();
        foreach ($this->cerradura as $key => $value) 
        {
            for($i=2 ; $i<strlen($key) ; $i++)
            {
                if($key[$i] == '.')
                {
                    if(strlen($key)>($i + 1))
                    {
                        $temp = $this->existeProduccion($key[$i + 1]);
                        foreach ($temp as $key => $value)
                        {
                            $this->cerradura[$this->ponerPunto($key)] = 1;
                        }
                    }
                    break;
                }
            }
        }

    }
    public function ponerPunto($cadena)
    {
        $temp = $cadena['0'];
        $temp .= $cadena['1'];
        $temp .= ".";
        for($i=2 ; $i<strlen($cadena) ; $i++)
        {
            $temp .= $cadena[$i];
        }
        return $temp;
    }
    public function existeProduccion($simbolo)
    {
        $temp = array();
        foreach ($this->reglas as $key => $value)
        {
            if($value['0']==$simbolo)
            {
                $temp[$value] = 1;
            }
        }
        return $temp;
    }
    
}


 ?>