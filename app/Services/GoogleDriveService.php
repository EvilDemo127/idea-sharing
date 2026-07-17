<?php
namespace App\Services;

use Exception;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Illuminate\Support\Facades\Log;

class GoogleDriveService{
    protected Client $client;
    protected Drive $drive;

    public function __construct()
    {
        $this->client=new Client();
        $this->client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $this->client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $this->client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));

        $this->drive =new Drive($this->client);

    }

    public function upload($uploadFil,$parentFolderId =null)
    {
        $fileMedia =new DriveFile([
            'name'=>$uploadFil->getClientOriginalName()
        ]);

        if($parentFolderId)
            {
                $fileMedia->setParents([$parentFolderId]);
            }
        $fileName=file_get_contents($uploadFil->getRealPath());
        $fileType =$uploadFil->getClientMimeType();

        $file =$this->drive->files->create($fileMedia,[
            'data' => $fileName,
            'mimeType' => $fileType,
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);
        return $file->id;
    }

    public function deleteFile($fileId)
    {
        try {
            $this->drive->files->delete($fileId);
            return true;
        } catch (\Exception $e) {
             \Illuminate\Support\Facades\Log::error('Google api file deletion failed', [
            'error' => $e->getMessage(),
            'file_id' => $fileId
        ]);
        
        return false;
    }
    }
}