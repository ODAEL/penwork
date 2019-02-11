<?php

namespace vendor\penwork;

class FileUploader
{
    /** @var string $uploadDir */
    protected $uploadFilePath;

    /** @var array $userFile */
    protected $userFile;

    public function __construct(array $userFile, string $uploadFilePath)
    {
        $this->userFile = $userFile;
        $this->uploadFilePath = $uploadFilePath;
    }

    public function upload(): ?bool
    {
        if (move_uploaded_file($this->userFile['tmp_name'], $this->uploadFilePath)) {
            return true;
        }

        return false;
    }
}