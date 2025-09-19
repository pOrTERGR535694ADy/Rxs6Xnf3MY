<?php
// 代码生成时间: 2025-09-19 21:01:21
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Reader\Word2007;
use PhpOffice\PhpWord\Writer\Word2007;
use PhpOffice\PhpWord\IOFactory as PhpWordIOFactory;

class DocumentConverter {
    // 将Word文档转换为PDF
    public function convertWordToPdf($filePath) {
        try {
            $ioFactory = PhpWordIOFactory::getInstance();
            $phpWord = $ioFactory->load($filePath);
            $writer = IOFactory::createWriter($phpWord, 'PDF');
            $outputPath = 'path/to/output/pdf/' . basename($filePath, '.docx') . '.pdf';
            $writer->save($outputPath);
            return response()->json(['message' => 'Document converted successfully', 'filePath' => $outputPath]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to convert document', 'message' => $e->getMessage()], 500);
        }
    }

    // 上传Word文档
    public function uploadWordDocument(Request $request) {
        $request->validate([
            'file' => 'required|file|mimes:docx',
        ]);
        try {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            Storage::disk('local')->putFileAs('word', $file, $filename);
            return response()->json(['message' => 'Document uploaded successfully', 'filename' => $filename]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to upload document', 'message' => $e->getMessage()], 500);
        }
    }
}
