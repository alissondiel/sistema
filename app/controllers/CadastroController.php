<?php
class CadastroController extends \HXPHP\System\Controller
{
  //teste
  public function __construct($configs)
  {
    parent::__construct($configs);
    $this->load(
      'Services\Auth',
      $configs->auth->after_login,
      $configs->auth->after_logout,
      true
    );

    $this->auth->redirectCheck(true);//true = publico, false= privado(exige login);
  }

  public function cadastrarAction()
  {
      $this->view->setFile('index');
      $this->request->setCustomFilters(array(
        'email' => FILTER_VALIDATE_EMAIL
      ));
      $post = $this->request->post();
      if(!empty($post)){
        $cadastarUsuario = User::cadastrar($post);

        if($cadastarUsuario->status === false){
          $this->load('Helpers\Alert',array(
            'danger',
            'Ops! Não foi possível efetuar seu cadastro. Verifique os erros abaixo:',
            $cadastarUsuario->errors
          ));
        }
        else{
          $this->auth->login($cadastrarUsuario->user->id, $cadastrarUsuario->user->username);
        }
        //
        // var_dump($cadastarUsuario);
      }
  }
}
