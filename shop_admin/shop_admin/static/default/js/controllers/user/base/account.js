$(function () {
    function a() {
        Public.zTree.init($('#tree'), {
            defaultClass: 'innerTree',
            showRoot: !0,
            rootTxt: '全部'
        }, {
            callback: {
                beforeClick: function (a, b) {
                    $('#currentCategory').data('id', b.id).html(b.name),
                        $('#search').trigger('click')
                }
            }
        })
    }
    function b() {
        var a = Public.setGrid(f, g),
            b = parent.SYSTEM.rights,
            c = !(parent.SYSTEM.isAdmin || b.AMOUNT_COSTAMOUNT),
            h = !(parent.SYSTEM.isAdmin || b.AMOUNT_INAMOUNT),
            k = !(parent.SYSTEM.isAdmin || b.AMOUNT_OUTAMOUNT),
            l = [
                {
                    name: 'operate',
                    label: '操作',
                    width: 35,
                    fixed: !0,
                    formatter: function (a, b, c) {
                        var d = '<div class="operating" data-id="' + c.server_id + '"><span class="ui-icon ui-icon-pencil" title="修改"><!--</span><span class="ui-icon ui-icon-trash" title="删除"></span><span class="ui-icon ui-icon-pic" title="商品图片"></span>--></div>';
                        return d
                    },
                    title: !1
                },
                {
                    name: 'company_name',
                    label: '公司名称',
                    width: 100,
                    align: 'center'
                },
                {
                    name: 'company_phone',
                    label: '公司电话',
                    width: 120,
                    align: 'center'
                },
                {
                    name: 'contacter',
                    label: '联系人',
                    width: 150,
                    align: 'center'
                },
                {
                    name: 'sign_time',
                    label: '签约时间',
                    width: 150,
                    align: 'center'
                },
                {
                    name: 'account_num',
                    label: '帐号个数',
                    width: 50,
                    align: 'center',
                    width:50
                },
                {
                    name: 'user_name',
                    label: '用户帐号',
                    width: 150
                },
                {
                    name: 'db_name',
                    label: '数据库名',
                    width: 100
                },
                {
                    name: 'upload_path',
                    label: '附件存放地址',
                    width: 200
                },
                {
                    name: 'business_agent',
                    label: '业务代表',
                    width: 100
                },
                {
                    name: 'price',
                    label: '费用',
                    width: 100
                },
                {
                    name: 'effective_date_start',
                    label: '开始有效时间',
                    width: 150
                },
                {
                    name: 'effective_date_end',
                    label: '结束有效时间',
                    width: 150
                },
                {
                    name: 'delete',
                    label: '状态',
                    index: 'delete',
                    width: 80,
                    align: 'center',
                    formatter: i.statusFmatter
                }
            ];
        j.gridReg('grid', l),
            l = j.conf.grids.grid.colModel,

            $('#grid').jqGrid({

                url: SITE_URL + '?ctl=User_Base&met=getUserList&typ=json',

                datatype: 'json',
                width: a.w,
                height: a.h,
                altRows: !0,
                gridview: !0,
                onselectrow: !1,
                colModel: l,
                pager: '#page',
                viewrecords: !0,
                checkbox:false,
                cmTemplate: {
                    sortable: !1
                },
                rowNum: 100,
                rowList: [
                    100,
                    200,
                    500
                ],
                shrinkToFit: !1,
                forceFit: !0,
                jsonReader: {
                    root: 'data.items',
                    records: 'data.records',
                    total: 'data.total',
                    repeatitems: !1,
                    id: 'id'
                },
                loadComplete: function (a) {
                    if (a && 200 == a.status) {
                        var b = {
                        };
                        a = a.data;
                        for (var c = 0; c < a.items.length; c++) {
                            var d = a.items[c];
                            d['id'] = d.goods_id;
                            b[d.goods_id] = d
                        }
                        $('#grid').data('gridData', b)
                    }
                },
                loadError: function (a, b, c) {
                    parent.Public.tips({
                        type: 1,
                        content: '操作失败了哦，请检查您的网络链接！'
                    })
                },
                resizeStop: function (a, b) {
                    j.setGridWidthByIndex(a, b, 'grid')
                }
            }).navGrid('#page', {
                edit: !1,
                add: !1,
                del: !1,
                search: !1,
                refresh: !1
            }).navButtonAdd('#page', {
                caption: '',
                buttonicon: 'ui-icon-config',
                onClickButton: function () {
                    j.config()
                },
                position: 'last'
            })
    }
    function c() {
        $_matchCon = $('#matchCon'),
            $_matchCon.placeholder(),
            $('#search').on('click', function (a) {
                a.preventDefault();
                var b = '按商品编号，商品名称查询' === $_matchCon.val() ? '' : $.trim($_matchCon.val()),
                    c = $('#currentCategory').data('id');
                $('#grid').jqGrid('setGridParam', {
                    page: 1,
                    postData: {
                        skey: b,
                        assistId: c
                    }
                }).trigger('reloadGrid')
            }),
            $('#btn-add').on('click', function (a) {
                a.preventDefault(),
                Business.verifyRight('INVENTORY_ADD') && h.operate('add')
            }),
            $('#btn-print').on('click', function (a) {
                a.preventDefault()
            }),
            $('#btn-import').on('click', function (a) {
                a.preventDefault(),
                Business.verifyRight('BaseData_IMPORT') && parent.$.dialog({
                    width: 560,
                    height: 300,
                    title: '批量导入',
                    content: 'url:/import.jsp',
                    lock: !0
                })
            }),
            $('#btn-export').on('click', function (a) {
                if (Business.verifyRight('INVENTORY_EXPORT')) {
                    var b = '按商品编号，商品名称，规格型号等查询' === $_matchCon.val() ? '' : $.trim($_matchCon.val()),
                        c = $('#currentCategory').data('id') || '';
                    $(this).attr('href', '/basedata/inventory.do?action=exporter&isDelete=2&skey=' + b + '&assistId=' + c)
                }
            }),
            $('#grid').on('click', '.operating .ui-icon-pencil', function (a) {
                if (a.preventDefault(), Business.verifyRight('INVENTORY_UPDATE')) {
                    var b = $(this).parent().data('id');
                    h.operate('edit', b)
                }
            }),
            $('#grid').on('click', '.operating .ui-icon-trash', function (a) {
                if (a.preventDefault(), Business.verifyRight('INVENTORY_DELETE')) {
                    var b = $(this).parent().data('id');
                    h.del(b + '')
                }
            }),
            $('#grid').on('click', '.operating .ui-icon-pic', function (a) {
                a.preventDefault();
                var b = $(this).parent().data('id'),
                    c = '商品图片';
                $.dialog({
                    content: '',
                    data: {
                        title: c,
                        id: b,
                        callback: function () {
                        }
                    },
                    title: c,
                    width: 775,
                    height: 470,
                    max: !1,
                    min: !1,
                    cache: !1,
                    lock: !0
                })
            }),
            $('#btn-batchDel').click(function (a) {
                if (a.preventDefault(), Business.verifyRight('INVENTORY_DELETE')) {
                    var b = $('#grid').jqGrid('getGridParam', 'selarrrow');
                    b.length ? h.del(b.join())  : parent.Public.tips({
                        type: 2,
                        content: '请选择需要删除的项'
                    })
                }
            }),
            $('#btn-disable').click(function (a) {
                a.preventDefault();
                var b = $('#grid').jqGrid('getGridParam', 'selarrrow').concat();
                return b && 0 != b.length ? void h.setStatuses(b, !0)  : void parent.Public.tips({
                    type: 1,
                    content: ' 请先选择要禁用的商品！'
                })
            }),
            $('#btn-enable').click(function (a) {
                a.preventDefault();
                var b = $('#grid').jqGrid('getGridParam', 'selarrrow').concat();
                return b && 0 != b.length ? void h.setStatuses(b, !1)  : void parent.Public.tips({
                    type: 1,
                    content: ' 请先选择要启用的商品！'
                })
            }),
            $('#hideTree').click(function (a) {
                a.preventDefault();
                var b = $(this),
                    c = b.html();
                '&gt;&gt;' === c ? (b.html('&lt;&lt;'), g = 0, $('#tree').hide(), Public.resizeGrid(f, g))  : (b.html('&gt;&gt;'), g = 270, $('#tree').show(), Public.resizeGrid(f, g))
            }),
            $('#grid').on('click', '.set-status', function (a) {
                if (a.stopPropagation(), a.preventDefault(), Business.verifyRight('INVLOCTION_UPDATE')) {
                    var b = $(this).data('id'),
                        c = !$(this).data('delete');
                    h.setStatus(b, c)
                }
            }),
            $(window).resize(function () {
                Public.resizeGrid(f, g),
                    $('.innerTree').height($('#tree').height() - 95)
            }),
            Public.setAutoHeight($('#tree')),
            $('.innerTree').height($('#tree').height() - 95)
    }
    var d = (parent.SYSTEM, Number(parent.SYSTEM.qtyPlaces), Number(parent.SYSTEM.pricePlaces)),
        e = Number(parent.SYSTEM.amountPlaces),
        f = 95,
        g = 0,
        h = {
            operate: function (a, b) {
                if(a=='edit')
                {
                    $.dialog({
                        title: '编辑用户',
                        content: 'url:'+SITE_URL + "?ctl=User_Base&met=accountmanage&id=" + b,
                        width: $(window).width() * 0.5,
                        height: $(window).height() * 0.4,
                        data: {oper:a,id:b,callback: this.callback},
                        max: !1,
                        min: !1,
                        cache: !1,
                        lock: !0
                    })
                }
                if(a=='add')
                {
                    $.dialog({
                        title: '新增用户',
                        content: 'url:'+SITE_URL + "?ctl=User_Base&met=accountmanage",
                        width: $(window).width() * 0.5,
                        height: $(window).height() * 0.4,
                        data: {oper:a,callback: this.callback},
                        max: !1,
                        min: !1,
                        cache: !1,
                        lock: !0
                    })
                }

            },
            del: function (a) {
                $.dialog.confirm('删除的商品将不能恢复，请确认是否删除？', function () {
                    Public.ajaxPost('', {
                        id: a
                    }, function (b) {
                        if (b && 200 == b.status) {
                            var c = b.data.id || [];
                            a.split(',').length === c.length ? parent.Public.tips({
                                content: '成功删除' + c.length + '个商品！'
                            })  : parent.Public.tips({
                                type: 2,
                                content: b.data.msg
                            });
                            for (var d = 0, e = c.length; e > d; d++) $('#grid').jqGrid('setSelection', c[d]),
                                $('#grid').jqGrid('delRowData', c[d])
                        } else parent.Public.tips({
                            type: 1,
                            content: '删除商品失败！' + b.msg
                        })
                    })
                })
            },
            setStatus: function (a, b) {
                a && Public.ajaxPost(SITE_URL + '?ctl=User_Base&met=change&typ=json', {
                    id: a,
                    server_status: !Number(b)
                }, function (c) {
                    c && 200 == c.status ? (parent.Public.tips({
                        content: '状态修改成功！'
                    }), $('#grid').jqGrid('setCell', a, 'delete', b))  : parent.Public.tips({
                        type: 1,
                        content: '状态修改失败！' + c.msg
                    })
                })
            },
            setStatuses: function (a, b) {
                if (a && 0 != a.length) {
                    var c = $('#grid').jqGrid('getGridParam', 'selarrrow'),
                        d = c.join();
                    Public.ajaxPost(SITE_URL + '?ctl=User_Base&met=change&typ=json', {
                        id: a,
                        server_status: Number(b)
                    }, function (c) {
                        if (c && 200 == c.status) {
                            parent.Public.tips({
                                content: '状态修改成功！'
                            });
                            for (var d = 0; d < a.length; d++) {
                                var e = a[d];
                                $('#grid').jqGrid('setCell', e, 'delete', b)
                            }
                        } else parent.Public.tips({
                            type: 1,
                            content: '状态修改失败！' + c.msg
                        })
                    })
                }
            },
            callback: function (a, b, c) {
                $("#grid").trigger("reloadGrid");
                var d = $('#grid').data('gridData');
                d || (d = {
                }, $('#grid').data('gridData', d)),
                    d[a.id] = a,
                    'edit' == b ? ($('#grid').jqGrid('setRowData', a.id, a), c && c.api.close())  : ($('#grid').jqGrid('addRowData', a.id, a, 'last'), c && c.resetForm(a))
            }
        },
        i = {
            money: function (a, b, c) {
                var a = Public.numToCurrency(a);
                return a || '&#160;'
            },
            currentQty: function (a, b, c) {
                if ('none' == a) return '&#160;';
                var a = Public.numToCurrency(a);
                return a
            },
            quantity: function (a, b, c) {
                var a = Public.numToCurrency(a);
                return a || '&#160;'
            },
            statusFmatter: function (a, b, c) {
                var d = a === !0 ? '未开通' : '已开通',
                    e = a === !0 ? 'ui-label-default' : 'ui-label-success';
                return '<span class="set-status ui-label ' + e + '" data-delete="' + a + '" data-id="' + c.id + '">' + d + '</span>'
            }
        },
        j = Public.mod_PageConfig.init('goodsList');
    b(),
        a(),
        c()
});
