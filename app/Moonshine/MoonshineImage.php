<?php

namespace App\Moonshine;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MoonshineImage
{
    protected $name;
    protected $field;
    protected $disk;
    protected $dir;
    protected $allowedExtensions = [];
    protected $afterSaveCallback;

    public function __construct($name, $field)
    {
        $this->name = $name;
        $this->field = $field;
    }

    public static function make($name, $field)
    {
        return new static($name, $field);
    }

    public function disk($disk)
    {
        $this->disk = $disk;
        return $this;
    }

    public function dir($dir)
    {
        $this->dir = $dir;
        return $this;
    }

    public function allowedExtensions($extensions)
    {
        $this->allowedExtensions = $extensions;
        return $this;
    }

    public function afterSave($callback)
    {
        $this->afterSaveCallback = $callback;
        return $this;
    }

    public function storeAs($path, $filename)
    {
        Storage::disk($this->disk)->put($path . '/' . $filename, file_get_contents($this->field));
    }

    public function getExtension()
    {
        return $this->field->getClientOriginalExtension();
    }

    public function handleSave($item)
    {
        if ($this->afterSaveCallback) {
            call_user_func($this->afterSaveCallback, $this, $item);
        }
    }
}
