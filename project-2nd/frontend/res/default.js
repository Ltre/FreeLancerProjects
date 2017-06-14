
$(document).ready(function(){
	
	function fadeButtonOne(){
		$(this).stop().fadeTo(100,1);
	}
	function fadeButtonTwo(){ 
		$(this).stop().fadeTo(400,0);
	}
	

	
	$('.fade_button').css('opacity',0);

	$('li.navBoarder').not('.here').children('.fade_button').hover(
		fadeButtonOne,fadeButtonTwo
	); 
	$('li.navBoarder').not('.here').children('.fade_a').hover(
		function(){
		$(this).siblings('.fade_button').stop().fadeTo(100,1);
		},
		function(){ 
		$(this).siblings('.fade_button').stop().fadeTo(400,0);
		}
	);


    if($('#loginForm').length > 0){
        $('#loginForm').submit(function(){
			return true;
        })
    }
    if($('.loginbox_form').length > 0){
        $('.loginbox_form').submit(function(){
			if($.trim($("#loginbox_username").val()).length == 0){
				$(".loginbox_erro_info").text("用户名为空!");
				return false;
			}
			if($.trim($("#loginbox_password").val()).length == 0){
				$(".loginbox_erro_info").text("密码为空!");
				return false;
			}			
        });
    }

});

