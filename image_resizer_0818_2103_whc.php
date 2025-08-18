<?php
// 代码生成时间: 2025-08-18 21:03:44
 * It uses the Intervention Image library which is a powerful PHP image handling library.
 *
 * @author Your Name
 * @version 1.0
 */
class ImageResizer
{
    protected $sourceDirectory;
    protected $targetDirectory;
    protected $width;
    protected $height;
    protected $resizeType;

    // Constructor
    public function __construct($sourceDirectory, $targetDirectory, $width, $height, $resizeType)
    {
        $this->sourceDirectory = $sourceDirectory;
        $this->targetDirectory = $targetDirectory;
        $this->width = $width;
        $this->height = $height;
        $this->resizeType = $resizeType;
    }

    // Resize images in the source directory and save to the target directory
    public function resizeImages()
    {
        if (!file_exists($this->sourceDirectory)) {
            throw new Exception("Source directory does not exist.");
        }

        if (!file_exists($this->targetDirectory)) {
            mkdir($this->targetDirectory, 0777, true);
        }

        $files = scandir($this->sourceDirectory);
        foreach ($files as $file) {
            if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
                $sourcePath = $this->sourceDirectory . DIRECTORY_SEPARATOR . $file;
                $targetPath = $this->targetDirectory . DIRECTORY_SEPARATOR . $file;

                $this->resizeImage($sourcePath, $targetPath);
            }
        }
    }

    // Resize a single image
    protected function resizeImage($sourcePath, $targetPath)
    {
        try {
            $image = Image::make($sourcePath);

            // Resize the image based on the resize type
            switch ($this->resizeType) {
                case 'width':
                    $image->resize($this->width, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    break;
                case 'height':
                    $image->resize(null, $this->height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    break;
                case 'exact':
                    $image->resize($this->width, $this->height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    break;
            }

            $image->save($targetPath);
        } catch (Exception $e) {
            error_log("Error resizing image: " . $e->getMessage());
        }
    }
}

// Usage example
try {
    $sourceDir = "/path/to/source/directory";
    $targetDir = "/path/to/target/directory";
    $width = 800;
    $height = 600;
    $resizeType = "width"; // 'width', 'height', or 'exact'

    $imageResizer = new ImageResizer($sourceDir, $targetDir, $width, $height, $resizeType);
    $imageResizer->resizeImages();
    echo "Images resized successfully.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
