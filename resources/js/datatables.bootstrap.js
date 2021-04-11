/*! DataTables Bootstrap 3 integration
 * ©2011-2015 SpryMedia Ltd - datatables.net/license
 */

/**
 * DataTables integration for Bootstrap 3. This requires Bootstrap 3 and
 * DataTables 1.10 or newer.
 *
 * This file sets the defaults and adds options to DataTables to style its
 * controls using Bootstrap. See http://datatables.net/manual/styling/bootstrap
 * for further information.
 */
(function( factory ){
    if ( typeof define === 'function' && define.amd ) {
        // AMD
        define( ['jquery', 'datatables.net'], function ( $ ) {
            return factory( $, window, document );
        } );
    }
    else if ( typeof exports === 'object' ) {
        // CommonJS
        module.exports = function (root, $) {
            if ( ! root ) {
                root = window;
            }

            if ( ! $ || ! $.fn.dataTable ) {
                // Require DataTables, which attaches to jQuery, including
                // jQuery if needed and have a $ property so we can access the
                // jQuery object that is used
                $ = require('datatables.net')(root, $).$;
            }

            return factory( $, root, root.document );
        };
    }
    else {
        // Browser
        factory( jQuery, window, document );
    }
}(function( $, window, document, undefined ) {
    'use strict';
    var DataTable = $.fn.dataTable;


    /* Set the defaults for DataTables initialisation */
    $.extend( true, DataTable.defaults, {
        dom:
            "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        renderer: 'bootstrap'
    } );


    /* Default class modification */
    $.extend( DataTable.ext.classes, {
        sWrapper:      "dataTables_wrapper form-inline dt-bootstrap",
        sFilterInput:  "form-control input-sm",
        sLengthSelect: "form-control input-sm",
        sProcessing:   "dataTables_processing panel panel-default"
    } );


    /* Bootstrap paging button renderer */
    DataTable.ext.renderer.pageButton.bootstrap = function ( settings, host, idx, buttons, page, pages ) {
        var api     = new DataTable.Api( settings );
        var classes = settings.oClasses;
        var lang    = settings.oLanguage.oPaginate;
        var aria = settings.oLanguage.oAria.paginate || {};
        var btnDisplay, btnClass, counter=0;

        var attach = function( container, buttons ) {
            var i, ien, node, button;
            var clickHandler = function ( e ) {
                e.preventDefault();
                if ( !$(e.currentTarget).hasClass('disabled') && api.page() != e.data.action ) {
                    api.page( e.data.action ).draw( 'page' );
                }
            };

            for ( i=0, ien=buttons.length ; i<ien ; i++ ) {
                button = buttons[i];

                if ( $.isArray( button ) ) {
                    attach( container, button );
                }
                else {
                    btnDisplay = '';
                    btnClass = '';

                    switch ( button ) {
                        case 'ellipsis':
                            btnDisplay = '&#x2026;';
                            btnClass = 'disabled';
                            break;

                        case 'first':
                            btnDisplay = lang.sFirst;
                            btnClass = button + (page > 0 ?
                                '' : ' disabled');
                            break;

                        case 'previous':
                            btnDisplay = lang.sPrevious;
                            btnClass = button + (page > 0 ?
                                '' : ' disabled');
                            break;

                        case 'next':
                            btnDisplay = lang.sNext;
                            btnClass = button + (page < pages-1 ?
                                '' : ' disabled');
                            break;

                        case 'last':
                            btnDisplay = lang.sLast;
                            btnClass = button + (page < pages-1 ?
                                '' : ' disabled');
                            break;

                        default:
                            btnDisplay = button + 1;
                            btnClass = page === button ?
                                'active' : '';
                            break;
                    }

                    if ( btnDisplay ) {
                        node = $('<li>', {
                            'class': classes.sPageButton+' '+btnClass,
                            'id': idx === 0 && typeof button === 'string' ?
                                settings.sTableId +'_'+ button :
                                null
                        } )
                            .append( $('<a>', {
                                    'href': '#',
                                    'aria-controls': settings.sTableId,
                                    'aria-label': aria[ button ],
                                    'data-dt-idx': counter,
                                    'tabindex': settings.iTabIndex
                                } )
                                    .html( btnDisplay )
                            )
                            .appendTo( container );

                        settings.oApi._fnBindAction(
                            node, {action: button}, clickHandler
                        );

                        counter++;
                    }
                }
            }
        };

        // IE9 throws an 'unknown error' if document.activeElement is used
        // inside an iframe or frame.
        var activeEl;

        try {
            // Because this approach is destroying and recreating the paging
            // elements, focus is lost on the select button which is bad for
            // accessibility. So we want to restore focus once the draw has
            // completed
            activeEl = $(host).find(document.activeElement).data('dt-idx');
        }
        catch (e) {}

        attach(
            $(host).empty().html('<ul class="pagination"/>').children('ul'),
            buttons
        );

        if ( activeEl !== undefined ) {
            $(host).find( '[data-dt-idx='+activeEl+']' ).focus();
        }
    };


    return DataTable;
}));

$.extend($.fn.dataTable.defaults, {
    serverSide: true,
    autoWidth: true,
    processing: true,
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "الكل"]],
    language: {
        "emptyTable": "ليست هناك بيانات متاحة في الجدول",
        "loadingRecords": "جارٍ التحميل...",
        "lengthMenu": "أظهر _MENU_ مدخلات",
        "zeroRecords": "لم يعثر على أية سجلات",
        "info": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
        "infoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
        "infoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
        "search": "ابحث:",
        "paginate": {
            "first": "الأول",
            "previous": "السابق",
            "next": "التالي",
            "last": "الأخير"
        },
        "aria": {
            "sortAscending": ": تفعيل لترتيب العمود تصاعدياً",
            "sortDescending": ": تفعيل لترتيب العمود تنازلياً"
        },
        "select": {
            "rows": {
                "_": "%d قيمة محددة",
                "0": "",
                "1": "1 قيمة محددة"
            },
            "1": "%d سطر محدد",
            "_": "%d أسطر محددة",
            "cells": {
                "1": "1 خلية محددة",
                "_": "%d خلايا محددة"
            },
            "columns": {
                "1": "1 عمود محدد",
                "_": "%d أعمدة محددة"
            }
        },
        "buttons": {
            "print": "طباعة",
            "copyKeys": "زر <i>ctrl<\/i> أو <i>⌘<\/i> + <i>C<\/i> من الجدول<br>ليتم نسخها إلى الحافظة<br><br>للإلغاء اضغط على الرسالة أو اضغط على زر الخروج.",
            "copySuccess": {
                "_": "%d قيمة نسخت",
                "1": "1 قيمة نسخت"
            },
            "pageLength": {
                "-1": "اظهار الكل",
                "_": "إظهار %d أسطر"
            },
            "collection": "مجموعة",
            "copy": "نسخ",
            "copyTitle": "نسخ إلى الحافظة",
            "csv": "CSV",
            "excel": "Excel",
            "pdf": "PDF",
            "colvis": "إظهار الأعمدة",
            "colvisRestore": "إستعادة العرض"
        },
        "autoFill": {
            "cancel": "إلغاء",
            "info": "مثال عن الملئ التلقائي",
            "fill": "املأ جميع الحقول بـ <i>%d&lt;\\\/i&gt;<\/i>",
            "fillHorizontal": "تعبئة الحقول أفقيًا",
            "fillVertical": "تعبئة الحقول عموديا"
        },
        "searchBuilder": {
            "add": "اضافة شرط",
            "clearAll": "ازالة الكل",
            "condition": "الشرط",
            "data": "المعلومة",
            "logicAnd": "و",
            "logicOr": "أو",
            "title": [
                "منشئ البحث"
            ],
            "value": "القيمة",
            "conditions": {
                "date": {
                    "after": "بعد",
                    "before": "قبل",
                    "between": "بين",
                    "empty": "فارغ",
                    "equals": "تساوي",
                    "not": "ليس",
                    "notBetween": "ليست بين",
                    "notEmpty": "ليست فارغة"
                },
                "number": {
                    "between": "بين",
                    "empty": "فارغة",
                    "equals": "تساوي",
                    "gt": "أكبر من",
                    "gte": "أكبر وتساوي",
                    "lt": "أقل من",
                    "lte": "أقل وتساوي",
                    "not": "ليست",
                    "notBetween": "ليست بين",
                    "notEmpty": "ليست فارغة"
                },
                "string": {
                    "contains": "يحتوي",
                    "empty": "فاغ",
                    "endsWith": "ينتهي ب",
                    "equals": "يساوي",
                    "not": "ليست",
                    "notEmpty": "ليست فارغة",
                    "startsWith": " تبدأ بـ "
                }
            },
            "button": {
                "0": "فلاتر البحث",
                "_": "فلاتر البحث (%d)"
            },
            "deleteTitle": "حذف فلاتر"
        }
    }
});
