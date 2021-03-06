// Generated by CoffeeScript 1.4.0
(function() {
  var App, List, Todo;

  List = function(id, title) {
    this.id = id;
    this.title = title;
    this.todos = [];
    this.show_add = false;
    this.selected = false;
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
        if (t.completed === 1) {
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
        if (t.completed === 0) {
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

  Todo = function(id, title, summary, completed) {
    this.id = id;
    this.title = title;
    this.summary = summary;
    this.completed = parseInt(completed);
    this.selected = false;
    this.select = function() {
      if (this.selected === true) {
        this.selected = false;
      } else {
        this.selected = true;
      }
    };
  };

  App = angular.module('todo-app', ['ngDragDrop']);

  App.directive('ngFocusBlur', function() {
    return function(scope, element, attrs) {
      var functions;
      functions = attrs.ngFocusBlur.split(',');
      element.bind('focus', function() {
        return scope.$apply(function() {
          return scope.$eval(functions[0]);
        });
      });
      return element.bind('blur', function() {
        return scope.$apply(function() {
          if (functions.length === 1) {
            return scope.$eval(functions[0]);
          } else {
            return scope.$eval(functions[1]);
          }
        });
      });
    };
  });

  App.controller('ToDoCtrl', function($scope, $timeout, $http) {
    $scope.loading = false;
    $scope.signup_loading = false;
    $scope.email = "jack.popp@gmail.com";
    $scope.password = "123456";
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
      var data;
      if ($scope.new_todo_title !== null && $scope.new_todo_title !== "" && $scope.new_todo_title.length > 0) {
        data = {
          todo_list_id: $scope.selected_list.id,
          title: $scope.new_todo_title,
          summary: $scope.new_todo_summary
        };
        $http.post('/todo-laravel/public/todo', data).success($scope.push_to_todos_array);
      } else {
        alert('Please enter title');
      }
    };
    $scope.push_to_todos_array = function(data) {
      if ($scope.selected_list.todos.push(new Todo(data.todo.id, data.todo.title, data.todo.summary, data.todo.completed))) {
        $scope.new_todo_title = "";
        $scope.new_todo_summary = "";
        $scope.show_add = false;
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
    $scope.check_signin = function() {
      $http.get('/todo-laravel/public/auth/check').success($scope.get_lists);
    };
    $scope.get_lists = function(data) {
      if (data.success) {
        $http.get('/todo-laravel/public/list').success($scope.list_success).error($scope.list_error);
      }
    };
    $scope.list_success = function(data) {
      var index, k, key, v, value, _ref, _ref1;
      $scope.loading_list = false;
      _ref = data.list;
      for (key in _ref) {
        value = _ref[key];
        index = $scope.lists.push(new List(value.id, value.title));
        _ref1 = value.todos;
        for (k in _ref1) {
          v = _ref1[k];
          $scope.lists[index - 1].todos.push(new Todo(v.id, v.title, v.summary, v.completed));
        }
      }
    };
    $scope.list_error = function(data) {
      console.log(data);
    };
    $scope.todo_complete_request = function(todo) {
      if (todo.completed === 1) {
        todo.completed = 0;
      } else {
        todo.completed = 1;
      }
      $http.put('/todo-laravel/public/todo/' + todo.id, todo).success($scope.todo_complete_success).error($scope.todo_complete_error);
    };
    $scope.todo_complete_success = function(data, status, headers, config) {
      var todo;
      todo = config.data;
      console.log(todo);
      todo.selected === false;
    };
    $scope.todo_complete_error = function(data) {
      console.log(data);
    };
    $scope.toggle_expand_texarea = function() {
      if ($scope.expand_textarea === true) {
        $scope.expand_textarea = false;
      } else {
        $scope.expand_textarea = true;
      }
    };
    $scope.check_signin();
  });

}).call(this);
