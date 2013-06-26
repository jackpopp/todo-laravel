# List Class
# Class for an array of Todo Objects
List = (id,title) ->
	@.id = id
	@.title = title
	@.todos = []
	@.show_add = false
	@.selected = false

	@.show_add_view = ->
		if @.show_add is false then @.show_add = true else @.show_add = false
		return

	@.get_total_todos = -> 
		return @.todos.length

	@.get_completed_todos = -> 
		amount = 0
		for t in @.todos
			amount++ if t.completed is 1
		return amount

	@.get_incomplete_todos = ->
		amount = 0
		for t in @.todos
			amount++ if t.completed is 0
		return amount

	@.select = -> 
		if @.selected is true then @.selected = false else @.selected = true
		return

	@.select_todo_item = (todo) ->
		@.deselect_todo_items()
		todo.select()
		return

	@.deselect_todo_items = ->
		for obj in @.todos
			obj.selected = false
		return

	@.all_completed = ->
		if @.todos.length > 0
			if @.get_total_todos() == @.get_completed_todos() then return true else return false
		else return false
		return

	return

# Todo Class
# Class for a single Todo Object
Todo = (id,title,summary,completed) ->
	@.id = id
	@.title = title
	@.summary = summary
	#@.description = description
	@.completed = parseInt(completed)
	@.selected = false

	@.select = -> 
		if @.selected is true then @.selected = false else @.selected = true
		return
		
	return

App = angular.module('todo-app', ['ngDragDrop'])

App.directive('ngFocusBlur', ->
	(scope, element, attrs) ->
		functions = attrs.ngFocusBlur.split(',')
		element.bind('focus', ->
			scope.$apply(
				->
					scope.$eval(functions[0])	
			)		
		)
		element.bind('blur', ->
			scope.$apply(
				->
					if functions.length is 1 then scope.$eval(functions[0]) else scope.$eval(functions[1])	
			)		
		)	
)

App.controller('ToDoCtrl', ($scope, $timeout, $http) ->

	$scope.loading = false
	$scope.signup_loading = false

	# Sign In Vars
	$scope.email = "jack.popp@gmail.com"
	$scope.password = "123456"
	$scope.signin_error = ""


	# Sign Up Vars
	$scope.signup_name = "Jack"
	$scope.signup_password = "1234"
	$scope.signup_email = "jack.popp@gmail.com"
	$scope.signup_error_message = ""
	$scope.signup_success_message = ""

	$scope.new_list_title = ""
	$scope.loading_list = true

	# New Todo Vars
	$scope.new_todo_title = ""
	$scope.new_todo_summary = ""
	$scope.show_add = null
	
	$scope.lists = []

	$scope.selected_list = $scope.lists[0]

	$scope.signup = ->
		$signup_error = ""
		$scope.signup_loading = true
		data = (
			name: $scope.signup_name
			email: $scope.signup_email
			password: $scope.signup_password
		)
		$http.post('/todo-laravel/public/user', data).success($scope.signup_success).error($scope.signup_error)
		return

	$scope.signup_success = (data) ->
		$scope.signup_loading = false
		if data.success
			$scope.signup_success = data.message
		return

	$scope.signup_error = (data) ->
		$scope.signup_loading = false
		if !data.success
			$scope.signup_error_message = data.message.join('<br>')
		return

	$scope.signin = ->
		$scope.signin_error = ""
		$scope.loading = true
		data = (
			email: $scope.email
			password: $scope.password
		)
		$http.post('/todo-laravel/public/auth', data).success($scope.signin_success).error($scope.signing_error)
		return

	$scope.signin_success = (data) ->
		$scope.signin_error = ""
		if data.success
			location.reload()
		else
			$scope.loading = false
		return

	$scope.signing_error = (data) ->
		$scope.loading = false
		if !data.success
			$scope.signin_error = data.message
		return

	$scope.add_new_list = ->
		if $scope.new_list_title isnt null and $scope.new_list_title isnt "" and  $scope.new_list_title.length > 0
			data = (
				title: $scope.new_list_title
			)
			$http.post('/todo-laravel/public/list', data).success($scope.new_list_success)
		else
			alert 'Enter list title'
		return

	$scope.new_list_success = (data) ->
		if $scope.lists.push(new List(data.list.id,$scope.new_list_title)) then $scope.new_list_title = ""
		return

	# Add new todo Function
	# Adds a new ToDo that has been created in the view
	$scope.add_new_todo = ->
		if $scope.new_todo_title isnt null and $scope.new_todo_title isnt "" and  $scope.new_todo_title.length > 0
			data = (
				todo_list_id: $scope.selected_list.id
				title: $scope.new_todo_title
				summary: $scope.new_todo_summary
			)
			$http.post('/todo-laravel/public/todo', data).success($scope.push_to_todos_array)
		else
			alert 'Please enter title'
		return

	$scope.push_to_todos_array = (data) ->
		if $scope.selected_list.todos.push(new Todo(data.todo.id,data.todo.title,data.todo.summary,data.todo.completed))
			$scope.new_todo_title = ""
			$scope.new_todo_summary = ""
			$scope.show_add = false
		return

	$scope.select_todo = (list) ->
		$scope.selected_list = list
		for obj in $scope.lists
			obj.selected = false
		list.selected = true
		list.deselect_todo_items()
		return

	# Check if the user is signed in, if they are then load the lists
	$scope.check_signin = ->
		$http.get('/todo-laravel/public/auth/check').success($scope.get_lists)
		return

	# GET request to load Todo lists
	$scope.get_lists = (data) ->
		if data.success
			$http.get('/todo-laravel/public/list').success($scope.list_success).error($scope.list_error)
		return

	# If get_lists is successful then populate list
	$scope.list_success = (data) ->
		$scope.loading_list = false
		for key, value of data.list
			index = $scope.lists.push(new List(value.id,value.title))
			for k, v of value.todos
				$scope.lists[index-1].todos.push(new Todo(v.id, v.title, v.summary, v.completed))
		return

	# If we have an error while requesting our lists then this runs
	$scope.list_error = (data) ->
		console.log data
		return

	$scope.todo_complete_request = (todo) -> 
		if todo.completed is 1 then todo.completed = 0 else todo.completed = 1
		$http.put('/todo-laravel/public/todo/'+todo.id, todo).success($scope.todo_complete_success).error($scope.todo_complete_error)
		return

	$scope.todo_complete_success = (data,status,headers,config) ->
		todo = config.data
		console.log todo
		todo.selected is false
		return

	$scope.todo_complete_error = (data) ->
		console.log data
		return

	$scope.toggle_expand_texarea = ->
		if $scope.expand_textarea is true then $scope.expand_textarea = false else $scope.expand_textarea = true
		return

	$scope.check_signin()
	return
)