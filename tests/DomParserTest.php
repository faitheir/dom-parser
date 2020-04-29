<?php
/**
 * test
 */
require_once '../vendor/autoload.php';

$parser = new \Faitheir\DomParser\DomParser();

$html = <<< 'HTML'
    <template>
        <!-- doc hello 
         world 
         -->
        <view  class="container"  id="main-view" data-genid="12323">
            <navigator name="nav" style="margin-left: 1px; margin-right: 10px; color: red; float: left" url="/pages/show?id=1">
                <image name="image" src="../../static/images/home-by.jpg" class="hello world" mode="widthFix"></image>
            </navigator>
            <view class="layout">
                <view class="scan">
                    <text style="float: left; border: 1px solid #000" class="iconfont icon-saoyisao" @click="scan()"></text>
                </view>
                <search-box class="search" :lable="search_lable" :value="serch" />
                <view class="view-box">
                    Hello World !
                </view>
            </view>
        </view>
    </template>
HTML;

$dom = $parser->setConfig([
])->parse($html);

echo '<pre>';
print_r($dom);

$string = (string) $dom;
file_put_contents('test.vue', $string);