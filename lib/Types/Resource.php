<?php

namespace OCA\RdsNg\Types;

class Resource {
    public const TYPE_FOLDER = "folder";
    public const TYPE_FILE = "file";

    public string $filename;
    public string $basename;
    public string $type;

    public int $size;

    public function __construct(string $filename, string $basename, string $type, int $size = 0) {
        $this->filename = $filename;
        $this->basename = $basename;
        $this->type = $type;

        $this->size = $size;
    }
}
