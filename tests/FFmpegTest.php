<?php

class FFmpegTest extends PHPUnit\Framework\TestCase
{
    public function testConfure()
    {
        $ffmpeg = '/usr/bin/ffmpeg';
        $command = '{ffmpeg} -hide_banner -y -i {input} {output}';
        $ff = new FFmpeg([
            'ffmpeg' => $ffmpeg,
            'command' => $command,
        ]);
        $this->assertEquals($ffmpeg, $ff->ffmpeg);
        $this->assertEquals($command, $ff->command);
    }

    public function testInputEmpty()
    {
        $ff = new FFmpeg();
        $this->expectException(InvalidArgumentException::class);
        $ff->input('');
    }

    public function testInputNonFile()
    {
        $ff = new FFmpeg();
        $this->expectException(InvalidArgumentException::class);
        $ff->input('/non-file');
    }

    public function testInput()
    {
        $ff = new FFmpeg();
        $file = __DIR__ . '/input.mp4';
        $ff->input($file);
        $this->assertEquals($file, $ff->input);
    }

    public function testOutput()
    {
        $ff = new FFmpeg();
        $output = '-f mp3 output/output.mp3';
        $ff->output($output);
        $this->assertEquals($output, $ff->output[0]);

        $output = '-f image2 -an -vframes 1 -q:v 2 output/output.jpg';
        $ff->output($output);
        $this->assertEquals($output, $ff->output[1]);
    }

    public function testSave()
    {
        $ff = new FFmpeg([
            'ffmpeg' => 'ffmpeg',
        ]);

        $this->assertFalse($ff->save());

        $dir = __DIR__;
        $output = "-f mp3 $dir/output/output.mp3";
        $ff->input("$dir/input.mp4")->output($output)->save();
        $this->assertFileExists("$dir/output/output.mp3");
    }
}
