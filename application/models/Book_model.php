<?php defined('BASEPATH') OR exit('No direct script access allowed');


  /**
   * Essa classe representa a relação Book da base dados.
   * @author Caio de Freitas Adriano
   * @since 2017/11/02
   */
  class Book_model extends CI_Model {

    /**
     * "Remove" todas as relações entre o livro e seus autores
     * @author Caio de Freitas Adriano
     * @since 2017/11/07
     * @param Object - Objeto Book com os dados do livro
     * @return Boolean - retorna true caso a remoção ocorra com sucesso.
     */
    public function clearAuthor($book){
      $this->db->set('deleted',true);
      $this->db->where('book',$book->id);
      $this->db->update('Book_Author');
    }

    /**
     * Remove todos as relações entre o livro e suas categorias
     * @author Caio de Freitas Adriano
     * @since 2017/11/07
     * @param Object - Objeto Book com os dados do livro
     * @return Boolean - Retorna um boolean true caso a remoção ocorra com sucesso
     */
    public function clearCategory($book){
      $this->db->set('deleted',true);
      $this->db->where('book',$book->id);
      $this->db->update('Book_Category');
    }

    /**
     * Atualiza os dados do livro no banco de dados
     * @author Caio de Freitas Adriano
     * @since 2017/11/07
     * @param Object - Objeto Book com os novos dados do livro
     * @return Boolean - Retorna um true caso os dados sejam atulizado com sucesso
     */
    public function update($book) {
      $this->db->where('id',$book->id);
      return $this->db->update("Book",$book);
    }

    /**
     * altera o status "deleted" do livro no banco de dados
     * @author Caio de Freitas Adriano
     * @since 2017/11/06
     * @param Int - ID do livro
     * @param Boolean - novo valor do atributo "deleted".
     * @return Boolean - Retorna true caso o valor seja alterado.
     */
    public function setDeleted($id,$value) {
      $this->db->set('deleted',$value);
      $this->db->where('id',$id);
      return $this->db->update('Book');
    }

    /**
     * Verifica se existe releções entre o livro informado com alguma biblioteca.
     * @author Caio de Freitas Adriano
     * @since 2017/11/06
     * @param Int - ID do livro
     * @return Boolean - Retorna true caso exista algum relacionamento.
     */
    public function hasLibrary($book) {
      $this->db->where("book",$book);
      $query = $this->db->get("Library_has_Book");
      return ($query->num_rows() >= 1) ? true : false;
    }

    /**
     * Busca todos os autores de um livro
     * @author Caio de Freitas Adriano
     * @since 2017/11/06
     * @param Object - Objeto Book com os dados do livro
     * @return Array - Retorna um vetor com objetos author
     */
    public function getAuthors($book) {
      $this->db->select("Author.*");
      $this->db->join('Author','Book_Author.author = Author.id');
      $this->db->where('book',$book->id);
      $this->db->where('Book_Author.deleted',false);
      return $this->db->get("Book_Author")->result();
    }

    /**
     * Busca todas as bibliotecas relacinadas com um livro.
     * @author Caio de Freitas Adriano
     * @since 2017/11/12
     * @param Object - Objeto Book com os dados do livro
     * @return Array - Retona um vetor de objetos Library com os dados das
     * bibliotecas.
     */
    public function getLibraries($book){
      $this->db->select('User.*');
      $this->db->join('Library','Library.id = Library_has_Book.library');
      $this->db->join('User','User.id = Library.id');
      $this->db->where('Library_has_Book.book',$book->id);
      $this->db->where('Library_has_Book.deleted',false);
      return $this->db->get('Library_has_Book')->result();
    }

    /**
     * Busca todas as categorias de um livro.
     * @author Caio de Freitas Adriano
     * @since 2017/11/06
     * @param Object - Objeto book com os dados do livro
     * @return Array - Retorna um vetor com objetos category com os dados da categoria
     */
    public function getCategories($book) {
      $this->db->select('Category.*');
      $this->db->join('Category','Category.id = Book_Category.category');
      $this->db->where('book',$book->id);
      $this->db->where('Book_Category.deleted',false);
      return $this->db->get("Book_Category")->result();
    }

    /**
     * busca um livro no banco de dados.
     * @author Caio de Freitas Adriano
     * @since 2017/11/06
     * @param Int - ID do livro
     * @return Object - Retorna um objeto com os dados do livro
     */
    public function getById($id) {
      $this->db->where('id',$id);
      $this->db->where('deleted',false);
      return $this->db->get("Book")->row();
    }

    /**
     * Busca todos os livros cadastrados no banco de dados
     * @author Caio de Freitas Adriano
     * @since 2017/11/02
     * @return Array - Retorna um vetor com objetos Book com os dados dos livros
     */
    public function getAll () {
      $this->db->where("deleted",false);
      return $this->db->get("Book")->result();
    }

    /**
     * faz o vinculo da categoria ao livro.
     * @author Caio de Freitas Adriano
     * @since 2017/11/02
     * @param Object - Objeto Book com os dados do livro
     * @param Object - Objeto category com os dados da categoria
     * @return Boolen - Retorna true caso o objeto sejá persistido com sucesso.
     */
    public function setCategory($book,$category) {
      $data = new stdClass();
      $data->book = $book->id;
      $data->category = $category->id;
      return $this->db->insert("Book_Category",$data);
    }

    /**
     * Faz os vinculo do autor ao livro no banco de dados.
     * @author Caio de Freitas Adriano
     * @since 2017/11/02
     * @param Object - objeto book os dados do livro.
     * @param Object - Objeto author com os dados do autor.
     * @return Boolean - Retorna true caso o objeto sejá persistido com sucesso.
     */
    public function setAuthor($book,$author) {
      $data = new stdClass();
      $data->book = $book->id;
      $data->author = $author->id;
      return $this->db->insert("Book_Author",$data);
    }

    /**
     * Faz a persistencia do objeto book
     * @author Caio de Freitas Adriano
     * @since 2017/11/02
     * @param Object - Objeto book com os dados do livro.
     * @return BOOLEAN - return true caso o livro sejá persistido com sucesso
     */
    function insert($book) {
      return $this->db->insert('Book',$book);
    }
  }

?>
