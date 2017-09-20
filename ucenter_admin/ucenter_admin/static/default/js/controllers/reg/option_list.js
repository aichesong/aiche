/**
 * Created by cesar on 2017/4/5.
 */
$(function() {
    var searchFlag = false;
    var catorageCombo;
    var handle = {
        //修改、新增
        operate: function(oper, row_id) {
            if (oper == 'add') {
                var title = _('新增');
                var data = {
                    oper: oper,
                    callback: this.callback
                };
            } else {
                var title = _('修改');

                var data = {
                    oper: oper,
                    rowId: row_id,
                    rowData: $("#grid").data('gridData')[row_id],
                    callback: this.callback
                };
            }

            $.dialog({
                title: title,
                content: 'url:' + SITE_URL + '?ctl=Reg_Option&met=manage&typ=e',
                data: data,
                width: 600,
                height: 360,
                max: false,
                min: false,
                cache: false,
                lock: true
            });
        },

        //删除
        del: function(row_ids) {
            $.dialog.confirm(_('删除的将不能恢复，请确认是否删除？'), function() {
                Public.ajaxPost(SITE_URL + '?ctl=Reg_Option&met=remove&typ=json', {
                    reg_option_id: row_ids
                }, function(data) {
                    if (data && data.status == 200) {
                        var id_arr = data.data.reg_option_id || [];
                        if (row_ids.split(',').length === id_arr.length) {
                            parent.Public.tips({
                                content: sprintf(_('成功删除 %d 个！'), id_arr.length)
                            });
                        } else {
                            parent.Public.tips({
                                type: 2,
                                content: data.data.msg
                            });
                        }
                        for (var i = 0, len = id_arr.length; i < len; i++) {
                            $('#grid').jqGrid('setSelection', id_arr[i]);
                            $('#grid').jqGrid('delRowData', id_arr[i]);
                        };
                    } else {
                        parent.Public.tips({
                            type: 1,
                            content: _('删除失败！') + data.msg
                        });
                    }
                });
            });
        },

        //修改状态
        setStatus: function(id, is_enable) {
            if (!id) {
                return;
            }
            Public.ajaxPost(SITE_URL + '?ctl=Reg_Option&met=enable&typ=json', {
                reg_option_id: id,
                reg_option_id_enable: Number(is_enable)
            }, function(data) {
                if (data && data.status == 200) {
                    parent.Public.tips({
                        content: _('状态修改成功！')
                    }),
                    $('#grid').jqGrid('setCell', id, 'reg_option_active', is_enable);
                } else {
                    parent.Public.tips({
                        type: 1,
                        content: _('状态修改失败！') + data.msg
                    });
                }
            });
        },

        //批量修改状态
        setStatuses: function(ids, is_enable) {
            if (!ids || ids.length == 0) {
                return;
            }
            var arr_ids = $('#grid').jqGrid('getGridParam', 'selarrrow')
            var sel_ids = arr_ids.join();
            Public.ajaxPost(SITE_URL + '?ctl=Reg_Option&met=enable&typ=json', {
                reg_option_id: sel_ids,
                reg_option_id_enable: Number(is_enable)
            }, function(data) {
                if (data && data.status == 200) {
                    parent.Public.tips({
                        content: _('状态修改成功！')
                    });
                    for (var i = 0; i < ids.length; i++) {
                        var id = ids[i];
                        $('#grid').jqGrid('setCell', id, 'reg_option_id_enable', is_enable);
                    }
                } else {
                    parent.Public.tips({
                        type: 1,
                        content: _('状态修改失败！') + data.msg
                    });
                }
            });
        },
        callback: function(data, oper, dialogWin) {
            var gridData = $("#grid").data('gridData');
            if (!gridData) {
                gridData = {};
                $("#grid").data('gridData', gridData);
            }

            //计算期初余额字段difMoney
            //data.difMoney = data.amount - data.periodMoney;

            gridData[data.reg_option_id] = data;

            if (oper == "edit") {
                $("#grid").jqGrid('setRowData', data.reg_option_id, data);
                dialogWin && dialogWin.api.close();
            } else {
                $("#grid").jqGrid('addRowData', data.reg_option_id, data, 'first');
                dialogWin && dialogWin.resetForm(data);
            }
        },

        //操作项格式化，适用于有“修改、删除”操作的表格
        operFormatter: function(val, opt, row) {
            var html_con = '<div class="operating" data-id="' + row.id + '"><span class="ui-icon ui-icon-pencil" title="修改"></span><span class="ui-icon ui-icon-trash" title="删除"></span></div>';
            return html_con;
        },

        statusFormatter: function(val, opt, row) {
            var text = val == 0 ? _('已禁用') : _('已启用');
            var cls = val == 0 ? 'ui-label-default' : 'ui-label-success';
            return '<span class="set-status ui-label ' + cls + '" data-enable="' + val + '" data-id="' + row.id + '">' + text + '</span>';
        }
    };

    function initDom() {
        var defaultPage = Public.getDefaultPage();
        defaultPage.SYSTEM = defaultPage.SYSTEM || {};
        defaultPage.SYSTEM.categoryInfo = defaultPage.SYSTEM.categoryInfo || {};
        catorageCombo = Business.categoryCombo($('#catorage'), {
            editable: false,
            extraListHtml: '',
            addOptions: {
                value: -1,
                text: _('选择类别')
            },
            defaultSelected: 0,
            trigger: true,
            width: 120
        }, 'customertype');
    };

    function initGrid() {
        var grid_row = Public.setGrid();
        var colModel = [{
            "name": "operate",
            "label": "操作",
            "width": 80,
            "sortable": false,
            "search": false,
            "resizable": false,
            "fixed": true,
            "align": "center",
            "title": false,
            "formatter": handle.operFormatter
        }, {
            "name": "reg_option_id",
            "index": "reg_option_id",
            "label": "编号",
            "classes": "ui-ellipsis",
            "align": "center",
            "title": false,
            "fixed": true,
            "width": 100
        }, {
            "name": "reg_option_name",
            "index": "reg_option_name",
            "label": "配置名称",
            "classes": "ui-ellipsis",
            "align": "center",
            "title": false,
            "fixed": true,
            "width": 100
        }, {
            "name": "option_id",
            "index": "option_id",
            "label": "类型",
            "classes": "ui-ellipsis",
            "align": "center",
            "title": false,
            "fixed": true,
            "width": 100,
            "formatter": function(val, opt, row) {
                var r = {
                    "1": "列表",
                    "2": "单选",
                    "3": "复选框",
                    "4": "输入框",
                    "5": "多行文本框"
                };
                return r[val];
            }
        }, {
            "name": "reg_option_value",
            "index": "reg_option_value",
            "label": "配置值",
            "classes": "ui-ellipsis",
            "align": "center",
            "title": false,
            "width": 100
        }/*, {
         "name": "reg_option_placeholder",
         "index": "reg_option_placeholder",
         "label": "placeholder",
         "classes": "ui-ellipsis",
         "align": "center",
         "title": false,
         "fixed": true,
         "width": 100
         }*/, {
            "name": "reg_option_datatype",
            "index": "reg_option_datatype",
            "label": "规则设定",
            "classes": "ui-ellipsis",
            "align": "center",
            "title": false,
            "fixed": true,
            "width": 60,
            "formatter": function(val, opt, row) {
                var r = [
                    "不限制",
                    "手机",
                    "身份证",
                    "数字",
                    "字母",
                    "Email",
                    "真实姓名"
                ];
                return r[val];
            }
        }, {
            "name": "reg_option_required",
            "index": "reg_option_required",
            "label": "是否必填",
            "classes": "ui-ellipsis",
            "align": "center",
            "title": false,
            "fixed": true,
            "width": 60,
            "formatter": function(val, opt, row) {
                var r = [
                    "非必填",
                    "必填"
                ];
                return r[val];
            }
        }/*, {
            "name": "reg_option_order",
            "index": "reg_option_order",
            "label": "排序",
            "classes": "ui-ellipsis",
            "align": "center",
            "title": false,
            "fixed": true,
            "width": 60
        }*/, {
            "name": "reg_option_active",
            "index": "reg_option_active",
            "label": "是否启用",
            "classes": "ui-ellipsis",
            "align": "center",
            "title": false,
            "fixed": true,
            "width": 60,
            "formatter": handle.statusFormatter
        }];


        $('#grid').jqGrid({
            url: SITE_URL + '?ctl=Reg_Option&met=lists&typ=json',
            datatype: 'json',
            autowidth: true,
            shrinkToFit: true,
            forceFit: true,
            width: grid_row.w,
            height: grid_row.h,
            altRows: true,
            gridview: true,
            onselectrow: false,
            multiselect: false, //多选
            colModel: colModel,
            cmTemplate: {
                sortable: true
            },
            sortname: "reg_option_id", //指定默认排序的列
            sortorder: "asc", //指定默认排序方式
            pager: '#grid-pager',
            viewrecords: true,
            rowNum: 100,
            rowList: [100, 200, 500],
            prmNames: { //向后台传递的参数,重新命名
                //page:"page.currentPage",
                //rows:"page.pageSize"
            },
            //scroll: 1,
            jsonReader: {
                root: "data.items",
                records: "data.records",
                total: "data.total",
                repeatitems: false,
                id: "reg_option_id"
            },
            loadComplete: function(response) {
                if (response && response.status == 200) {
                    var gridData = {};
                    data = response.data;
                    for (var i = 0; i < data.items.length; i++) {
                        var item = data.items[i];
                        item['id'] = item.reg_option_id;
                        gridData[item.reg_option_id] = item;
                    }

                    $("#grid").data('gridData', gridData);
                } else {
                    var msg = response.status === 250 ? (searchFlag ? _('没有满足条件的结果哦！') : _('没有数据哦！')) : response.msg;
                    parent.Public.tips({
                        type: 2,
                        content: msg
                    });
                }

                var re_records = $("#grid").getGridParam('records');
                if (re_records == 0 || re_records == null) {
                    if ($("#grid").parent().find(".norecords").length < 1) {
                        $("#grid").parent().append(_('<div class="norecords">没有符合数据</div>'));
                    }


                    $(".norecords").show();
                } else {
                    //如果存在记录，则隐藏提示信息。
                    $(".norecords").hide();
                }
            },
            loadError: function(xhr, status, error) {
                parent.Public.tips({
                    type: 1,
                    content: _('操作失败了哦，请检查您的网络链接！')
                });
            },
            resizeStop: function(newwidth, index) {
            }
        }).navGrid('#grid-pager', {
                edit: false,
                add: false,
                del: false,
                search: false,
                refresh: false
            }, {}, // edit options
            {}, // add options
            {}, // delete options
            {
                multipleSearch: true,
                multipleGroup: true,
                showQuery: true
            }
        );
    }

    function initEvent() {
        var match_con = $('#matchCon');
        //查询
        $('#search').on('click', function(e) {
            e.preventDefault();
            var skey = $.trim(match_con.val());
            var category_id = catorageCombo ? catorageCombo.getValue() : -1;
            $("#grid").jqGrid('setGridParam', {
                page: 1,
                postData: {
                    skey: skey,
                    category_id: category_id
                }
            }).trigger("reloadGrid");

        });

        //新增
        $('#btn-add').on('click', function(e) {
            e.preventDefault();
            handle.operate('add');
        });

        //导入
        $('#btn-import').on('click', function(e) {
            e.preventDefault();

            parent.$.dialog({
                width: 560,
                height: 300,
                title: '批量导入',
                content: 'url:' + SITE_URL + '?ctl=Reg_Option&met=import&typ=e',
                lock: true
            });
        });

        //修改
        $('#grid').on('click', '.operating .ui-icon-pencil:not(.ui-icon-disabled)', function(e) {
            e.preventDefault();
            var id = $(this).parent().data('id');
            handle.operate('edit', id);
        });

        //删除
        $('#grid').on('click', '.operating .ui-icon-trash:not(.ui-icon-disabled)', function(e) {
            e.preventDefault();

            var id = $(this).parent().data('id');
            handle.del(id + '');
        });

        //批量删除
        $('#btn-batchDel').click(function(e) {
            e.preventDefault();

            var ids = $('#grid').jqGrid('getGridParam', 'selarrrow');
            ids.length ? handle.del(ids.join()) : parent.Public.tips({
                type: 2,
                content: _('请选择需要删除的项')
            });
        });

        //禁用
        $('#btn-disable').click(function(e) {
            e.preventDefault();
            var ids = $("#grid").jqGrid('getGridParam', 'selarrrow').concat();
            if (!ids || ids.length == 0) {
                parent.Public.tips({
                    type: 1,
                    content: _(' 请先选择要禁用的！')
                });
                return;
            }
            handle.setStatuses(ids, true);
        });

        //启用
        $('#btn-enable').click(function(e) {
            e.preventDefault();
            var ids = $("#grid").jqGrid('getGridParam', 'selarrrow').concat();
            if (!ids || ids.length == 0) {
                parent.Public.tips({
                    type: 1,
                    content: _(' 请先选择要启用的！')
                });
                return;
            }
            handle.setStatuses(ids, false);
        });

        //设置状态
        $('#grid').on('click', '.set-status', function(e) {
            if (e.stopPropagation(), e.preventDefault(), Business.verifyRight('INVLOCTION_UPDATE'))
            {

                var id = $(this).data('id'),
                    is_enable = Number(!$(this).data('enable'));

                handle.setStatus(id, is_enable);
            }
        });

    }

    initDom();
    initGrid();
    initEvent();
});