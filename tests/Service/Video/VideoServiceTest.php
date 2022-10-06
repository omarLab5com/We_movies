<?php

namespace App\Tests\Service\Video;

use App\Service\Video\VideoService;
use App\Service\Video\Youtube;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VideoServiceTest extends KernelTestCase
{
    /**
     * @dataProvider videoProvider
     */
    public function testReturnCorrectUrl(array $videoData, string $expectedUrl)
    {
        $videoService = new VideoService(new Youtube());
        $this->assertSame($expectedUrl, $videoService->getURLVideo($videoData));
    }

    public function videoProvider(): array
    {
        return [
            [['key' => 'my_key', 'site' => 'YouTube'], 'https://www.youtube.com/embed/my_key'],
            [['key' => 'my_key', 'site' => 'other'], ''],
            [['key' => 'my_key', 'site' => ''], ''],
        ];
    }
}
