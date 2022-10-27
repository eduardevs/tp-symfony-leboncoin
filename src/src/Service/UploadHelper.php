<?php

namespace App\Service;

class UploadHelper {

    private string $projectDir;

    public function __construct(string $projectDir){
        $this->projectDir = $projectDir;
    }

    public function uploadPostImage(UploadedFile $file): string {
        $destination = $this->projectDir . '/public/uploads/post_images';
        $originalFileName = $file->getClientOriginalName();
        $baseFileName = pathinfo($originalFileName, PATHINFO_FILENAME);
        $fileName = Urlizer::urlize($baseFileName) . '-' . uniqid() . '-' . $file->guessExtension();
        $file->move($destination, $fileName);

        return $fileName;
    }

}