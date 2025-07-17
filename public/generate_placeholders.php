<?php

/**
 * Generate placeholder images for the e-commerce application
 */

// Create images directories if they don't exist
$directories = ['images', 'images/products', 'images/categories', 'images/users'];
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "<p>Created directory: $dir</p>";
    }
}

// Function to create a placeholder image
function createPlaceholder($width, $height, $text, $filename)
{
    // Check if GD extension is available
    if (!extension_loaded('gd')) {
        echo "<p style='color: red;'>Error: GD extension is not available. Cannot generate images.</p>";
        return false;
    }

    $image = imagecreate($width, $height);

    // Colors
    $bg_color = imagecolorallocate($image, 240, 240, 240);
    $text_color = imagecolorallocate($image, 100, 100, 100);
    $border_color = imagecolorallocate($image, 200, 200, 200);

    // Fill background
    imagefill($image, 0, 0, $bg_color);

    // Add border
    imagerectangle($image, 0, 0, $width - 1, $height - 1, $border_color);

    // Add text
    $font_size = 3;
    $text_width = imagefontwidth($font_size) * strlen($text);
    $text_height = imagefontheight($font_size);

    $x = ($width - $text_width) / 2;
    $y = ($height - $text_height) / 2;

    imagestring($image, $font_size, $x, $y, $text, $text_color);

    // Save image
    $result = imagejpeg($image, $filename, 80);
    imagedestroy($image);

    return $result;
}

// Create placeholder images for products
$products = [
    'headphones-1.jpg' => 'Headphones',
    'smartphone-1.jpg' => 'Smartphone',
    'laptop-1.jpg' => 'Laptop',
    'mouse-1.jpg' => 'Mouse',
    'tshirt-1.jpg' => 'T-Shirt',
    'jeans-1.jpg' => 'Jeans',
    'hoodie-1.jpg' => 'Hoodie',
    'coffee-maker-1.jpg' => 'Coffee Maker',
    'garden-tools-1.jpg' => 'Garden Tools',
    'desk-lamp-1.jpg' => 'Desk Lamp',
    'yoga-mat-1.jpg' => 'Yoga Mat',
    'water-bottle-1.jpg' => 'Water Bottle',
    'running-shoes-1.jpg' => 'Running Shoes',
    'programming-book-1.jpg' => 'Programming Book',
    'cookbook-1.jpg' => 'Cookbook',
    'skincare-1.jpg' => 'Skincare Set',
    'toothbrush-1.jpg' => 'Electric Toothbrush'
];

echo "<h1>Generating Placeholder Images</h1>";

// Check if GD extension is available
if (!extension_loaded('gd')) {
    echo "<h2 style='color: red;'>Error: GD Extension Not Available</h2>";
    echo "<p>The GD extension is required to generate images. Please enable it in your PHP configuration.</p>";
    echo "<p>In XAMPP/Laragon, uncomment <code>extension=gd</code> in php.ini</p>";
    exit;
}

$success_count = 0;
$total_count = 0;

foreach ($products as $filename => $text) {
    $filepath = 'images/products/' . $filename;
    $total_count++;
    if (createPlaceholder(400, 400, $text, $filepath)) {
        echo "<p style='color: green;'>✓ Created: $filepath</p>";
        $success_count++;
    } else {
        echo "<p style='color: red;'>✗ Failed to create: $filepath</p>";
    }
}

// Create a general placeholder
$total_count++;
if (createPlaceholder(400, 400, 'No Image', 'images/placeholder.jpg')) {
    echo "<p style='color: green;'>✓ Created: images/placeholder.jpg</p>";
    $success_count++;
} else {
    echo "<p style='color: red;'>✗ Failed to create: images/placeholder.jpg</p>";
}

// Create hero background
$total_count++;
if (createPlaceholder(1200, 600, 'Hero Background', 'images/hero-bg.jpg')) {
    echo "<p style='color: green;'>✓ Created: images/hero-bg.jpg</p>";
    $success_count++;
} else {
    echo "<p style='color: red;'>✗ Failed to create: images/hero-bg.jpg</p>";
}

echo "<h2>Image Generation Complete!</h2>";
echo "<p>Successfully created $success_count out of $total_count images.</p>";

if ($success_count === $total_count) {
    echo "<p style='color: green;'>✅ All images created successfully!</p>";
    echo "<p><a href='/' class='btn'>Go to your store</a> <a href='status.php' class='btn'>Check Status</a></p>";
} else {
    echo "<p style='color: orange;'>⚠️ Some images failed to generate. Check file permissions.</p>";
    echo "<p><a href='status.php' class='btn'>Check Status</a></p>";
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
    }

    h1,
    h2 {
        color: #333;
    }

    p {
        line-height: 1.6;
    }

    a {
        color: #007cba;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: #667eea;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        margin: 0.25rem;
        transition: background 0.3s;
    }

    .btn:hover {
        background: #5a6fd8;
        text-decoration: none;
    }
</style>