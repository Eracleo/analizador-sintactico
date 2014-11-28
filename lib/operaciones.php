<?php 
/**
* Operaciones
*/
function imprimirArray($array,$separador="<br />")
{
    foreach ($array as $key => $value)
    {
        echo "$value $separador";
    }
}
 ?>