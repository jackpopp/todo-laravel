@extends('layouts.master')
@section('content')

@if (!Auth::check())
    <div class="masthead full-width ">
        <div class="row">
            <div class="large-12 columns">
                <fieldset>
                    <div class="row">
                        <div class="large-3 large-offset-3 columns">
                            <h3>
                                Sign In!
                            </h3>
                            <form ng-submit="signin()">
                                <input type="text" ng-model="email" placeholder="Email" required />
                                <input type="password" ng-model="password" placeholder="Password" required />
                                <div class="alert-box alert" ng-show="signin_error" ng-animate=" 'animate' ">
                                    {{signin_error}}
                                </div>
                                <input type="submit" value="Signin" class="small button" ng-hide="loading" />
                                <img src="assets/img/loader.gif" ng-show="loading">
                            </form>
                        </div>
                        <div class="large-3 columns left">
                            <h3>
                                Sign Up!
                            </h3>
                            <form ng-submit="signup()">
                                <input type="text" ng-model="signup_name" placeholder="Name" required />
                                <input type="email" ng-model="signup_email" placeholder="Email" required />
                                <input type="password" ng-model="signup_password" placeholder="Password" required />
                                <div class="alert-box alert" ng-show="signup_error_message" ng-animate=" 'animate' " ng-bind-html-unsafe="signup_error_message">
                                </div>
                                <input type="submit" value="Signup" class="small button" ng-hide="signup_loading" />
                                <img src="assets/img/loader.gif" ng-show="signup_loading">
                            </form>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
@endif

@if (Auth::check())
    <div class="row main-area">
        <!-- Add New Todo List -->
         <div class="large-12 columns">
            <div class="new-list clearfix">
                <form ng-submit="add_new_list()">
                    <input class="large-12" type="text" ng-model="new_list_title" placeholder="Add new list">
                </form>
            </div>
        </div>
        <!-- End Add New Todo List -->

        <!-- Todo Lists holder -->
        <div class="large-4 columns todo-list-holder">
            <ul class="todo-list">
                <img src="assets/img/loader.gif" ng-show="loading_list">
                <li class="todo-block" ng-repeat="list in lists" ng-click="select_todo(list)" ng-class="{'selected' : list.selected==true, 'done' : list.all_completed()}">
                        <p>
                            {{list.title}}<br>
                            {{list.get_completed_todos()}}/{{list.get_total_todos()}}
                        </p>
                </li>
            </ul>
        </div>
        <!-- End Todo Lists holder -->

        <!-- Selected Todo List -->
        <div class="large-8 columns selected-todo">

            <!-- New Todo input -->
            <div class="new-todo clearfix">
                <form ng-submit="add_new_todo()">
                    <input type="text" class="new-todo-input todo-title" ng-model="new_todo_title" placeholder="New todo title">
                </form>
                <form ng-submit="add_new_todo()">
                    <input type="text" class="new-todo-input" ng-model="new_todo_summary" placeholder="New todo summary">
                </form>
                
            </div>
            <!-- End new Todo input -->

           <ul>
                <li class="todo-item clearfix" ng-repeat="todo in selected_list.todos" ng-model="selected_list.todos" data-drop="true" jqyoui-droppable="{index: {{$index}}}" ng-click="selected_list.select_todo_item(todo)" ng-class="{'selected':todo.selected == true, 'done':todo.done == true}" >
                    <span ng-model="selected_list.todos" data-drag="true" jqyoui-draggable="{index: {{$index}},animate:false}" data-jqyoui-options="{revert: 'invalid'}">
                        <span class="left">{{todo.title}}</span>
                        <span class="right" ng-click="todo.todo_complete()">
                            <span ng-hide="todo.done">
                                Tick
                            </span>
                            <span ng-show="todo.done">
                                Untick
                            </span>
                        </span>
                    </span>
                </li>
           </ul>
        </div>
        <!-- End Selected Todo List -->
    </div>
@endif

@stop