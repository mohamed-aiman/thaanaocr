## TO DO

Just a pre-release, but works fine. Need little refactoring to make it perfect. Feel free to contribute. I wrote it for a project 2 years ago, wanted to make it public as soon as it is for now.

### Features
- OCR Thaana images
- OCR PDFs

### Installation

```composer require aimme/thaanaocr```

add following to .env

```
VISION_API_ENABLED=true
VISION_API_URL=https://vision.googleapis.com/v1p2beta1/images:annotate
VISION_API_KEY=
```

create ```storage/app/uploaded/ocr``` folder to store complete response from Vision API  as text.


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


#### PDF Conversion Requirments

If you are working with just images, ignore this part.

to convert pdf to image format php package spatie/pdf-to-image is required - ref: https://github.com/spatie/pdf-to-image

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


