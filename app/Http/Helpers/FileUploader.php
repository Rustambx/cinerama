<?php

namespace App\Http\Helpers;

use Illuminate\Http\UploadedFile;
use Image;

class FileUploader
{
    public static function uploadImage(UploadedFile $file, $path = '')
    {
        // Генерация уникального названия файла с использованием хеша из оригинального имени файла и текущего времени
        $fileTitle = md5($file->getClientOriginalName() . time());

        // Добавление расширения файла к сгенерированному названию
        $filename = $fileTitle . '.' . $file->getClientOriginalExtension();

        // Полный путь к файлу
        $resizeRealPath = storage_path('app/public/' . $path . '/' . $filename);

        // Полный путь к директории
        $directoryPath = storage_path('app/public/' . $path);

        // Создайте директорию, если её нет
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }

        // Изменение размера и сохранение изображения
        $obImage = Image::make($file);
        $obImage->fit(300, 450);
        $obImage->save($resizeRealPath);

        return $path . '/' . $filename;
    }

    public static function uploadVideo(UploadedFile $file, $path = '', $disk = 'public')
    {
        $fileTitle = md5($file->getClientOriginalName().time());

        $filename = $fileTitle.'.'.$file->getClientOriginalExtension();

        // Метод storeAs сохраняет файл с указанным именем
        $file->storeAs($path, $filename, $disk);

        return $path.'/'.$filename;
    }
}
