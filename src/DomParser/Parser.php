<?php

namespace Faitheir\DomParser;


class Parser
{
    # config obj
    private $_config;

    # set config obj
    public function config($config = null)
    {
        $this->_config = $config;

        #
        $this->_startTagReg = $this->_config->get('start_tag_reg');
        $this->_endTagReg   = $this->_config->get('end_tag_reg');
        $this->_contentReg  = $this->_config->get('content_reg');
        $this->_attrsReg    = $this->_config->get('attrs_reg');
        $this->_startEndTagReg      = $this->_config->get('start_end_tag_reg');
        return $this;
    }


    /**
     * main method
     * @param string $domString
     * @return $this
     */
    public function parse($domString = '')
    {
        $root = Node::generRootNode();

        $domString = trim($domString);
        if (empty($domString))
            return $root;

        $this->_parseChildNodes($domString, $root);
        return $root;
    }

    /**
     * Parse DOM String recursively
     * @param string    $domString  DOM String
     * @param Node      $parent     the Parent DOM object
     * @return string               The rest string after parsing
     */
    private function _parseChildNodes($domString = '', $parent = null)
    {
        #
        do {
            $stringLen = strlen($domString);
            # match start tad
            list($domString, $node) = $this->_parseStartTag($domString, $parent);
//            $domString = $this->_parseStartTag($domString, $parent);

            # match content
            $domString = $this->_parseContent($domString, $parent);

            # match end tag
//            $domString = $this->_parseEndTag($domString, $parent);
            $domString = $this->_parseEndTag($domString, $node);

            if ($stringLen == strlen($domString))
                return $domString;

        } while(true);

        return $domString;
    }

    /**
     * pase the start tag and attrs
     * @param $domString
     * @param $parent
     * @return array
     */
    private function _parseStartTag($domString, $parent)
    {
        $startTagMatch = [];
        preg_match($this->_startTagReg, $domString, $startTagMatch);
        $startTagName = $startTagMatch[1] ?? '';
        if (empty($startTagName))
            return [$domString, null];

        $startTagPos    = strpos($domString, $startTagName);
        $domString      = substr($domString, $startTagPos + strlen($startTagName));

        # new Node
        $node = new Node($startTagName);
        $node->level        = $parent->level + 1;
        $parent->childs[]   = $node;

        # parse Attrs
        $domString = $this->_parseAttrs($domString, $node);

        # node id
        if (empty($node->nodeId))
            $node->setNodeId();

        return [$domString, $node];
    }

    /**
     * @param $domString
     * @param $node
     * @return bool|string
     */
    private function _parseStartEndTag(& $domString, $node)
    {
        # 判断是否到了开始标签最后 或者单标签
        $startEndTag = [];
        if (preg_match($this->_startEndTagReg, $domString, $startEndTag)) {
            $startEndPos    = strpos($domString, $startEndTag[0]);
            $domString      = substr($domString, $startEndPos + strlen($startEndTag[0]));
            # 开标签最后
            if (!empty($startEndTag[1]))
                return 'start_end';
            if (!empty($startEndTag[2])) {
                # 单标签
                $node->setNodeId()->setIsSingle();
                return 'single_end';
            }
        }
        return false;
    }

    /**
     * @param $domString
     * @param $parent
     * @return bool|string
     */
    private function _parseEndTag($domString, $parent)
    {
        if(empty($parent->nodeName))
            return $domString;

        $endTagMatch = [];
        if (preg_match('/^\s*(<\/' . $parent->nodeName . '>)/is', $domString, $endTagMatch)) {
            $endTagPos    = strpos($domString, $endTagMatch[0]);
            $domString    = substr($domString, $endTagPos + strlen($endTagMatch[0]));
        }

        return $domString;
    }

    /**
     * @param $domString
     * @param $node
     * @return bool|string
     */
    private function _parseAttrs($domString, $node)
    {
        $stringLen = strlen($domString);
        #
        while (true) {

            # 判断是否到了开始标签最后 或者单标签
            $checked = $this->_parseStartEndTag($domString, $node);
            if ($checked === 'start_end') {
                # parse childs
                $domString = $this->_parseChildNodes($domString, $node);
                return $domString;
            } elseif ($checked === 'single_end') {
                return $domString;
            }

            # Attrs
            $attrMatch  = [];
            if (preg_match($this->_attrsReg, $domString, $attrMatch)) {
                $node->setAttrMatch($attrMatch);
                $attrPos = strpos($domString, $attrMatch[0]);
                $domString = substr($domString, $attrPos + strlen($attrMatch[0]));

            }

            if ($stringLen == strlen($domString))
                return $domString;
        }
    }

    /**
     * @param $domString
     * @param $parent
     * @return bool|string
     */
    private function _parseContent($domString, $parent)
    {
        # match content
        $contentMatch = [];
        $match = preg_match($this->_contentReg, $domString, $contentMatch);
        if (!$match)
            return $domString;

        $content    = trim($contentMatch[0] ?? '');
        if (empty($content)) {
            $domString  = substr($domString, strpos($domString, $contentMatch[0]) + strlen($contentMatch[0]));
            return $domString;
        }

        # gener content node
        $contentDom = Node::generContentNode($content);
        $contentDom->level  = $parent->level + 1;
        $parent->childs[]   = $contentDom;

        $contentPos = strpos($domString, $contentMatch[0]);
        $domString  = substr($domString, $contentPos + strlen($contentMatch[0]));
        return $domString;
    }

}