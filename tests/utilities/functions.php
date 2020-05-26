<?php


function create($class, $atributtes =[])
{
    return factory($class)->create($atributtes);
}


function make($class, $atributtes =[])
{
    return factory($class)->make($atributtes);
}