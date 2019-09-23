<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Mekari Assessment</title>
    </head>
    <body>
		<h1>Simple Todo List</h1>
		<div>
			<input type="text" id="nameTodo" />
			<button id="addBtn">Add todo</button>
		</div>
		<div id="ann"></div>
		<div id="todoContainer"></div>
		<button id="delBtn">Delete selected</button>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script>
			var tstr = 'Type in a new todo...';
			
			function delTodo(id)
			{
				$.post('./todos/' + id, {_method: 'PUT'}, function(res){
					$('#tdc-' + res.id).remove();
				});
			}
			
			function generateTodoHtml(todo){
				return "<div id='tdc-" + todo.id + "'><label><input type='checkbox' value='" + todo.id + "' />" + todo.name + "</label><span onclick='delTodo(" + todo.id + ")'>[x]</span></div>";
			}
			
			$(function(){
				$('#ann').html(tstr);
				
				$('#addBtn').click(function(){
					$.post('./todos/', {
						name: $('#nameTodo').val()
					}, function(res){
						$('#todoContainer').append(generateTodoHtml(res));
						$('#ann').html(tstr);
						$('#nameTodo').val('');
					});
				});
				
				$('#delBtn').click(function(){
					let $cbs = $('input[type="checkbox"]:checked');
					for(let i = 0; i < $cbs.length; ++i)
						delTodo($cbs[i].value);
				});
				
				$('#nameTodo').keyup(function(){
					if(this.value !== '')
						$('#ann').html('Typing: ' + this.value);
					else
						$('#ann').html(tstr);
				});
				
				$.get('./todos', function(todos){
					for(let i = 0; i < todos.length; ++i)
						$('#todoContainer').append(generateTodoHtml(todos[i]));
				});
			});
		</script>
    </body>
</html>
