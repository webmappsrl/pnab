var TotalPoll = {
    Editor: {
        pollId: false,
    },
    API: {},
    VERSION: 3.0,
    i18n: i18nTotalPoll,
};

// Container
TotalPoll.API.Container = function (el, options) {
    var _this = this;
    this.options = options || {};
    this.templates = {};
    this.containables = {};
    this.$el = jQuery(el);
    this.$container = this.$el.find(this.options.items.container);
    this.sortable = this.$container.attr(this.options.items.sortableAttr) !== undefined;
    // Parse templates
    jQuery(this.options.templates.item).each(function () {
        var type = jQuery(this).data(_this.options.templates.dataNameAttr);
        _this.templates[type] = jQuery(this).html().replace(/(\r\n|\n|\r)/gm, '').trim();
    });
    // Insert
    this.$el.on('click', this.options.buttons, function () {
        _this.insert(_this.templates[jQuery(this).val()]);
    });
    // Add existing containables
    this.$el.find(this.options.items.item.container).each(function () {
        _this.insert(jQuery(this));
    });

    return this;
};
TotalPoll.API.Container.prototype.insert = function ($el) {
    var index;
    var id;

    if (typeof $el === 'string') {
        id = Date.now();
        index = this.$container.find(this.options.items.item.container).length;
    } else {
        id = $el.attr(this.options.items.item.idAttr);
        index = $el.index();
    }
    var containable = new TotalPoll.API.Containable(id, $el, index, this);
    this.containables[id] = containable;

    this.$container.append(containable.$el);
    this.containables[id].rich();
    if (this.sortable) {
        this.sort();
    }

    return this.containables[id];

};
TotalPoll.API.Container.prototype.sort = function () {

    var _this = this;

    if (this.$container.data('sortableInstance') !== undefined) {
        this.$container.sortable('option', 'start')();
        this.$container.sortable('option', 'stop')();
        this.$container.sortable('refresh');
        return;
    }

    this.options.items.sortable.start = function () {
        _this.$container.find('input[type="radio"],input[type="checkbox"]').each(function () {
            jQuery(this).data('wasChecked', jQuery(this).is(':checked'))
        });
    };
    this.options.items.sortable.stop = function () {
        // TinyMce re-initializing
        if (typeof tinymce.editors !== 'undefined') {
            jQuery(tinymce.editors).each(function () {
                var selector = '#wp-' + this.settings.id + '-wrap.tmce-active';
                this.destroy();
                setTimeout(function () {
                    jQuery(selector).find('.switch-tmce').click();
                }, 100);
            });
        }
        _this.refresh();
    };
    var sortableInstance = this.$container.sortable(this.options.items.sortable);
    sortableInstance.disableSelection();
    this.$container.data('sortableInstance', sortableInstance);
    return;
};

TotalPoll.API.Container.prototype.refresh = function () {
    // Renaming
    this.$container.find(this.options.items.item.container).each(function () {
        var $item = jQuery(this);
        $item.find('[data-rename]').each(function () {
            var $this = jQuery(this);
            var wasChecked = $this.data('wasChecked');
            $this.attr('name', $this.attr('data-rename').replace(/\{\{new-index\}\}/gi, $item.index()));
            if (wasChecked !== undefined) {
                $this[0].checked = wasChecked;
            }

        });
    });
};

// Containable
TotalPoll.API.Containable = function (id, el, index, parent) {
    var _this = this;
    this.id = id;
    this.parent = parent;
    if (typeof el === 'string') {
        this.$el = jQuery(el.replace(/\{\{index\}\}/gi, index).replace(/\{\{id\}\}/gi, this.id));
    } else {
        this.$el = el;
    }

    this.$content = this.$el.find(parent.options.items.item.content);
    this.$handle = this.$el.find(parent.options.items.item.handle);
    this.$remove = this.$el.find(parent.options.items.item.remove);
    this.$preview = this.$el.find(this.parent.options.items.item.preview);
    this.$previewSource = this.$el.find(parent.options.items.item.previewSource);
    this.$upload = this.$el.find(parent.options.items.item.upload.button);

    // Preview
    this.$previewSource.on('change keyup keydown', function () {
        _this.preview();
    }).trigger('change');

    // Remove
    this.$remove.on('click', function () {
        _this.remove();
        parent.refresh();
    });

    // Toggle
    this.$handle.on('click', function (e) {
        if (e.target == e.delegateTarget || e.target == _this.$preview[0]) {
            _this.toggle();
        }
    });
    // Upload
    this.$upload.each(function () {
        var $upload = jQuery(this);
        var $fields = {
            $id: _this.$el.find($upload.attr(_this.parent.options.items.item.upload.idAttr)),
            $label: _this.$el.find($upload.attr(_this.parent.options.items.item.upload.labelAttr)),
            $sizes: _this.$el.find($upload.attr(_this.parent.options.items.item.upload.sizesAttr)),
            $full: _this.$el.find($upload.attr(_this.parent.options.items.item.upload.fullAttr)),
            $thumbnail: _this.$el.find($upload.attr(_this.parent.options.items.item.upload.thumbnailAttr)),
        };

        $upload.on('click', function () {
            var type = $upload.attr(_this.parent.options.items.item.upload.typeAttr);
            _this.upload(type, $fields);
        });

        _this._uploadSizesHandler($fields);

    });

    return this;
};
TotalPoll.API.Containable.prototype.upload = function (type, fields) {
    var _this = this;
    TotalPoll.Media.open(type, function () {
        _this._uploadHandle.call(_this, fields, this);
    });
};
TotalPoll.API.Containable.prototype._uploadHandle = function (fields, attachement) {
    var media = attachement.get('selection').first();

    if (media.attributes['sizes']) {
        fields.$sizes.empty();

        var $options = jQuery.map(media.attributes.sizes, function (props, size) {
            var $option = jQuery('<option></option>', {value: props.url}).text(size);
            return $option;
        });
        fields.$sizes.append($options).trigger('change');
    }

    fields.$full.val(media.attributes.url);

    if (!fields.$label.val()) {
        fields.$label.val(media.attributes.title || media.attributes.name).trigger('change');
    }

    fields.$id.val(media.attributes.id);

};
TotalPoll.API.Containable.prototype._uploadSizesHandler = function (fields) {
    fields.$sizes.off('change').on('change', function () {
        fields.$thumbnail.val(jQuery(this).val());
    });

};
TotalPoll.API.Containable.prototype.preview = function () {
    var text = this.$previewSource.val();
    this.$preview.text(text.substr(0, 30) + (text.length > 30 ? '...' : ''));
    return true;
};
TotalPoll.API.Containable.prototype.remove = function () {
    if (confirm(TotalPoll.i18n.sure)) {
        this.$el.remove();
        delete this.parent.containables[this.id];
    }

    return false;
};
TotalPoll.API.Containable.prototype.toggle = function () {
    if (!this.$el.hasClass('ui-sortable-helper')) {
        this.$content.toggle(0, jQuery.proxy(function () {
            this.$el.toggleClass(this.parent.options.items.item.toggleClass);
        }, this));
    }

    return false;
};
TotalPoll.API.Containable.prototype.rich = function () {
    if (this.$el.find('.wp-editor-area').length > 0) {
        var id = 'tinymce-' + this.id;
        var settings = jQuery.extend(true, {}, tinyMCEPreInit.mceInit['totalpollTinyMceTemplate']);
        settings.selector = '#' + id;

        tinyMCEPreInit.mceInit[id] = settings;
        tinymce.init(settings);

        quicktags({id: id, buttons: tinyMCEPreInit.qtInit['totalpollTinyMceTemplate'].buttons});
        QTags._buttonsInit();
    }
};

// Media browser/uploader
TotalPoll.API.Media = function () {
    this._frame = false;
    return this;
};
TotalPoll.API.Media.prototype.frame = function (type) {
    if (!this._frame) {

        this._frame = wp.media({
            title: wp.media.view.l10n.insertMediaTitle,
            multiple: false,
            library: {
                type: type
            }
        });
    }

    if (type !== this._frame.options.library.type) {
        this._frame = false;
        this.frame(type);
    }

    return this._frame;
};
TotalPoll.API.Media.prototype.open = function (type, callback) {
    this.frame(type).open();
    if (typeof callback === 'function') {
        this._frame.state('library').off('select').on('select', callback);
    }
};

// Tabs
TotalPoll.API.Tabs = function (el, options) {
    var _this = this;

    this.$el = jQuery(el);
    this.options = options || {};

    this.$el.on('click', '[%attr%]'.replace('%attr%', this.options.tabAttr), function (e) {
        _this.tab(this);
        return false;
    });
};
TotalPoll.API.Tabs.prototype.tab = function (el) {
    var $tab = jQuery(el);
    var $tabs = $tab.parent().find('> [%attr%]'.replace('%attr%', this.options.tabAttr));
    var selector = '[%attr%="%val%"]'
        .replace('%attr%', this.options.tabContentAttr)
        .replace('%val%', $tab.attr(this.options.tabAttr));
    var $target = jQuery(selector);
    var $tabsContents = $target.parent().find('> [%attr%]'.replace('%attr%', this.options.tabContentAttr));

    $tabs.removeClass('active');
    $tab.addClass('active');

    $tabsContents.removeClass('active');
    $target.addClass('active');
};

// Toggleables
TotalPoll.API.Toggleables = function (el, options) {
    var _this = this;

    this.$el = jQuery(el);
    this.options = options || {};

    this.$el.on('click change', '[%attr%]'.replace('%attr%', this.options.toggleAttr), function (e) {
        if (e.type === 'click' && e.target.tagName === 'INPUT') {
            return true;
        }
        _this.toggle(this, e);
        if (e.type === 'click' && (e.target.tagName === 'A' || e.target.tagName === 'BUTTON')) {
            return false;
        }
    });
};
TotalPoll.API.Toggleables.prototype.toggle = function (el, event) {
    var selector = '[%attr%="%val%"]'
        .replace('%attr%', this.options.toggleableAttr)
        .replace('%val%', jQuery(el).attr(this.options.toggleAttr));

    var $el = this.$el.find(selector);
    var toggled = !$el.data('toggled');

    if (event['target']['tagName'] === 'INPUT') {
        toggled = event.target.checked;
    }

    $el
        [toggled ? 'addClass' : 'removeClass']('active')
        .data('toggled', toggled);

};

// Paginate
TotalPoll.API.Paginate = function (el, options) {
    var _this = this;

    this.options = options || {};
    this.$el = jQuery(el);
    this.$body = this.$el.find(this.options.body);
    this.$buttons = this.$el.find(this.options.buttons);
    this.$next = this.$buttons.filter(this.options.next);
    this.$previous = this.$buttons.filter(this.options.previous);
    this.$last = this.$buttons.filter(this.options.last);
    this.$first = this.$buttons.filter(this.options.first);

    this.count = this.$el.find(this.options.count).val();
    this.action = this.$el.find(this.options.action).val();

    this.$buttons.on('click', function (e) {
        _this.seek(jQuery(this).val());
        return false;
    });
};
TotalPoll.API.Paginate.prototype.refreshToggleables = function () {
    this.$el.find('input').change();
};
TotalPoll.API.Paginate.prototype.seek = function (page) {
    var _this = this;
    this.$buttons.attr('disabled', 'disabled');
    this.$body.css('opacity', 0.5);

    var request = {
        action: this.action,
        page: page,
        poll_id: TotalPoll.Editor.pollId
    };

    jQuery.post(ajaxurl, request, function (response) {
        if (response.success === true) {
            _this.$body.html(response.data.items);
            _this.$body.css('opacity', 1);
            _this.refreshToggleables();

            _this.$last.add(_this.$next)[response.data.last ? 'attr' : 'removeAttr']('disabled', 'disabled');
            _this.$first.add(_this.$previous)[response.data.first ? 'attr' : 'removeAttr']('disabled', 'disabled');

            _this.$next.val(response.data.next);
            _this.$previous.val(response.data.previous);

        } else {
            alert(response.data.message);
        }

    });
};

// Statistics
TotalPoll.API.Statistics = function (el, options) {
    var _this = this;

    this.options = options || {};

    this.$el = jQuery(el);
    this.$progressbar = this.$el.find(this.options.progressBar);

    this.action = this.$el.find(this.options.action).val();
    this.request = {
        action: this.action,
        poll_id: TotalPoll.Editor.pollId
    };

    this.process = function () {
        jQuery.post(ajaxurl, _this.request, function (response) {
            if (response.success === true) {
                if (response.data['continue'] === false) {
                    _this.$el.html(response.data.body);
                    TotalPoll.readyCallback.charts();
                } else {
                    _this.$progressbar.css('width', response.data.percentage + '%');
                    _this.process();
                }
            } else {
                alert(response.data.message);
            }
        });
    }


    if (this.$progressbar.length !== 0) {
        this.process();
    }

};

// Chart
TotalPoll.API.Chart = function (el, options) {
    var _this = this;

    this.options = options || {};
    this.$el = jQuery(el);

    this.data = JSON.parse(this.$el.attr(this.options.dataAttr) || '[]');
    this.type = this.$el.attr(this.options.typeAttr) || 'LineChart';

    this.instance = new google.visualization[this.type](this.$el.get(0));
    this.instance.draw(
        google.visualization.arrayToDataTable(this.data),
        options.chartOptions[this.type]
    );
};

// Media instance
TotalPoll.Media = new TotalPoll.API.Media;

TotalPoll.onReady = function () {
    TotalPoll.Editor.pollId = jQuery('#post_ID').val();

    var containerOptions = {
        items: {
            container: '[data-tp-containables]',
            sortableAttr: 'data-tp-sortable',
            item: {
                idAttr: 'data-tp-containable',
                container: '[data-tp-containable]',
                content: '.containable-content',
                toggleClass: 'active',
                handle: '[data-tp-containable-handle]',
                remove: '[data-tp-containable-remove]',
                preview: '[data-tp-containable-preview]',
                previewSource: '[data-tp-containable-preview-field]',
                upload: {
                    button: '[data-tp-containable-upload]',
                    typeAttr: 'data-tp-containable-upload-type',
                    idAttr: 'data-tp-containable-upload-field-id',
                    labelAttr: 'data-tp-containable-upload-field-label',
                    sizesAttr: 'data-tp-containable-upload-field-sizes',
                    fullAttr: 'data-tp-containable-upload-field-full',
                    thumbnailAttr: 'data-tp-containable-upload-field-thumbnail',
                }
            },
            sortable: {
                axis: 'y',
                items: '[data-tp-containable]',
                handle: '[data-tp-containable-handle]',
                cancel: 'input, button',
                helper: 'original',
            },
        },
        buttons: '[data-tp-containables-insert]',
        templates: {
            item: '[data-tp-containable-template]',
            dataNameAttr: 'tp-containable-template'
        }
    };
    var tabsOptions = {
        tabAttr: 'data-tp-tab',
        tabContentAttr: 'data-tp-tab-content',
    };
    var toggleablesOptions = {
        toggleAttr: 'data-tp-toggle',
        toggleableAttr: 'data-tp-toggleable',
    };

    var paginateOptions = {
        body: '[data-tp-paginate-body]',
        next: '[data-tp-paginate-next]',
        buttons: '[data-tp-paginate-button]',
        previous: '[data-tp-paginate-previous]',
        last: '[data-tp-paginate-last]',
        first: '[data-tp-paginate-first]',
        count: '[data-tp-paginate-count]',
        action: '[data-tp-paginate-action]',
    };

    var chartsOptions = {
        dataAttr: 'data-tp-chart-data',
        typeAttr: 'data-tp-chart-type',
        chartOptions: {
            PieChart: {
                pieHole: 0.5,
                legend: {position: 'labeled'},
                chartArea: {width: '90%', height: '90%'},
                pieSliceText: 'none',
                vAxis: {
                    format: 'short',
                },
                hAxis: {
                    format: 'short',
                }
            },
            LineChart: {
                pointSize: 6,
                curveType: 'none',
                legend: {position: 'none'},
                chartArea: {width: '90%', height: '70%'},
                vAxis: {
                    format: 'short',
                    baselineColor: '#aaaaaa'
                },
                hAxis: {
                    format: 'short',
                }
            },
            BarChart: {
                sStacked: true,
                legend: {position: 'top', maxLines: 3},
                vAxis: {
                    format: 'short',
                },
                hAxis: {
                    format: 'short',
                }
            }
        }
    };

    var statisticsOptions = {
        action: '[data-tp-statistics-action]',
        progressBar: '[data-tp-statistics-progress-bar]',
    };

    this.containers = function () {
        jQuery('[data-tp-container]').each(function () {
            if (jQuery(this).data('container_instance') === undefined) {
                jQuery(this).data('container_instance', new TotalPoll.API.Container(this, containerOptions));
            }
        });
    };

    this.tabs = function () {
        jQuery('[data-tp-tabs]').each(function () {
            if (jQuery(this).data('tabs_instance') === undefined) {
                jQuery(this).data('tabs_instance', new TotalPoll.API.Tabs(this, tabsOptions));
            }
        });
    };

    this.toggleables = function () {
        jQuery('[data-tp-toggleables]').each(function () {
            if (jQuery(this).data('toggleables_instance') === undefined) {
                jQuery(this).data('toggleables_instance', new TotalPoll.API.Toggleables(this, toggleablesOptions));
            }
        });
    };

    this.paginate = function () {
        jQuery('[data-tp-paginate]').each(function () {
            if (jQuery(this).data('paginate_instance') === undefined) {
                jQuery(this).data('paginate_instance', new TotalPoll.API.Paginate(this, paginateOptions));
            }
        });
    };

    this.statistics = function () {
        jQuery('[data-tp-statistics]').each(function () {
            if (jQuery(this).data('progress_instance') === undefined) {
                jQuery(this).data('progress_instance', new TotalPoll.API.Statistics(this, statisticsOptions));
            }
        });
    };

    this.charts = function () {
        jQuery('[data-tp-chart-canvas]').each(function () {
            jQuery(this).data('chart_instance', new TotalPoll.API.Chart(this, chartsOptions));
        });
    };

    this.fields = function () {
        jQuery('[data-tp-field-color]').wpColorPicker();
        jQuery('[data-tp-field-date]').datetimepicker({
            mask: true,
            format: 'm/d/Y H:i',
            validateOnBlur: false
        });
    };

    this.reset = function () {
        jQuery('[data-tp-reset-votes]').on('click', function () {
            if (confirm(TotalPoll.i18n.sure)) {
                jQuery('[data-tp-containable-votes]').val(0);
                jQuery('input[name="totalpoll[settings][limitations][unique_id]"]').prop('checked', true);
            }
        })
    };

    this.bulk = function () {
        var $container = jQuery('[data-tp-bulk-container]');
        var $button = jQuery('[data-tp-insert-bulk]');
        var $choices = jQuery('[data-tp-insert-bulk-choices]');
        var $import = jQuery('[data-tp-insert-bulk-import]');

        $button.on('click', function () {
            $container.show();
        });

        $import.on('click', function () {
            $container.hide();
            var choices = $choices.val().split("\n");
            var container = jQuery('[data-tp-choices]').data('container_instance');
            var choice;
            jQuery.each(choices, function (key, value) {
                choice = container.insert(container.templates['choices-text']);
                choice.$content.find('input[name*="label"]').attr('value', value).trigger('change');
            });
            $choices.val('');
        });

    };

    this.templates = function () {
        jQuery('[data-tp-templates]').on('keydown mousedown', function (e) {
            e.target.lastSelectedIndex = e.target.selectedIndex;
        }).on('change', function (e) {
            if (confirm(TotalPoll.i18n.change_template)) {
                jQuery('#publish').click();
            } else {
                e.target.selectedIndex = e.target.lastSelectedIndex;
                e.target.checked = false;
            }
        });
    };

    this.containers();
    this.tabs();
    this.toggleables();
    this.paginate();
    this.statistics();
    this.fields();
    this.templates();
    this.reset();
    this.bulk();

    if (window['google'] !== undefined) {
        google.setOnLoadCallback(this.charts);
    }

    return this;
};

jQuery(function () {
    TotalPoll.readyCallback = new TotalPoll.onReady();

    jQuery(window).on('resize', function () {
        TotalPoll.readyCallback.charts();
    });
});