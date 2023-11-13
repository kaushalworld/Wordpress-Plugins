// noinspection JSCheckFunctionSignatures

jQuery(function ($) {

    function WpReactionsFront(data) {
        this.data = data;
        this.$body = $('body');
        this.can_user_react = true;
        this.can_user_react_timer = null;
        this.all_emoji_containers = [];
        this.center_on_top_css = {
            left: {'left': 0, 'right': 'unset', 'width': 'auto'},
            center: {'justify-content': 'center', 'width': '100%'},
            right: {'right': 0, 'left': 'unset', 'width': 'auto'}
        };
        this.init();
    }

    WpReactionsFront.prototype.init = function () {
        this.register_events();
        this.animate_emojis();
        this.post_init();
    }

    WpReactionsFront.prototype.post_init = function () {
        const self = this;

        $('.wpra-plugin-container').each(function () {
            const $plugin_container = $(this);

            // if it is regular reactions check if it needs narrowing
            if ($plugin_container.hasClass('wpra-regular')) {
                // if classic reactions does not fit to its container then narrow it
                if ($plugin_container.find('.wpra-reactions').outerWidth() > $plugin_container.parent().width()) {
                    self.narrowContainerize($plugin_container);
                } else {
                    $plugin_container.addClass('wpra-rendered');
                }
            }

            if ($plugin_container.hasClass('wpra-button-reveal')) {
                let emoji_id = $plugin_container.find('.wpra-reaction.active').data('emoji_id');
                if (typeof emoji_id === "undefined") return;

                const $reveal_wrap = $plugin_container.find('.wpra-button-reveal-wrap');
                const $reacted_emoji = $reveal_wrap.find('.wpra-reacted-emoji');
                const $badge = $plugin_container.find('.wpra-reaction.active .arrow-badge').clone();
                const $reveal_toggle = $reveal_wrap.find('.wpra-reveal-toggle');
                const format = $plugin_container.data('format');

                const prepare_reacted_emoji = function () {
                    const size = $reveal_toggle.outerHeight();
                    $reacted_emoji
                        .append($badge)
                        .width(size)
                        .height(size)
                        .show();
                }

                if (format.indexOf('json') > -1) {
                    self.load_lottie_emoji({
                        container: $plugin_container,
                        emoji_elem: $reacted_emoji,
                        emoji_id: emoji_id,
                        onComplete: prepare_reacted_emoji
                    });

                    return;
                }

                $reacted_emoji.html(`<img src="${self.getEmojiUrl(emoji_id, format)}">`);
                prepare_reacted_emoji();
            }
        });
    }

    WpReactionsFront.prototype.isMobile = function () {
        return $(window).width() < 768;
    }

    WpReactionsFront.prototype.calcPercentage = function (value, base, precision = 0) {
        if (base === 0) return 0 + '%';
        value = value * 100 / base;
        return parseFloat(value).toFixed(precision) + '%';
    };

    WpReactionsFront.prototype.hex2rgba = function (color, opacity) {
        return 'rgba(' + parseInt(color.slice(-6, -4), 16)
            + ',' + parseInt(color.slice(-4, -2), 16)
            + ',' + parseInt(color.slice(-2), 16)
            + ',' + opacity + ')';
    };

    WpReactionsFront.prototype.getEmojiUrl = function (emoji_id, format) {
        const type = emoji_id > 200 ? 'custom' : 'builtin';
        return this.data.emojis_base_url[type] + format + '/' + emoji_id + '.' + format + '?v=' + this.data.version;
    }

    WpReactionsFront.prototype.animate_emojis = function ($container = null) {
        const self = this;
        const $containers = $container == null ? $('.wpra-plugin-container') : $container;

        $containers.each(function () {
            const $container = $(this);
            $container.data('animations', []);
            if ($container.data('animation') !== true || !$container.data('format').includes('json')) return;
            self.all_emoji_containers.push($container);
            const $emojis = $container.find('.wpra-reaction-animation-holder');

            $emojis.each(function () {
                let emoji_id = $(this).data('emoji_id');
                self.load_lottie_emoji({
                    container: $container,
                    emoji_elem: $(this),
                    emoji_id: emoji_id
                })
            });
        });

        self.checkIfPlayable();
    };

    WpReactionsFront.prototype.load_lottie_emoji = function (params) {

        const defaults = {
            container: null,
            emoji_elem: null,
            emoji_id: 0,
            onComplete: null,
            autoplay: false,
            loop: true
        };

        params = $.extend(defaults, params);

        let animation = bodymovin.loadAnimation({
            container: params.emoji_elem.get(0),
            path: this.getEmojiUrl(params.emoji_id, 'json'),
            renderer: 'svg',
            loop: params.loop,
            autoplay: params.autoplay,
            name: params.emoji_id,
        });

        params.container.data('animations').push(animation);

        if (params.onComplete != null) {
            animation.addEventListener('DOMLoaded', params.onComplete);
            animation.play();
        }
    };

    WpReactionsFront.prototype.checkIfPlayable = function () {
        let self = this;

        $.each(self.all_emoji_containers, function (key, container) {
            if (container.data('animation') !== true) return;
            const elem_top = container.offset().top;
            const isScrolled = $(window).scrollTop() + $(window).height() > elem_top;
            const isDisplayed = container.is(':visible');
            if (container.data('layout') !== 'button_reveal') {
                if (isScrolled && isDisplayed && !container.data('isPlaying')) {
                    container.data('isPlaying', true);
                    $.each(container.data('animations'), function (key, emoji) {
                        emoji.play();
                    });
                }
                if ((!isScrolled || !isDisplayed) && container.data('isPlaying')) {
                    container.data('isPlaying', false);
                    $.each(container.data('animations'), function (key, emoji) {
                        emoji.pause();
                    });
                }
            }
        });
    };

    WpReactionsFront.prototype.narrowContainerize = function ($plugin_container, for_button_reveal = false) {
        $plugin_container.find('.wpra-reactions').addClass('wpra-reactions-narrow');
        const reaction_count = $plugin_container.find('.wpra-reaction').length;
        const reactions_width = for_button_reveal ? $(window).width() - 30 : $plugin_container.width();
        $plugin_container.find('.wpra-reaction-emoji-holder').css('width', reactions_width / reaction_count + 'px');
        $plugin_container.find('.wpra-reaction-emoji-holder').css('height', reactions_width / reaction_count + 'px');
        $plugin_container.addClass('wpra-rendered');
    };

    WpReactionsFront.prototype.register_social_click = function (platform, data) {
        $.ajax({
            url: this.data.ajaxurl,
            dataType: 'text',
            type: 'post',
            data: {
                action: 'wpra_handle_user_requests',
                sub_action: 'register_social_click',
                platform: platform,
                bind_id: data.bind_id,
                source: data.source,
                sgc_id: data.sgc_id,
                checker: data.secure
            },
        });
    };

    WpReactionsFront.prototype.wpra_show_reveal = function ($btn) {
        const $container = $btn.parents('.wpra-plugin-container');
        const $reactWrap = $container.find('.wpra-reactions-wrap');
        if ($reactWrap.css('visibility') !== 'hidden') return;

        setTimeout(function () {
            if (!$container.data('isPlaying')) {
                $container.data('isPlaying', true);
                $.each($container.data('animations'), function (key, anim) {
                    anim.play();
                });
            }
        }, 300);

        $btn.addClass('show-reactions');
        if (!$btn.data('user_reacted')) {
            $reactWrap.show();
            // if button reactions does not fit to its container then narrow them down
            if ($(window).width() < $btn.find('.wpra-reactions').outerWidth() && !$btn.data('narrow_done')) {
                this.narrowContainerize($container, true);
                $btn.data('narrow_done', true);
            }
        }
        this.centerOntopEmojis($btn);
    };

    WpReactionsFront.prototype.centerOntopEmojis = function ($btn) {
        const $reactWrap = $btn.find('.wpra-reactions-wrap');
        const align = $btn.parents('.wpra-plugin-container').data('align');

        this.isMobile() && $reactWrap.css(this.center_on_top_css[align]);
    };

    WpReactionsFront.prototype.register_events = function () {
        const self = this;
        const $document = $(document);

        $document.on({
            mouseenter: function () {
                $(this).find('[data-hover_css]').each(function () {
                    $(this).data('old_styles', $(this).attr('style'));
                    $(this).css($(this).data('hover_css'));
                });
            },
            mouseleave: function () {
                if ($(this).hasClass('active')) return;
                $(this).find('[data-hover_css]').each(function () {
                    $(this).attr('style', $(this).data('old_styles'))
                });
            }
        }, ".wpra-layout-bimber .wpra-reaction");

        $document.on('click', '.wpra-reaction', function () {
            const $reaction = $(this);
            const $plugin_container = $reaction.parents('.wpra-plugin-container');

            if ($plugin_container.data('flying')
                || !self.can_user_react
                || self.data.user_reaction_limitation === 1 && $reaction.hasClass('active')) 
            return;

            const emoji_id = $reaction.data('emoji_id');
            const secret = $plugin_container.data('react_secure');
            const layout = $plugin_container.data('layout');
            const sgc_id = $plugin_container.data('sgc_id');
            const show_count = $plugin_container.data('show_count');
            const bind_id = $plugin_container.data('bind_id');
            const source = $plugin_container.data('source');
            const is_percentage = $plugin_container.data('count_percentage');
            const flying_type = $plugin_container.data('flying_type');
            const enable_share = $plugin_container.data('enable_share');

            const $reactions = $plugin_container.find('.wpra-reactions');
            const $social_share = $plugin_container.find('.wpra-share-wrap');
            const reacted_class = $reaction.attr('class').split(" ")[0];
            const $brother_containers = $('.wpra-plugin-container[data-bind_id=' + bind_id + ']');
            const $others = $brother_containers.find('.' + reacted_class);
            const $prev = $reactions.find('.active');

            const new_count = parseInt($reaction.data('count')) + 1;

            let total_counts = 0;

            // add active class to clicked reaction
            $brother_containers.find('.wpra-reaction').removeClass("active");
            $others.addClass("active");

            // add new count to all clicked reactions and show badge
            $brother_containers.find('.active').data("count", new_count);
            $brother_containers.find('.active .arrow-badge').removeClass('hide-count').addClass('show-count');

            // there is limitation, rollback previous reactions
            if ($prev.length > 0 && +self.data.user_reaction_limitation === 1) {
                const prev_count = parseInt($prev.data('count')) - 1;
                $prev.data('count', prev_count);

                if (prev_count === 0) {
                    $prev.find('.arrow-badge').removeClass('show-count').addClass('hide-count')
                }

                if (!is_percentage && prev_count < 1000) {
                    $prev.find('.count-num').html(prev_count);
                }
            }

            $reactions.find('.wpra-reaction').each(function () {
                total_counts += parseInt($(this).data('count'));
            });

            if (is_percentage) {
                $reactions.find('.wpra-reaction').each(function () {
                    const reaction_count = parseInt($(this).data('count'));
                    $(this)
                        .find('.count-num')
                        .html(self.calcPercentage(reaction_count, total_counts));
                });
            }

            if (!is_percentage) {
                if (new_count < 1000) {
                    $brother_containers.find('.wpra-reaction.active .count-num').html(new_count);
                } else if (new_count === 1000) {
                    $brother_containers.find('.wpra-reaction.active .count-num').html('1k');
                }
            }

            if (layout === 'bimber') {
                $reactions.find('.wpra-reaction').each(function () {
                    const reaction_count = parseInt($(this).data('count'));
                    console.log(total_counts);
                    $(this)
                        .find('.wpra-reaction-track-bar')
                        .css('height', self.calcPercentage(reaction_count, total_counts, 2));
                });
            }

            if (flying_type && layout !== 'button_reveal') {
                $plugin_container.data('flying', true);
                $brother_containers.find('.wpra-reaction').find('.wpra-flying').removeClass("triggered");
                $others.find('.wpra-flying').addClass("triggered");
                $brother_containers.find('.wpra-call-to-action').addClass('wpra-hide-cta-temp');

                setTimeout(function () {
                    $brother_containers.find('.wpra-call-to-action').removeClass('wpra-hide-cta-temp');
                    $others.find('.wpra-flying').removeClass("triggered");
                    $plugin_container.data('flying', false);
                }, 1000);
            }

            if (flying_type === 'count') {
                $others.find('.wpra-flying').html(new_count);
            }

            if (layout === 'disqus' || layout === 'jane') {
                total_counts < 1000 && $brother_containers.find('.wpra-total-counts > span').text(total_counts);
            }

            if (layout === 'disqus' && show_count === 'onclick') {
                $brother_containers.find('.count-num').show();
            }

            if (enable_share && $plugin_container.find('.share-btn').length > 0) {
                $social_share.css('display', 'flex');
            }

            $.ajax({
                url: self.data.ajaxurl,
                dataType: 'json',
                type: 'post',
                data: {
                    action: 'wpra_handle_user_requests',
                    sub_action: 'react',
                    bind_id: bind_id,
                    checker: secret,
                    emoji_id: emoji_id,
                    source: source,
                    sgc_id: sgc_id
                }
            });

            const $reveal_wrap = $reactions.parents('.wpra-button-reveal-wrap');
            $reveal_wrap.data('ontop_align_centered', false);

            if (layout === 'button_reveal') {
                const $reacted_emoji = $reveal_wrap.find('.wpra-reacted-emoji');
                const $reactions_wrap = $reveal_wrap.find('.wpra-reactions-wrap');
                const $reveal_toggle = $reveal_wrap.find('.wpra-reveal-toggle');
                const $badge = $(this).find('.arrow-badge').clone();
                const $plus_one = $(this).find('.wpra-flying').clone();
                const format = $plugin_container.data('format');

                $reacted_emoji.html('');
                $reactions_wrap.hide();
                $reveal_wrap.data('user_reacted', true);

                // if share popup enabled then change button text and class
                if ($plugin_container.data('popup')) {
                    $reveal_toggle.find('.wpra-button-toggle-text').hide();
                    $reveal_toggle.find('.wpra-button-toggle-text-clicked').show();
                    $reveal_toggle.addClass('share-popup-toggle');
                }

                const prepare_reacted_emoji = function () {
                    const size = $reveal_toggle.outerHeight();
                    $plus_one.addClass('triggered');
                    $reacted_emoji
                        .append($plus_one, $badge)
                        .width(size)
                        .height(size)
                        .show();
                };

                if (format.indexOf('json') > -1) {
                    self.load_lottie_emoji({
                        container: $plugin_container,
                        emoji_elem: $reveal_wrap.find('.wpra-reacted-emoji'),
                        emoji_id: $(this).data('emoji_id'),
                        onComplete: prepare_reacted_emoji
                    });

                    return;
                }

                $reacted_emoji.html(`<img src="${self.getEmojiUrl(emoji_id, format)}">`);
                prepare_reacted_emoji();
            }

            $plugin_container.trigger('user.reacted', [$others]);
        });

        $document.on('click', '.share-btn', function () {
            let $share_wrap = $(this).parents('.wpra-share-wrap');
            let share_url = $share_wrap.data('share_url') ? $share_wrap.data('share_url') : window.location.href;
            let platform = $(this).data('platform');
            let platform_url = (self.isMobile() && typeof self.data.social_platforms[platform]['url']['mobile'] != "undefined")
                ? self.data.social_platforms[platform]['url']['mobile']
                : self.data.social_platforms[platform]['url']['desktop'];

            self.register_social_click(platform, {
                bind_id: $share_wrap.data('bind_id'),
                source: $share_wrap.data('source'),
                sgc_id: $share_wrap.data('sgc_id'),
                secure: $share_wrap.data('secure')
            });

            window.open(platform_url + share_url, '_blank', 'width=626, height=436');

            $(this).parents('.wpra-plugin-container').trigger('user.share', [platform, self.data.social_platforms[platform]]);
        });

        $document.on({
            mouseenter: function () {
                self.can_user_react = false;
                self.wpra_show_reveal($(this));
                self.can_user_react_timer = setTimeout(function () {
                    self.can_user_react = true;
                }, 150);
            },
            mouseleave: function () {
                $(this).removeClass('show-reactions');
                $(this).find('.wpra-reactions-wrap').hide();

                self.can_user_react_timer && clearTimeout(self.can_user_react_timer);
            }
        }, '.wpra-button-reveal-wrap');

        $document.on('click', '.wpra-share-popup-close', function () {
            $('html,body').removeClass('wpra-share-popup-active');
            $('body > .wpra-share-popup').remove();
            $('body > .wpra-share-popup-overlay').remove();
        });

        $document.on('click', '.wpra-plugin-container .share-popup-toggle, .wpra-share-expandable-more .qa-share', function () {
            const $plugin_container = $(this).parents('.wpra-plugin-container');
            if ($plugin_container.has('.wpra-share-popup').length) {
                const $clone = $plugin_container.find('.wpra-share-popup').clone();
                self.$body.append('<div class="wpra-share-popup-overlay"></div>');
                self.$body.append($clone);
                self.$body.addClass('wpra-share-popup-active');
            }
        });

        $(window).scroll(function () {
            self.checkIfPlayable();
        });

        $document.click(function () {
            self.checkIfPlayable();
        });

        $document.on('click', '.wpra-share-expandable-more .qa-times', function () {
            let $expandable = $(this).parents('.wpra-share-expandable');
            $expandable.removeClass('active');
            $expandable.find('.wpra-share-expandable-list').removeClass('active');
            $(this).parent().removeClass('active');
        });

        $document.on({
            mouseenter: function () {
                let $container = $(this).parents('.wpra-plugin-container');
                const format = $container.data('format');

                if (!$container.data('animation')) return;

                // animate single emojis that hovered
                if ($container.data('animation') === 'on_hover') {
                    const $anim_holder = $(this).find('.wpra-reaction-animation-holder');
                    const $static_holder = $(this).find('.wpra-reaction-static-holder');
                    const emoji_id = $(this).data('emoji_id');

                    if (format.indexOf('gif') > -1) {
                        if ($anim_holder.find('img').length === 0) {
                            const emoji_url = self.getEmojiUrl(emoji_id, 'gif');
                            $anim_holder.html(`<img src="${emoji_url}">`);
                        }
                        $anim_holder.show();
                        $static_holder.hide();
                        return;
                    }

                    if ($anim_holder.children().length > 0) {
                        $container.data('animations').forEach(function (anim) {
                            if (anim.name === emoji_id) {
                                $static_holder.hide();
                                $anim_holder.show();
                                anim.play();
                            }
                        });
                        return;
                    }

                    self.load_lottie_emoji({
                        container: $container,
                        emoji_elem: $anim_holder,
                        emoji_id: emoji_id,
                        autoplay: true,
                        onComplete: function () {
                            $static_holder.hide();
                            $anim_holder.show();
                        }
                    });
                }

                // animate all emojis when one hovered
                if ($container.data('animation') === 'on_hover_all') {

                    if (!self.can_user_react) return;

                    if (format.indexOf('gif') > -1) {
                        $container.find('.wpra-reaction').each(function () {
                            const emoji_id = $(this).data('emoji_id');
                            const emoji_url = self.getEmojiUrl(emoji_id, 'gif');
                            $(this).find('img').attr('src', emoji_url);
                        });

                        return;
                    }

                    $container.find('.wpra-reaction').each(function () {
                        let emoji_id = $(this).data('emoji_id');
                        let $animated = $(this).find('.wpra-reaction-animation-holder');
                        let $static = $(this).find('.wpra-reaction-static-holder');
                        if ($animated.data('animation')) return;

                        self.load_lottie_emoji({
                            container: $container,
                            emoji_elem: $animated,
                            emoji_id: emoji_id,
                            autoplay: true,
                            onComplete: function () {
                                $animated.show();
                                $static.hide();
                            }
                        });

                        $animated.data('animation', true);
                    });
                }
            },
            mouseleave: function () {
                const $container = $(this).parents('.wpra-plugin-container');
                const format = $container.data('format');

                if (format.indexOf('/') === -1) return;
                if ($container.data('animation') !== 'on_hover') return;

                const $static_holder = $(this).find('.wpra-reaction-static-holder');
                const $anim_holder = $(this).find('.wpra-reaction-animation-holder');
                $static_holder.show();
                $anim_holder.hide();

                $container.data('animations').forEach(function (anim) {
                    anim.pause();
                });
            }
        }, '.wpra-reaction');

        $('.dismiss-alert').click(function () {
            $('.wpra-license-alert-wrap').remove();

            $.post(self.data.ajaxurl, {
                action: 'wpra_handle_admin_requests',
                sub_action: 'dismiss_license_alert'
            });
        });

        $(window).on('wpra.animate_emojis', function (e, $parent) {
            $parent.find('.wpra-plugin-container').each(function () {
                self.animate_emojis($(this));
                $(this).addClass('wpra-rendered');
            });
        });
    }

    window.WpReactionsFront = new WpReactionsFront(wpreactions);
});