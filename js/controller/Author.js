hotlibrary.controller('Author',function ($scope,authorAPI,authors){
  var init = function () {
    $scope.Page = {title:'Hotlibrary - Autores'};
    $scope.register = _register;
    $scope.authors = authors.data;
    $scope.setOrder = _setOrder;
  }

  var _setOrder = function () {
    $scope.order = !$scope.order;
  }

  var _register = function (author, event) {

    if ($scope.form.$valid) {
      $scope.registration = true;

      authorAPI.save(author).then(
        function success (response) {
          if (response.data.result) {
            options = {type:'success',msg:'Autor(a) Cadastrado com sucesso'};

            // recarrega a listagem de autores
            authorAPI.getAll().then(function (response) {
              $scope.authors = response.data;
            });
          } else {
            options = {type:'danger',title:'Ops!',msg:'Problemas ao cadastrar autor(a)'};
          }

          $scope.$emit('alert',options);
          delete $scope.author;
          $scope.form.$setPristine();
          $scope.registration = false;
        }, function error (response) {
          $scope.$emit('alert',{type:'warning',title:'Ops!',msg:'Problemas para se conectar ao servidor, tente novamente mais tarde'});
          $scope.registration = false;
        }
      );
    }
  }

  init();
});
