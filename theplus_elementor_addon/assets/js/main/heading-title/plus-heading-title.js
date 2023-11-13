(function($) {
	"use strict";
    var WidgetHeadingTitleHandler = function($scope, $) {
       
        jQuery( document ).ready(function() {
           
            var container = $scope.find('.heading_style.style-10'),
                substyle = container.find('.sub-style'),
                animsplitType = substyle.data("animsplit-type"),
                attr = substyle.data('aniattrht');
               
                
                var animation = Power4.easeOut;
                if(attr && attr["effect"] != undefined && attr["effect"] != 'default'){                        
                        animation = attr['effect'];
                }

                substyle.waypoint(function() {
                    let mySplitText = new SplitText(substyle, { type: animsplitType });
                    let splitTextTimeline = new TimelineLite();        
                    
                    TweenLite.set(substyle, { perspective: 4000 });

                    /*word start*/
                    if(substyle.hasClass('words')){
                        let words = $(mySplitText.words);
                        words.each((index, elementotsword) => {
                            splitTextTimeline.from($(elementotsword), attr['speed'], {
                                x:attr['x'],
                                y:attr['y'],
                                z:attr['z'],
                                scale: attr['scale'],
                                rotation: attr['rotation'],
                                autoAlpha: 0,
                                ease: animation
                            }, index * attr['delay']);
                        });
                    }
                    /*word end*/

                    /*char start*/
                    if(substyle.hasClass('chars')){
                        splitTextTimeline.staggerFrom(mySplitText.chars, attr['speed'], {
                            x:attr['x'],
                            y:attr['y'],
                            z:attr['z'],
                            scale: attr['scale'],
                            rotation: attr['rotation'],
                            autoAlpha: 0,                          
                            ease: animation
                        }, attr['delay']);
                    }                
                    /*char start*/

                    /*line start*/
                    if(substyle.hasClass('lines')){
                        TweenMax.staggerFrom(mySplitText.lines, attr['speed'], {                            
                            x:attr['x'],
                            y:attr['y'],
                            z:attr['z'],
                            scale: attr['scale'],
                            rotation: attr['rotation'],
                            autoAlpha: 0,                       
                            ease:animation
                        }, attr['delay']);
                    }
                    /*line end*/
                    setTimeout(function() { 
                        jQuery($scope.find('.heading_style.style-10 .sub-style.chars > div')).each(function () {                           
                            if(animsplitType != undefined  && (animsplitType === 'chars') ){                                
                                if (isEmptyCheck(jQuery(this))) {
                                    jQuery(this).addClass('tp-hsas');
                                }
                            }
                        });

                        jQuery($scope.find('.heading_style.style-10 .sub-style.lines > div > div')).each(function () {
                            if(animsplitType != undefined  && (animsplitType === 'lines,chars') ){                               
                                if (isEmptyCheck(jQuery(this))) {
                                    jQuery(this).addClass('tp-hsas');
                                }
                            }
                        });

                        function isEmptyCheck( el ){
                            return !$.trim(el.html())
                        }

                    }, 50);
                     
                }, { offset: '90%' } );
        });
		
    };
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/tp-heading-title.default', WidgetHeadingTitleHandler);
    });
})(jQuery);