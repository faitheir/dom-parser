<?php


require_once '../vendor/autoload.php';

$parser = new \Faitheir\DomParser\DomParser();

$html = <<< 'HTML'
    <template>
        <!-- doc hello 
         world 
         -->
        <view  class="container"  id="main-view" data-genid="12323">
            <navigator data-genid="genid-1588151808" url="/pages/show?id=1">
                <image src="../../static/images/home-by.jpg" class="hello world" mode="widthFix"></image>
            </navigator>
            <view class="layout">
                <view class="scan">
                    <text name="scan" class="iconfont icon-saoyisao" @click="scan()"></text>
                </view>
                <search-box class="search" :lable="search_lable" :value="serch" />
                <view class="view-box">
                    Hello World !
                </view>
            </view>
        </view>
    </template>
HTML;

# parse dom
$dom    = $parser->parse($html);


# genIdQuery
$node   = $dom->genIdQuery('genid-1588151808');
# idQuery
$node   = $dom->idQuery('main-view');
# nameQuery
$node   = $dom->nameQuery('scan');

# tagsQuery
$node   = $dom->tagsQuery('view');
$node   = $dom->tagsQuery('view', ['class' => 'scan']);

# parentQuery
$node   = $dom->genIdQuery('genid-1588151808')->parentQuery();
# childsQuery
$node   = $dom->genIdQuery('genid-1588151808')->childsQuery();
# siblingsQuery
$node   = $dom->genIdQuery('genid-1588151808')->siblingsQuery();


