<?php

use App\Models\EmailTemplate;
use Faker\Generator as Faker;

$factory->define(EmailTemplate::class, function (Faker $faker) {
    return [
        'name' => '营销活动 - ' . $faker->randomElement(['一', '二', '三', '四', '五']),
        'type' => 'html',
        'template' => '<p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><div><span style="color: rgb(194, 79, 74);"><font size="4"><span style="font-weight: bold;">&nbsp;商品介绍：</span></font></span></div><div><span style="color: rgb(194, 79, 74);"><font size="4"><span style="font-weight: bold;"><br></span></font></span></div><ul><li title="贝丽丝（PRESTIGE）"><span style="font-weight: bold;">品牌</span>：<span style="color: rgb(123, 91, 161);">莱瑞（Lyrical Hair）</span></li><li title="1454651331"><span style="font-weight: bold;">商品名称</span>：<span style="color: rgb(123, 91, 161);">莱瑞（Lyrical Hair）</span>&nbsp;<span style="font-weight: bold;"></span>女士中长卷发梨花假发套</li><li title="1454651331"><span style="font-weight: bold;">商品编号</span>：1454651331</li><li title="贝丽丝假发官方旗舰店"><span style="font-weight: bold;">店铺</span>：<span style="color: rgb(123, 91, 161);">莱瑞美业官方旗舰店</span><span> </span></li><li title="210.00g"><span style="font-weight: bold;">商品毛重</span>：210.00g</li><li title="高温丝"><span style="font-weight: bold;">发丝材质</span>：高温丝<strong></strong><strong></strong></li><li title="通用"><span style="font-weight: bold;">适用性别</span>：通用</li><li title="短卷发"><span style="font-weight: bold;">假发发型</span>：短卷发</li><li title="中长发"><span style="font-weight: bold;">长度</span>：中长发</li><li title="棕色系"><span style="font-weight: bold;">颜色</span>：棕色系</li></ul><div><span style="color: rgb(194, 79, 74);"><font size="4"><span style="font-weight: bold;"><br></span></font></span></div><div><span style="color: rgb(194, 79, 74);"><font size="4"><span style="font-weight: bold;">商品详情：</span></font></span></div><div><table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td><span style="color: rgb(28, 72, 127);"><span style="font-weight: bold;">长度</span></span></td><td><span style="color: rgb(249, 150, 59);"><span>短发</span></span></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td><span style="color: rgb(28, 72, 127);"><span style="font-weight: bold;">假发发型</span></span></td><td><span style="color: rgb(249, 150, 59);">短卷发</span></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td><span style="color: rgb(28, 72, 127);"><span style="font-weight: bold;">发丝材质</span></span></td><td><span style="color: rgb(249, 150, 59);"><span>高温丝</span></span></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td><span style="color: rgb(28, 72, 127);"><span style="font-weight: bold;">颜色</span></span></td><td><span style="color: rgb(249, 150, 59);"><span>棕色系</span></span></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td><span style="color: rgb(28, 72, 127);"><span style="font-weight: bold;">适用性别</span></span></td><td><span style="color: rgb(249, 150, 59);"><span>女士</span></span></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table></div><br><p><img src="/demo/product-7.jpg" style="max-width:100%;"></p>',
    ];
});