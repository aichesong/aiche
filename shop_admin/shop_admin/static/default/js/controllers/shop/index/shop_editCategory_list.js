urlParam = Public.urlParam();
var queryConditions = {
        cardName: '',shop_id:urlParam.shop_id,
    },  
    hiddenAmount = false, 
    SYSTEM = system = parent.SYSTEM;
var THISPAGE = {
    init: function(data){
        if (SYSTEM.isAdmin === false && !SYSTEM.rights.AMOUNT_COSTAMOUNT) {
            hiddenAmount = true;
        };
        this.mod_PageConfig = Public.mod_PageConfig.init('complain-new-list');//页面配置初始化
        this.initDom();
        this.loadGrid();            
        this.addEvent();
    },
    initDom: function(){
        this.$_searchName = $('#searchName');
        this.$_searchName.placeholder();
    },
    loadGrid: function(){
        var gridWH = Public.setGrid(), _self = this;
        var colModel = [
            {name:'operating', label:'操作', width:100, fixed:true, formatter:operFmattershop, align:"center"},
            {name:'shop_name', label:'店铺名称', width:100,align:'center'},
            {name:'commission_rate', label:'分佣比例（%）',  width:100, align:"center"},
            {name:'shop_class_bind_enablecha', label:'状态',  width:100, align:"center"},
            {name:'cat_namenum', label:'经营类目',  width:200, align:"center"},

               
        ];
        this.mod_PageConfig.gridReg('grid', colModel);
        colModel = this.mod_PageConfig.conf.grids['grid'].colModel;
        $("#grid").jqGrid({
            url:SITE_URL +  "?ctl=Shop_Manage&met=editCategory&typ=json",
            postData: queryConditions,
            datatype: "json",
            autowidth: true,//如果为ture时，则当表格在首次被创建时会根据父元素比例重新调整表格宽度。如果父元素宽度改变，为了使表格宽度能够自动调整则需要实现函数：setGridWidth
            height: gridWH.h,
            altRows: true, //设置隔行显示
            gridview: true,
            multiboxonly: true,
            colModel:colModel,
            cmTemplate: {sortable: false, title: false},
            page: 1, 
            sortname: 'number',    
            sortorder: "desc", 
            pager: "#page",  
            rowNum: 100,
            rowList:[100,200,500], 
            viewrecords: true,
            shrinkToFit: false,
            forceFit: true,
            jsonReader: {
              root: "data.items",
              records: "data.records",
              repeatitems : false,
              total : "data.total",
              id: "shop_class_bind_id"
            },
            loadError : function(xhr,st,err) {
                
            },
            ondblClickRow : function(rowid, iRow, iCol, e){
                $('#' + rowid).find('.ui-icon-pencil').trigger('click');
            },
            resizeStop: function(newwidth, index){
                THISPAGE.mod_PageConfig.setGridWidthByIndex(newwidth, index, 'grid');
            }
        }).navGrid('#page',{edit:false,add:false,del:false,search:false,refresh:false}).navButtonAdd('#page',{
            caption:"",   
            buttonicon:"ui-icon-config",   
            onClickButton: function(){
                THISPAGE.mod_PageConfig.config();
            },   
            position:"last"  
        });
        
    
    function operFmattershop(val, opt, row) {
            var html_con = '<div class="operating" data-id="' + row.shop_class_bind_id + '"><span class="ui-icon ui-icon-trash" title="删除"></span><span class="ui-icon  ui-icon-pencil" title="修改比例"></span></div>';
            return html_con;
};


    },
    reloadData: function(data){
        $("#grid").jqGrid('setGridParam',{postData: data}).trigger("reloadGrid");
    },
    addEvent: function(){
        var _self = this;
        //删除
             $("#grid").on("click", ".operating .ui-icon-trash", function (e)
        {
            e.preventDefault();
            if (Business.verifyRight("INVLOCTION_DELETE"))
            {
                var e = $(this).parent().data("id");
                handle.del(e)
            }
        });
     $("#btn-add").click(function (t)
    {
        t.preventDefault();
        Business.verifyRight("INVLOCTION_ADD") && handle.operate("add")
    });
                //修改
        $("#grid").on("click", ".operating .ui-icon-pencil", function (e)
        {
            e.preventDefault();
           
                var e = $(this).parent().data("id");
                handle.operate("edit",e);
        });
        $('#search').click(function(){
            queryConditions.search_name = _self.$_searchName.val() === '请输入相关数据...' ? '' : _self.$_searchName.val();
            queryConditions.user_type = $source.getValue();
            queryConditions.shop_id = urlParam.shop_id;
            THISPAGE.reloadData(queryConditions);
        });

        $("#btn-refresh").click(function ()
        {
            queryConditions.shop_id = urlParam.shop_id;
            THISPAGE.reloadData(queryConditions);
            _self.$_searchName.val('请输入相关数据...');
        });

        $(window).resize(function(){
            Public.resizeGrid();
        });
    }
};
var handle = {
      operate: function (t, e)
    {         
        if ("add" == t)
        {
            var i = "新增店铺经营类目", a = {oper: t, callback:testF};
        }
        else
        {
            var i = "编辑店铺经营类目", a = {oper: t, callback:testF};
           
        }
        $.dialog({
            title: i,
            content: "url:"+ SITE_URL + "?ctl=Shop_Manage&met="+t+"ShopCategory&shop_class_bind_id="+e+"&shop_id="+urlParam.shop_id,
            data: a,
            width: 600,
            height: 300,
            max: !1,
            min: !1,
            cache: !1,
            lock: !0
        })
      
    
  
    },
     del: function (t)
    {
        $.dialog.confirm("该类目已经审核通过，删除它可能影响到商家的使用，确认删除吗？", function ()
        {
            Public.ajaxPost(SITE_URL + "?ctl=Shop_Manage&met=delCategory&typ=json", {shop_class_bind_id: t}, function (e)
            {
                if (e && 200 == e.status)
                {
                    parent.Public.tips({content: "类目删除成功！"});
                    $("#grid").jqGrid("delRowData", t)
                }
                else
                {
                    parent.Public.tips({type: 1, content: "类目删除失败！" + e.msg})
                }
            })
        })
    },
        status: function (t)
    {
        $.dialog.confirm("审核经营类目", function ()
        {
            Public.ajaxPost(SITE_URL + "?ctl=Shop_Manage&met=categoryStatus&typ=json", {shop_class_bind_id: t}, function (e)
            {
                if (e && 200 == e.status)
                {
                    parent.Public.tips({content: "成功！"});
                    location.href= SITE_URL + "?ctl=Shop_Manage&met=category"; 
                }
                else
                {
                    parent.Public.tips({type: 1, content: "失败！" + e.msg})
                }
            })
        })
    }
};
    function testF(){ 
      window.location.reload(); 
}
    
$(function(){
    $source = $("#source").combo({
        data: [{
            id: "0",
            name: "店主id"
        },{
            id: "1",
            name: "分佣比例"
        }],
        value: "id",
        text: "name",
        width: 110
    }).getCombo();

    THISPAGE.init();
    
});
