<?php

namespace Ryadnov\ZenMoney\Api\V8;

use GuzzleHttp\Client;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Request
 *
 * @package Ryadnov\ZenMoney\Api\V8
 */
abstract class Request
{
    /**
     * @var array
     */
    protected $options;
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var array
     */
    protected $request_params;

    /**
     * Request constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);

        $this->client = $this->createClient();
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'token',
            'url',
        ]);
    }

    /**
     * @return Client
     */
    protected function createClient()
    {
        return new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $this->options['token'],
            ],
        ]);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function execute(array $params = [])
    {
        $resolver = new OptionsResolver();
        $this->configureRequestParams($resolver);

        return $this->executeRequest($resolver->resolve($params));
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureRequestParams(OptionsResolver $resolver)
    {
    }

    /**
     * @param array $params
     *
     * @return array
     */
    protected function executeRequest(array $params = [])
    {
        $response = $this->client->request('POST', $this->options['url'], [
            'json' => $params,
        ]);

        return json_decode($response->getBody(), true);
    }
}
