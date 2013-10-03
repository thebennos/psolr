<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/CommonQueryParameters
 */
class Select extends SolrRequest
{
    /**
     * @param string $q
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#q
     */
    public function setQuery($query)
    {
        $this['q'] = $query;
        return $this;
    }

    /**
     * @param string $sort
     *
     * @return \PSolr\Request\Select
     *
     * @todo Component\Sort.php
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#sort
     */
    public function setSort($sort)
    {
        $this['sort'] = $sort;
        return $this;
    }

    /**
     * @param int $rows
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#start
     */
    public function setStart($start)
    {
        $this['start'] = $start;
        return $this;
    }

    /**
     * @param int $rows
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#rows
     */
    public function setRows($rows)
    {
        $this['rows'] = $rows;
        return $this;
    }

    /**
     * @param int $pageDoc
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#pageDoc_and_pageScore
     */
    public function setPageDoc($pageDoc)
    {
        $this['pageDoc'] = $pageDoc;
        return $this;
    }

    /**
     * @param float $pageScore
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#pageDoc_and_pageScore
     */
    public function setPageScore($pageScore)
    {
        $this['pageScore'] = $pageScore;
        return $this;
    }

    /**
     * @param string $fq
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#fq
     */
    public function setFilterQuery($filterQuery)
    {
        $this['fq'] = $filterQuery;
        return $this;
    }

    /**
     * @param string $fl
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#fl
     *
     * @todo Component\Sort.php
     */
    public function setFieldList($fl)
    {
        $this['fl'] = $fl;
        return $this;
    }

    /**
     * @param string $defType
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#defType
     */
    public function setDefType($defType)
    {
        $this['defType'] = $defType;
        return $this;
    }

    /**
     * @param int $timeAllowed
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#timeAllowed
     */
    public function setTimeAllowed($timeAllowed)
    {
        $this['timeAllowed'] = $timeAllowed;
        return $this;
    }

    /**
     * @param boolean $omitHeader
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#omitHeader
     */
    public function omitHeader($omitHeader)
    {
        $this['omitHeader'] = $omitHeader ? 'true' : 'false';
        return $this;
    }
}