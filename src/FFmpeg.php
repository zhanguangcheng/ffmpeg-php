<?php

/**
 * 在PHP中调用ffmpeg的简单实现
 * @author ZhanGUangcheng <14712905@qq.com>
 * @link https://github.com/zhanguangcheng/ffmpeg-php
 */
class FFmpeg
{
    public $ffmpeg = '/usr/local/ffmpeg/bin/ffmpeg';
    public $command = '{ffmpeg} -hide_banner -y -i {input} {output} {redirect}';
    public $input;
    public $output = [];

    public function __construct(array $config = [])
    {
        if (!empty($config)) {
            foreach ($config as $name => $value) {
                $this->$name = $value;
            }
        }
    }

    public function input($input)
    {
        $this->inputCheck($input);
        $this->input = $input;
        return $this;
    }

    public function output($output)
    {
        $this->output[] = $output;
        return $this;
    }

    public function save(&$output = null, $redirect = '2>&1')
    {
        if (empty($this->output)) {
            return false;
        }
        $this->inputCheck($this->input);
        $command = strtr($this->command, [
            '{ffmpeg}' => $this->ffmpeg,
            '{input}' => escapeshellcmd($this->input),
            '{output}' => escapeshellcmd(implode(' ', $this->output)),
            '{redirect}' => $redirect,
        ]);

        return $this->exec($command, $output);
    }

    private function exec($command, &$output)
    {
        exec($command, $output, $code);
        return $code === 0;
    }

    private function inputCheck($input)
    {
        if (empty($input)) {
            throw new \InvalidArgumentException("文件不能为空");
        }
        if (!is_file($input)) {
            throw new \InvalidArgumentException("文件不存在：$input");
        }
    }
}
