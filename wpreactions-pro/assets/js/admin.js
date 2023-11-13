jQuery(window).on('load', function () {
    jQuery('.loading-overlay').removeClass('active');
});

jQuery(function ($) {
    $.expr[':'].icontains = $.expr.createPseudo(function (arg) {
        return function (elem) {
            return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });

    $.fn.extend({
        enabled: function () {
            return this.each(function () {
                this.disabled = false;
            });
        },
        disabled: function () {
            return this.each(function () {
                this.disabled = true;
            });
        },
        readFormValuesFromElement: function () {
            let settings = {};
            this.each(function () {
                if (this.classList.contains('wpra-no-save')) return;
                if (this.type === 'text' || this.type === 'number' || this.type === 'hidden') {
                    settings[this.id] = this.value;
                } else if (this.type === 'radio') {
                    if (this.checked) {
                        settings[this.name] = this.value;
                    }
                } else if (this.type === 'checkbox') {
                    if (typeof this.name == 'undefined' || this.name === '') {
                        settings[this.id] = this.checked ? 1 : 0;
                    } else {
                        if (typeof settings[this.name] == 'undefined') {
                            settings[this.name] = [];
                        }
                        if (this.checked) {
                            settings[this.name].push(this.id);
                        }
                    }
                } else if (this.tagName.toLocaleLowerCase() === 'select') {
                    settings[this.id] = this.value;
                }
            });
            return settings;
        },
        readFormValues: function () {
            let settings = {};
            this.each(function () {
                $(this).extend(true, settings, $(this).find('input[type=text]').readFormValuesFromElement());
                $(this).extend(true, settings, $(this).find('input[type=number]').readFormValuesFromElement());
                $(this).extend(true, settings, $(this).find('input[type=hidden]').readFormValuesFromElement());
                $(this).extend(true, settings, $(this).find('input[type=radio]').readFormValuesFromElement());
                $(this).extend(true, settings, $(this).find('input[type=checkbox]').readFormValuesFromElement());
                $(this).extend(true, settings, $(this).find('select').readFormValuesFromElement());
            });
            return settings;
        },
        isInViewport: function () {
            const elementTop = $(this).offset().top;
            const elementBottom = elementTop + $(this).outerHeight();
            const viewportTop = $(window).scrollTop();
            const viewportBottom = viewportTop + $(window).height();
            return elementBottom > viewportTop && elementTop < viewportBottom;
        },
        isThere: function () {
            return $(this).length > 0;
        },
    });

    function WpReactions(data) {
        const picker_type = $('#picker-type').val();
        const picker_format = $('#picker-format').val();

        this.$dom = {
            social_picker: $('.social-picker'),
            picked_emojis: $('.picked-emojis'),
            color_chooser: $('.wpra-color-chooser'),
            loading_overlay: $('.loading-overlay'),
            my_sgc_table_holder: $('.my-shortcodes-table-holder'),
            tooltip: $('.wpra-tooltip'),
            emoji_pick: $('.emoji-picker .emoji-pick'),
        };

        this.data = data;
        this.$body = $('body');
        this.$window = $(window);
        this.url_params = this.getUrlVars();
        this.picker_state = {
            saved: {
                type: picker_type,
                format: picker_format,
            },
            active: {
                type: picker_type,
                format: picker_format,
            },
            chosen: {
                type: picker_type,
                format: picker_format,
            },
        };
        this.need_reset_picker = false;
        this.max_steps = $('.wpra-stepper__bar-item').length;
        this.current_step = 1;
        this.picked_emojis = this.get_picked_emojis();
        this.is_scg_page = this.$body.hasClass('wp-reactions_page_wpra-shortcode-generator');
        this.full_url = window.location.href;
        this.current_emojis = WpReactionsUtils.toIntegerArray(this.data.current_options.picked_emojis);
        this.shortcode_id = this.url_params['sgc_action'] === 'edit' ? this.url_params['id'] : 0;
        this.my_sgc_current_page = 1;
        this.my_sgc_max_page = $('.my-sgc-max-page').text();
        this.my_sgc_count = $('.my-sgc-count').text();
        this.sgc_view_timers = [];
        this.fa_icon_types = {
            solid: 'qas',
            regular: 'qar',
            brands: 'qab',
            duotone: 'qad',
        };
        this.init();
    }

    WpReactions.prototype.init = function () {
        let self = this;
        this.register_events();
        this.$dom.picked_emojis.sortable();
        this.$dom.picked_emojis.disableSelection();
        this.$dom.social_picker.sortable();
        this.$dom.social_picker.disableSelection();

        self.load_lazy_bg();
        setTimeout(function () {
            $(window).scrollTop(0);
        }, 100);

        if (window.location.hash) {
            $('ul.nav-pills a[href="' + window.location.hash + '"]').tab('show');
            setTimeout(function () {
                $(window).scrollTop(0);
            }, 100);
        }

        $('.floating-menu a').each(function () {
            $(this).attr('href') === self.full_url && $(this).addClass('active');
        });

        this.$dom.color_chooser.minicolors({
            keywords: 'transparent',
            swatches: ['#ff0000', '#2ec18d', '#000000', '#ffffff', '#00ff00', '#028fff', '#a054ff'],
        });

        this.$dom.color_chooser.on('change', function () {
            $(this).minicolors('value', $(this).val());
        });

        // Main plugin JS initialisation finished
        this.$window.trigger('wpra.initialized', [$, this]);

        this.$dom.picked_emojis.find('.picked-emoji').each(function () {
            self.$window.trigger('wpra.load_emoji', [
                {
                    container: $(this).find('.picked-emoji-holder'),
                    emoji_id: $(this).data('emoji_id'),
                    source: 'emoji_depended_block',
                },
            ]);
        });
    };

    WpReactions.prototype.play_lottie_emoji = function ($container, emoji_id, animated = true, cache = true) {
        if (cache && typeof $container.data('animation') !== 'undefined') {
            $container.data('animation').play();
            return;
        }

        const animation = bodymovin.loadAnimation({
            container: $container.get(0),
            path: this.getEmojiUrl(emoji_id, 'json'),
            renderer: 'svg',
            loop: animated,
            autoplay: animated,
            name: emoji_id,
        });

        $container.data('animation', animation);
    };

    WpReactions.prototype.getUrlVars = function () {
        let vars = {};
        window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
            vars[key] = value;
        });
        return vars;
    };

    WpReactions.prototype.getText = function (name) {
        if (typeof this.data.messages[name] != 'undefined') {
            return this.data.messages[name];
        }
        return '';
    };

    WpReactions.prototype.getValue = function (name, type = 'String') {
        if (typeof this.data[name] != 'undefined') {
            return type === 'Number' ? +this.data[name] : this.data[name];
        }
        return '';
    };

    WpReactions.prototype.getExtension = function (format, part = 1) {
        const slash = format.indexOf('/');
        if (slash === -1) return format;

        return part === 1 ? format.substring(0, slash) : format.substring(slash + 1, format.length);
    };

    WpReactions.prototype.getEmojiUrl = function (emoji_id, format, part = 1) {
        const type = this.detectEmojiType(emoji_id);
        format = this.getExtension(format, part);
        return this.data.emojis_base_url[type] + format + '/' + emoji_id + '.' + format + '?v=' + this.getValue('version');
    };

    WpReactions.prototype.pickerHavePair = function () {
        return this.picker_state.active.format.indexOf('/') > -1;
    };

    WpReactions.prototype.detectEmojiType = function (emoji_id) {
        return emoji_id > 200 ? 'custom' : 'builtin';
    };

    WpReactions.prototype.pickerSaved = function () {
        this.picker_state.saved = this.picker_state.chosen;
        this.$window.trigger('wpra.picker_state_changed');
    };

    WpReactions.prototype.get_picked_emojis = function () {
        let picked = [];
        this.$dom.picked_emojis.find('.picked-emoji').each(function () {
            picked.push($(this).data('emoji_id'));
        });
        return picked;
    };

    WpReactions.prototype.addLoadingOverlay = function (message) {
        this.$dom.loading_overlay.addClass('active');
        this.$dom.loading_overlay.find('.overlay-message').html(message);
    };

    WpReactions.prototype.removeLoadingOverlay = function () {
        this.$dom.loading_overlay.removeClass('active');
    };

    WpReactions.prototype.get_options = function () {
        let options = {};
        $('.option-wrap input, .option-wrap select').each(function () {
            let $elem = $(this);
            if ($elem.hasClass('wpra-no-save')) return;
            let type = $elem.attr('type');
            let key, val;
            if (type === 'radio') {
                if (!$elem.is(':checked')) return;
                key = $elem.attr('name');
                val = $elem.val();
            } else if (type === 'checkbox') {
                if ($elem.attr('name') === '') {
                    key = $elem.attr('id');
                    val = $elem.is(':checked') ? 'true' : 'false';
                } else {
                    key = $elem.attr('name');
                    val = [];
                    $('input[name=' + key + ']').each(function () {
                        $(this).is(':checked') && val.push($(this).val());
                    });
                }
            } else if (type === 'range') {
                const unit = $elem.data('unit');
                key = $elem.attr('id');
                val = $elem.val() + unit;
            } else {
                key = $elem.attr('id');
                val = $elem.val();
            }

            options[key] = val;
        });

        options['layout'] = this.url_params['layout'];
        let picked = this.get_picked_emojis();
        options['emojis'] = picked;
        options['picked_emojis'] = picked.join();

        return options;
    };

    WpReactions.prototype.get_preview = function (callbacks, options, sgc_id = 0) {
        $.ajax({
            url: this.getValue('ajaxurl'),
            dataType: 'text',
            type: 'post',
            data: {
                action: 'wpra_handle_admin_requests',
                sub_action: 'preview',
                options: JSON.stringify(options),
                sgc_id: sgc_id,
            },
            beforeSend: function () {
                if ('beforeSend' in callbacks) {
                    callbacks['beforeSend']();
                }
            },
            success: function (data) {
                if ('success' in callbacks) {
                    callbacks['success'](data, options);
                }
            },
            complete: function () {
                if ('complete' in callbacks) {
                    callbacks['complete']();
                }
            },
        });
    };

    WpReactions.prototype.change_social_button_style = function ($elem) {
        if ($elem.is(':checked')) {
            $('#social-border_color').enabled();
            $('#social-text_color').enabled();
            $('#social-bg_color').enabled();
        } else {
            $('#social-border_color').disabled();
            $('#social-text_color').disabled();
            $('#social-bg_color').disabled();
        }
        this.$dom.color_chooser.minicolors();
    };

    WpReactions.prototype.ajax_save_options = function (callbacks, options, extra = {}) {
        $.ajax({
            url: this.getValue('ajaxurl'),
            dataType: 'JSON',
            type: 'post',
            data: {
                action: 'wpra_handle_admin_requests',
                sub_action: 'save_options',
                options: JSON.stringify(options),
                extra: JSON.stringify(extra),
            },
            beforeSend: function () {
                if ('beforeSend' in callbacks) {
                    callbacks['beforeSend']();
                }
            },
            success: function (data) {
                if ('success' in callbacks) {
                    callbacks['success'](data);
                }
            },
            complete: function () {
                if ('complete' in callbacks) {
                    callbacks['complete']();
                }
            },
        });
    };

    WpReactions.prototype.stepChanged = function () {
        $(window).scrollTop(0);
        if (this.current_step > 1 && this.current_step < this.max_steps) {
            $('.floating-preview').show();
            $('.prev span').last().text(this.getText('global_prev_step'));
        } else {
            $('.floating-preview').hide();
            $('.prev span').last().text(this.getText('global_go_back'));
        }

        if (this.current_step === this.max_steps) {
            $('.next span').first().text(this.getText('global_start_over'));
            $('.next i').last().removeClass('qa-chevron-right').addClass('qa-redo');
        } else {
            $('.next span').first().text(this.getText('global_next_step'));
            $('.next i').last().removeClass('qa-redo').addClass('qa-chevron-right');
        }

        $('.wpra-stepper__body-item').removeClass('active');
        $('.wpra-stepper__body-item[data-body_id="' + this.current_step + '"]').addClass('active');

        if (this.current_step === this.max_steps) {
            let options = this.get_options();
            options['custom_data'] = {preview_source: 'final_step'};

            this.get_preview(
                {
                    beforeSend: function () {
                        $('#review-and-save').html('').html('<div class="wpra-spinner" style="width: 50px;height: 50px;"></div>');
                    },
                    success: function (data) {
                        $('#review-and-save').html(data);
                        const $plugin_container = $('#review-and-save .wpra-plugin-container');
                        WpReactionsFront.animate_emojis($plugin_container);
                        $plugin_container.addClass('wpra-rendered');
                    },
                },
                options
            );
        }

        if ($('input[name=enable_reveal_button]:checked').val() === 'true') {
            $('.option-reveal-button-styles').show();
            $('.enable_popup_share_opt').show();
        } else {
            $('.option-reveal-button-styles').hide();
            $('.enable_popup_share_opt').hide();
        }

        this.current_step - 2 === 0 && this.set_dynamic_option_blocks();
    };

    WpReactions.prototype.set_dynamic_option_blocks = function () {
        let self = this;

        $('.emoji-depended-block').each(function () {
            const option_name = $(this).data('option_name');
            const def_val = $(this).data('def_val');
            self.emoji_depended_block($(this), option_name, def_val);
        });
    };

    WpReactions.prototype.emoji_depended_block = function ($elem, option_name, def_val = '') {
        let self = this;
        let options = self.get_options();
        let picked_emojis = options['emojis'];
        if (picked_emojis.length === 0) return;
        let $item_clone = $elem.children().first().clone();
        $elem.html('');

        $.each(picked_emojis, function (key, emoji_id) {
            let $item = $item_clone.clone();
            let val = options[option_name + '-' + emoji_id] ? options[option_name + '-' + emoji_id] : def_val;
            $item.find('input').data('emoji_id', emoji_id);
            $item.find('input').attr('id', option_name + '-' + emoji_id);
            $item.find('input').val(val);
            let $item_label = $item.find('.icon-input-label');
            $item_label.html('');
            self.$window.trigger('wpra.load_emoji', [
                {
                    container: $item_label,
                    emoji_id: emoji_id,
                    source: 'emoji_depended_block',
                },
            ]);
            $elem.append($item);
        });
    };

    WpReactions.prototype.validate_empty_labels = function () {
        let self = this;
        let is_valid = true;
        $('.flying-labels-item input').each(function () {
            if (!self.is_valid_label($(this))) {
                is_valid = false;
                return false;
            }
        });
        return is_valid;
    };

    WpReactions.prototype.validate_range_inputs = function () {
        let self = this;
        let is_valid = true;
        $('.validate-range input').each(function () {
            if (!self.is_valid_range_input($(this))) {
                is_valid = false;
                return false;
            }
        });
        return is_valid;
    };

    WpReactions.prototype.is_valid_range_input = function ($input) {
        const value = $input.val();
        const range_items = value.split('-');
        if (!(/^\d+$/.test(range_items[0]) && /^\d+$/.test(range_items[1]) && parseInt(range_items[0]) <= parseInt(range_items[1]))) {
            WpReactionsUtils.showMessage(this.getText('wrong_range_input'), 'error');
            $input.addClass('is-invalid');
            $input.focus();
            return false;
        }
        $input.removeClass('is-invalid');
        return true;
    };

    WpReactions.prototype.is_valid_label = function ($input) {
        if ($input.val().length === 0) {
            WpReactionsUtils.showMessage(this.getText('has_an_empty_label'), 'error');
            $input.addClass('is-invalid');
            $input.focus();
            return false;
        }
        $input.removeClass('is-invalid');
        return true;
    };

    WpReactions.prototype.save_options = function (options, extra = {}) {
        let self = this;
        this.current_emojis = WpReactionsUtils.toIntegerArray(options.picked_emojis);
        let req = {
            beforeSend: function () {
                self.addLoadingOverlay(self.getText('options_updating'));
            },
            success: function (response) {
                WpReactionsUtils.showMessage(response.message, response.status);
            },
            complete: function () {
                self.removeLoadingOverlay();
            },
        };

        console.log(options)

        this.ajax_save_options(req, options, extra);
        this.pickerSaved();
    };

    WpReactions.prototype.isMaxSelected = function () {
        return this.picked_emojis.length === this.getValue('max_emojis', 'Number');
    };

    WpReactions.prototype.reset_picker = function () {
        this.$dom.picked_emojis.html('');
        this.$dom.emoji_pick.removeClass('active');
        $('.picker-empty').show();
        this.picked_emojis = [];
        this.need_reset_picker = false;
        this.picker_state.chosen = {
            format: this.picker_state.active.format,
            type: this.picker_state.active.type,
        };
        this.$window.trigger('wpra.picker_state_changed');
    };

    WpReactions.prototype.search_fa_icons = function (icon_name, callback) {
        let self = this;
        let fontawesome_api = this.getValue('fontawesome_api');
        let query_params = fontawesome_api.query_params.replace('{icon_name}', icon_name);
        let url_params = $.param(fontawesome_api.url_params);

        let req = {
            url: fontawesome_api.url + '?' + url_params,
            data: '{"params": "query=' + encodeURI(query_params) + '"}',
            contentType: 'application/json; charset=utf-8',
            dataType: 'JSON',
            type: 'POST',
            success: function (data) {
                let icons = [];
                $.each(data.hits, function (key, icon) {
                    $.each(icon.membership.free, function (key, type) {
                        let icon_name = self.fa_icon_types[type] + ' qa-' + icon.name;
                        icons.push({
                            name: icon_name,
                            label: icon.label,
                            type: type,
                        });
                    });
                });
                callback(icons);
            },
        };

        $.ajax(req);
    };

    WpReactions.prototype.do_sgc_nav = function (page, $btn) {
        const $my_sgc_table_holder = this.$dom.my_sgc_table_holder;

        $.ajax({
            url: this.getValue('ajaxurl'),
            dataType: 'text',
            type: 'post',
            data: {
                action: 'wpra_handle_admin_requests',
                sub_action: 'my_sgc_nav',
                page: page,
            },
            beforeSend: function () {
                $btn.disabled();
                $my_sgc_table_holder.addClass('active');
            },
            success: function (data) {
                $my_sgc_table_holder.html(data);
                $('.my-sgc-current-page').html(this.my_sgc_current_page);
            },
            complete: function () {
                $btn.enabled();
                $my_sgc_table_holder.removeClass('active');
            },
        });
    };

    WpReactions.prototype.searchShortcodes = function (needle) {
        const $my_sgc_table_holder = this.$dom.my_sgc_table_holder;

        if (needle.length === 0) {
            $('.my-sgc-table-navs').show();
            this.do_sgc_nav(1, $('.shortcode-nav-next'));
            return;
        }

        self.$dom.my_sgc_table_holder.addClass('active');
        self.$dom.my_sgc_table_holder.append('<div class="wpra-spinner" style="width: 50px;height: 50px;"></div>');

        this.send_post({
            data: {
                sub_action: 'search_shortcode',
                needle: needle,
            },
            success: function (response) {
                $my_sgc_table_holder.html(response);
                $('.my-sgc-table-navs').hide();
            },
            complete: function () {
                $my_sgc_table_holder.removeClass('active');
                $my_sgc_table_holder.find('.wpra-spinner').remove();
            },
        });
    };

    WpReactions.prototype.icon_search_box = function (needle, $input) {
        let $result = $input.siblings('.icon-search-box-result');
        $result.html('');
        if (needle.length === 0) {
            $result.hide();
            return;
        }
        $input.siblings('.wpra-spinner').show();
        this.search_fa_icons(needle, function (icons) {
            if (icons.length === 0) {
                $result.html('<p>No any icons found</p>');
                return;
            }
            let icon_grid_html = '<div class="icon-search-box-grid">';
            $.each(icons, function (key, icon) {
                icon_grid_html += '<div data-icon="' + icon.name + '" title="' + icon.label + ' - ' + icon.type + '"><i class="' + icon.name + '"></i></div>';
            });
            icon_grid_html += '</div>';
            $result.append(icon_grid_html);
            $result.show();
            $input.next('.wpra-spinner').hide();
        });
    };

    WpReactions.prototype.send_post = function (req_params) {
        req_params.data['action'] = 'wpra_handle_admin_requests';

        let req = {
            url: this.getValue('ajaxurl'),
            // dataType: 'JSON',
            type: 'post',
            data: req_params.data,
        };

        if (req_params.hasOwnProperty('success')) {
            req['success'] = function (resp) {
                req_params.success(resp);
            };
        }

        if (req_params.hasOwnProperty('complete')) {
            req['complete'] = req_params.complete;
        }

        $.ajax(req);
    };

    WpReactions.prototype.load_lazy_bg = function () {
        $('[data-bglazy]').each(function () {
            if ($(this).data('loaded') || !$(this).isInViewport()) return;
            $(this).css('background-image', `url(${$(this).data('bglazy')}`);
            $(this).data('loaded', true);
        });
    };

    WpReactions.prototype.register_events = function () {
        let self = this;

        $('.nav-pills a').click(function () {
            $(this).tab('show');
            let scroll_mem = $('body').scrollTop() || $('html').scrollTop();
            window.location.hash = this.hash;
            $('html,body').scrollTop(scroll_mem);
        });

        $('#save-shortcode').click(function () {
            let options = self.get_options();
            if (!self.validate_empty_labels()) return;

            let $btn = $(this);
            const shortcode_name = $('#shortcode-name').val();
            const shortcode_post_type = $('#shortcode_post_type').val();
            const front_render = $('#shortcode_front_render').is(':checked') ? 1 : 0;

            if (shortcode_name.length === 0) {
                WpReactionsUtils.showMessage(self.getText('no_shortcode_name'), 'error');
                return;
            }

            if (shortcode_name.length > 100) {
                WpReactionsUtils.showMessage(self.getText('max_shortcode_chars'), 'error');
                return;
            }

            $btn.html('<span class="wpra-spinner spinner-sm"></span>');
            $btn.disabled();

            self.send_post({
                data: {
                    sub_action: 'save_shortcode',
                    options: JSON.stringify(options),
                    shortcode_name: shortcode_name,
                    shortcode_post_type: shortcode_post_type,
                    front_render: front_render,
                    shortcode_id: self.shortcode_id,
                },
                success: function (response) {
                    self.shortcode_id = response.sgc_id;
                    $('#shortcode-result').val(response.shortcode);
                    $('.shortcode-ready').show();
                    WpReactionsUtils.showMessage(response.message, response.status);
                },
                complete: function () {
                    $btn.html(self.getText('sgc_btn_created'));
                    $btn.enabled();
                },
            });
        });

        self.$dom.picked_emojis.on('mouseenter', '.picked-emoji', function () {
            $(this).append('<span class="remove-picked-emoji">&times;</span>');
        });

        self.$dom.picked_emojis.on('mouseleave', '.picked-emoji', function () {
            $(this).find('.remove-picked-emoji').remove();
        });

        self.$dom.picked_emojis.on('click', '.remove-picked-emoji', function () {
            const emoji_id = $(this).parent().data('emoji_id');
            self.picked_emojis.splice(self.picked_emojis.indexOf(emoji_id), 1);
            $(this).parent().remove();
            $('.emoji-pick[data-emoji_id="' + emoji_id + '"]').removeClass('active');
            self.$dom.picked_emojis.children().length === 0 && $('.picker-empty').show();
        });

        $(document).on('change', '.validate-range input', function () {
            self.is_valid_range_input($(this));
        });

        $(document).on('change', '.flying-labels-item input', function () {
            self.is_valid_label($(this));
        });

        $('a').click(function (e) {
            let a_click_url = $(this).attr('href');
            let a_target = $(this).attr('target');

            if (typeof a_click_url == 'undefined' || a_click_url.indexOf('#') !== -1) {
                return;
            }

            let message = self.is_scg_page ? self.getText('sure_leave_sgc') : self.getText('sure_leave_global');

            if ((self.current_step > 1 && self.current_step < self.max_steps) || self.is_scg_page) {
                e.preventDefault();
                if (confirm(message)) {
                    if (a_target === '_blank') {
                        window.open(a_click_url, '_blank');
                    } else {
                        window.location.href = a_click_url;
                    }
                }
            }
        });

        $('#bgcolor_trans').change(function () {
            let is_trans = $(this).is(':checked');

            if (is_trans) {
                $('#bgcolor').disabled();
            } else {
                $('#bgcolor').enabled();
            }
        });

        $('.save-wpj-options').click(function () {
            if (self.getValue('min_emojis') > 0 && self.picked_emojis.length < self.getValue('min_emojis')) {
                WpReactionsUtils.showMessage(self.getText('layout_minimal_emojis'), 'error', 'long');
                return;
            }

            self.set_dynamic_option_blocks();

            if (!self.validate_empty_labels()) return;
            if (!self.validate_range_inputs()) return;

            let options = self.get_options();
            let new_emojis_int = WpReactionsUtils.toIntegerArray(options.picked_emojis);
            let new_emojis = options.emojis;
            let removed_from_old = WpReactionsUtils.differ(self.current_emojis, new_emojis_int);

            if (removed_from_old.length > 0) {
                $('.reset-emojis-holder').html('');
                $('.keep-emoji-stats').disabled();

                $.each(new_emojis, function (reaction, new_emoji_id) {
                    self.$window.trigger('wpra.load_emoji', [
                        {
                            container: $('.reset-emojis-target'),
                            emoji_id: new_emoji_id,
                            source: 'data_merge_target',
                        },
                    ]);
                });

                $.each(removed_from_old, function (index, emoji_id) {
                    self.$window.trigger('wpra.load_emoji', [
                        {
                            container: $('.reset-emojis-source'),
                            emoji_id: emoji_id,
                            source: 'data_merge_source',
                        },
                    ]);
                });

                $('.reset-emojis-source > div').draggable({
                    revert: 'invalid',
                    helper: 'clone',
                    cursor: 'move',
                });

                $('.reset-emojis-target > div > span').droppable({
                    accept: '.emoji-draggable',
                    activeClass: 'ui-state-highlight',
                    hoverClass: 'ui-state-hover',
                    classes: {
                        'ui-droppable-hover': 'ui-state-hover',
                        'ui-droppable-active': 'ui-state-highlight',
                    },
                    drop: function (event, ui) {
                        let $item = ui.draggable;
                        $item.addClass('reset-emojis-dropped');
                        $(this).append($item);
                        $('.reset-emojis-target > div > span').removeClass('ui-state-highlight'); // to fix class not removing bug

                        if ($('.reset-emojis-source').children().length === 1) {
                            $('.keep-emoji-stats').enabled();
                        }
                    },
                });

                $('#resetEmojiStats').modal('toggleBsModal');
                return;
            }

            self.save_options(options);
        });

        $('.take-action-before-save').click(function () {
            $('#resetEmojiStats').modal('toggleBsModal');
            let options = self.get_options();

            let user_migration = [];
            $('.reset-emojis-target > div > span').each(function () {
                let from = [];
                $(this)
                    .children()
                    .each(function () {
                        from.push($(this).data('emoji_id'));
                    });

                if (from.length > 0) {
                    user_migration.push({
                        to: $(this).data('emoji_id'),
                        from: from,
                    });
                }
            });

            let removed_emojis = [];
            $('.reset-emojis-source > div').each(function () {
                removed_emojis.push($(this).data('emoji_id'));
            });

            self.save_options(options, {
                action: $(this).data('action'),
                user_migration: user_migration,
                removed_emojis: removed_emojis,
            });
        });

        $('#social_style_buttons').click(function () {
            self.change_social_button_style($(this));
        });

        $('#shortcode-result').focusin(function () {
            $(this).select();
            document.execCommand('copy');
            $('#copied').fadeIn();
            setTimeout(function () {
                $('#copied').fadeOut();
            }, 3000);
        });

        $('.generated-sgc > input').focusin(function () {
            let $input = $(this);
            $input.select();
            document.execCommand('copy');
            $input.after('<span>Copied</span>');
            setTimeout(function () {
                $input.next('span').fadeOut();
            }, 3000);
        });

        $('#reset-shortcode').click(function () {
            window.location.reload();
        });

        $('.license-key-action').click(function () {
            let $btn = $(this);
            let btn_text = $btn.html();

            let email = $('#license_email').val();
            let license_key = $('#license_key').val();
            let license_action = $btn.attr('id');

            if (email === '' || license_key === '') {
                WpReactionsUtils.showMessage(self.getText('fill_all_fields'), 'error', 'stick');
                return;
            }

            let $activation_result = $('#activation-result');
            let $license_key_action = $('.license-key-action');

            $activation_result.hide();
            $license_key_action.disabled();

            if (license_action === 'activate') $btn.html('<span class="wpra-spinner spinner-sm"></span>');
            else if (license_action === 'revoke') $btn.append('<span class="wpra-spinner spinner-xs"></span>');

            self.send_post({
                data: {
                    sub_action: 'take_license_action',
                    license_action: license_action,
                    email: email,
                    license_key: license_key,
                },
                success: function (data) {
                    if (data['status'] === 'success') {
                        window.location.reload();
                    } else {
                        $activation_result.show();
                        $activation_result.html(data['message']);
                        $btn.html(btn_text);
                    }
                },
                complete: function () {
                    $license_key_action.enabled();
                },
            });
        });

        $('.floating-preview-close').click(function () {
            $('.floating-preview-holder').hide();
        });

        $('.floating-preview-holder').mouseleave(function () {
            $('.floating-preview-holder').hide();
        });

        $('.floating-preview-button').mouseenter(function () {
            let options = self.get_options();
            let request = {
                beforeSend: function () {
                    $('.floating-preview-holder').show();
                    $('.floating-preview-result').html('');
                    $('.floating-preview-loading').show();
                },
                success: function (data, options) {
                    if (options.layout === 'button_reveal') {
                        $('.floating-preview-holder').css({'padding-top': '160px'});
                    }
                    if (options.layout === 'button_reveal' && options.size === 'large') {
                        $('.floating-preview-holder').css({width: '1100px'});
                    }

                    $('.floating-preview-result').html(data);
                    let $plugin_container = $('.floating-preview-result .wpra-plugin-container');
                    WpReactionsFront.animate_emojis($plugin_container);
                    $plugin_container.addClass('wpra-rendered');
                },
                complete: function () {
                    $('.floating-preview-loading').hide();
                },
            };

            options['custom_data'] = {preview_source: 'floating_button'};

            self.get_preview(request, options);
        });

        $('.next').on('click', function () {
            if (self.getValue('min_emojis') > 0 && self.picked_emojis.length < self.getValue('min_emojis')) {
                WpReactionsUtils.showMessage(self.getText('layout_minimal_emojis'), 'error', 'long');
                return;
            }
            if (self.current_step === self.max_steps) {
                window.location.href = self.getValue('global_lp');
                return;
            }
            let $bar = $('.wpra-stepper__bar');
            if ($bar.children('.is-current').length > 0) {
                $bar.children('.is-current').removeClass('is-current').addClass('is-complete').next().addClass('is-current');
            } else {
                $bar.children().first().addClass('is-current');
            }
            self.current_step = $bar.children('.is-current').data('tab_id');
            self.stepChanged();
        });

        $('.prev').on('click', function () {
            if (self.current_step === 1) {
                window.location.href = self.getValue('global_lp');
                return;
            }
            if (self.current_step > 1) {
                let $bar = $('.wpra-stepper__bar');
                if ($bar.children('.is-current').length > 0) {
                    $bar.children('.is-current').removeClass('is-current').prev().removeClass('is-complete').addClass('is-current');
                } else {
                    $bar.children('.is-complete').last().removeClass('is-complete').addClass('is-current');
                }
                self.current_step = $bar.children('.is-current').data('tab_id');
                self.stepChanged();
            }
        });

        $('.wpra-stepper__bar-item').click(function () {
            if (self.getValue('min_emojis') > 0 && self.picked_emojis.length < self.getValue('min_emojis')) {
                WpReactionsUtils.showMessage(self.getText('layout_minimal_emojis'), 'error', 'long');
                return;
            }
            const $bar = $('.wpra-stepper__bar');
            $bar.children('.is-current').removeClass('is-current');
            $bar.children('.is-complete').removeClass('is-complete');
            $(this).addClass('is-current');
            $bar.children().each(function () {
                if (!$(this).hasClass('is-current')) {
                    $(this).addClass('is-complete');
                } else {
                    return false;
                }
            });
            self.current_step = $(this).data('tab_id');
            self.stepChanged();
        });

        self.$dom.tooltip.mouseover(function () {
            let $content = $(this).find('.wpra-tooltip-content-wrap');
            $content.css({top: 0, bottom: 'auto'});
            $content.fadeIn();
            $content.addClass('active');
            let right = $content.css('left');
            if ($content.offset().top > $(window).scrollTop() + $(window).height() - $content.outerHeight()) {
                $content.css({bottom: 0, top: 'auto'});
            }
            if ($content.offset().left + $content.outerWidth() > $(window).width()) {
                $content.css({right: right, left: 'auto'});
            }
            if ($content.offset().left < 0) {
                let x = $content.outerWidth() + $content.offset().left - 10;
                $content.css({transform: 'translateX(-' + x + 'px)', left: 0});
            }
        });

        self.$dom.tooltip.mouseleave(function () {
            let $content = $(this).find('.wpra-tooltip-content-wrap');
            $content.hide();
            $content.removeClass('active');
        });

        this.$dom.emoji_pick.click(function () {
            self.need_reset_picker && self.reset_picker();

            let $pick = $(this);
            let emoji_id = $pick.data('emoji_id');

            if ($pick.hasClass('active')) {
                $pick.removeClass('active');
                self.picked_emojis.splice(self.picked_emojis.indexOf(emoji_id), 1);
                $('.picked-emoji[data-emoji_id=' + emoji_id + ']').remove();
                self.$dom.picked_emojis.children().length === 0 && $('.picker-empty').show();
                return;
            }

            if (self.isMaxSelected()) {
                WpReactionsUtils.showMessage(self.getText('max_emojis_alert'), 'error', 'long');
                return;
            }

            $pick.addClass('active');
            self.picked_emojis.push(emoji_id);

            let $picked_emoji = $(`<div class="picked-emoji" data-emoji_id="${emoji_id}"><div class="picked-emoji-holder"></div></div>`).appendTo(self.$dom.picked_emojis);

            let $picked_emoji_holder = $picked_emoji.find('.picked-emoji-holder');

            self.$window.trigger('wpra.load_emoji', [
                {
                    container: $picked_emoji_holder,
                    emoji_id: emoji_id,
                    source: 'picked_emojis',
                },
            ]);

            $('.picker-empty').hide();
        });

        this.$dom.emoji_pick.mouseover(function () {
            if (!self.pickerHavePair()) return;
            let emoji_id = $(this).data('emoji_id');
            let $anim_holder = $(this).find('.emoji-pick-animated-holder');
            let $static_holder = $(this).find('.emoji-pick-static-holder');

            $anim_holder.show();
            $static_holder.hide();

            if (self.picker_state.active.format.indexOf('png/gif') > -1) {
                $anim_holder.find('img').length === 0 && $anim_holder.append(`<img src="${self.getEmojiUrl(emoji_id, 'gif')}">`);
                return;
            }

            self.play_lottie_emoji($anim_holder, emoji_id);
        });

        this.$dom.emoji_pick.mouseleave(function () {
            if (!self.pickerHavePair()) return;
            const $anime_holder = $(this).find('.emoji-pick-animated-holder');
            const $static_holder = $(this).find('.emoji-pick-static-holder');

            if (typeof $anime_holder.data('animation') !== 'undefined') {
                $anime_holder.data('animation').pause();
            }

            $anime_holder.hide();
            $static_holder.show();
        });

        $('.reset-emoji-picker').click(function () {
            self.reset_picker();
        });

        $('.start-sgc').click(function () {
            if (self.getValue('min_emojis') > 0 && self.picked_emojis.length < self.getValue('min_emojis')) {
                WpReactionsUtils.showMessage(self.getText('layout_minimal_emojis'), 'error', 'long');
                return;
            }
            $('.shortcode-builder-emoji-groups').hide();
            $('.shortcode-builder-options').show();
            $('.floating-preview').addClass('active');
            $(window).scrollTop(0);

            self.picked_emojis = self.get_picked_emojis();
            let $emojis_set_item = $('.emojis-set-items .emojis-set-item');
            $emojis_set_item.hide();

            $.each(self.picked_emojis, function (key, emoji_id) {
                $emojis_set_item.eq(key).show();
                let $emoji_holder = $emojis_set_item.eq(key).find('.emojis-set-item-holder').html('');

                self.$window.trigger('wpra.load_emoji', [
                    {
                        container: $emoji_holder,
                        emoji_id: emoji_id,
                        source: 'emojis_set_item',
                    },
                ]);
            });

            self.set_dynamic_option_blocks();
        });

        $('.sgc-go-back').click(function () {
            $('.shortcode-builder-emoji-groups').show();
            $('.shortcode-builder-options').hide();
            $('.floating-preview').removeClass('active');
            $(window).scrollTop(0);
        });

        $('.scg_goto_groups').click(function () {
            let url = window.location.href;
            let layout = $('input[name="shortcode_layout"]:checked').attr('id');
            window.location.href = url + '&layout=' + layout;
        });

        $('#customize').click(function () {
            let url = window.location.href;
            let layout = $('input[name="global_layout"]:checked').attr('id');
            window.location.href = url + '&layout=' + layout;
        });

        let $resetGlobalOptionsModal = $('#resetGlobalOptionsModal');

        $('#resetGlobalOptionsToggle').click(function () {
            $resetGlobalOptionsModal.modal('toggleBsModal');
        });

        $('#doResetGlobalOptions').click(function () {
            $resetGlobalOptionsModal.data('reset', true);
            $resetGlobalOptionsModal.modal('hide');
        });

        $resetGlobalOptionsModal.on('hidden.bs.modal', function () {
            if (!$resetGlobalOptionsModal.data('reset')) return;

            self.addLoadingOverlay(self.getText('resetting_options'));

            self.send_post({
                data: {
                    sub_action: 'reset_global',
                },
                success: function (response) {
                    if (response.status === 'success') {
                        $('.loading-overlay .overlay-message').html(response.message);
                        window.location.reload();
                    } else {
                        WpReactionsUtils.showMessage(response.message, response.status);
                        self.removeLoadingOverlay();
                    }
                },
            });
        });

        $('input[name="global_layout"]').change(function () {
            let sw = $(this);
            let $pairs = $('input[name="global_layout"]');
            if (sw.is(':checked')) {
                $pairs.prop('checked', false);
                sw.prop('checked', true);
            }

            let activation = sw.is(':checked') > 0 ? 'true' : 'false';

            if (activation === 'false') {
                $('#customize').disabled();
            } else {
                $('#customize').enabled();
            }

            self.ajax_save_options(
                {
                    beforeSend: function () {
                        sw.parents('.wpe-switch').before('<div class="wpra-spinner active"></div>');
                    },
                    success: function (response) {
                        WpReactionsUtils.showMessage(response.message, response.status);
                    },
                    complete: function () {
                        sw.parents('.wpe-switch-wrap').find('.wpra-spinner').remove();
                    },
                },
                {activation: activation, layout: sw.attr('id')},
                {single: 1}
            );
        });

        $('.floating-menu-toggler').click(function (e) {
            e.stopPropagation();
            if ($('.floating-menu').hasClass('active')) {
                $('.floating-menu').removeClass('active');
            } else {
                $('.floating-menu').addClass('active');
            }
        });

        $('.floating-menu').click(function (e) {
            e.stopPropagation();
        });

        $(document).click(function () {
            $('.floating-menu').removeClass('active');
        });

        $(window).scroll(function () {
            if ($('.floating-menu').hasClass('active')) {
                $('.floating-menu').removeClass('active');
            }

            if ($(window).width() < 768) {
                let scrollTop = $(this).scrollTop();
                let adminBarHeight = $('#wpadminbar').outerHeight();
                let headerHeight = $('.wpra-options-header').outerHeight();
                if (scrollTop > adminBarHeight) {
                    $('.wpra-options-header').css('top', 0);
                    $('.floating-menu').css({top: headerHeight});
                } else {
                    $('.wpra-options-header').css('top', adminBarHeight - scrollTop);
                    $('.floating-menu').css('top', headerHeight + adminBarHeight);
                }
            }

            self.load_lazy_bg();
        });

        $('.wp-admin').on('click', '.wpra-share-wrap .share-btn', function (e) {
            e.preventDefault();
            return false;
        });

        $('a[href="#toggle-feedback-form"]').click(function (e) {
            e.preventDefault();
            $('#wpraFeedbackForm').modal('toggleBsModal');
        });

        $('.wpra-submit-feedback').click(function () {
            let email = $('#feedback-email').val() === '' ? 'No Email' : $('#feedback-email').val();
            let message = $('#feedback-message').val();
            let rating = $('.rating-item.selected').data('label');
            let $btn = $(this);

            if (!rating) {
                WpReactionsUtils.showMessage('Please select your rating!', 'error');
                return;
            }

            if (!message) {
                WpReactionsUtils.showMessage('Please tell us something about your experience', 'error');
                return;
            }

            $btn.disabled();
            $btn.append('<span class="wpra-spinner spinner-modal-btn"></span>');

            self.send_post({
                data: {
                    sub_action: 'submit_feedback',
                    email: email,
                    message: message,
                    rating: rating,
                },
                success: function (response) {
                    if (response.status === 'success') {
                        $('#wpraFeedbackForm').find('.modal-body').html(`<p class="text-center">${response.message}</p>`).css('color', '#1e7e34');
                    }
                },
                complete: function () {
                    $btn.enabled();
                },
            });
        });

        $('.shortcode-nav-next').click(function () {
            if (self.my_sgc_current_page === self.my_sgc_max_page) {
                return;
            }
            let $btn = $(this);
            self.my_sgc_current_page++;
            self.do_sgc_nav(self.my_sgc_current_page, $btn);
        });

        $('.shortcode-nav-prev').click(function () {
            if (self.my_sgc_current_page === 1) {
                return;
            }
            let $btn = $(this);
            self.my_sgc_current_page--;
            self.do_sgc_nav(self.my_sgc_current_page, $btn);
        });

        $('.shortcode-nav-start').click(function () {
            if (self.my_sgc_current_page === 1) {
                return;
            }
            let $btn = $(this);
            self.my_sgc_current_page = 1;
            self.do_sgc_nav(self.my_sgc_current_page, $btn);
        });

        $('.shortcode-nav-end').click(function () {
            if (self.my_sgc_current_page === self.my_sgc_max_page) {
                return;
            }
            let $btn = $(this);
            self.my_sgc_current_page = self.my_sgc_max_page;
            self.do_sgc_nav(self.my_sgc_current_page, $btn);
        });

        self.$dom.my_sgc_table_holder.on('click', '.sgc-delete', function () {
            if (!confirm(self.getText('sure_delete_shortcode'))) {
                return;
            }

            let $btn = $(this);
            let sgc_id = $btn.parents('tr').data('sgc_id');

            $btn.disabled();
            self.$dom.my_sgc_table_holder.addClass('active');
            self.$dom.my_sgc_table_holder.append('<div class="wpra-spinner" style="width: 50px;height: 50px;"></div>');

            self.send_post({
                data: {
                    sub_action: 'delete_shortcode',
                    sgc_id: sgc_id,
                },
                success: function (response) {
                    if (response.status === 'success') {
                        $btn.parents('tr').fadeOut(400, 'swing', function () {
                            $(this).remove();
                            self.my_sgc_count--;
                            $('.my-sgc-count').html(self.my_sgc_count);
                            if (self.my_sgc_count === 0) {
                                $('.my-shortcodes-table-navs').hide();
                            }
                            if ($('.my-shortcodes-table').find('td').length === 0) {
                                self.my_sgc_max_page--;
                                if (self.my_sgc_current_page > 1) {
                                    self.my_sgc_current_page--;
                                }
                                $('.my-sgc-max-page').html(self.my_sgc_max_page);
                                self.do_sgc_nav(self.my_sgc_current_page, $('.shortcode-nav-next'));
                            }
                        });
                    }
                    WpReactionsUtils.showMessage(response.message, response.status);
                },
                complete: function () {
                    $btn.enabled();
                    self.$dom.my_sgc_table_holder.removeClass('active');
                    self.$dom.my_sgc_table_holder.find('.wpra-spinner').remove();
                },
            });
        });

        self.$dom.my_sgc_table_holder.on('click', '.sgc-clone', function () {
            let $btn = $(this);
            let sgc_id = $btn.parents('tr').data('sgc_id');

            $btn.disabled();
            self.$dom.my_sgc_table_holder.addClass('active');
            self.$dom.my_sgc_table_holder.append('<div class="wpra-spinner" style="width: 50px;height: 50px;"></div>');

            self.send_post({
                data: {
                    sub_action: 'clone_shortcode',
                    sgc_id: sgc_id,
                },
                success: function (response) {
                    if (response.status === 'success') {
                        window.location.reload();
                    }
                },
                complete: function () {
                    $btn.enabled();
                },
            });
        });

        self.$dom.my_sgc_table_holder.on('click', '.sgc-edit', function (e) {
            e.preventDefault();
            let $btn = $(this);
            let sgc_id = $btn.parents('tr').data('sgc_id');

            $btn.disabled();
            $('.loading-overlay').addClass('active');
            $('.loading-overlay .overlay-message').html('Preparing Shortcode...');

            self.send_post({
                data: {
                    sub_action: 'edit_shortcode',
                    sgc_id: sgc_id,
                },
                success: function (response) {
                    if (response.status === 'success') {
                        window.location.href = response.sgc_edit_url;
                    }
                },
                complete: function () {
                    $btn.enabled();
                },
            });
        });

        $('.woo-sgc-edit').click(function (e) {
            e.preventDefault();
            let $btn = $(this);
            let sgc_id = $btn.data('sgc_id');

            $btn.disabled();
            $('.loading-overlay').addClass('active');

            self.send_post({
                data: {
                    sub_action: 'edit_shortcode',
                    sgc_id: sgc_id,
                },
                success: function (response) {
                    if (response.status === 'success') {
                        window.location.href = response.sgc_edit_url;
                    }
                },
                complete: function () {
                    $btn.enabled();
                },
            });
        });

        self.$dom.my_sgc_table_holder.on('mouseenter', '.sgc-view', function () {
            let $btn = $(this);
            let $holder = $btn.find('.sgc-view-popup > span');
            let sgc_id = $btn.parents('tr').data('sgc_id');

            let t = setTimeout(function () {
                self.get_preview(
                    {
                        beforeSend: function () {
                            $btn.find('.sgc-view-popup').show();
                            $holder.html('<div class="wpra-spinner" style="width: 50px;height: 50px;"></div>');
                            if ($btn.find('.sgc-view-popup').offset().top > $(window).scrollTop() + $(window).height() - $btn.find('.sgc-view-popup').outerHeight()) {
                                $btn.find('.sgc-view-popup').css({bottom: 0, top: 'auto'});
                            }
                        },
                        success: function (data) {
                            $holder.html(data);
                            $holder.addClass('sgc-view-added');
                            const $plugin_container = $btn.find('.wpra-plugin-container');
                            WpReactionsFront.animate_emojis($plugin_container);
                            $plugin_container.addClass('wpra-rendered');
                        },
                    },
                    null,
                    sgc_id
                );
            }, 500);

            self.sgc_view_timers.push(t);
        });

        $('#search-shortcodes').keyup(function () {
            let needle = $(this).val();
            clearTimeout($.data(this, 'timer'));
            let wait = setTimeout(function () {
                self.searchShortcodes(needle);
            }, 500);
            $(this).data('timer', wait);
        });

        self.$dom.my_sgc_table_holder.on('mouseleave', '.sgc-view', function () {
            let $btn = $(this);
            let $holder = $btn.find('.sgc-view-popup > span');
            $btn.find('.sgc-view-popup').hide();
            $holder.html('');
            $.each(self.sgc_view_timers, function (key, timer) {
                clearTimeout(timer);
            });
        });

        $('.feedback-ratings .rating-item').click(function () {
            $(this).siblings().removeClass('selected');
            $(this).addClass('selected');
        });

        $('.wpra-save-settings').click(function () {
            let $btn = $(this);
            let $settings = $('#wpra-settings-tabContent');
            let wpra_settings = $settings.readFormValues();

            if (wpra_settings.woo_integration === 1 && wpra_settings.woo_shortcode_id === 0) {
                WpReactionsUtils.showMessage(self.getText('woo_no_shortcode'), 'error');
                $('ul.nav-pills a[href="#wpra-woocommerce-content"]').tab('show');
                return;
            } else if (wpra_settings.woo_location === 'woocommerce_use_custom_hook' && wpra_settings.woo_custom_product_hook === '') {
                WpReactionsUtils.showMessage(self.getText('woo_empty_hook'), 'error');
                $('ul.nav-pills a[href="#wpra-woocommerce-content"]').tab('show');
                $settings.find('#woo_custom_product_hook').focus();
                return;
            }

            $btn.disabled();
            $('.loading-overlay').addClass('active');

            self.send_post({
                data: {
                    sub_action: 'save_settings',
                    settings: JSON.stringify(wpra_settings),
                },
                success: function (response) {
                    WpReactionsUtils.showMessage(response.message, response.status);
                    $('.woo-sgc-edit').data('sgc_id', wpra_settings.woo_shortcode_id);
                },
                complete: function () {
                    $btn.enabled();
                    $('.loading-overlay').removeClass('active');
                },
            });
        });

        $('.radio-image-label').click(function () {
            $(this).find('input[type=radio]').prop('checked', true);
        });

        $('.radio-image-label .woo-location-zoom > i').on('click', function () {
            let preview = $(this).siblings('img').attr('src');
            let title = $(this).siblings('img').attr('title');
            let $html = '<div class="wpra-woo-preview">';
            $html += '<div class="wpra-woo-preview-header">' + title + '<span>&times;</span></div>';
            $html += '<div class="wpra-woo-preview-body"><img src="' + preview + '" alt=""></div>';
            $html += '</div>';
            $(this).parent().append($html);
            $(this).parent().find('.wpra-woo-preview').fadeIn();
        });

        $(document).on('click', '.wpra-woo-preview-header > span', function () {
            $('.wpra-woo-preview').remove();
        });

        $('.icon-search-box input').on('keyup', function () {
            let $input = $(this);
            let needle = $input.val();
            if (needle.length > 0 && needle.length < 3) return;
            clearTimeout($.data(this, 'timer'));
            let wait = setTimeout(function () {
                self.icon_search_box(needle, $input);
            }, 500);
            $(this).data('timer', wait);
        });

        $(document).on('click', '.icon-search-box-grid > div', function () {
            let icon = $(this).data('icon');
            let $icon_box = $(this).parents('.icon-search-box');
            let $selected = $icon_box.find('.icon-search-box-selected');
            let $result = $icon_box.find('.icon-search-box-result');
            $icon_box.find('.icon-search-input').val('');
            $icon_box.find('.icon-search-box-value').val(icon);
            $selected.html('<i class="' + icon + '"></i>');
            $result.html('');
            $result.hide();
        });

        $('#reset-reaction-counts').click(function () {
            let $btn = $(this);
            let global = $('#reset_reactions_global').is(':checked') ? 1 : 0;
            let shortcode = $('#reset_reactions_shortcodes').is(':checked') ? 1 : 0;

            if (global === 0 && shortcode === 0) {
                WpReactionsUtils.showMessage('Please check what you want to be reset', 'error');
                return;
            }

            if (!confirm('Are you sure to reset counts')) return;

            $btn.disabled();
            self.addLoadingOverlay('Resetting reaction counts...');

            self.send_post({
                data: {
                    sub_action: 'reset_reaction_counts',
                    global: global,
                    shortcode: shortcode,
                },
                success: function (response) {
                    WpReactionsUtils.showMessage(response.message, response.status);
                },
                complete: function () {
                    $btn.enabled();
                    self.removeLoadingOverlay();
                },
            });
        });

        $('#revoke-license').click(function () {
            $('#revokeModal').modal('toggleBsModal');
        });

        $('.generate-fake-rand-counts').click(function () {
            let type = $(this).data('type');
            let post_types = [];

            $('input[name=generate-fake-post-types]').each(function () {
                $(this).is(':checked') && post_types.push($(this).val());
            });

            if (post_types.length === 0) {
                WpReactionsUtils.showMessage('Please choose one post type at least', 'error');
                return;
            }

            self.addLoadingOverlay('Generating random fake counts...');

            self.send_post({
                data: {
                    sub_action: 'generate_random_fake_counts',
                    post_types: JSON.stringify(post_types),
                    type: type,
                },
                success: function (response) {
                    WpReactionsUtils.showMessage(response.message, response.status);
                },
                complete: function () {
                    self.removeLoadingOverlay();
                },
            });
        });

        $(document).on('click', function () {
            $('.wpra-searchable-input-dropdown').removeClass('active');
            $('.wpra-searchable-input-arrow').removeClass('active');
        });

        $('.wpra-searchable-input input[type=text]').click(function (e) {
            e.stopPropagation();
            let $searchable = $(this).parents('.wpra-searchable-input');
            $searchable.find('.wpra-searchable-input-dropdown-values').addClass('active');
            $searchable.find('.wpra-searchable-input-arrow').addClass('active');
        });

        $('.wpra-searchable-input').on('click', '.wpra-searchable-input-dropdown-value', function () {
            let $searchable = $(this).parents('.wpra-searchable-input');
            $searchable.find('.wpra-searchable-input-dropdown').removeClass('active');
            $searchable.find('.wpra-searchable-input-arrow').removeClass('active');
            $searchable.find('input[type=text]').val($(this).text());
            $searchable.find('input[type=hidden]').val($(this).data('value'));
            $searchable.find('input[type=hidden]').trigger('searchable.change');
        });

        $('.wpra-searchable-input input[type=text]').keyup(function () {
            let search = $(this).val();
            let $searchable = $(this).parents('.wpra-searchable-input');
            $searchable.find('.wpra-searchable-input-dropdown-values').removeClass('active');
            let $found = $searchable.find('.wpra-searchable-input-dropdown-values > div:icontains(' + search + ')').clone();
            $searchable.find('.wpra-searchable-input-dropdown-search').addClass('active').html($found);
        });

        this.$window.on('wpra.analytics.emotional_data_loaded', function () {
            $('.emotional-data-emoji').each(function () {
                self.$window.trigger('wpra.load_emoji', [
                    {
                        container: $(this),
                        emoji_id: $(this).data('emoji_id'),
                        source: 'emotional_data',
                    },
                ]);
            });
        });

        let $floating_button = $('.floating-button');
        if ($floating_button.isThere()) {
            $floating_button.addClass('active');

            $(window).scroll(function () {
                if ($('.picked-emojis').isInViewport()) {
                    $floating_button.removeClass('active');
                } else {
                    $floating_button.addClass('active');
                }
            });
        }

        $('.wpra-range-slider input').on('change', function () {
            const value = $(this).val();
            const unit = $(this).data('unit');
            $(this)
                .parents('.wpra-range-slider')
                .find('.wpra-range-slider-curr-val')
                .text(value + unit);
        });

        $('[data-factory_value]').on('click', function () {
            const factory_value = $(this).data('factory_value');
            const $input = $(this).parents('.wpra-field').find('input');
            $input.val(factory_value);
            $input.trigger('change');
        });

        $('.wpra-range-slider-change').on('click', function () {
            const change = $(this).data('change');
            const $input = $(this).parent().find('input');
            const cur_val = +$input.val();
            $input.val(change === 'plus' ? cur_val + 1 : cur_val - 1);
            $input.trigger('change');
        });

        function animation_state_option_changed() {
            const val = $('input[name=animation]:checked').val();
            if (val === 'true') {
                $('.option-emoji-adjust-static').hide().addClass('mb-3');
                $('.option-emoji-adjust-animated').show();
            } else if (val === 'false') {
                $('.option-emoji-adjust-static').show().removeClass('mb-3');
                $('.option-emoji-adjust-animated').hide();
            } else {
                $('.option-emoji-adjust-static').show().addClass('mb-3');
                $('.option-emoji-adjust-animated').show();
            }
        }

        animation_state_option_changed();

        $('input[name=animation]').on('change', animation_state_option_changed);

        $('.wpra-color-input-states > span').on('click', function () {
            const state = $(this).data('state');
            const $parent = $(this).parents('.wpra-color-input');
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            $parent.find('.minicolors').hide();
            $parent.find(`input[data-state=${state}]`).parent().show();
        });

        this.$window.on('wpra.load_emoji', function (e, data) {
            const emoji_id = data.emoji_id;
            const $container = data.container;

            let sources = {
                emojis_set_item: function () {
                    $container.css('background-image', `url('${self.getEmojiUrl(emoji_id, self.picker_state.chosen.format)}')`);
                },
                picked_emojis: function () {
                    $container.css('background-image', `url('${self.getEmojiUrl(emoji_id, self.picker_state.active.format)}')`);
                },
                picked_emoji: function () {
                    $container.css('background-image', `url('${self.getEmojiUrl(emoji_id, self.picker_state.saved.format)}')`);
                },
                emoji_depended_block: function () {
                    $container.css('background-image', `url(${self.getEmojiUrl(emoji_id, self.picker_state.chosen.format)})`);
                },
                data_merge_target: function () {
                    $container.append(`<div><span data-emoji_id="${emoji_id}"></span><img src="${self.getEmojiUrl(emoji_id, self.picker_state.chosen.format)}"></div>`);
                },
                data_merge_source: function () {
                    $container.append(`<div class="emoji-draggable" data-emoji_id="${emoji_id}"><img src="${self.getEmojiUrl(emoji_id, self.picker_state.saved.format)}"></div>`);
                },
                emotional_data: function () {
                    $container.css('background-image', `url(${self.getEmojiUrl(emoji_id, 'svg')})`);
                },
            };

            sources[data.source]();
        });
    };

    new WpReactions(wpreactions);
});
