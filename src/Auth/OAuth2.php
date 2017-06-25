<?php

namespace Ryadnov\ZenMoney\Api\Auth;

use GuzzleHttp\Client;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class OAuth2
 *
 * @package Ryadnov\ZenMoney\Api\Auth
 */
class OAuth2
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
     * OAuth2 constructor.
     *
     * @param array $options
     */
    function __construct(array $options = [])
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
        $resolver->setDefaults([
            'url_authorize'   => 'https://api.zenmoney.ru/oauth2/authorize/',
            'url_token'       => 'https://api.zenmoney.ru/oauth2/token/',
            'url_redirect'    => 'http://example.com',
        ]);

        $resolver->setRequired([
            'consumer_key',
            'consumer_secret',
            'username',
            'password',
        ]);
    }

    /**
     * @return Client
     */
    protected function createClient()
    {
        return new Client([
            'cookies' => true,
            'headers' => [
                'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language' => 'ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4',
                'Connection'      => 'keep-alive',
                'User-Agent'      => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36',
            ],
        ]);
    }

    /**
     * @return array
     */
    public function getToken()
    {
        $this->visitAuthorizeUri();

        return $this->getTokenInternal($this->getAuthorizeCode());
    }

    /**
     * @return string
     */
    protected function generateAuthorizeUri()
    {
        return $this->options['url_authorize'] . '?' . http_build_query([
                'response_type' => 'code',
                'client_id'     => $this->options['consumer_key'],
                'redirect_uri'  => $this->options['url_redirect'],
            ]);
    }

    /**
     *
     */
    protected function visitAuthorizeUri()
    {
        $this->client->request('GET', $this->generateAuthorizeUri());
    }

    /**
     * @return string
     */
    protected function getAuthorizeCode()
    {
        $response = $this->client->request('POST', $this->generateAuthorizeUri(), [
            'form_params'     => [
                'username'           => $this->options['username'],
                'password'           => $this->options['password'],
                'auth_type_password' => 'Sign in',
            ],
            'allow_redirects' => false,
        ]);
        $code_url = $response->getHeaderLine('Location');
        parse_str(parse_url($code_url, PHP_URL_QUERY), $code_query);

        return $code_query['code'];
    }

    /**
     * @param string $code
     *
     * @return array
     */
    protected function getTokenInternal($code)
    {
        $response = $this->client->request('POST', $this->options['url_token'], [
            'form_params' => [
                'grant_type'    => 'authorization_code',
                'client_id'     => $this->options['consumer_key'],
                'client_secret' => $this->options['consumer_secret'],
                'code'          => $code,
                'redirect_uri'  => $this->options['url_redirect'],
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
