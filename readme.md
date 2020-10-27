# OCR Thaana images

A Laravel package that can be used for OCR of Thaana (Maldives/Dhivehi Language) images using Google Cloud Vision API. The package includes usage examples, on how to use this package for OCR of images and multi page PDFs.


This is just a pre-release, but it works fine. Need little refactoring to make it perfect. Feel free to contribute. I wrote this for a project 2 years ago, wanted to make it public as soon as it is for now. 


### Installation

```composer require aimme/thaanaocr```

##### Add following to .env

```
VISION_API_ENABLED=true
VISION_API_URL=https://vision.googleapis.com/v1p2beta1/images:annotate
VISION_API_KEY=
```

##### Create  following folders and give read/write permission
- storage/app/uploaded/ocr/google_vision_responses
- storage/app/uploaded/ocr/images
- storage/app/uploaded/ocr/pdfs
- storage/app/uploaded/ocr/pdfs/converted_images

Need to clean these folders once in a while. This was created for a specific project, so it is bit customized. Will be improving it.


### Usage

Here is an example inside routes/web.php

```php
Route::get('/', function () {

    $sampleImagePath = storage_path('app/sample_dhivehi_text.png');

    //recognise text from image
    $string = app(Aimme\ThaanaOCR\ThaanaOCR::class)
        ->fromImage($sampleImagePath)
        ->recognise()
        ->getText();

    return response()->json([
        'text' => $string
    ]);
});
```

For more examples and ways to convert PDF to images for OCR check
```php
Aimme\ThaanaOCR\Http\Controllers\ThaanaOCRController
```


#### PDF Conversion Requirments

If you are working with just images, ignore this part.

to convert pdf to image format php package ```spatie/pdf-to-image``` is required - ref: https://github.com/spatie/pdf-to-image

for that package you need to install php7.2-imagick - ref: https://www.php.net/manual/en/imagick.setup.php

```sudo apt-get install php7.2-imagick```

then check policy - ref: https://stackoverflow.com/a/52661288/1409707


additional info regarding installing imagick  - ref: https://www.php.net/manual/en/imagick.setup.php
- need to install somethings like pear, php-dev - ref:https://stackoverflow.com/a/18023106/1409707

Answer from William Size:
After 2 hours of looking for help from different documentation & sites, I found out none of them are complete solution.  So, I summary my instruction here:

1) yum install php-devel
2) cd /usr
3) wget http://pear.php.net/go-pear
4) php go-pear
5) See the following line in /etc/php.ini [include_path=".:/usr/PEAR"]
6) pecl install imagick
7) Add the following line in /etc/php.ini [extension=imagick.so]
8) service httpd restart


Not working but good to look into
- https://serverpilot.io/docs/how-to-install-the-php-imagemagick-extension


