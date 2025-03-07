<?php

/**
 * Get the base path
 *
 * @param string $path
 * @return string
 */
function basePath($path = '')
{
    return __DIR__ . '/' . $path;
}

/**
 * Load a view
 *
 * @param string $name
 * @return void 
 */
function loadView($folder, $name , $data = [])
{
    $viewPath =  basePath("App/views/{$folder}/default.view.php");
    if (file_exists($viewPath)) {
        require $viewPath;
    } else {
        echo "View not found: {$name}";
    }
}

/**
 * Load a view
 *
 * @param string $name
 * @return void 
 */
function loadViewError($name , $data = [])
{
    $viewPath =  basePath("App/views/{$name}.view.php");
    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "View not found: {$name}";
    }
}

/**
 * Load a view
 *
 * @param string $name
 * @return void 
 */
function loadViewFolder($folder, $page, $data = [])
{
    $viewPath =  basePath("App/views/{$folder}/pages/{$page}.view.php");
    if (file_exists($viewPath)) {
        extract($data);  // extract variables to the current symbol table
        require $viewPath;
    } else {
        echo "View not found: {$page}";
    }
}

/**
 * Load a partial
 *
 * @param string $name
 * @return void 
 */
function loadPartial($folder, $name, $data = [])
{
    $partialPath =  basePath("App/views/{$folder}/partials/{$name}.php");
    if (file_exists($partialPath)) {
        require $partialPath;
    } else {
        echo "Partial not found: {$name}";
    }
}

/**
 * Inspect a value(s)
 *
 * @param mixed $value
 * @return void 
 */
function inspect($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

/**
 * Inspect a value(s) and die
 *
 * @param mixed $value
 * @return void 
 */
function inspectAndDie($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    exit();
}
/**
 * Format salary
 * 
 * @param string $salary
 * 
 * @return string Formatted Salary 
 */
function formatSalary($salary)
{
    return number_format(floatval($salary), 0, ',', '.') . ' đ';
}
/**
 * Sanitize Data
 * 
 * @param string $dirty
 * @return string
 */
function sanitize($dirty)
{
    return filter_var(trim($dirty), FILTER_SANITIZE_SPECIAL_CHARS);
}
/**
 * Redirect to a given url
 */
function redirect($url)
{
    header("Location: {$url}");
    exit;
}
function createFolderIfNotExists($folderPath)
{
    // Kiểm tra nếu thư mục chưa tồn tại
    if (!is_dir($folderPath)) {
        // Tạo thư mục với quyền 0755 (đọc, ghi, thực thi)
        mkdir($folderPath, 0755, true);
    }
}

/**
 * lưu file ảnh vào folder
 */
function upFileInFolder($folder, $file, $file_temp)
{
    $targetDir = "images/" . $folder . "/";
    createFolderIfNotExists($targetDir);
    $isError = false;
    $randomDigits = rand(1000, 9999);
    $fileName = pathinfo($file, PATHINFO_FILENAME);
    $fileType = pathinfo($file, PATHINFO_EXTENSION);
    $newFileName = $fileName . "_" . $randomDigits . "." . $fileType;
    $targetFilePath = $targetDir . $newFileName;
    $allowTypes = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg', 'jfif'];
    if (in_array(strtolower($fileType), $allowTypes)) {
        // Kiểm tra và di chuyển tệp tới thư mục đích
        if (move_uploaded_file($file_temp, $targetFilePath)) {
            $isError = $newFileName;
        }
    }
    return $isError;
}


function handleImgBySummernote($description) 
{
    // Thêm meta charset UTF-8
    $description = '<!DOCTYPE html><html><meta charset="UTF-8"><body>' . $description . '</body></html>';
    
    $dom = new DOMDocument('1.0', 'UTF-8');
    
    // Tắt báo lỗi XML
    libxml_use_internal_errors(true);
    
    // Load với encoding UTF-8
    $dom->loadHTML($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR);
    
    $images = $dom->getElementsByTagName('img');
    foreach ($images as $key => $img) {
        if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
            if (!$img) {
                continue;
            }

            $src = $img->getAttribute('src');
            if (!$src) {
                continue;
            }

            try {
                $data = base64_decode(explode(',', explode(';', $src)[1])[1]);
                $image_name = "/images/" . time() . $key . '.png';

                if (file_put_contents(basePath("public" . $image_name), $data)) {
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $image_name);
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
                continue;
            }
        }
    }

    // Lấy nội dung từ thẻ body
    $body = $dom->getElementsByTagName('body')->item(0);
    $content = '';
    foreach ($body->childNodes as $childNode) {
        $content .= $dom->saveHTML($childNode);
    }
    
    // Decode HTML entities
    $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
    
    return $content;
}


function handlePage($page, $count, $per_page1 = 10)
{
    $per_page = $per_page1;
    $count = ceil($count / $per_page);
    if ($page == 1) {
        $offset = 0;
    } else {
        $offset = ($page * $per_page) - $per_page;
    }
    return ['offset' => (int)$offset, 'count' => (int)$count, 'per_page' => (int)$per_page];
}
