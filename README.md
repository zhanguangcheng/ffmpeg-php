# ffmpeg-php
 在PHP中调用ffmpeg的简单实现

## 使用示例
```php
include 'FFmpeg.php';

$ffmpeg = new FFmpeg([
    'ffmpeg' => '/usr/local/ffmpeg/bin/ffmpeg',
]);

$video = 'input.mp4';
$success = $ffmpeg->input($video)
    ->output("-vn -ar 16000 -ac 1 -b:a 8k -f mp3 output.mp4")
    ->output("-f image2 -an -vframes 1 -q:v 2 output.jpg")
    ->save($output);

var_dump($success);
var_dump($output);
```

## 执行测试

```bash
composer install
phpunit
```