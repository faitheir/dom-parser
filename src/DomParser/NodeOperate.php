<?php
namespace Faitheir\DomParser;

/**
 * the methods of node edit .
 */
trait NodeOperate
{
    #
    # class 
    #
    public function addClass($class)
    {
        $classArr = empty($this->domAttrs['class']) ? [] : $this->domAttrs['class'];
        if (!in_array($class, $classArr)) {
            $classArr[] = $class;
            $this->domAttrs['class'] = $classArr;
        }
        return $this;
    }
    public function removeClass($class)
    {
        if (empty($this->domAttrs['class']))
            return $this;

        $key = array_search($class, $this->domAttrs['class']);
        if ($key !== false) {
            unset($this->domAttrs['class'][$key]);
            if (empty($this->domAttrs['class']))
                unset($this->domAttrs['class']);
        }
        return $this;
    }
    public function resetClass()
    {
        if (empty($this->domAttrs['class']))
            return $this;

        unset($this->domAttrs['class']);
        return $this;
    }
    
    #
    # style
    #
    public function addStyle($styleKey, $styleValue)
    {
        if (empty($styleKey) || empty($styleValue))
            return $this;

        $this->domAttrs['style'][$styleKey] = $styleValue;
        return $this;
    }
    public function addMultStyle($styles = [])
    {
        if (empty($styles))
            return $this;

        $curStyle = empty($this->domAttrs['style']) ? [] : $this->domAttrs['style'];
        $this->domAttrs['style'] = array_merge($curStyle, $styles);
        return $this;
    }
    public function removeStyle($styleKey)
    {
        if (empty($this->domAttrs['style'][$styleKey]))
            return $this;

        unset($this->domAttrs['style'][$styleKey]);
        return $this;
    }
    public function resetStyle()
    {
        if (empty($this->domAttrs['style']))
            return $this;

        unset($this->domAttrs['style']);
        return $this;
    }
    
    #
    # normal attrs
    #
    public function addAttr($attrKey, $attrValue)
    {
        if (empty($attrKey) || empty($attrValue))
            return $this;

        $this->domAttrs[$attrKey] = $attrValue;
        return $this;
    }
    public function addMultAttr($attrs = [])
    {
        if (empty($attrs))
            return $this;

        $curAttrs = empty($this->domAttrs) ? [] : $this->domAttrs;
        $this->domAttrs = array_merge($curAttrs, $attrs);
        return $this;
    }
    public function removeAttr($attrKey)
    {
        if (empty($this->domAttrs[$attrKey]))
            return $this;

        unset($this->domAttrs[$attrKey]);
        return $this;
    }
    public function resetAttr()
    {
        $attrs = [];
        if (!empty($this->domAttrs['class']))
            $attrs['class'] = $this->domAttrs['class'];
        if (!empty($this->domAttrs['style']))
            $attrs['style'] = $this->domAttrs['style'];

        $this->domAttrs = $attrs;
        return $this;
    }

    #
    # other
    #
    public function resetAllAttr()
    {
        $this->domAttrs = [];
        return $this;
    }
    
}