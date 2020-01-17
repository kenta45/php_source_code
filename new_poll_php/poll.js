$(function(){

  'use strict';

  $('.box').on('click',function(){
    $('.box').removeClass('selected');
    $(this).addClass('selected');
    $('#answer').val($(this).data('id'));
  });

  $('#btn').on('click', function(){
    if ($('#answer').val() === '') {
      alert('Chose One');
    } else {
      $('form').submit();
    }
  });

  $('.error').fadeOut(5000);




});
