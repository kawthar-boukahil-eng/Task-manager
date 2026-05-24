<?php
$docTitle = isset($pageTitle) ? htmlspecialchars($pageTitle) . ' — Velora' : 'Velora';
$pageDesc = $pageDesc ?? 'Velora — premium task management workspace.';
?>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($pageDesc); ?>">
    <title><?php echo $docTitle; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
