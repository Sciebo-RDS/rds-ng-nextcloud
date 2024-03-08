<?php

namespace OCA\RdsNg\Service;

use OCA\RdsNg\Types\Resource;
use OCA\RdsNg\Types\ResourcesList;
use OCP\DB\Exception;
use OCP\Files\FileInfo;
use OCP\Files\Folder;
use OCP\Files\IRootFolder;
use OCP\IUserSession;

class ResourcesService {
    private IUserSession $userSession;
    private IRootFolder $rootFolder;

    public function __construct(
        IUserSession $session,
        IRootFolder  $rootFolder) {

        $this->userSession = $session;
        $this->rootFolder = $rootFolder;
    }

    public function getResourcesList(): ResourcesList|null {
        if (!$this->userSession->isLoggedIn() || !$this->userSession->getUser()) {
            return null;
        }

        try {
            $userFolder = $this->rootFolder->getUserFolder($this->userSession->getUser()->getUID());
            return $this->listResources($userFolder);
        } catch (Exception $e) {
            return null;
        }
    }

    private function listResources(Folder $path, bool $includeFolders = true, bool $includeFiles = true, bool $recursive = true): ResourcesList {
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
                            $node->getInternalPath(),
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
                    $rootPath->getInternalPath(),
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
