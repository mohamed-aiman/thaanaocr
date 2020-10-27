<?php

namespace Aimme\ThaanaOCR;

use Aimme\ThaanaOCR\ApiResponseHandler;
use Aimme\ThaanaOCR\Vision\API as VisionAPI;

/**
 * $ocr->fromImage($path)->recognise();
 */
class ThaanaOCR
{
	protected $api;

	public function __construct(VisionAPI $api)
	{
		$this->api = $api;
	}

	public function fromImage($path)
	{
		$this->imagePath = $path;
		$this->encoded = $this->encodeToBase64($path);
		
		return $this;
	}

	public function recognise()
	{
		$this->response = $this->api->recogniseText($this->encoded, $this->imagePath);

		return $this;
	}

    protected function encodeToBase64($path)
    {
		return base64_encode(file_get_contents($path));
    }

	public function responseHandler()
	{
		return $this->response;
	}

    public function __call($method, $parameters)
    {
        if (strncmp($method, "get", 3) === 0) {
            $method = \Illuminate\Support\Str::camel(substr($method, 3));
            return call_user_func_array([$this->responseHandler(), $method], $parameters);
        }
    }
}