<?php if (!defined('ROOT_PATH'))
{
    exit('No Permission');
} ?>
<?php
include TPL_PATH . '/' . 'header.php';
// 当前管理员权限
$admin_rights = $this->getAdminRights();
// 当前页父级菜单 同级菜单 当前菜单
$menus = $this->getThisMenus();
?>

<script>
function validMaxForShare(){
    $.ajax({
      url: './erp.php?ctl=User_Base&met=right&action=isMaxShareUser',
      dataType: 'json',
      type: 'POST',
      success: function(data){
        if(data.status === 200){
        	var json = data.data;
        	if(json.shareTotal >= json.totalUserNum)
        	{
        		parent.Public.tips({type:2, content : '共享用户已经达到上限值：'+json.totalUserNum});
        		return false;
        	}
        	else
        	{
        		window.location.href='./index.php?ctl=User_Base&met=manage';
        	}
        }
      }
  });
}
</script>
</head>
<body>

<div class="wrapper page">

    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3><?=$menus['father_menu']['menu_name']?></h3>
                <h5><?=$menus['father_menu']['menu_url_note']?></h5>
            </div>
            <ul class="tab-base nc-row">
              <?php 
              foreach($menus['brother_menu'] as $key=>$val){ 
                  if(in_array($val['rights_id'],$admin_rights)||$val['rights_id']==0){
              ?>
              <li><a <?php if(!array_diff($menus['this_menu'], $val)){?> class="current"<?php }?> href="<?= Yf_Registry::get('url') ?>?ctl=<?=$val['menu_url_ctl']?>&met=<?=$val['menu_url_met']?><?php if($val['menu_url_parem']){?>&<?=$val['menu_url_parem']?><?php }?>"><span><?=$val['menu_name']?></span></a></li>
              <?php 
                  }
              }
              ?>
                <!-- <li><a class="current"  href="<?= Yf_Registry::get('url') ?>?ctl=User_Base&met=index"><span>管理员</span></a></li>
                <li><a href="<?= Yf_Registry::get('url') ?>?ctl=Rights_Group&met=index"><span>权限组</span></a></li>
                <li><a  href="<?= Yf_Registry::get('url') ?>?ctl=Log_Action&met=index"><span>操作日志</span></a></li> -->
            </ul>
        </div>
    </div>
    <!-- 操作说明 -->
    <p class="warn_xiaoma"><span></span><em></em></p><div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="iconfont icon-lamp"></i>
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示"></span><em class="close_warn iconfont icon-guanbifuzhi"></em></div>
        <ul>
            <?=$menus['this_menu']['menu_url_note']?>
        </ul>
    </div>
    
    <div class="mod-toolbar-top cf mod-search" >
      <div class="fr"><a href="javascript:void(0)" id="btn-add_user" class="ui-btn ui-btn-sp">新增同事</a></div>
      <!-- <div class="fr"><a href="./index.php?ctl=Rights_Group&met=index" class="ui-btn ui-btn-sp" id="btn-add">权限组管理</a></div> -->

       
<!--       <span class="tit" id="shareInfo" style="display:none;">该账套主服务最多支持<strong id="totalUser"></strong>用户共同管理，已共享<strong id="usedTotal"></strong>人，剩余<strong id="leftTotal"></strong>。</span>-->
    </div>
    <div class="grid-wrap">
      <table id="grid">
      </table>
      <div id="page"></div>
    </div>


  <div id="initCombo" class="dn">
    <input type="text" class="textbox goodsAuto" name="goods" autocomplete="off">
    <input type="text" class="textbox storageAuto" name="storage" autocomplete="off">
    <input type="text" class="textbox unitAuto" name="unit" autocomplete="off">
  </div>
  <div id="storageBox" class="shadow target_box dn">
  </div>
</div>
<script>


  (function($){
    var totalUser, usedTotal, leftTotal;
    initGrid();

    $('.grid-wrap').on('click', '.authorize', function(e){
      var id = $(this).parents('tr').attr('id');
      var rowData = $('#grid').getRowData(id);
      var user_account = rowData.user_account;
      var user_id = rowData.user_id;
      console.info(this)
      console.info(id)
      console.info(rowData)
      e.preventDefault();
      $.ajax({
        url: './index.php?ctl=User_Base&met=right&typ=json&action=auth2UserCancel&user_account=' + user_account +'&user_id=' + user_id,
        type: 'POST',
        dataType: 'json',
        success: function(data){
          if (data.status == 200) {
            parent.Public.tips({content: '授权成功！'});
            usedTotal--;
            leftTotal++;
            showShareCount();
            if (rowData.isCom) {
                rowData.user_delete = false;
                $("#grid").jqGrid('setRowData', id, rowData);
            } else {
                $("#grid").jqGrid('setRowData', id, rowData);
            }

          } else {
            parent.Public.tips({type: 1, content: '取消用户授权失败！' + data.msg});
          }
        },
        error: function(){
           parent.Public.tips({content:'取消用户授权失败！请重试。', type: 1});
        }
      });
    });

    $('.grid-wrap').on('click', '.delete', function(e){
      var id = $(this).parents('tr').attr('id');
      var rowData = $('#grid').getRowData(id);
      var user_account = rowData.user_account;
      var user_id = rowData.user_id;
      console.info(this)
      console.info(id)
      console.info(rowData)
      e.preventDefault();
       $.ajax({
        type: 'POST',
        dataType: 'json',
        url: './index.php?ctl=User_Base&met=right&typ=json&action=auth2User&user_account=' + user_account + '&user_id=' + user_id,
        success: function(data){
          if (data.status == 200) {
            parent.Public.tips({content : '取消用户授权成功！'});
            rowData.user_delete = true;
            $("#grid").jqGrid('setRowData', id, rowData);
            usedTotal++;
            leftTotal--;
            showShareCount();
            //window.location.href = 'authority-setting.jsp?user_account=' + user_account + '&right=0';
          } else {
            parent.Public.tips({type:1, content : data.msg});
          }
        },
        error: function(){
          parent.Public.tips({type:1, content : '用户授权失败！请重试。'});
        }
      });
    });

function operDataFormatter(val, opt, row) {
	var html_con = '<div class="operating" data-id="' + row.user_id + '"><span class="ui-icon ui-icon-pencil" title="修改"></span></div>';
	return html_con;

};

	var handle = {
    operate: function (t, e)
    {
        if ("add" == t)
        {
            var i = "新增职员", a = {oper: t, callback: this.callback};
        }
        else
        {
            var i = "修改职员", a = {oper: t, rowData: $("#grid").data("gridData")[e], callback: this.callback};
        }
        $.dialog({
            title: i,
            content: "url:./index.php?ctl=User_Base&met=manage",
            data: a,
            width: 400,
            height: 280,
            max: !1,
            min: !1,
            cache: !1,
            lock: !0
        })
    },

    callback: function (t, e, i)
    {
        var a = $("#grid").data("gridData");

        if (!a)
        {
            a = {};
            $("#grid").data("gridData", a)
        }

        a[t.user_id] = t;

        if ("edit" == e)
        {
            $("#grid").jqGrid("setRowData", t.user_id, t);
            i && i.api.close()
        }
        else
        {
            $("#grid").jqGrid("addRowData", t.user_id, t, "last");
            i && i.resetForm(t)
        }
    }
};

    $("#grid").on("click", ".operating .ui-icon-pencil", function (t)
    {
        t.preventDefault();
        if (Business.verifyRight("INVLOCTION_UPDATE"))
        {
            var e = $(this).parent().data("id");
            handle.operate("edit", e)
        }
    });
    $("#btn-add_user").click(function (t)
    {
        t.preventDefault();
        Business.verifyRight("INVLOCTION_ADD") && handle.operate("add")
    });

    function initGrid(){
      $('#grid').jqGrid({
        url: './index.php?ctl=User_Base&met=userList&typ=json',
        datatype: 'json',
        height: Public.setGrid().h,
        colNames:['操作', '用户id',  '用户',  '公司','权限组',/*'功能授权','数据授权',*/'启用授权'],
        colModel:[
            {
                name: 'operate',
                width: 40,
                fixed: !0,
                formatter: operDataFormatter,
                title: !1,
                align:"center"
            },
          {name:'user_id',index:'user_id', width:100, editable: !1, hidden:!0,align:"center"},
          {name:'user_account',index:'user_account', width:100, editable: !1, align:"center"},
          {name:'isCom', index:'isCom', hidden: true},
          {
				name:'rights_group_name', index:'rights_group_name', width:200,
				editable: !0,align:"center"
			},

//        {name:'setting', index:'setting', width:100, align:"center", editable: !1, title:false, formatter: settingFormatter},
//		  {name:'setting_data', index:'setting_data', width:100, align:"center", editable: !1, title:false, formatter: settingDataFormatter, hidden:(parent.SYSTEM.siType == 1)},
		  {name:'user_delete', index:'user_share', width:100, align:"center", editable: !1, title:false, formatter: shareFormatter}
        ],
        altRows:true,
        gridview: true,
        page: 1,
        scroll: 1,
        autowidth: true,
        cmTemplate: {sortable:false},
        rowNum:150,
        shrinkToFit:false,
        forceFit:false,
        pager: '#page',
        viewrecords: true,
        jsonReader: {
          root: 'data.items',
          records: 'data.totalsize',
          repeatitems : false,
          id: 'user_id'
        },
        loadComplete: function(data){

          if (data.status == 200) {
            var temp = data.data;

            /*totalUser = temp.totalUserNum;
            usedTotal = temp.shareTotal;
            leftTotal = totalUser - usedTotal;*/
            leftTotal = data.data.leftTotal;
            usedTotal = data.data.items.length;
            showShareCount();
            $('#shareInfo').show();

            var e = {};
            t = temp;
            for (var i = 0; i < t.items.length; i++)
            {
                var item = t.items[i];
                e[item.user_id] = item
            }
            $("#grid").data("gridData", e)


          } else {
        	  parent.Public.tips({type: 1, content: data.msg});
          }

        },
        loadonce: true
      });

      $("#grid").jqGrid("setGridParam", {cellEdit: !1})
    }


    function showShareCount(){
        $('#totalUser').text(totalUser);
        $('#usedTotal').text(usedTotal);
        $('#leftTotal').text(leftTotal);
    }

	function rightsGroupFormate(a)
	{
		return a = "boolean" == typeof a ? a ? "1" : "0" : a, "1" === a ? "是" : "&#160;"
	}

    function shareFormatter(val, opt, row) {
        if (Number(val) || '1' == row.user_admin) {
          if ('1' == row.user_admin) {
              return '管理员';
          } else {
               return '<div class="operating" data-id="' + row.user_id + '"><span class="authorize ui-label ui-label-default">已停用</span></div>';
          }
        } else {
          //return '<p class="operate-wrap"><span class="authorize ui-label ui-label-default">已停用</span></p>';
          return '<div class="operating" data-id="' + row.user_id + '"><span class="delete ui-label ui-label-success">已启用</span></p>';
        }
    };
    function settingFormatter(val, opt, row) {
		if ('1' == row.user_admin || row.user_delete) {
			return '&nbsp;';
		} else {
			return '<div class="operating" data-id="' + row.user_id + '"><a class="ui-icon ui-icon-pencil" title="详细设置授权信息" href="./erp.php?ctl=Rights_Base&met=index&user_account=' + row.user_account + '&user_id=' + row.user_id + '"></a></div>';
		}
    };
    function settingDataFormatter(val, opt, row) {
		if ('1' == row.user_admin || row.user_delete) {
			return '&nbsp;';
		} else {
			return '<div class="operating" data-id="' + row.user_id + '"><a class="ui-icon ui-icon-pencil" title="详细设置授权信息" href="./erp.php?ctl=Rights_Base&met=indexData&user_account=' + row.user_account + '&user_id=' + row.user_id + '"></a></div>';
		}
    };
  })(jQuery)

  $(window).resize(function(){
	  Public.resizeGrid();
  });
</script>
<?php
include TPL_PATH . '/' . 'footer.php';
?>