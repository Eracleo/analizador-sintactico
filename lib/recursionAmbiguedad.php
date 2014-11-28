<?php 
/**
* Analizador Lexico
*/
class RecursionAmbiguedad
{
    private $reglas = array();

    public function setReglas($pReglas = null)
    {
        if(is_array($pReglas))
        {
            $this->reglas = $pReglas;
        } 
        return $this;
    }
    public function getReglas()
    {
        return $this->reglas;
    }
    /**
    * Es recursivo una regla
    */
    private function esRecursivo($regla)
    {
        if($regla['0']==$regla['2'])
            return 1;
        else
            return 0;
    }
    /**
    * Existe la recurcion en un conjunto de reglas
    */
    public function hayRecurrencia()
    {
        foreach ($this->reglas as $regla) 
        {
            if($this->esRecursivo($regla))
                return $regla['0'];
        }
        return null;
    }
    private function generarNuevoSimbolo($char)
    {
        $ascii = ord($char);
        if($ascii < 90)
        {
            return chr($ascii + 1);
        } else {
            return chr($ascii - 10);
        }
    }
    /**
    * Eliminar La recursividad
    */
    public function sinRecursion()
    {
        $recurrente = $this->hayRecurrencia();
        $reglasSinR = array();
        $reemplazaRecurrente = $this->generarNuevoSimbolo($recurrente);
        foreach ($this->reglas as $key => $regla)
        {
            if($regla['2']==$recurrente) // Parte 
            {
                $reglasSinR[$key] = $reemplazaRecurrente."=".substr($regla, 3,strlen($regla)).$reemplazaRecurrente;
            } else { // Parte no recursivo
                if($recurrente == $regla['0'] )
                {
                    $reglasSinR[$key] = $regla.$reemplazaRecurrente;
                } else {
                    $reglasSinR[$key] = $regla;
                }

            }
        }
        if(!is_null($recurrente))
            $reglasSinR[] = $reemplazaRecurrente.'=3';
        return $reglasSinR;
    }
    public function hayAmbiguedad()
    {
        return 0;
    }
    public function sinAmbiguedad()
    {
        return 1;
    }
}

 ?>