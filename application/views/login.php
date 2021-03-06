<!DOCTYPE html>
<!--HTML5 doctype-->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="description" content="超级Home监理客户端"/>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>

<title>超级Home监理</title>
</head>
<script id="style" type="text/template">
    *{
    	margin:0px;
		padding:0px;
		border:0px;
        background-size:100% 100%;
        font-family: :"Microsoft YaHei";
        text-decoration:none;
    }
    body{
    	background-image:<@bg1.jpg>;
    	width:100%;
    	height:1136vx;
    }
    header{
    	height:120vx;
    	width:100%;
    	background-image:<@banner.png>;
    }
    section{
    	width:580vx;
    	position:relative;
    	left:50%;
    	margin-left:-290vx;
    	top:150vx;
    	height:600vx;
    	border:1px solid #1dd2af;
    	border-radius:5px;
    	background-color:#fff;
    }
    section>h1{
    	height:100vx;
    	width:440vx;
    	background-color:#1dd2af;
    	padding:0px 70vx;
    	font-size:36vx;
    	line-height:100vx;
    	color:#fff;
    }
    section div{
    	height:100vx;
    	width:440vx;
    	padding:60vx 70vx; 	
    }
    section div>h2{
    	color:#717171;
    	font-size:28vx;
    	font-weight:normal;
    	margin-bottom:10vx;
    }
    section div>input{
    	border-radius:5px;
    	width:440vx;
    	height:60vx;
    	border:1px solid #a6a6a6;
    	margin-bottom:20vx;
    	text-indent:10px;
    }
    section button{
    	width:440vx;
    	height:60vx;
    	background-color:#1dd2af;
    	color:#fff;
    	border-radius:5px;
    	margin-top:10px;
    }
    section div>a:nth-of-type(1){
    	float:left;
    	color:#1dd2af;
    	font-size:24vx;
    	margin-top:20vx;
    }
    section div>a:nth-of-type(2){
    	float:right;
    	margin-top:20vx;
    	color:#717171;
    	font-size:24vx;
    }
</script>
<style></style>
<script>
    $(window).on("resize orientationchange",function () {
        var vw = innerWidth;
        if (window._vw == vw) return;
        $("style").text(function (temp) {

            return temp.replace(/<(.)(.*?)>/g,function (str, c, exp) {

                switch (c) {
                    case '=':
                        return eval(exp);
                    case '@':
                        return 'url(/static/image/login/' + exp + ')';
                }
            }).replace(/\b(\d+)vx\b/g,function (str, val) {
                return vw / 640 * val + "px";
            }).replace(/(?:background-size|border-radius|box-sizing):[^};]+/g, "-webkit-$&;-moz-$&;$&");
        }($("#style").text()));
        window._vw = vw;
        setTimeout(function () {
            $(window).trigger("resize");
        }, 1000)
    }).trigger("resize");


    $("button").live('click', function(){
        var phone = $('input[name="phone"]').val();
        var passwd = $('input[name="passwd"]').val();
        var reg = /^1[3|4|5|8|7]\d{9}$/;
        if(!reg.test(phone)){
            alert('请输入正确的手机号');
            return false;
        }else if(passwd.length < 6){
            alert('请输入大于6位的密码');
            return false;
        }

        $.post('/user/sign_in_passwd',
                {phone : phone, passwd : passwd, <?=REDIRECT_RENDER;?>: 0},
                function(data, status){
                    if(status == "success"){
                        data = eval('(' + data + ')');
                        if(data.code == 0){
                            if($("#redirect").val() != ''){
                                window.location.href = $("#redirect").val();
                            }else{
                                window.location.href = "/index.php";
                            }
                        }else{
                            alert(data.msg);
                            return false;
                        }
                    }else{
                        alert("通信错误");
                        return false;
                    }
                });
    });

</script>
<body>
    <div style="display:none;">
        <?php if(isset($redirect)):?>
        <input type="hidden" id="redirect" value="<?=$redirect;?>"/>
        <?php else:?>
        <input type="hidden" id="redirect" value=""/>
        <?php endif;?>
    </div>
	<header></header>
	<section>
		<h1>监理登录</h1>
		<div>
			    <h2>账号</h2>
			    <input type="text" name="phone" placeholder="请输入手机号" value=""/>
			    <h2>密码</h2>
			    <input type="text" name="passwd" placeholder="请输入密码" value=""/>
			    <button>立即登录</button>
                <!--
			    <a href="/user/signup">马上注册</a>
                -->
			    <!--<a href="###">忘记密码</a>-->
		</div>
	</section>
</body>

</html>  
