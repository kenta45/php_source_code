$(function(){

  'use strict';

  $('#new_todo').focus();


  // Update todo list

  $('#todos').on('click','.update_todo',function(){
    var id = $(this).parents('li').data('id');

    $.post('_ajax.php',{
      id: id,
      mode: 'update',
      Token: $('#Token').val()
    },function(res){
      if (res.state === '1') {
        $('#todo_' + id).find('.todo_title').addClass('done');
      }else{
        $('#todo_' + id).find('.todo_title').removeClass('done');
      }
    })
  })

  // Delete todo list

  $('#todos').on('click','.delete_todo',function(){
    var id = $(this).parents('li').data('id');

    if (confirm('Are you OK?')) {
      $.post('_ajax.php',{
        id: id,
        mode: 'delete',
        Token: $('#Token').val()
      },function(){
        $('#todo_' + id).fadeOut(800);
      }
    )
  }
  })

  // Create todo list

  $('#new_todo_form').on('submit',function(){

    var title = $('#new_todo').val();

      $.post('_ajax.php',{
        title: title,
        mode: 'create',
        Token: $('#Token').val()
      },function(res){
        var $li = $('#todo_template').clone();

        $li
           .attr('id', 'todo_' + res.id)
           .data('id', res.id)
           .find('.todo_title').text(title);

        $('#todos').prepend($li.fadeIn());
        $('#new_todo').val('').focus();

      })
      return false;
  })





})
