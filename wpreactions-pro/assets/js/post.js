jQuery(document).ready(function ($) {

    function setCookie(cname, cvalue, exdays = 365) {
        let d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    let guide_num = 0;
    let wpra_guides_order = [
        {
            'guide': $('#wpra-post-activate-emoji'),
            'top': '-10px',
            'left': '50%',
        },
        {
            'guide': $('#wpra-post-fake-counts'),
            'top': '-10px',
            'left': '50%'
        },
        {
            'guide': $('#wpra-post-reaction-stats'),
            'top': '-30px',
            'left': '50%'
        },
        {
            'guide': $('#wpra-post-fake-share-counts'),
            'top': '0px',
            'left': '50%'
        },
        {
            'guide': $('#wpra-post-social-stats'),
            'top': '-30px',
            'left': '50%'
        }
    ];

    function navGuide() {
        $('.wpra-guide-box').hide();
        wpra_guides_order[guide_num].guide.show();
        wpra_guides_order[guide_num].guide.css(
            {
                'top': wpra_guides_order[guide_num].top,
                'left': wpra_guides_order[guide_num].left
            }
        );
        if (guide_num == wpra_guides_order.length - 1) {
            wpra_guides_order[guide_num].guide.find('.wpra-guide-box-next').text('Okay, Got it');
        }
        if (guide_num == 0) {
            wpra_guides_order[guide_num].guide.find('.wpra-guide-box-prev').hide();
        } else if (guide_num > 0) {
            wpra_guides_order[guide_num].guide.find('.wpra-guide-box-prev').show();
        }
    }
    $(window).load(function () {
        let wpra_show_guides = getCookie('wpra_show_guides');
        if (wpra_show_guides == 1 ||  wpra_show_guides == '') {
            navGuide();
        }
    });

    $('.wpra-guide-box-next').click(function () {
        if (guide_num == wpra_guides_order.length) {
            $('.wpra-guide-box').hide();
            setCookie('wpra_show_guides', 0);
            return;
        }
        guide_num++;
        navGuide();
    });

    $('.wpra-guide-box-prev').click(function () {
        if (guide_num == 0) return;
        guide_num--;
        navGuide();
    });

    $('.wpra-restart-guides').click(function (e) {
        e.preventDefault();
        guide_num = 0;
        navGuide();
    });
    
    $('.wpra-guide-box-dismiss').click(function () {
        $('.wpra-guide-box').hide();
        setCookie('wpra_show_guides', 0);
    });
});