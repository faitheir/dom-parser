# dom-parser

A PHP library , use to parse normal and special DOM string like vue react .  to DOM Tree .

## Installation
    composer require faitheir/dom-parser

## Base Usage

```php
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

//
$parser     = new \Faitheir\DomParser\DomParser($html);
//$parser   = $parser->setConfig([]);
$dom        = $parser->parse();

// or
$parser     = new \Faitheir\DomParser\DomParser();
$dom        = $parser->setConfig([])->parse($html);

print_r($dom);
```