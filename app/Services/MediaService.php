<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{

  private function base64_mimetype(string $encoded, bool $strict = true): ?string
  {
    if ($decoded = base64_decode($encoded, $strict)) {
      $tmpFile = tmpFile();
      $tmpFilename = stream_get_meta_data($tmpFile)['uri'];

      file_put_contents($tmpFilename, $decoded);
      $mime_content_type = mime_content_type($tmpFilename) ? explode('/', mime_content_type($tmpFilename))  : null;
      return $mime_content_type[1] ?: null;
    }

    return null;
  }

  public function saveFile($file)
  {
    $allowedFileTypes = [
      'jpg', 'jpeg', 'png', 'docx', 'pdf', 'xml', 'ppt', 'xls'
    ];

    // $imgdata = base64_decode($img);
    // $mimetype = $this->getImageMimeType($imgdata);    
    $mimetype = $this->base64_mimetype($file);
    // dd($mimetype);
    $image = $file; //data to be stored ? default
    if (!$mimetype) {
      //if format has data:type?mime;base64
      {
        try {
          $d = explode(':', substr($file, 0, strpos($file, ';')));
          if (count($d) > 1) {
            $d = $d[1];
          } else {
            $err = $this->createErrorMessage("File type is not allowed. Please upload only a 'jpg', 'jpeg', 'png', 'docx', 'pdf', 'xml', 'ppt' or 'xls' file type.");

            return $err;
          }
          $mimetype = explode('/', $d)[1];
        } catch (Exception $e) {
          $err = $this->createErrorMessage("File type is not allowed. Please upload only a 'jpg', 'jpeg', 'png', 'docx', 'pdf', 'xml', 'ppt' or 'xls' file type.");

          return $err;
          // return response()->json(['error'=>$err], 400);
        }
      }
      $replace = substr($file, 0, strpos($file, ',') + 1);


      $image = str_replace($replace, '', $file);

      $image = str_replace(' ', '+', $image); //data to be stored 
    }
    // dd($mimetype);
    if (!in_array($mimetype, $allowedFileTypes)) {
      $err = $this->createErrorMessage("File type is not allowed. Please upload only a 'jpg', 'jpeg', 'png', 'docx', 'pdf', 'xml', 'ppt' or 'xls' file type.");

      return $err;
    }



    $user_id = Auth::user()->id;


    $file_name = $user_id . '-' . Str::random(10) . '.' . $mimetype;

    $file_path = 'attachments/' . $file_name;
    // $str_path  = env('APP_URL').'/storage'.$file_path;
    // $str_path = Storage::path('public/'.$file_path);

    $public_path = '/public/' . $file_path;
    Storage::put($public_path, base64_decode($image));

    return $file_path;
  }

  static function createErrorMessage(string $message): array
  {
    $err = [
      "err"        => true,
      "message"    => $message,
      "data"        => []
    ];
    return $err;
  }
}
