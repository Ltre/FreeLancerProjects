function checkUsername(){
    var username = $.trim($('#username').val());
    if(username.length == 0){
        $('.forget_password_hint').html('请输入用户名');
    }
    else if(!username.match(/^[a-zA-Z_0-9]{2,20}$/)){
        $('.forget_password_hint').html('请输入有效的用户名');
    }else{
        return true;
    }
    return false;
}

function checkEmail(){
    var rule = '请输入正确的电子邮箱地址';
    var email = $.trim($('#check_email').val());
    $('#check_email').val(email);
	if(email.length != 0){
		$('#email_info').removeClass('info_ok').removeClass('erro').empty();
		if(email.length <= 6 || !email.match(/^[\w\-\.]+@[\w\-]+(\.\w+)+$/)){
			$('#email_info').addClass('erro').html(rule);
		} else {
            $.ajax({
                url: '/do/job.php?job=ckreg&type=email',
                data: 'name='+email,
                dataType: 'json',
                success: function(msg){
                    switch(msg.toString()){
                        case '1':
							$('#email_info').removeClass('info_ok').removeClass('erro').removeClass('info').empty();
							$('#email_info').addClass('info_ok').html('邮箱可用');
							return '1';
                            break;
                        case '-1':
                            $('#email_info').addClass('erro').html(rule);
							return '-1';
                            break;
                        case '-3':
                            $('#email_info').removeClass('info').addClass('erro').html('此邮箱已被注册,请更换其他邮箱！');
							return '-3';
                            break;
                    }
                }
            });
		}
	} else {
		$('#email_info').removeClass('info_ok').removeClass('erro').empty();
		$('#email_info').addClass('erro').html(rule);	
	}

    return false;
}

$(document).ready(function(){

	var email = $.trim($("#check_email").val());
	if(email.length <= 5 || email != $.trim($("#check_email").val()) ){
		$("#check_email").blur(function(){
			checkEmail();
		});
	}

	$("#set_email_form").submit(function(){
		var stat = $("#email_info").hasClass("info_ok");
		if(stat){
			return true;
		} else {
			if(email.length <= 5 || email != $.trim($("#check_email").val()) ){
				return checkEmail();
			}
		}
	});
});