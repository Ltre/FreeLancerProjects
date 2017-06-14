function slideImg(){
    $("div[id*='listbox']").hover(function(){
        clearIntv();
        $(this).stop().animate({
            "margin-top": "-10px"
        }, 200)
    }, function(){
        setIntv();
        $(this).stop().animate({
            "margin-top": "0px"
        }, 200);
    });
    var tmp = $("div[id*='listbox']").eq(0).children("img").attr("src");
    //鼠标点击过程
    $("div[id*='listbox']").click(function(){
        clearIntv();
        if (parseInt($(this).css("z-index")) <= 3) {
            var curZindex = parseInt($(this).css("z-index"));
            //通过z-index差计算该层需要经过几次轮换效果置顶，
            var fntimes = 4 - curZindex;
            //对于当前处于第一位的图片点击无效果.
            $(document).everyTime(300, function(){
                $("div[id*='listbox']").each(function(){
                    if (parseInt($(this).css("z-index")) == 4) {
                        $(this).css("z-index", "1");
                    }
                    else {
                        $(this).css("z-index", "" + (parseInt($(this).css("z-index")) + 1) + "");
                    }
                    $(this).css("margin-top", "0px");
                    $(this).animate({
                        "margin-left": ((4 - parseInt($(this).css("z-index"))) * 29) + "px"
                    }, 300);
                });
            }, fntimes);
        }
        else {
            var url = $(this).children('.big_banner').attr('href');
            if (url != undefined) {
                window.open(url);
            }
        }
    });
    
    
    setIntv();
}

var intv;
function setIntv(){
    intv = setInterval(function(){
        $("div[id*='listbox']").each(function(){
            if (parseInt($(this).css("z-index")) == 4) {
                $(this).css("z-index", "1");
            }
            else {
                $(this).css("z-index", "" + (parseInt($(this).css("z-index")) + 1) + "");
            }
            $(this).animate({
                "margin-left": ((4 - parseInt($(this).css("z-index"))) * 29) + "px"
            }, 300);
        });
    }, 3000);
}

function clearIntv(){
    clearInterval(intv);
}

$(document).ready(function(){
    var images = window.images || ['/images/hy/QQad0.png', 'images/hy/QQad1.png', 'images/hy/QQad2.png', '/images/hy/QQad3.png'];
    var t = 0;
    for (i = 0; i < images.length; i++) {
    
        $("<img />").attr('src', images[i]).data('box', i).load(function(){
                $("#listbox" + $(this).data('box') + " a").empty().append(this);
                t++;
                if (t == 4) {
                    slideImg();
                }
        });
    }
});
