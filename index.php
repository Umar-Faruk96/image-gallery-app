<?php
declare(strict_types=1);
include_once 'image_handler.php';

// handle the file upload
fileUploadHandler($_FILES['images'] ?? [], $allowedType, $maxSize);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Image Gallery</title>
    <!-- link tailwind css -->
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="./css/style.css">

</head>

<body>
    <main class="min-h-screen w-full flex flex-col gap-y-4 my-4 justify-center items-center">
        <!-- HEAD Section -->
        <section class="w-11/12 flex flex-wrap justify-between items-center font-bold bg-blue-50 p-3 rounded-s-xl">
            <div class="flex items-center gap-3 w-[55%] text-blue-700">
                <img src="./imgs/official_logo.jpg" alt="PHP Elephant Symbolized Logo" width="600" height="600"
                    class="w-16 shadow-lg shadow-blue-700 rounded-full">
                <h1 class="text-3xl">Welcome to PHP Image Gallery</h1>
            </div>
            <form action="<?php echo $PHP_SELF; ?>" method="post" enctype="multipart/form-data"
                class="flex flex-wrap items-end gap-3 border-solid border-2 border-blue-200 p-3 w-[45%] rounded text-blue-500 text-lg font-medium"
                id="upload-form">
                <div>
                    <label for="image" class="block pb-2">Upload Image</label>
                    <input type="file" name="images[]" title="Upload Image" accept="image/*" multiple>
                </div>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 focus:outline-none focus:bg-blue-700 text-white px-5 py-1 rounded text-lg font-bold transiton-[background-color] duration-300 ease-in-out"
                    id="upload">Upload</button>
            </form>
        </section>
        <section class="w-11/12 flex flex-wrap gap-3 justify-around rounded-e-xl bg-blue-50 p-4">
            <!-- GALLERY Images Presentation -->
            <?php if (is_null(directoryHandler('gallery'))): ?>
                <p class="text-lg font-bold text-red-500">
                    The folder is not found or access is denied, please upload an image first or give the necessary
                    permission to the folder, then try again.
                </p>
            <?php elseif (empty(directoryHandler('gallery'))): ?>
                <p class="text-lg font-bold text-red-500">
                    <?php echo count(directoryHandler('gallery')) . " images found"; ?>
                </p>
            <?php else: ?>
                <?php foreach (directoryHandler('gallery') as $image): ?>
                    <img src="<?php echo $image; ?>" alt="Gallery Image" width="640" height="480"
                        class="w-32 shadow-lg shadow-stone-700 rounded">
                <?php endforeach ?>
            <?php endif ?>
        </section>
    </main>
</body>

</html>