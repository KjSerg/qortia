var $doc = $(document);
var showedMsg = false;
var calculateFormData = false;
$doc.ready(function () {
    table();
    setProductInputValue();
    hideEmptyPriceElements();
    initAutocomplete();
    selectricInit();
    telMaskInit();
    $doc.on('change', '.trigger-input', function () {
        var $t = $(this);
        var isChecked = $t.prop('checked');
        var triggeredSelector = $t.attr('data-trigger');
        if (triggeredSelector === undefined) return;
        var $triggeredElement = $doc.find(triggeredSelector);
        if ($triggeredElement.length === 0) return;
        if (!isChecked) {
            $triggeredElement.slideUp();
            $triggeredElement.find('input').removeAttr('required');
        } else {
            $triggeredElement.slideDown();
            $triggeredElement.find('input').attr('required', 'required');
        }
    });
    $doc.on('change input', '.product-item-input, .product-item-input-qnt', setProductInputValue);
    $doc.on('change input', 'input[name="qnt"]', function () {
        $(this).val($(this).val().replace(/[A-Za-zА-Яа-яЁёІіЇї]/, ''))
    });
    $doc.on('change input', '.calculate-form input[name="email"]', function () {
        var test = true;
        var thsInput = $(this),
            $label = thsInput.closest('.form-group'),
            thsInputType = thsInput.attr('type'),
            thsInputVal = thsInput.val().trim(),
            inputReg = new RegExp(thsInput.data('reg')),
            inputTest = inputReg.test(thsInputVal);
        var $form = thsInput.closest('form');
        $form.find('input[type="tel"]').attr('required', 'required');
        if (thsInputVal.length <= 0) {
            test = false;
            thsInput.addClass('error');
            $label.addClass('error');
            thsInput.focus();
        } else {
            thsInput.removeClass('error');
            $label.removeClass('error');
            if (thsInput.data('reg')) {
                if (inputTest === false) {
                    test = false;
                    thsInput.addClass('error');
                    $label.addClass('error');
                    thsInput.focus();
                } else {
                    thsInput.removeClass('error');
                    $label.removeClass('error');
                    $form.find('input[type="tel"]').removeAttr('required').removeClass('error');
                    $form.find('input[type="tel"]').closest('.form-group').removeClass('error');
                }
            }
        }
    });
    $doc.on('change input', '.calculate-form input[name="tel"]', function () {
        var test = true;
        var thsInput = $(this),
            $label = thsInput.closest('.form-group'),
            thsInputType = thsInput.attr('type'),
            thsInputVal = thsInput.val().trim(),
            inputReg = new RegExp(thsInput.data('reg')),
            inputTest = inputReg.test(thsInputVal);
        var $form = thsInput.closest('form');
        $form.find('input[type="email"]').attr('required', 'required');
        if (thsInputVal.length <= 0) {
            test = false;
            thsInput.addClass('error');
            $label.addClass('error');
            thsInput.focus();
        } else {
            thsInput.removeClass('error');
            $label.removeClass('error');
            $form.find('input[type="email"]').removeAttr('required').removeClass('error');
            $form.find('input[type="email"]').closest('.form-group').removeClass('error');
            if (thsInput.data('reg')) {
                $form.find('input[type="email"]').attr('required', 'required');
                if (inputTest === false) {
                    test = false;
                    thsInput.addClass('error');
                    $label.addClass('error');
                    thsInput.focus();
                } else {
                    thsInput.removeClass('error');
                    $label.removeClass('error');
                    $form.find('input[type="email"]').removeAttr('required').removeClass('error');
                    $form.find('input[type="email"]').closest('.form-group').removeClass('error');
                }
            }
        }
    });
    $doc.on('input change submit', '.order-page-js form', function (e) {
        var $t = $(this);
        var val = getProductInputValue();
        if (val.length === 0) {
            $doc.find('.order-page-js form').attr('data-test', 'false');
        } else {
            $doc.find('.order-page-js form').removeAttr('data-test');

        }
        if (val.length === 0 && !showedMsg) {
            showedMsg = true;
            $.fancybox.open(msgError);
            $doc.find('.order-item').addClass('error');
            $('html, body').animate({
                scrollTop: 0
            }, 500);
            setTimeout(function () {
                $.fancybox.close();
                showedMsg = false;
            }, 3000);
        }
    });
    $doc.on('submit', '.form-js', function (e) {
        e.preventDefault();
        var $form = $(this);
        var this_form = $form.attr('id');
        var test = true,
            thsInputs = $form.find('input, textarea'),
            $select = $form.find('select[required]');
        var $address = $form.find('input.address-js[required]');
        $select.each(function () {
            var $ths = $(this);
            var $label = $ths.closest('.form-group');
            var val = $ths.val();
            if (Array.isArray(val) && val.length === 0) {
                test = false;
                $label.addClass('error');
            } else {
                $label.removeClass('error');
                if (val === null || val === undefined) {
                    test = false;
                    $label.addClass('error');
                }
            }
        });
        thsInputs.each(function () {
            var thsInput = $(this),
                $label = thsInput.closest('.form-group'),
                thsInputType = thsInput.attr('type'),
                thsInputVal = thsInput.val().trim(),
                inputReg = new RegExp(thsInput.data('reg')),
                inputTest = inputReg.test(thsInputVal);
            if (thsInput.attr('required')) {
                if (thsInputVal.length <= 0) {
                    test = false;
                    thsInput.addClass('error');
                    $label.addClass('error');
                    thsInput.focus();
                } else {
                    thsInput.removeClass('error');
                    $label.removeClass('error');
                    if (thsInput.data('reg')) {
                        if (inputTest === false) {
                            test = false;
                            thsInput.addClass('error');
                            $label.addClass('error');
                            thsInput.focus();
                            if (thsInputType === 'email') {
                                $.fancybox.open('<div class=" dark_section"><div class="text-group">' + emailErrorString + '</div></div>');
                            }
                        } else {
                            thsInput.removeClass('error');
                            $label.removeClass('error');
                        }
                    }
                }
            }
        });
        if (!validationInputs($form)) return;
        var $inp = $form.find('input[name="consent"]');
        if ($inp.length > 0) {
            if ($inp.prop('checked') === false) {
                $inp.closest('.form-consent').addClass('error');
                return;
            }
            $inp.closest('.form-consent').removeClass('error');
        }
        if ($address.length > 0) {
            var addressTest = true;
            $address.each(function (index) {
                var $el = $(this);
                var val = $el.val() || '';
                var selected = $el.attr('data-selected') || '';
                if (selected.trim() !== val.trim()) {
                    test = false;
                    addressTest = false;
                    $el.addClass('error');
                } else {
                    $el.removeClass('error');
                }
                if (val.length === 0) {
                    test = false;
                    $el.addClass('error');
                }
            });
            if (!addressTest) showMassage(locationErrorString);
        }
        if ($form.attr('data-test') === 'false') return;
        if (test) {
            var thisForm = document.getElementById(this_form);
            var formData = new FormData(thisForm);
            var serialize = $form.serialize();
            if ($form.hasClass('calculate-form') && calculateFormData === serialize) {
                $form.find('.next-step').trigger('click');
                return;
            }
            showPreloader();
            if (!$form.hasClass('calculate-form')) $.fancybox.close();
            if ($form.hasClass('calculate-form')) calculateFormData = serialize;
            $.ajax({
                type: $form.attr('method'),
                url: admin_ajax,
                processData: false,
                contentType: false,
                data: formData,
            }).done(function (r) {
                hidePreloader();
                if (!$form.hasClass('calculate-form')) {
                    $form.trigger('reset');
                }
                if (r) {
                    if (isJsonString(r)) {
                        var res = JSON.parse(r);
                        if ($form.hasClass('calculate-form')) {
                            if (res.html !== '' && res.html !== undefined) {
                                $form.closest('.modal-calculate').find('.step-form__info').html(res.html);
                            }
                            if (res.msg !== '' && res.msg !== undefined) {
                                $form.closest('.modal-calculate').find('.step-form__info').html(res.msg);
                            }
                            if (res.ID !== '' && res.ID !== undefined) {
                                $form.closest('.modal-calculate').find('.calculation-id').val(res.ID);
                            }
                            if (res.button_text !== '' && res.button_text !== undefined) {
                                $form.closest('.modal-calculate').find('.set-calculate-status-form .btn_st span').html(res.button_text);
                            }
                            $form.find('.next-step').trigger('click');
                            return;
                        }
                        if (res.msg !== '' && res.msg !== undefined) {
                            showMassage(res.msg);
                        }

                    } else {
                        showMassage(r);
                    }
                }
            });
        }
    });
    $doc.on('click', '.calculate-modal-btn', function (e) {
        var $t = $(this);
        var regionID = $t.attr('data-region-id');
        var pointID = $t.attr('data-point-id');
        if (regionID) {
            $('.selected-region').val(regionID);
        }
        if (pointID) {
            $('.selected-point').val(pointID);
        }
    });
    $doc.on('click', '.add-products-by-category', function (e) {
        e.preventDefault();
        var $t = $(this);
        var $wrapper = $t.closest('.form-horizontal');
        var category = $t.attr('data-category') || '';
        $.ajax({
            type: 'POST',
            url: admin_ajax,
            data: {
                action: 'get_products_form_row',
                category: category
            },
        }).done(function (r) {
            if (r) {
                if (isJsonString(r)) {
                    var res = JSON.parse(r);
                    if (res.html !== '' && res.html !== undefined) {
                        $wrapper.before(res.html);
                        selectricInit();
                        hidePreloader();
                    }
                    if (res.msg !== '' && res.msg !== undefined) {
                        showMassage(res.msg);
                    }
                } else {
                    showMassage(r);
                }
            }
            hidePreloader();
        });
    });
    $doc.on('click', '.sortable-table .table-row--head .table-column', function () {
        var $t = $(this);
        var table = $(this).parents('.sortable-table').eq(0);
        var rows = table.find('.table-row').not('.table-row--head').toArray().sort(comparer($(this).index(), $(this).data('type')));
        this.asc = !this.asc;
        table.find('.table-row--head .table-column').removeAttr('data-sort');
        $t.attr('data-sort', this.asc ? 'asc' : 'desc');
        if (!this.asc) {
            rows = rows.reverse();
        }
        for (var i = 0; i < rows.length; i++) {
            table.append(rows[i]);
        }
    });
    $doc.on('click', '.js-tab-link', function (event) {
        event.preventDefault();
        var $t = $(this);
        var data_hreff = $(this).data('target');
        var $el = $t.closest('.js-tab').find('.js-tab-item[data-target="' + data_hreff + '"]');
        $(this).closest('.js-tab').find('.js-tab-link').removeClass('active');
        $(this).addClass('active');
        $(this).closest('.js-tab').find('.js-tab-item').hide().removeClass('active');
        $(this).closest('.js-tab').find('.js-tab-item').find('input, select').removeAttr('required');
        $el.fadeIn().addClass('active');
        $el.find('input, select').not('.selectric-input').attr('required', 'required');
        if ($t.closest('.place-wrap__map').length > 0) {
            $el.setPlacePriceElementHeight();
            setTimeout(function () {
                if ($el.outerHeight() > 350) scrollTopToElement($el.find('.price-collapse:not(.hidden)').eq(0));
            }, 50);
        }
    });
    $(document).on('click', '.next-step', function (e) {
        e.preventDefault();
        $(this).closest('.step-form__item.active').removeClass('active').next('.step-form__item').addClass('active');
        var in_ = $('.step-form__item.active').index();
        in_ = in_ - 1;
        $('.step-form__top-item').eq(in_).addClass('active').nextAll().removeClass('active');
    });
    $(document).on('click', '.video-list__item-main', function (e) {
        e.preventDefault();
        var $t = $(this);
        var $a = $t.find('a');
        if ($a.length === 0) return;
        var href = $a.attr('href');
        if (href === '#') return;
        window.location.href = href;
    });
    $(document).on('click', '.show-all-content', function (e) {
        e.preventDefault();
        var $t = $(this);
        var href = $t.attr('href');
        if (href === undefined) return;
        var $content = $(document).find(href);
        if ($content.length === 0) return;
        var newHeight = $content.attr('data-height');
        var _height = $content.attr('data-full-height');
        var h = $t.hasClass('active') ? newHeight : _height;
        $content.css('height', h + 'px');
        if ($t.hasClass('active')) {
            $t.removeClass('active');
        } else {
            $t.addClass('active');
        }
    });
});


(function ($) {

    function clearPlacePriceElementHeight() {
        $(document).find('.show-all-content').remove();
        var $contents = $(document).find('.price-collapse__item-content');
        $(document).find('.price-collapse__item').removeClass('active');
        $contents.each(function (l) {
            var $content = $(this);
            $content.removeAttr('id');
            $content.removeAttr('style');
            $content.removeAttr('data-height');
            $content.removeAttr('data-full-height');
            $content.removeClass('clipped-element');
        });
    }

    $.fn.setPlacePriceElementHeight = function () {
        var headerH = $(document).find('header').outerHeight();
        var windowHeight = $(window).height();
        var viewHeight = windowHeight - headerH;
        clearPlacePriceElementHeight();
        return this.each(function (index) {
            var $wrapper = $(this);
            if ($(window).width() <= 860) {
                clearPlacePriceElementHeight();
                return;
            }
            var paddingTop = $wrapper.css('padding-top');
            var paddingBottom = $wrapper.css('padding-bottom');
            paddingTop = paddingTop.replace("px", '');
            paddingTop = Number(paddingTop);
            paddingBottom = paddingBottom.replace("px", '');
            paddingBottom = Number(paddingBottom);
            var $contents = $wrapper.find('.price-collapse__item-content');
            var contentsCount = $contents.length;
            if (contentsCount > 0) {
                var contentsActiveCount = 0;
                var height = 0;
                var $title = $wrapper.find('.place-price-tab__item-title');
                var $btn = $wrapper.find('.calculate-modal-btn');
                var titleMaddingBottom = $title.css('margin-bottom');
                titleMaddingBottom = titleMaddingBottom.replace("px", '');
                titleMaddingBottom = Number(titleMaddingBottom);
                var $collapse = $wrapper.find('.price-collapse');
                var secondaryHeight = $title.outerHeight() + paddingTop + paddingBottom;
                if (!isNaN(titleMaddingBottom)) secondaryHeight = secondaryHeight + titleMaddingBottom;
                if ($btn.length > 0) {
                    secondaryHeight = secondaryHeight + $btn.outerHeight();
                }
                $collapse.each(function () {
                    var $this = $(this);
                    if ($this.css('display') !== 'none') {
                        contentsActiveCount = contentsActiveCount + 1;
                        var $headers = $this.find('.price-collapse__item-title');
                        var margin = $this.css('margin-top');
                        margin = margin.replace("px", '');
                        margin = Number(margin);
                        if (!isNaN(margin)) secondaryHeight = secondaryHeight + margin;
                        $headers.each(function () {
                            secondaryHeight = secondaryHeight + ($(this).outerHeight());
                        });
                    }
                });
                height = viewHeight - secondaryHeight;
                if (contentsActiveCount > 0) {
                    var newHeight = height / contentsActiveCount;
                    var diff = 0;
                    var diffCount = 0;
                    $collapse.each(function () {
                        var $this = $(this);
                        if ($this.css('display') !== 'none') {
                            var $contents = $this.find('.price-collapse__item-content');
                            $contents.each(function () {
                                var $content = $(this);
                                var _height = $content.outerHeight();
                                if (_height < newHeight) {
                                    diff = diff + (newHeight - _height);
                                    diffCount = diffCount + 1;
                                }
                            });

                        }
                    });
                    if(diff > 0 && diffCount > 0) newHeight = newHeight + (diff / diffCount);
                    if (newHeight < 70) {
                        newHeight = 80;
                    }
                    $collapse.each(function (j) {
                        var $this = $(this);
                        if ($this.css('display') !== 'none') {
                            var $contents = $this.find('.price-collapse__item-content');
                            $contents.each(function (l) {
                                var $content = $(this);
                                var $button = $content.find('.show-all-content');
                                var _height = $content.outerHeight();
                                var ID = 'clipped-element-' + index + j + l;
                                _height = Math.round(_height);
                                newHeight = Math.round(newHeight);
                                if (_height > newHeight) {
                                    $content.css('height', newHeight + 'px');
                                    $content.attr('data-height', newHeight);
                                    if ($content.attr('data-full-height') === undefined) $content.attr('data-full-height', (_height + 40));
                                    if (!$content.hasClass('clipped-element')) $content.addClass('clipped-element');
                                }
                                if ($button.length > 0) $button.remove();
                                if ($content.hasClass('clipped-element')) {
                                    $content.attr('id', ID);
                                    $content.append('<a href="#' + ID + '" class="show-all-content">' + arrowBottomSVG + '</a>');
                                }
                            });
                        }
                    });
                }
            }
        });
    };
})(jQuery);

function scrollTopToElement($element) {
    var top = $element.offset().top;

    var headerH = $(document).find('header').outerHeight();
    $('html, body').animate({
        scrollTop: top - headerH
    });
}

$(window).on('load resize', tableInit);
$(window).on('resize', function () {
    $(document).find('.js-tab-item[data-target]').setPlacePriceElementHeight();
});

function table() {
    hideEmptyTableRow();
    hideEmptyTableColumn();
    tableColumnCheck();
    changePositionTableSingleColumns();
    changePositionTableColumns();
    tableInit();
}

function hideEmptyTableRow() {
    var $tables = $(document).find('.price-wrap__table .single-product-table');
    $tables.each(function () {
        var $rows = $(this).find('.table-row').not('.table-row--head');
        $rows.each(function () {
            var $row = $(this);
            var $column = $row.find('.table-column[data-code][data-price]');
            if ($column.length === 0) $row.remove();
        })
    })
}

function changePositionTableSingleColumns() {
    var $tables = $(document).find('.price-wrap__table .table.single-product-table');
    $tables.each(function (tableIndex) {
        var $table = $(this);
        var $columns = $table.find('.table-row--head .table-column');
        var $rows = $table.find('.table-row').not('.table-row--head');
        var list = {};
        $columns.each(function (index) {
            var $t = $(this);
            var code = $(this).attr('data-code');
            if (code) {
                list[code] = index;
            }
        });
        console.log(list)
        $rows.each(function (rowIndex) {
            var $row = $(this);
            var $_columns = $row.find('.table-column');
            changeTableColumns($_columns, {
                rowIndex: rowIndex, tableIndex: tableIndex, list: list, headColumnsCount: $columns.length
            });
        });
    });

}

function changeTableColumns($_columns, args) {
    var rowIndex = args.rowIndex || 0;
    var tableIndex = args.tableIndex || 0;
    var list = args.list || {};
    var headColumnsCount = args.headColumnsCount || 0;
    var $table = $(document).find('.price-wrap__table .table.single-product-table').eq(tableIndex);
    var $_row = $table.find('.table-row').not('.table-row--head').eq(rowIndex);
    if ($_columns.length < headColumnsCount) {
        var diff = headColumnsCount - $_columns.length;
        var HTML = '';
        for (var a = 1; a <= diff; a++) {
            HTML += " <div class=\"table-column\"></div>";
        }
        $_row.find('.table-column').last().before(HTML);
    }
    var collection = {};
    $_columns.each(function (columIndex) {
        var $_column = $(this);
        var code = $_column.attr('data-code');
        if (code) {
            var eq = list[code];
            var id = $_column.attr('id');
            if (id === undefined) {
                id = tableIndex + '' + rowIndex + '' + eq;
                $_column.attr('id', id);
            }
            collection[code] = {
                element: $_column.prop('outerHTML'),
                eq: eq,
                code: code,
                ID: tableIndex + '' + rowIndex + '' + eq,
            };
        }
        if (columIndex > 1 && $_column.find('.calculate-modal-btn').length === 0) {
            var ID = tableIndex + '' + rowIndex + '' + columIndex;
            $_column.replaceWith('<div id="' + ID + '" class="table-column"></div>');
        }
    });
    console.log(rowIndex);
    console.log(collection);
    for (var code in collection) {
        var el = collection[code];
        var ID = collection[code].ID;
        var eq = collection[code].eq;
        $_row.find('.table-column').eq(eq).replaceWith(el.element);
    }
}

function changePositionTableColumns() {
    var $tables = $(document).find('.price-wrap__table .table').not('.single-product-table');
    $tables.each(function (tableIndex) {
        var $table = $(this);
        var $columns = $table.find('.table-row--head .table-column');
        var $rows = $table.find('.table-row').not('.table-row--head');
        var list = {};
        $columns.each(function (index) {
            var $t = $(this);
            var ID = $(this).attr('data-product_id');
            if (ID) {
                list[ID] = index;
            }
        });
        console.log(list)
        $rows.each(function (rowIndex) {
            var $row = $(this);
            var $_columns = $(this).find('.table-column');
            $_columns.each(function (columIndex) {
                var $_column = $(this);
                var ID = $_column.attr('data-product_id');
                if (ID !== undefined) {
                    var eq = Number(list[ID]);
                    if (eq !== undefined && eq !== columIndex) {
                        var elem1 = $_column;
                        var elem2 = $_column.eq(eq);
                        if (elem2.length === 0) {
                            var diff = eq - columIndex;
                            if (diff > 0) {
                                var HTML = '';
                                var columnID = null;
                                for (var a = 1; a <= diff; a++) {
                                    columnID = tableIndex + '' + rowIndex + '' + columIndex + a;
                                    HTML += " <div id='" + columnID + "' class=\"table-column\"></div>";
                                }
                                $row.append(HTML);
                                elem2 = $(document).find('#' + columnID);
                            }
                        }

                        var elem1Clone = elem1.clone();
                        var elem2Clone = elem2.clone();
                        elem1.replaceWith(elem2Clone);
                        elem2.replaceWith(elem1Clone);
                    }
                }
            });
        });
    });
}

function tableInit() {
    var $table = $(document).find('.price-wrap__table .table');
    var ww = $(window).width();
    $table.each(function () {
        var $t = $(this);
        var isMutable = false;
        var $headColumns = $t.find('.table-row--head .table-column');
        var $headColumnsNotActive = $t.find('.table-row--head .table-column.not-active');
        var $rows = $t.find('.table-row');
        var columnCount = $headColumns.length;
        var notActiveCount = $headColumnsNotActive.length;

        if (!isMutable) {
            $t.removeClass('active');
            isMutable = true;
            $headColumns.each(function (index) {
                var $t = $(this);
                if (!$t.hasClass('not-active')) {
                    var text = $t.text().trim();
                    if (text.length > 0) {
                        $rows.not('.table-row--head').each(function () {
                            var $_el = $(this).find('.table-column').not('[data-price="0"]').eq(index);
                            if ($_el.text().trim().length > 0) {
                                if ($_el.find('.calculate-modal-btn').length === 0) {
                                    if ($_el.find('.table-column-head').length === 0) $_el.prepend('<span class="table-column-head">' + text + '</span>');
                                }
                            } else {
                                $_el.addClass('table-column-empty');
                            }

                        });
                    }
                }

            });
        }

        if (ww <= 768) {
            $rows.find('.table-column').removeAttr('style');
        } else {
            isMutable = false;
            if (columnCount > 0) {
                var percent = (100 - (notActiveCount * 10)) / (columnCount - notActiveCount);
                if (ww < 930) {
                    percent = 100 / columnCount;
                }
                $rows.find('.table-column').css({
                    'width': percent + '%'
                });
                if (ww >= 930) {
                    $headColumns.each(function (index) {
                        var $t = $(this);
                        if ($t.hasClass('not-active')) {
                            $rows.each(function () {
                                $(this).find('.table-column').not('[data-price="0"]').eq(index).css({
                                    'width': '10%'
                                });
                            });
                        }
                    });
                    $(document).find('.single-product-table .table-column:last-child').css({
                        'width': '10%'
                    });
                }

            }
        }


        $t.addClass('active');
    });

}

function tableColumnCheck() {
    $doc.find('.price-wrap__table .table').each(function () {
        var $t = $(this);
        var columnCount = $t.find('.table-row--head .table-column').length;
        var $rows = $t.find('.table-row').not('.table-row--head');
        $rows.each(function () {
            var $row = $(this);
            var rowColumnCount = $row.find('.table-column').length;
            if (rowColumnCount > columnCount) {
                $row.find('.table-column[data-price="0"]').hide();
            }
        });
    });
}

function telMaskInit() {
    $doc.find('input[type="tel"]').each(function () {
        var $input = $(this);
        $input.inputmask($input.attr('data-placeholder') || '+38(999)999-99-99');
    });

}

function selectricInit() {
    $('.select_st').selectric({
        onInit: function onInit() {
        },
        onChange: function onChange(element) {
            var $t = $(element);
            if ($t.hasClass('price-region-select')) {
                var val = $t.val();
                var $section = $t.closest('section');
                var $tableBody = $section.find('.table-row').not('.table-row--head');
                if (val === '') {
                    $tableBody.removeClass('hidden');
                    return;
                }
                $tableBody.each(function () {
                    var $row = $(this);
                    var region = $row.attr('data-region').trim();
                    if (val === region) {
                        $row.removeClass('hidden');
                    } else {
                        $row.addClass('hidden');
                    }
                });
            }
            if ($t.hasClass('trigger-select')) {
                var triggeredSelector = $t.attr('data-trigger');
                if (triggeredSelector === undefined) return;
                var $triggeredElement = $doc.find(triggeredSelector);
                if ($triggeredElement.length === 0) return;
                if (!$t.val()) {
                    $triggeredElement.removeAttr('required').removeClass('error');
                    $triggeredElement.closest('.form-group').removeClass('error');
                } else {
                    $triggeredElement.attr('required', 'required');
                }
            }
        },
        disableOnMobile: false,
        nativeOnMobile: false
    });
}

function validationInputs($form) {
    var obj = {};
    var res = true;
    var $requiredInputs = $form.find('[data-required]');
    $requiredInputs.each(function () {
        var $t = $(this);
        var name = $t.attr('name');
        if (name !== undefined) {
            var hasChecked = $t.prop('checked') === true;
            if (obj[name] === undefined) obj[name] = [];
            if (hasChecked) {
                obj[name].push($t.val());
            }
        }
    });
    for (var key in obj) {
        var items = obj[key];
        if (items.length === 0) {
            res = false;
            $form.find('[name="' + key + '"]').closest('.form-group').addClass('error');
        } else {
            $form.find('[name="' + key + '"]').closest('.form-group').removeClass('error');
        }
    }
    return res;
}

function showMassage(message) {
    $.fancybox.close();
    $('.js-thanks').html(message);
    // $.fancybox.open('<div class="message dark_section"><div class="text-group">' + message + '</div></div>');

    $.fancybox.open([{
        src: '#thanks',
    }]);

    setTimeout(function () {
        $.fancybox.close();
    }, 3000);
}

function showPreloader() {
    jQuery('.preloader').addClass('active');
}

function hidePreloader() {
    jQuery('.preloader').removeClass('active')
}

function isJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function getProductInputValue() {
    var $items = $doc.find('.product-item-input');
    var res = [];
    $items.each(function () {
        var $item = $(this);
        if ($item.prop('checked')) {
            var $wrapper = $item.closest('.order-item');
            var $qntInput = $wrapper.find('.product-item-input-qnt');
            var val = $item.val();
            var qnt = $qntInput.val();
            if (val && qnt) res.push({
                name: val,
                qnt: qnt
            });
        }
    });
    return res;
}

function setProductInputValue() {
    $doc.find('.order-item').removeClass('error');
    var values = getProductInputValue();
    var $inpContainer = $doc.find('.order-page-js form .products');
    var html = '';
    if ($inpContainer.length === 0) {
        $doc.find('.order-page-js form').prepend('<div class="products"></div>');
        $inpContainer = $doc.find('.order-page-js form .products');
    }
    if (values.length > 0) {
        $doc.find('.order-page-js form').removeAttr('data-test');
        values.forEach(function (elem) {
            var name = elem.name;
            var qnt = elem.qnt;
            html += '<input type="hidden" name="' + name + '" value="' + qnt + '">';
        });
    } else {
        $doc.find('.order-page-js form').attr('data-test', 'false');
    }

    $inpContainer.html(html);

}

function isEmptyObject(object) {
    return JSON.stringify(object) === '{}';
}

function hideEmptyPriceElements() {
    $doc.find('.price-collapse').each(function () {
        var $t = $(this);
        var $items = $t.find('.price-collapse__item-content ul li');
        if ($items.length === 0) {
            $t.hide();
            $t.addClass('hidden');
        }
    });
    $doc.find('.place-price-tab__item').each(function () {
        var $t = $(this);
        var $items = $t.find('.price-collapse');
        var $hiddenItems = $t.find('.price-collapse.hidden');
        if ($hiddenItems.length !== $items.length) {
            $t.find('.place-price-tab-empty-text').remove();
        }
    });
}

function initAutocomplete() {
    if ($('#google-map-api').length === 0) return;
    $('.address-js').each(function (index) {
        var $t = $(this);
        var id = $t.attr('id');
        if (id === null || id === undefined) {
            $t.attr('id', 'address-input-' + index);
            id = $t.attr('id');
        }
        var addressField = document.querySelector('#' + id);
        var options = {
            fields: ["formatted_address", "address_components", "geometry", "name"],
            strictBounds: false,
            types: [],
        };
        if ($t.hasClass('is-cities')) {
            options = {
                fields: ["formatted_address", "address_components", "geometry", "name"],
                strictBounds: false,
                types: ['(cities)'],
                componentRestrictions: {country: 'ua'}
            };
        }
        var autocomplete = new google.maps.places.Autocomplete(addressField, options);
        autocomplete.addListener("place_changed", function () {
            addressField.removeAttribute('data-selected');
            fillInAddress(autocomplete, addressField);
        });
    });
}

function fillInAddress(autocomplete, addressField) {
    var place = autocomplete.getPlace();
    var lat = place.geometry.location.lat();
    var lng = place.geometry.location.lng();
    var name = place.name;
    var formatted_address = place.formatted_address;
    var address1 = "";
    var postcode = "";
    $('.lat').val(lat);
    $('.lng').val(lng);
    for (const component of place.address_components) {
        const componentType = component.types[0];
        switch (componentType) {
            case "street_number": {
                address1 = component.long_name + ' ' + address1;
                break;
            }
            case "route": {
                address1 += component.short_name;
                break;
            }
            case "postal_code": {
                address1 += ', ' + component.long_name;
                postcode = component.long_name;
                break;
            }
            case "postal_code_suffix": {
                postcode = postcode + '-' + component.long_name;
                break;
            }
            case "locality":
                address1 += ' ' + component.long_name;
                $('.city').val(component.long_name);
                break;
            case "administrative_area_level_1": {
                address1 += ' ' + component.short_name;
                $('.region').val(component.long_name);
                break;
            }
            case "country":
                address1 += ' ' + component.long_name;
                $('.country').val(component.long_name);
                break;
        }
    }
    addressField.value = formatted_address;
    addressField.setAttribute('data-selected', formatted_address);
    $('.post_code').val(postcode);
}

function hideEmptyTableColumn() {
    var $tables = $(document).find('.price-wrap__table .table').not('.single-product-table');
    $tables.each(function () {
        var $table = $(this);
        var counter = {};
        var $columns = $table.find('.table-row--head .table-column[data-product_id]');
        var $rows = $table.find('.table-row').not('.table-row--head');
        if ($columns) {
            $columns.each(function (index) {
                var ID = $(this).attr('data-product_id');
                if (ID !== undefined) {
                    counter[ID] = {
                        count: 0,
                        index: index
                    };
                }
            });
        }
        if ($rows) {
            $rows.each(function () {
                var $item = $(this);
                var $itemColumns = $item.find('.table-column');
                if ($itemColumns) {
                    $itemColumns.each(function (index) {
                        var $td = $(this);
                        var ID = $td.attr('data-product_id');
                        var text = $td.text().trim();
                        if (text.length > 0 && ID !== undefined) {
                            counter[ID].count = counter[ID].count + 1;
                        }
                    });
                }
            });
        }
        for (var ID in counter) {
            if (counter[ID].count > 0) $table.find('.table-row--head .table-column[data-product_id="' + ID + '"]').addClass('show');
        }

        $columns.not('.show').remove();
    });
    $tables = $(document).find('.price-wrap__table .table.single-product-table');
    $tables.each(function () {
        var $table = $(this);
        var collection = {};
        var $columns = $table.find('.table-row--head .table-column[data-code]');
        var $rows = $table.find('.table-row').not('.table-row--head');
        if ($columns) {
            $columns.each(function (index) {
                var code = $(this).attr('data-code');
                if (code) {
                    collection[code] = 0;
                }

            });
        }
        if ($rows) {
            $rows.each(function () {
                var $item = $(this);
                var $itemColumns = $item.find('.table-column[data-code]');
                if ($itemColumns) {
                    $itemColumns.each(function (index) {
                        var $td = $(this);
                        var text = $td.text().trim();
                        if (text.length > 0) {
                            var code = $(this).attr('data-code');
                            collection[code] = collection[code] + 1;
                        }
                    });
                }
            });
        }
        for (var code in collection) {
            if (collection[code] > 0) $table.find('.table-row--head .table-column[data-code="' + code + '"]').addClass('show');
        }

        $columns.not('.show').remove();

    });
}


function comparer(index, type) {
    return function (a, b) {
        var valA = getCellValue(a, index, type), valB = getCellValue(b, index, type);
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
    };
}

function getCellValue(row, index, type) {
    var cell = $(row).children('.table-column').eq(index);
    var text = cell.text().trim();
    if (cell.find('span').length > 0) {
        text = cell.html().split('</span>')[1].trim();
    }
    return type === 'number' ? parseFloat(cell.data('price')) : text;
}