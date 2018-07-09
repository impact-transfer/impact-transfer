<?php

namespace App\Service\Api;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;
use GuzzleHttp\Client;

class HivebriteConnector
{
	/** @var string */
	private $name = 'hivebrite';

	/** @var string */
	private $accessToken = null;

	/** @var Client */
	private $client;

	public function __construct()
    {
		$this->client = new Client();
	}

	/**
	 * @param object $community
	 * @return bool
	 */
    public function authenticate($community)
    {
		$response = $this->client->request('POST', $community['url'].'/oauth/token', [
		    'form_params' => [
		        'grant_type' => 'client_credentials',
				'client_id' => $community['uid'],
				'client_secret' => $community['secret'],
		        'scope' => 'admin',
		    ]
		]);

		if ($response->getStatusCode() !== 200) {
			return false;
		}

		$body = json_decode($response->getBody());
		$this->accessToken = $body->access_token;

        return true;
    }

	/**
	 * @param object $community
	 * @param string $endpoint
	 * @return object|bool
	 */
	public function get($community, $endpoint)
	{
		$response = $this->client->request('GET', $community['url'].'/api/admin/v1/'.$endpoint.'?access_token='.$this->accessToken);

		if ($response->getStatusCode() !== 200) {
			return false;
		}

		$body = json_decode($response->getBody());
		return $body;
	}

	public function getConfiguration() {
		$fileLocator = new FileLocator(__DIR__ . '/../../../config/api');
		$configFile = $fileLocator->locate($this->name . '.yaml');
		$config = Yaml::parse(file_get_contents($configFile));

		if ($config === null) {
			$config = array();
		}

		if (!is_array($config)) {
			throw new \InvalidArgumentException(sprintf('The file "%s" must contain a YAML array.', $configFile));
		}

		return $config;
	}

}
