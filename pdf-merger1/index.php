<?php include_once 'config.php'; ?>
<?php include_once 'merge.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PDF Merger</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form action="" class="form-group" method="POST">
            <h1 class="text-center mb-4">PDF Merger</h1>

            <?php $files = array_merge($files, $output_files); ?>

            <ul class="list-group">
                <?php foreach ($files as $file): ?>
                    <?php $directory = strpos($file, 'output') === false ? FILES_URL : OUTPUT_URL; ?>
                    <?php $file = basename($file); ?>

                    <li class="list-group-item">
                        <div><i class="bi-file-earmark"></i> <?php echo $file; ?></div>
                        <a href="<?php echo $directory . $file; ?>" target="_blank">Download</a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" id="compress" name="compress" checked>
                <label class="form-check-label" for="compress">Compress image quality</label>
            </div>

            <input type="submit" name="submit" class="btn btn-primary btn-lg mt-4" value="Merge">
        </form>
    </div>
</body>
</html>