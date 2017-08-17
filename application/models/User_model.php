<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Essa classe represenda a relação User do banco de dados.
 * @author Caio de Freitas Adriano
 * @since 2017/07/21
 */
class User_model extends CI_Model {

  /**
   * Insere um novo usuário na base de dados
   * @author Caio de Freitas adriano
   * @since 2017/07/23
   * @param $User Objeto usuário que será persistido no bando de dados;
   * @return Retorna um BOOLEAN TRUE caso o objeto usuário sejá persistido com sucesso.
   */
  public function insert($User) {
    return $this->db->insert("User",$User);
  }

  /**
   * Verifica se o usuário informado existe na base de dados.
   * @author Caio de Freitas
   * @since 2017/08/02
   * @param $User OBJECT: Recebe o objeto usuário com os dados do usuário.
   * @return Retorna um BOOLEAN false caso ocorra um erro no banco de dados. NULL
   * caso a query sejá executada, porêm não foi encontrado o usuário. Caso a
   * Query sejá executada com sucesso e o usuário foi encontrado, é retornado
   * um objeto com os dados do usuário.
   */
  public function exist ($User, $level) {
    $this->db->where($User);
    $this->db->where_in('level',$level);
    $query = $this->db->get('User');

    return $query->row();
  }

  /**
   * Verifica se existe o email informado existe no banco de dados.
   * @author Caio de Freitas
   * @since 2017/08/16
   * @param String $email: email do usuário
   * @return retorna um boolean true caso o email esteja cadastrado.
   */
  public function existEmail($email) {
    $this->db->where('email',$email);
    $result = $this->db->get('User')->num_rows();

    return ($result == 1) ? TRUE : FALSE;
  }
}

?>
