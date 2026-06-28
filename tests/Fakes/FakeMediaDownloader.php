<?php

namespace Tests\Fakes;

use Spatie\MediaLibrary\Downloaders\Downloader;
use Spatie\MediaLibrary\MediaCollections\Exceptions\UnreachableUrl;

class FakeMediaDownloader implements Downloader
{
    public function getTempFile(string $url): string
    {
        if (str_contains($url, 'missing')) {
            throw UnreachableUrl::create($url);
        }

        $temporaryFile = tempnam(sys_get_temp_dir(), 'media-library-test');

        $image = imagecreatetruecolor(1200, 630);
        if ($image === false) {
            throw UnreachableUrl::create($url);
        }

        $background = imagecolorallocate($image, 42, 84, 112);
        if ($background === false) {
            throw UnreachableUrl::create($url);
        }

        imagefill($image, 0, 0, $background);
        imagejpeg($image, $temporaryFile);
        imagedestroy($image);

        return $temporaryFile;
    }
}
