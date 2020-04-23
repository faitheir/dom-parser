<?php
/**
 * test
 */
require_once '../vendor/autoload.php';

$parser = new \Faitheir\DomParser\DomParser();

$html = <<< 'HTML'
    <template>
        <view class="container">
            <navigator url="/pages/show?id=1">
                <image src="../../static/images/home-by.jpg" mode="widthFix"></image>
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
$dom = $parser->setConfig([])->parse($html);

print_r($dom);