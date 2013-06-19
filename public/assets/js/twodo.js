// Generated by CoffeeScript 1.4.0
(function() {
  var App, List, Todo;

  List = function(id, title) {
    this.id = id;
    this.title = title;
    this.todos = [];
    this.show_add = false;
    this.selected = false;
    this.add_todo = function(id, title, summary, description, done) {
      if (this.todos.push(new Todo(id, title, summary, description, done))) {
        return true;
      } else {
        return false;
      }
    };
    this.show_add_view = function() {
      if (this.show_add === false) {
        this.show_add = true;
      } else {
        this.show_add = false;
      }
    };
    this.get_total_todos = function() {
      return this.todos.length;
    };
    this.get_completed_todos = function() {
      var amount, t, _i, _len, _ref;
      amount = 0;
      _ref = this.todos;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        t = _ref[_i];
        if (t.done === true) {
          amount++;
        }
      }
      return amount;
    };
    this.get_incomplete_todos = function() {
      var amount, t, _i, _len, _ref;
      amount = 0;
      _ref = this.todos;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        t = _ref[_i];
        if (t.done === false) {
          amount++;
        }
      }
      return amount;
    };
    this.select = function() {
      if (this.selected === true) {
        this.selected = false;
      } else {
        this.selected = true;
      }
    };
    this.select_todo_item = function(todo) {
      this.deselect_todo_items();
      todo.select();
    };
    this.deselect_todo_items = function() {
      var obj, _i, _len, _ref;
      _ref = this.todos;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        obj = _ref[_i];
        obj.selected = false;
      }
    };
    this.all_completed = function() {
      if (this.todos.length > 0) {
        if (this.get_total_todos() === this.get_completed_todos()) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    };
  };

  Todo = function(id, title, summary, description, done) {
    this.id = id;
    this.title = title;
    this.summary = summary;
    this.description = description;
    this.done = done;
    this.selected = false;
    this.select = function() {
      if (this.selected === true) {
        this.selected = false;
      } else {
        this.selected = true;
      }
    };
    this.todo_complete = function() {
      if (this.done === true) {
        this.done = false;
      } else {
        this.done = true;
      }
      this.selected === false;
    };
  };

  App = angular.module('todo-app', ['ngDragDrop']);

  App.controller('ToDoCtrl', function($scope, $timeout, $http) {
    $scope.loading = false;
    $scope.signup_loading = false;
    $scope.email = "jack.popp@gmail.com";
    $scope.password = "1234";
    $scope.signin_error = "";
    $scope.signup_name = "Jack";
    $scope.signup_password = "1234";
    $scope.signup_email = "jack.popp@gmail.com";
    $scope.signup_error_message = "";
    $scope.signup_success_message = "";
    $scope.new_list_title = "";
    $scope.loading_list = true;
    $scope.new_todo_title = "";
    $scope.new_todo_summary = "";
    $scope.show_add = null;
    $scope.lists = [];
    /*
    	$scope.lists.push(new List(1,'To Do Example List'))
    	$scope.lists.push(new List(2,'Another List with quite a long title!'))
    	$scope.lists.push(new List(3,'A Third List with quite a long title!'))
    	$scope.lists[0].add_todo(1,'Test One','This is a summary', 'This is a description Test One',false)
    	$scope.lists[0].add_todo(2,'Test Two','This is a summary', 'This is a description Test Two',false)
    	$scope.lists[0].selected = true
    	$scope.lists[1].add_todo(1,'Test Three','This is a summary', 'This is a description Test Three',false)
    	$scope.lists[2].add_todo(1,'Test Four','This is a summary', 'This is a description Test Four',false)
    */

    $scope.selected_list = $scope.lists[0];
    $scope.signup = function() {
      var $signup_error, data;
      $signup_error = "";
      $scope.signup_loading = true;
      data = {
        name: $scope.signup_name,
        email: $scope.signup_email,
        password: $scope.signup_password
      };
      $http.post('/todo-laravel/public/user', data).success($scope.signup_success).error($scope.signup_error);
    };
    $scope.signup_success = function(data) {
      $scope.signup_loading = false;
      if (data.success) {
        $scope.signup_success = data.message;
      }
    };
    $scope.signup_error = function(data) {
      $scope.signup_loading = false;
      if (!data.success) {
        $scope.signup_error_message = data.message.join('<br>');
      }
    };
    $scope.signin = function() {
      var data;
      $scope.signin_error = "";
      $scope.loading = true;
      data = {
        email: $scope.email,
        password: $scope.password
      };
      $http.post('/todo-laravel/public/auth', data).success($scope.signin_success).error($scope.signing_error);
    };
    $scope.signin_success = function(data) {
      $scope.signin_error = "";
      if (data.success) {
        location.reload();
      } else {
        $scope.loading = false;
      }
    };
    $scope.signing_error = function(data) {
      $scope.loading = false;
      if (!data.success) {
        $scope.signin_error = data.message;
      }
    };
    $scope.add_new_list = function() {
      var data;
      if ($scope.new_list_title !== null && $scope.new_list_title !== "" && $scope.new_list_title.length > 0) {
        data = {
          title: $scope.new_list_title
        };
        $http.post('/todo-laravel/public/list', data).success($scope.new_list_success);
      } else {
        alert('Enter list title');
      }
    };
    $scope.new_list_success = function(data) {
      if ($scope.lists.push(new List(data.list.id, $scope.new_list_title))) {
        $scope.new_list_title = "";
      }
    };
    $scope.add_new_todo = function() {
      if ($scope.new_todo_title !== null && $scope.new_todo_title !== "" && $scope.new_todo_title.length > 0) {
        if ($scope.selected_list.todos.push(new Todo(null, $scope.new_todo_title, $scope.new_todo_summary, null, false))) {
          $scope.new_todo_title = "";
          $scope.new_todo_summary = "";
          $scope.show_add = false;
        }
      } else {
        alert('Please enter title');
      }
    };
    $scope.select_todo = function(list) {
      var obj, _i, _len, _ref;
      $scope.selected_list = list;
      _ref = $scope.lists;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        obj = _ref[_i];
        obj.selected = false;
      }
      list.selected = true;
      list.deselect_todo_items();
    };
    $scope.get_lists = function() {
      $http.get('/todo-laravel/public/list').success($scope.list_success).error($scope.list_error);
    };
    $scope.list_success = function(data) {
      var key, value, _ref;
      $scope.loading_list = false;
      _ref = data.list;
      for (key in _ref) {
        value = _ref[key];
        $scope.lists.push(new List(value.id, value.title));
      }
    };
    $scope.list_error = function(data) {
      console.log(data);
    };
    $scope.get_lists();
  });

}).call(this);
