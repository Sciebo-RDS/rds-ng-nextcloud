<?php

namespace OCA\RdsNg\Service;

use \Exception;

use OCA\RdsNg\Types\Resource;
use OCA\RdsNg\Types\ResourcesList;
use OCP\Files\FileInfo;
use OCP\Files\Folder;
use OCP\Files\IRootFolder;

class ResourcesService {
    private IRootFolder $rootFolder;

    public function __construct(IRootFolder $rootFolder) {
        $this->rootFolder = $rootFolder;
    }

    public function getResourcesList(string $uid): ResourcesList|null {
        try {
            $userFolder = $this->rootFolder->getUserFolder($uid);
            return $this->listResources($userFolder);
        } catch (Exception $e) {
            return null;
        }
    }

    private function listResources(Folder $path, bool $includeFolders = true, bool $includeFiles = true, bool $recursive = true): ResourcesList {
        function sanitizePath(string $path): string {
            if (!str_starts_with($path, "/")) {
                return "/" . $path;
            }

            return $path;
        }

        function _listResources(Folder $rootPath, bool $processResource, bool $includeFolders, bool $includeFiles, bool $recursive): ResourcesList {
            $folders = [];
            $files = [];
            $totalSize = 0;

            if ($processResource) {
                foreach ($rootPath->getDirectoryListing() as $node) {
                    if ($node->getType() == FileInfo::TYPE_FOLDER and $includeFolders) {
                        $pathResources = _listResources($node, $recursive, $includeFolders, $includeFiles, $recursive);
                        $folders[] = $pathResources;
                        $totalSize += $pathResources->resource->size;
                    } else if ($node->getType() == FileInfo::TYPE_FILE and $includeFiles) {
                        $fileSize = $node->getSize();
                        $files[] = new Resource(
                            sanitizePath($node->getInternalPath()),
                            pathinfo($node->getInternalPath(), PATHINFO_BASENAME),
                            Resource::TYPE_FILE,
                            $fileSize
                        );
                        $totalSize += $fileSize;
                    }
                }
            }

            return new ResourcesList(
                new Resource(
                    sanitizePath($rootPath->getInternalPath()),
                    pathinfo($rootPath->getInternalPath(), PATHINFO_BASENAME),
                    Resource::TYPE_FOLDER,
                    $totalSize
                ),
                $folders,
                $files
            );
        }

        return _listResources($path, true, $includeFolders, $includeFiles, $recursive);
    }
}
