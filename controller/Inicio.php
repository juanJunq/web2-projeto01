<?php
class Inicio
{
  public function controller()
  {
    $inicio = new Template("view/comeco.html");
    $inicio->set("nome", "Lázaro");
    $retorno["msg"] = $inicio->saida();
    return $retorno;
  }
}