<?php

namespace PSolr\Handler;

use Guzzle\Http\Message\Response;
use Psolr\SolrClient;

abstract class RequestHandlerAbstract
{
    /**
     * @var \PSolr\SolrClient
     */
    protected $solr;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $method = 'get';

    /**
     * @var array
     */
    protected $defaultParams = array();

    /**
     * Sets the default parameters for this request handler.
     *
     * @param array $params
     *
     * @return \PSolr\SolrClient
     */
    public function setDefaultParams(array $params)
    {
        $this->defaultParams = $params;
        return $this;
    }

    /**
     * Returns the request handler's default parameters.
     *
     * @return array
     */
    public function getDefaultParams()
    {
        return $this->getConfig('default_params');
    }

    /**
     * Sets the default parameters for this request handler.
     *
     * @param string $param
     * @param mixed $value
     *
     * @return \PSolr\SolrClient
     */
    public function setDefaultParam($param, $value)
    {
        $this->defaultParams[$param] = $value;
        return $this;
    }

    /**
     * Sets the default parameters for this request handler.
     *
     * @param string $param
     *
     * @return \PSolr\SolrClient
     */
    public function removeDefaultParam($param)
    {
        unset($this->defaultParams[$param]);
        return $this;
    }

    /**
     * Returns a camel-cased value split by non-alphanumeric strings.
     *
     * @return string
     */
    public function buildNameFromPath()
    {
        $pieces = preg_split('/[^a-zA-Z0-9]/', $this->getPath());
        $normalized = array_map(function ($piece) { return ucfirst($piece); }, $pieces);
        return lcfirst(join('', $normalized));
    }

    /**
     * Merges default params.
     *
     * Order of precedence is below:
     *   - Params passed at runtime
     *   - Request handler's default parameters
     *   - Client's default parameters
     *
     * @param array $params
     *
     * @return array
     */
    public function mergeDefaultParams(array $params)
    {
        $clientDefault = $this->solr->getConfig('default_params');
        return array_merge($clientDefault, $this->defaultParams, $params);
    }

    /**
     * @param \PSolr\SolrClient
     */
    public function setSolrClient(SolrClient $solr)
    {
        $this->solr = $solr;
    }

    /**
     * @return \PSolr\SolrClient
     */
    public function getSolrClient()
    {
        return $this->solr;
    }

    /**
     * Returns the name of the method that can be invoked from the client.
     *
     * @return string
     */
    public function getName()
    {
        if (!isset($this->name)) {
            $this->name = $this->buildNameFromPath();
        }
        return $this->name;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Returns the path tp the request handler.
     *
     * @return string
     */
    abstract public function getPath();

    /**
     * @param mixed $params
     * @param array|\ArrayObject $headers
     * @param array $options
     *
     * @return array
     */
    public function sendRequest($params = array(), $headers = null, array $options = array())
    {
        $params = $this->mergeDefaultParams((array) $params);
        $response = $this->buildRequest($params, $options, $options)->send();
        return $this->parseResponse($response, $params);
    }

    /**
     * Builds the request.
     *
     * @param array $params
     * @param null|array $headers
     * @param array $options
     *
     * @return \Guzzle\Http\Message\RequestInterface
     */
    public function buildRequest($params, $headers, $options)
    {
        $method = $this->getMethod();
        $uri = $this->getPath();

        // Check if the GET is too long and do a POST instead.
        if ('get' == $method && $this->solr->usePostMethod($uri, $params)) {
            $method = 'post';
        }

        switch ($method) {
            case 'get':
            case 'head':
                $options['query'] = $params;
                return $this->solr->$method($uri, $headers, $options);

            case 'options':
                return $this->solr->$method($uri, $options);

            default:
                $body = $params ? $params : null;
                return $this->solr->$method($uri, $headers, $params, $options);
        }
    }

    /**
     * @param \Guzzle\Http\Message\Response $response
     * @param array $params
     *
     * @return array
     */
    public function parseResponse(Response $response, array $params)
    {
        $method = (isset($params['wt']) && 'json' == $params['wt']) ? 'json' : 'xml';
        return $response->$method();
    }
}