<?php
class Form
{
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    $form = new Template("view/form.html");
    $form->set("id", "");
    $form->set("emissor", "");
    $form->set("receptor", "");
    $form->set("mensagem", "");
    $retorno["msg"] = $form->saida();
    return $retorno;
  }

  public function salvar()
  {
    if (isset($_POST["emissor"]) && isset($_POST["receptor"]) && isset($_POST["mensagem"])) {
      try {
        $conexao = Transaction::get();
        $emissor = $conexao->quote($_POST["emissor"]);
        $receptor = $conexao->quote($_POST["receptor"]);
        $mensagem = $conexao->quote($_POST["mensagem"]);
        $crud = new Crud();
        if (empty($_POST["id"])) {
          $retorno = $crud->insert(
            "mensagens",
            "emissor,receptor,mensagem",
            "{$emissor},{$receptor},{$mensagem}"
          );
        } else {
          $id = $conexao->quote($_POST["id"]);
          $retorno = $crud->update(
            "mensagens",
            "emissor={$emissor}, receptor={$receptor}, mensagem={$mensagem}",
            "id={$id}"
          );
        }
      } catch (Exception $e) {
        $retorno["msg"] = "Ocorreu um erro! " . $e->getMessage();
        $retorno["erro"] = TRUE;
      }
    } else {
      $retorno["msg"] = "Preencha todos os campos! ";
      $retorno["erro"] = TRUE;
    }
    return $retorno;
  }

  public function __destruct()
  {
    Transaction::close();
  }
}