<?php
/**
 * Safe redirect back to an allowed in-app page.
 */
function velora_safe_redirect($default = 'index.php') {
    $allowed = ['index.php', 'priority.php', 'completed.php', 'edit.php', 'settings.php'];
    $redirect = $default;

    if (!empty($_SERVER['HTTP_REFERER'])) {
        $path = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
        $file = basename($path ?: '');
        if (in_array($file, $allowed, true)) {
            $query = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY);
            $redirect = $file . ($query ? '?' . $query : '');
        }
    }

    header('Location: ' . $redirect);
    exit();
}

?>
