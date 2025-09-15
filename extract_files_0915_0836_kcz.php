<?php
// 代码生成时间: 2025-09-15 08:36:36
// extract_files.php
// 使用Laravel框架创建的压缩文件解压工具

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Finder\Finder;
use ZipArchive;
use App\Exports\ZipFileExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ExtractFilesController extends Controller
{
    // 解压文件到指定目录
    public function extract(Request $request)
    {
        // 检查是否有文件上传
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file provided'], 400);
        }

        // 获取上传的文件
        $file = $request->file('file');
        $filePath = $file->getPathname();

        // 检查文件是否是压缩文件
        $zip = new ZipArchive();
        if ($zip->open($filePath) === true) {
            $zip->extract(storage_path('app/temp'));
            $zip->close();
        } else {
            return response()->json(['error' => 'File is not a valid zip file'], 400);
        }

        return response()->json(['message' => 'File extracted successfully'], 200);
    }

    // 清理临时目录
    public function cleanTemp()
    {
        $files = Finder::create()->files()->in(storage_path('app/temp'))->depth(0);
        foreach ($files as $file) {
            $file->delete();
        }
        return response()->json(['message' => 'Temporary directory cleaned'], 200);    
    }
}
