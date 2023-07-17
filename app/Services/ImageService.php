<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use InterventionImage;


class ImageService
{
  public static function upload($imageFile, $folderName){
    //dd($imageFile['image']);
    if(is_array($imageFile))
    {
      $file = $imageFile['image'];
    } else {
      $file = $imageFile;
    }

    $fileName = uniqid(rand().'_');
    $extension = $file->extension();
    $fileNameToStore = $fileName. '.' . $extension;
//    $resizedImage = InterventionImage::make($file)->resize(1920, 1080)->encode();
//    Storage::put('public/' . $folderName . '/' . $fileNameToStore, $resizedImage );


         // アップロード先S3フォルダ名 
         $dir = 'test';
 
         // バケット内の指定フォルダへアップロード ※putFileはLaravel側でファイル名の一意のIDを自動的に生成してくれます。
         $s3_upload = Storage::disk('s3')->putFile('/'.$dir, $file);
 
         // ※オプション（ファイルダウンロード、削除時に使用するS3でのファイル保存名、アップロード先のパスを取得します。）
         // アップロードファイルurlを取得
         $s3_url = Storage::disk('s3')->url($s3_upload);

         // s3_urlからS3でのファイル保存名取得
//         $s3_upload_file_name = explode("/", $s3_url)[5];
 
         // アップロード先パスを取得 ※ファイルダウンロード、削除で使用します。
//         $s3_path = $dir.'/'.$s3_upload_file_name;


    return $s3_url;
  }
}
