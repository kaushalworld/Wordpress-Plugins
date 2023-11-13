!function(){var e={369:function(){jQuery(document).ready((function(e){e.multiStepHandler={init(){const t=this;t.createHeaderNav(),t.createFooterNav(),t.moveStepHandler(t.active),t.adaptiveHeight(),t.fixBlinking(),t.onloadValidation(),t.fixLoginForm(),e(t.selectors.container).closest("form").on("input change",(function(e){t.fieldsValidation()})),t.elements.nextButton.on("click",(n=>{n.preventDefault(),t.fieldsValidation()?(t.moveStepHandler(t.active+1),t.adaptiveHeight()):e("html, body").animate({scrollTop:e(t.selectors.container).offset().top-100},500)})),t.elements.prevButton.on("click",(e=>{e.preventDefault(),t.moveStepHandler(t.active-1),t.adaptiveHeight()})),t.elements.stepButton.on("click",(function(n){n.preventDefault(),!t.fieldsValidation()&&Number(this.dataset.item)>t.active?e("html, body").animate({scrollTop:e(t.selectors.container).offset().top-100},500):(t.enableButton(e(t.selectors.container).find(".shopengine-multistep-next-button")),t.moveStepHandler(Number(this.dataset.item)),t.adaptiveHeight())}))},createHeaderNav(){const e=this;let t="";e.steps.each(((e,n)=>{let i="Step "+n.dataset.id,s="";if(n.dataset.settings){const e=JSON.parse(n.dataset.settings);i=e.shopengine_multistep_checkout_tab_title||i,e.shopengine__multistep_checkout_tab_icon&&(s=e.shopengine__multistep_checkout_tab_icon.value||s)}t+=`\n                <li class="step-${e}"> \n                    <div class="shopengine-multistep-button" data-item="${e}">\n                        <label> ${i} </label>\n                        <i class="${s}"></i>\n                    </div>\n                </li>`})),e.elements.stepWrapper.before(`\n                <div class="shopengine-multistep-navbar">\n                    <ul> ${t} </ul>\n                </div>`),e.elements.stepButton=e.elements.parentWrapper.find(e.selectors.stepButton)},createFooterNav(){const e=this;let t=e.settings,n=t.shopengine_multistep_next_button_text?t.shopengine_multistep_next_button_text:"Next",i=t.shopengine_multistep_previous_button_text?t.shopengine_multistep_previous_button_text:"Previous";e.elements.stepWrapper.after(`\n                <div class="shopengine-multistep-footer">\n                    <span class="shopengine-multistep-prev-button">${i}</span>\n                    <span class="shopengine-multistep-next-button">${n}</span>\n                </div>`),e.elements.nextButton=e.elements.parentWrapper.find(e.selectors.nextButton),e.elements.prevButton=e.elements.parentWrapper.find(e.selectors.prevButton)},moveStepHandler(e){let{steps:t,elements:n,length:i}=this;if(e>=0&&e<i){const i=n.parentWrapper.find(".shopengine-multistep-navbar ul").children();t[this.active].classList.remove("shopengine-active-step"),i[this.active].classList.remove("active"),t[e].classList.add("shopengine-active-step"),i[e].classList.add("active"),this.active=e,n.stepWrapper.css({transform:`translateX(-${100*e}%)`}),n.prevButton.css({pointerEvents:"auto",opacity:1}),n.nextButton.css({pointerEvents:"auto",opacity:1})}else console.warn(" Your target is invald - It can not be less or more then the inner sections your used for creating steps");e<=0&&n.prevButton.css({pointerEvents:"none",opacity:.5}),e>=i-1&&n.nextButton.css({pointerEvents:"none",opacity:0})},fixLoginForm(){let t=e(this.selectors.container),n=t.find(".shopengine-checkout-form-login"),i=n.closest(".elementor-widget-wrap").find(".elementor-widget"),s=n.closest(".shopengine-active-step"),o=t.find(".shopengine-multistep-next-button");n.length&&setTimeout((()=>{n.find(".showlogin").trigger("click"),0===n.html().trim().length&&1===i.length&&s.length>0&&(o.trigger("click"),this.adaptiveHeight()),shopEngineMultistepCheckout.is_login?n.html(shopEngineMultistepCheckout.is_login):shopEngineMultistepCheckout.existing_account_login&&n.html(shopEngineMultistepCheckout.existing_account_login)}),100)},adaptiveHeight(){"yes"===this.settings.shopengine_multistep_adaptive_height&&this.steps.each(((t,n)=>{e(n).removeAttr("style"),e(n).hasClass("shopengine-active-step")||e(n).height(0)}))},fieldsValidation(){let t=!0,n=e(this.selectors.container),i=n.find(".shopengine-active-step"),s=this.steps.index(i),o=i.find("input, select, textarea"),a=n.find(".shopengine-multistep-navbar ul li");if(shopEngineMultistepCheckout.need_login_validate){let e=i.find("input[name=username], input[name=password]");e.closest("p").addClass("validate-required"),e.length&&(t=!1)}return o.each(((n,i)=>{let s=e(i);s.closest(".validate-required").length&&(s.is(":checkbox")?s.is(":checked")||(t=!1):s.val()?s.removeAttr("style"):(t=!1,s.css({border:"1px solid #a00636",backgroundColor:"#ffefee"})))})),t?(this.enableButton(a.eq(s+1).find(".shopengine-multistep-button")),this.enableButton(n.find(".shopengine-multistep-next-button"))):(a.each(((t,n)=>{t>s&&this.disableButton(e(n).find(".shopengine-multistep-button"))})),this.disableButton(n.find(".shopengine-multistep-next-button"))),t},onloadValidation(){this.disableButton(e(this.selectors.container).find(".shopengine-multistep-navbar ul li").not(".active").find(".shopengine-multistep-button"))},enableButton(e){e.css({pointerEvents:"auto",opacity:1})},disableButton(e){e.css({pointerEvents:"none",opacity:.5})},fixBlinking(){e(this.selectors.container).addClass("multistep-loaded")}}}))}},t={};function n(i){if(t[i])return t[i].exports;var s=t[i]={exports:{}};return e[i](s,s.exports,n),s.exports}n.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return n.d(t,{a:t}),t},n.d=function(e,t){for(var i in t)n.o(t,i)&&!n.o(e,i)&&Object.defineProperty(e,i,{enumerable:!0,get:t[i]})},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){"use strict";n(369);jQuery(document).ready((function(e){const t={selectors:{container:".shopengine-multistep-enabled",nextButton:".shopengine-multistep-next-button",prevButton:".shopengine-multistep-prev-button",stepButton:".shopengine-multistep-button",stepWrapper:".elementor-widget-wrap"},init(){const t=this.selectors;elementorFrontend.hooks.addAction("frontend/element_ready/section",(function(n){if(n.hasClass("shopengine-multistep-enabled")){const i=n.data("settings");!function(t){"no"==t.shopengine_multistep_checkout_enable?e(".shopengine-multistep-active").remove():e(".shopengine-multistep-active").show()}(i);const s={};s.parentWrapper=n,s.stepWrapper=n.find(t.stepWrapper).first().addClass("shopengine-steps-wrapper"),s.nextButton=n.find(t.nextButton),s.prevButton=n.find(t.prevButton),e.multiStepHandler.init.call({selectors:t,elements:s,settings:i,steps:s.stepWrapper.children(),length:s.stepWrapper.children().length,active:0,...e.multiStepHandler})}}))}};e(window).on("elementor/frontend/init",t.init.bind(t))}))}()}();