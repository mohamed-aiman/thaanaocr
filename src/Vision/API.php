<?php

namespace Aimme\ThaanaOCR\Vision;

use Aimme\ThaanaOCR\Vision\ResponseHandler;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;

class API
{
	protected $client;

	public function __construct(ClientInterface $client)
	{
		$this->client = $client;
	}

	public function recogniseText($base64EncodedImage, $sourceImagePath = null)
	{
		$response = $this->makeRequest($base64EncodedImage);
		return (new ResponseHandler($response, $sourceImagePath))->handle();
	}

	protected function makeRequest($base64EncodedImage)
	{
    	$data = $this->prepareRequestData($base64EncodedImage);
		return $this->client->post($this->url(), [ RequestOptions::JSON => $data ]);
	}

	protected function url()
	{
		return config('thaana-ocr.vision_api.url') . '?key=' . config('thaana-ocr.vision_api.key');
	}

	protected function prepareRequestData($base64EncodedImage)
	{
    	$body = json_decode($this->getDataTemplate(), true);
    	$body['requests'][0]['image']['content'] = $base64EncodedImage;
    	$body['requests'][0]['imageContext']['languageHints'] = config('thaana-ocr.vision_api.language_hints');

    	return $body;
	}

	protected function getDataTemplate()
    {
    	return 
			'{
			  "requests": [
			    {
			      "image": {
			          "content": ""
			          },
			      "features": [
			        {
			          "type": "DOCUMENT_TEXT_DETECTION"
			        }
			      ],
			      "imageContext": {
			        "languageHints": ["dv"]
			      }
			    }
			  ]
			}';
    }
}