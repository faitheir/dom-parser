<?php

require_once '../vendor/autoload.php';

$parser = new \Faitheir\DomParser\DomParser();

$html = <<< 'HTML'
    <template  data-genid="genid-1588151809"  >
        <!-- doc hello 
         world 
         -->
        <view  id="main-view"  data-genid="12323"  class="container"  >
            <navigator  name="nav"  data-genid="genid-1588151802"  style="margin-left: 1px; margin-right: 10px; color: red; float: left; " url="/pages/show?id=1"  >
                <image  name="image"  data-genid="genid-1588151801"  class="hello world"  src="../../static/images/home-by.jpg"  mode="widthFix"  >
                </image>
            </navigator>
            <view  data-genid="genid-1588151808"  class="layout"  >
                <view name="scan" data-genid="genid-1588151804"  class="scan"  >
                    <text name="hello" data-genid="genid-1588151803"  class="iconfont icon-saoyisao"  style="float: left; border: 1px solid #000; " @click="scan()"  >
                    </text>
                </view>
                <search-box  data-genid="genid-1588151805"  class="search"  :lable="search_lable"  :value="serch"  />
                <view  data-genid="genid-1588151807"  class="view-box"  >
                    Hello World !
                </view>
            </view>
        </view>
    </template>
HTML;

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



print_r($node);