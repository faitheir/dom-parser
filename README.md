# dom-parser

A PHP library , use to parse normal and special DOM string like vue react. to DOM Tree. 
By modifying config variables, can parse other HTML-like markup languages string too.

## Installation
    composer require faitheir/dom-parser

## Base Usage
#### Parse Method
parse Dom string to DOM Tree (\Faitheir\DomParser\Node $dom).
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

#### Inverse Parse Method
parse Dom Tree(\Faitheir\DomParser\Node $dom) to DOM string.
```php
$string = $parser->setConfig([])->invParse($dom);
or
Config::getInstance()->setConfig([
    'tag_indent' => '  '
]);
$string = (string) $dom;
```

## Config Method
```php
# demo
# match string '{{php id="world"}}'

$configs = [
    'start_tag_reg'  => '/^\s*{{([^}\s\/!]+)/is'
];
# other confs see DomPaser/Config.php

$parser   = $parser->setConfig($configs);
$dom      = $parser->parse($html);
```


## Query Method
```php
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
```

## Dom Operate
```php

$dom = $parser->setConfig([
])->parse($html);

echo '<pre>';

$node = $dom->idQuery('main-view')->addClass('hello-world');
$node = $dom->idQuery('main-view')->removeClass('hello-world');
$node = $dom->idQuery('main-view')->resetClass();

$node = $dom->nameQuery('nav')->addStyle('border', '10px solid red');
$node = $dom->nameQuery('nav')->addMultStyle(['border' => '10px solid red', 'color' => 'blue']);
$node = $dom->nameQuery('nav')->removeStyle('border');
$node = $dom->nameQuery('nav')->resetStyle();

$node = $dom->nameQuery('nav')->addAttr(':click', "alter('hello world')");
$node = $dom->nameQuery('nav')->addMultAttr([':click' => "alter('hello world')", 'v-model' => 'testvari']);
$node = $dom->nameQuery('nav')->removeAttr(':click');
$node = $dom->nameQuery('nav')->resetAttr();

$node = $dom->nameQuery('nav')->resetAllAttr();
```