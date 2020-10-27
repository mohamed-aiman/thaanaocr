<?php

namespace Aimme\ThaanaOCR\Vision;

use Illuminate\Support\Str;


class ResponseHandler
{
	protected $encodedBody;

    public function __construct($response = null,  $sourceImagePath = null)
    {
        $this->response = $response;
        $this->sourceImagePath = $sourceImagePath;
    }

	public function handle($responseString = null)
	{
        if (!$responseString) {
            $responseString = $this->response->getBody()->__toString();
        }

		$filePath = $this->writeStringToFile($responseString);
		$this->encodeBody($filePath);

        return $this;
	}

	protected function writeStringToFile($string)
	{
		$filePath = storage_path('app/uploaded/ocr/google_vision_responses/' . $this->getFileName(). '.txt');

		file_put_contents($filePath, $string);

		return $filePath;
	}

    protected function getFileName($imagePath = null)
    {
        return ($this->sourceImagePath) ? pathinfo($this->sourceImagePath)['filename'] : Str::random(20);
    }

    /**
     * use this to pass file containing the json response, for testing purpose
     * @param  $outputFile public_path('IMwglljmSo.txt')
     */
    public function encodeBody($outputFile)
    {
    	return $this->encodedBody = json_decode(file_get_contents($outputFile), true);
    }

    public function getEncodedResponseBody()
    {
    	return $this->encodedBody;
    }

    public function responses()
    {
    	return $this->getEncodedResponseBody()['responses'];
    }

    public function textAnnotations()
    {
    	return $this->responses()[0]['textAnnotations'];
    }

    public function fullTextAnnotation()
    {
    	return $this->responses()[0]['fullTextAnnotation'];
    }

    public function text()
    {
    	return $this->fullTextAnnotation()['text'];
    }
}