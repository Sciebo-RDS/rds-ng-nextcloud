<?php

namespace OCA\RdsNg\Types;

class ResourcesList {
    public Resource $resource;

    public array $folders;
    public array $files;

    public function __construct(Resource $resource, array $folders = [], array $files = []) {
        $this->resource = $resource;

        $this->folders = $folders;
        $this->files = $files;
    }
}
