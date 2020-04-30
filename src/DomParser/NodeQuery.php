<?php
namespace Faitheir\DomParser;

/**
 * the methods of node query .
 */
trait NodeQuery
{
    #
    # query
    #
    public function genIdQuery($genid = '')
    {
        return $this->_baseQueryOne('genIdQuery', 'nodeId', $genid);
    }
    public function idQuery($domid = '')
    {
        return $this->_baseQueryOne('idQuery', 'domId', $domid);
    }
    public function nameQuery($domname = '')
    {
        return $this->_baseQueryOne('nameQuery', 'domName', $domname);
    }

    #
    # tag filter
    #
    public function tagsQuery($tagName, $filter = null)
    {
        $result = [];
        $this->_tagsQuery($tagName, $filter, $result);
        return $result;
    }

    #
    # parent childs siblings
    #
    public function parentQuery()
    {
        return $this->parent;
    }
    public function childsQuery()
    {
        return $this->childs;
    }
    public function siblingsQuery()
    {
        if (empty($this->parent))
            return null;

        return $this->parent->childs;
    }

    /**
     * base qeury one method
     * @param $queryMethod
     * @param $variable
     * @param $queryString
     * @return $this|null
     */
    private function _baseQueryOne($queryMethod, $variable, $queryString)
    {
        if (empty($queryString))
            return null;
        if ($this->$variable == $queryString)
            return $this;
        if (empty($this->childs))
            return null;

        foreach ($this->childs as $child) {
            $node = $child->$queryMethod($queryString);
            if ($node)
                return $node;
        }
        return null;
    }

    public function _tagsQuery($tagName, $filter = null, & $result = null)
    {
        if (empty($tagName))
            return ;
        if ($this->nodeName == $tagName) {
            # filter
            if (empty($filter))
                $result[] = $this;
            elseif ($this->_queryFilter($filter)) {
                $result[] = $this;
            }
        }
        if (empty($this->childs))
            return ;

        foreach ($this->childs as $child) {
            $child->_tagsQuery($tagName, $filter, $result);
        }
        return ;
    }

    private function _queryFilter($filter)
    {
        if (empty($filter))
            return false;
        # class
        if (isset($filter['class']) && !empty($this->domAttrs['class']) && in_array($filter['class'], $this->domAttrs['class']))
            return true;

        # other

        return false;
    }
}