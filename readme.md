to convert pdf to image format php package spatie/pdf-to-image is required - ref: https://github.com/spatie/pdf-to-image

for that package you need to install php7.2-imagick - ref: https://www.php.net/manual/en/imagick.setup.php

sudo apt-get install php7.2-imagick 

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

Hopefully, I can save other engineer effort & time.... Good luck!


Not working but good to look into
- https://serverpilot.io/docs/how-to-install-the-php-imagemagick-extension


