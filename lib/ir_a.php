<?php 
include 'clausura.php';
/**
* IR_A - Analizador sintáctico LR
*/
class Ir_A
{
    private $items = array();
    private $reglas = array();
    public function setItems($items = array())
    {
        $this->items = $items;
    }
    public function setReglas($reglas = array())
    {
        $this->reglas = $reglas;
    }
    public function ir($simbolo)
    {
        $ira = array();
        $temp = "";
        foreach ($this->items as $key => $value)
        {
            $temp = $this->moverPunto($simbolo,$value);
            if($value != $temp)
            {
                $ira[$temp] = 1;
            }
        }
        // Aplicar clausura
        if(count($ira)>0)
        {
            $cc = array();
            foreach ($ira as $key => $value)
            {
                $cc[] = $key;
            }
            $cerradura = new Clausura;
            $cerradura->setReglas($this->reglas);
            $cerradura->setItems($cc);
            $cerradura->clausura();

            return $cerradura->getCerradura();
        }
        return array();
    }
    public function moverPunto($simbolo,$cadena)
    {
        for ($i=2; $i < strlen($cadena); $i++)
        {
            if($cadena[$i]=='.')
            {
                if(strlen($cadena)>($i+1))
                {
                    if($cadena[$i+1] == $simbolo)
                    {
                        // Intercambiar
                        $cadena[$i] = $cadena[$i+1];
                        $cadena[$i+1] = '.';
                    }
                }
                break;
            }
        }
        return $cadena;
    }

}


 ?>