<?php
require __DIR__ . '/db.php';

$messages = [];

if ($pdo) {
    $messages = $pdo->query('SELECT id, name, email, message, created_at FROM messages ORDER BY id DESC')->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Messages &middot; <?= e($studentName) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="topbar">
    <div class="container">
        <div class="topbar-in">
            <a class="brand" href="index.php"><span class="brand-mark"></span><?= e($studentName) ?></a>
            <nav class="nav">
                <a href="index.php">Portfolio</a>
                <a href="index.php#contact">Say hi</a>
                <a class="nav-cta" href="index.php#contact">New message</a>
            </nav>
        </div>
    </div>
</div>

<div class="page-head">
    <div class="container">
        <span class="mono">Inbox</span>
        <h1>Messages</h1>
        <p>Every hello sent from the say-hi form, saved in MySQL and shown newest first.</p>
        <span class="counter mt-3"><?= count($messages) ?> message<?= count($messages) === 1 ? '' : 's' ?></span>
    </div>
</div>

<div class="msg-list">
    <div class="container">
        <?php if ($dbError): ?>
            <div class="notice bad"><?= e($dbError) ?></div>
        <?php endif; ?>

        <?php if (!$messages && !$dbError): ?>
            <div class="empty">
                <b>No messages yet.</b>
                <p class="mb-3">Be the first to say hi from the portfolio page.</p>
                <a class="btn-flat" href="index.php#contact">Say hi</a>
            </div>
        <?php endif; ?>

        <?php foreach ($messages as $message): ?>
            <article class="msg">
                <div class="msg-head">
                    <h3><span>#<?= (int) $message['id'] ?></span><?= e($message['name']) ?></h3>
                    <time class="msg-time"><?= date('d M Y, H:i', strtotime($message['created_at'])) ?></time>
                </div>
                <a class="msg-mail" href="mailto:<?= e($message['email']) ?>"><?= e($message['email']) ?></a>
                <p><?= e($message['message']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="footer-in">
            <span>&copy; <?= date('Y') ?> <?= e($studentName) ?> &middot; Grade 12 portfolio</span>
            <div class="d-flex gap-4">
                <a href="index.php">Portfolio</a>
                <a href="index.php#contact">Say hi</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
