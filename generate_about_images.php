<?php
/**
 * Generate placeholder images for About page
 */

// Create images directory if it doesn't exist
$imagesDir = __DIR__ . '/public/images';
if (!is_dir($imagesDir)) {
    mkdir($imagesDir, 0755, true);
}

$teamDir = $imagesDir . '/team';
if (!is_dir($teamDir)) {
    mkdir($teamDir, 0755, true);
}

// Function to create a placeholder image
function createPlaceholderImage($width, $height, $text, $filename, $bgColor = [99, 102, 241], $textColor = [255, 255, 255]) {
    // Create image
    $image = imagecreatetruecolor($width, $height);
    
    // Set colors
    $bg = imagecolorallocate($image, $bgColor[0], $bgColor[1], $bgColor[2]);
    $textColorResource = imagecolorallocate($image, $textColor[0], $textColor[1], $textColor[2]);
    
    // Fill background
    imagefill($image, 0, 0, $bg);
    
    // Add text
    $fontSize = min($width, $height) / 10;
    $font = 5; // Built-in font
    
    // Calculate text position
    $textWidth = imagefontwidth($font) * strlen($text);
    $textHeight = imagefontheight($font);
    $x = ($width - $textWidth) / 2;
    $y = ($height - $textHeight) / 2;
    
    imagestring($image, $font, $x, $y, $text, $textColorResource);
    
    // Save image
    imagejpeg($image, $filename, 90);
    imagedestroy($image);
    
    return file_exists($filename);
}

// Generate About story image
$storyImage = $imagesDir . '/about-story.jpg';
if (!file_exists($storyImage)) {
    createPlaceholderImage(600, 400, 'Our Story', $storyImage, [99, 102, 241]);
    echo "Created: about-story.jpg\n";
}

// Generate team member images
$teamMembers = [
    ['name' => 'CEO', 'filename' => 'ceo.jpg', 'color' => [99, 102, 241]],
    ['name' => 'CTO', 'filename' => 'cto.jpg', 'color' => [245, 158, 11]],
    ['name' => 'CMO', 'filename' => 'cmo.jpg', 'color' => [236, 72, 153]]
];

foreach ($teamMembers as $member) {
    $memberImage = $teamDir . '/' . $member['filename'];
    if (!file_exists($memberImage)) {
        createPlaceholderImage(300, 300, $member['name'], $memberImage, $member['color']);
        echo "Created: team/{$member['filename']}\n";
    }
}

// Generate category placeholder images
$categoriesDir = $imagesDir . '/categories';
if (!is_dir($categoriesDir)) {
    mkdir($categoriesDir, 0755, true);
}

$categories = [
    ['name' => 'Electronics', 'color' => [59, 130, 246]],
    ['name' => 'Fashion', 'color' => [236, 72, 153]],
    ['name' => 'Home', 'color' => [34, 197, 94]],
    ['name' => 'Sports', 'color' => [245, 158, 11]],
    ['name' => 'Books', 'color' => [139, 92, 246]],
    ['name' => 'Beauty', 'color' => [244, 63, 94]]
];

foreach ($categories as $category) {
    $categoryImage = $categoriesDir . '/' . strtolower($category['name']) . '.jpg';
    if (!file_exists($categoryImage)) {
        createPlaceholderImage(400, 300, $category['name'], $categoryImage, $category['color']);
        echo "Created: categories/" . strtolower($category['name']) . ".jpg\n";
    }
}

echo "\nPlaceholder images generated successfully!\n";
echo "Visit your About page to see the images in action.\n";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Generation Complete</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f8fafc;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #6366f1;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 5px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #4f46e5;
        }
        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .image-item {
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .image-item img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="success">
        <h2>🎉 Placeholder Images Generated Successfully!</h2>
        <p>All placeholder images have been created for your About page and categories.</p>
    </div>

    <div class="image-grid">
        <div class="image-item">
            <h4>About Story</h4>
            <img src="/public/images/about-story.jpg" alt="About Story">
        </div>
        <div class="image-item">
            <h4>CEO</h4>
            <img src="/public/images/team/ceo.jpg" alt="CEO">
        </div>
        <div class="image-item">
            <h4>CTO</h4>
            <img src="/public/images/team/cto.jpg" alt="CTO">
        </div>
        <div class="image-item">
            <h4>CMO</h4>
            <img src="/public/images/team/cmo.jpg" alt="CMO">
        </div>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="/about" class="btn">View About Page</a>
        <a href="/contact" class="btn">View Contact Page</a>
        <a href="/" class="btn">Back to Homepage</a>
    </div>

    <div style="margin-top: 30px; padding: 20px; background: white; border-radius: 8px;">
        <h3>What was created:</h3>
        <ul>
            <li><strong>About Story Image:</strong> /public/images/about-story.jpg</li>
            <li><strong>Team Photos:</strong> /public/images/team/ceo.jpg, cto.jpg, cmo.jpg</li>
            <li><strong>Category Images:</strong> /public/images/categories/ (electronics, fashion, home, etc.)</li>
        </ul>
        
        <h3>Next Steps:</h3>
        <ul>
            <li>Visit the <a href="/about">About page</a> to see the enhanced design</li>
            <li>Check the <a href="/contact">Contact page</a> with the working contact form</li>
            <li>Test the categories dropdown in the navigation</li>
            <li>Replace placeholder images with real photos when ready</li>
        </ul>
    </div>
</body>
</html>
