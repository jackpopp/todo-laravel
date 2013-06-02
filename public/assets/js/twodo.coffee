# List Class
# Class for an array of Todo Objects
List = (id,title) ->
	@.id = id
	@.title = title
	@.todos = []
	@.show_add = false
	@.selected = false

	# Add todo Function
	# Adds a todo object to the todo array.
	@.add_todo = (id,title,summary,description,done) ->
		if @.todos.push(new Todo(id,title,summary,description,done)) then return true else return false
		return

	@.show_add_view = ->
		if @.show_add is false then @.show_add = true else @.show_add = false
		return

	@.get_total_todos = -> 
		return @.todos.length

	@.get_completed_todos = -> 
		amount = 0
		for t in @.todos
			amount++ if t.done is true
		return amount

	@.get_incomplete_todos = ->
		amount = 0
		for t in @.todos
			amount++ if t.done is false
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
Todo = (id,title,summary,description,done) ->
	@.id = id
	@.title = title
	@.summary = summary
	@.description = description
	@.done = done
	@.selected = false

	@.select = -> 
		if @.selected is true then @.selected = false else @.selected = true
		return
		
	@.todo_complete = -> 
		if @.done is true then @.done = false else @.done = true
		@.selected is false
		return
	return

App = angular.module('todo-app', ['ngDragDrop'])

App.controller('ToDoCtrl', ($scope, $timeout,$http) ->

	# Sign In Vars
	$scope.email = ""
	$scope.password = ""

	# Sign Up Vars
	$scope.signup_name = "Jack"
	$scope.signup_password = "1234"
	$scope.signup_email = "jack.popp@gmail.com"
	$scope.masthead_closed = false
	$scope.new_list_title = ""

	# New Todo Vars
	$scope.new_todo_title = ""
	$scope.new_todo_summary = ""
	$scope.show_add = null
	
	$scope.lists = []

	# Demo
	$scope.lists.push(new List(1,'To Do Example List'))
	$scope.lists.push(new List(2,'Another List with quite a long title!'))
	$scope.lists.push(new List(3,'A Third List with quite a long title!'))
	$scope.lists[0].add_todo(1,'Test One','This is a summary', 'This is a description Test One',false)
	$scope.lists[0].add_todo(2,'Test Two','This is a summary', 'This is a description Test Two',false)
	$scope.lists[0].selected = true
	$scope.lists[1].add_todo(1,'Test Three','This is a summary', 'This is a description Test Three',false)
	$scope.lists[2].add_todo(1,'Test Four','This is a summary', 'This is a description Test Four',false)

	$scope.selected_list = $scope.lists[0]

	$scope.signup = ->
		data = (
			name: $scope.signup_name
			email: $scope.signup_email
			password: $scope.signup_password
		)
		$http.post('/todo-laravel/public/user', data).success($scope.signup_success)
		return

	$scope.signup_success = (data) ->
		console.log data
		return

	$scope.login = ->
		data = (
			email: $scope.email
			password: $scope.password
		)
		$http.post('/todo-laravel/public/auth', data).success($scope.login_success)
		return

	$scope.login_success = (data) ->
		console.log data
		return

	$scope.add_new_list = ->
		if $scope.new_list_title isnt null and $scope.new_list_title isnt "" and  $scope.new_list_title.length > 0
			if $scope.lists.push(new List('new',$scope.new_list_title)) then $scope.new_list_title = ""
		else
			alert 'Enter list title'
		return

	# Add new todo Function
	# Adds a new ToDo that has been created in the view
	$scope.add_new_todo = ->
		if $scope.new_todo_title isnt null and $scope.new_todo_title isnt "" and  $scope.new_todo_title.length > 0
			if $scope.selected_list.todos.push(new Todo(null,$scope.new_todo_title,$scope.new_todo_summary,null,false))
				$scope.new_todo_title = ""
				$scope.new_todo_summary = ""
				$scope.show_add = false
		else
			alert 'Please enter title'
		return

	$scope.select_todo = (list) ->
		$scope.selected_list = list
		for obj in $scope.lists
			obj.selected = false
		list.selected = true
		list.deselect_todo_items()
		return

	return
)