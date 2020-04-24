<?php
/**
 * Created by PhpStorm.
 * User: WangFei
 * Date: 4/24/2020
 * Time: 5:34 PM
 */

require_once '../vendor/autoload.php';

$parser = new \Faitheir\DomParser\DomParser();

$html = <<< 'HTML'
    <template>
        <!-- doc hello 
         world 
         -->
        <view  class="container"  id="main-view" data-genid="12323">
            <navigator url="/pages/show?id=1">
                <image src="../../static/images/home-by.jpg" class="hello world" mode="widthFix"></image>
            </navigator>
            <view class="layout">
                <view class="scan">
                    <text class="iconfont icon-saoyisao" @click="scan()"></text>
                </view>
                <search-box class="search" :lable="search_lable" :value="serch" />
                <view class="view-box">
                    Hello World !
                </view>
            </view>
        </view>
    </template>
HTML;


echo '<pre>';
$dom = $parser->parse($html);

print_r($dom);