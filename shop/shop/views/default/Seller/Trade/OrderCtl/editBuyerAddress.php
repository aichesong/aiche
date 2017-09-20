<!DOCTYPE HTML>
<html>
<head>
    <link href="<?= $this->view->css ?>/seller.css?ver=<?= VER ?>" rel="stylesheet">
    <link href="<?= $this->view->css ?>/iconfont/iconfont.css?ver=<?= VER ?>" rel="stylesheet" type="text/css">
    <link href="<?= $this->view->css ?>/seller_center.css?ver=<?= VER ?>" rel="stylesheet">
    <link href="<?= $this->view->css ?>/base.css?ver=<?= VER ?>" rel="stylesheet">
    <style>
        textarea, .textarea {
            font: 12px/18px Arial;
            color: #777;
            background-color: #FFF;
            vertical-align: top;
            display: inline-block;
            height: 54px;
            padding: 4px;
            border: solid 1px #CCD0D9;
            outline: 0 none;
        }
    </style>

    <link href="<?= $this->view->css_com ?>/jquery/plugins/validator/jquery.validator.css?ver=<?= VER ?>" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?=$this->view->js_com?>/jquery.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?= $this->view->js_com ?>/plugins/validator/jquery.validator.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?= $this->view->js_com ?>/plugins/validator/local/zh_CN.js"></script>
</head>
<body>

<div class="dialog_content" style="margin: 0px; padding: 0px;">
    <div class="eject_con">
        <div class="adds">
            <div id="warning"></div>
            <form id="address_form">
                <input type="hidden" id="order_id" name="order_id" value="">
                <dl>
                    <dt class="required"><?=__('收货人')?>：</dt>
                    <dd>
                        <input type="text" class="text" name="order_receiver_name" id="order_receiver_name" value="">
                    </dd>
                </dl>
                <dl>
                    <dt class="required"><?=__('手机')?>：</dt>
                    <dd>
                        <input type="text" class="text" name="order_receiver_contact" id="order_receiver_contact" value="">
                    </dd>
                </dl>
                <dl>
                    <dt class="required"><?=__('收货地址')?>：</dt>
                    <dd>
                        <textarea style="width:250px;resize: none;" name="order_receiver_address" id="order_receiver_address"></textarea>
                    </dd>
                </dl>
            </form>
        </div>
    </div>

</div>

</body>
</html>

<script>
    api = frameElement.api,
    address_data = api.data.address_data;
    callback = api.data.callback;

    $( function () {
        console.info(address_data);
        $('#order_id').val(address_data.order_id);
        $('#order_receiver_name').val(address_data.order_receiver_name);
        $('#order_receiver_contact').val(address_data.order_receiver_contact);
        $('#order_receiver_address').html(address_data.order_receiver_address);

        //验证
        $('#address_form').validator({
            theme: 'yellow_right',
            timely: true,

            fields: {
                'order_receiver_name':    'required;',
                'order_receiver_contact': 'required;mobile;',
                'order_receiver_address': 'required;',
            },

            valid: function(form) {
                $.post(parent.SITE_URL + '?ctl=Seller_Trade_Order&met=editBuyerAddress&typ=json', $('#address_form').serialize(), function (data) {
                    if ( data.status == 200 ) {
                        parent.Public.tips( { content:'success', type: 3 } );
                        callback(data.data);
                        api.close();
                    } else {
                        parent.Public.tips( { content:'failure', type: 1 } );
                    }
                })
            }
        });

        api.button({
            id: "confirm",
            name: '<?=__('确定')?>',
            focus: !0,
            callback: function() {
                $('#address_form').trigger("submit");
                return false;
            }
        }, {
            id: "cancel",
            name: '<?=__('取消')?>'
        });
    })
</script>