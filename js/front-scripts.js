// JavaScript Document

jQuery(document).ready(function($){
	$('.wp-ham-wrapper').on('click', 'ul > li.parent > a', function(event){
		event.preventDefault();
		console.log($(this).prop('href'));
	});
});