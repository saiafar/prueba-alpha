<?php

foreach($clases as $clase){
    echo "\n \e[0;32mClase: \e[0m".$clase->nombre." | ".$clase->ponderacion."/5";
}

foreach($examenes as $examen){
    echo "\n \e[0;34mExamen: \e[0m".$examen->nombre." | ".$examen->descripcion;
}

?>