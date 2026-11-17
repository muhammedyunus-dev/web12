<?php
require __DIR__ . '/db.php';

$errors = [];
$sent = false;
$formName = '';
$formEmail = '';
$formMessage = '';
$total = 0;

if ($pdo && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $formName = trim($_POST['name'] ?? '');
    $formEmail = trim($_POST['email'] ?? '');
    $formMessage = trim($_POST['message'] ?? '');

    if ($formName === '' || mb_strlen($formName) > 80) {
        $errors[] = 'Please write your name (80 characters or fewer).';
    }

    if (!filter_var($formEmail, FILTER_VALIDATE_EMAIL) || mb_strlen($formEmail) > 120) {
        $errors[] = 'Please write a valid email address.';
    }

    if ($formMessage === '' || mb_strlen($formMessage) > 1000) {
        $errors[] = 'Please write a message (1000 characters or fewer).';
    }

    if (!$errors) {
        $stmt = $pdo->prepare('INSERT INTO messages (name, email, message) VALUES (?, ?, ?)');
        $stmt->execute([$formName, $formEmail, $formMessage]);
        $sent = true;
        $formName = '';
        $formEmail = '';
        $formMessage = '';
    }
}

if ($pdo) {
    $total = (int) $pdo->query('SELECT COUNT(*) FROM messages')->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($studentName) ?> &middot; Grade 12 Portfolio</title>
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
                <a href="#about">About</a>
                <a href="#skills">Skills</a>
                <a href="#projects">Projects</a>
                <a href="#contact">Say hi</a>
                <a class="nav-cta" href="messages.php">Messages</a>
            </nav>
        </div>
    </div>
</div>

<header class="hero" id="home">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-7">
                <span class="tag-line"><span class="dot"></span>Grade 12 &middot; Kings School</span>
                <h1>Hello, I'm <?= e($studentName) ?>.<br><em>I build for the web.</em></h1>
                <p>
                    A Grade 12 student at Kings School focused on web development. I started with HTML, CSS
                    and JavaScript, and now I am learning backend basics with PHP and MySQL by building
                    small projects from start to finish.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn-flat" href="#projects">See my projects</a>
                    <a class="btn-outline" href="#contact">Say hi</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="index-card">
                    <div class="index-card-top">
                        <div class="seal"><?= e(mb_substr($studentName, 0, 1)) ?></div>
                        <div>
                            <h2><?= e($studentName) ?></h2>
                            <p>Student &middot; web developer in progress</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="spec"><span>Grade</span><strong>12</strong></div>
                        <div class="spec"><span>School</span><strong>Kings School</strong></div>
                        <div class="spec"><span>Focus</span><strong>Web Development</strong></div>
                        <div class="spec"><span>Learning</span><strong>PHP &amp; MySQL</strong></div>
                        <div class="spec"><span>Year</span><strong><?= date('Y') ?></strong></div>
                    </div>
                    <div class="stats">
                        <div><b>2</b><span>Projects</span></div>
                        <div><b>6</b><span>Skills</span></div>
                        <div><b><?= $total ?></b><span>Messages</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="block" id="about">
    <div class="container">
        <div class="block-head">
            <span class="block-num">01</span>
            <h2>About me</h2>
            <span class="aside">Who is behind the page</span>
        </div>
        <div class="row g-5">
            <div class="col-lg-7">
                <p class="prose">
                    I am a Grade 12 student at Kings School with a focus on <strong>web development</strong>.
                    My first pages were plain HTML and CSS, then JavaScript for small interactions. Right now
                    I am learning the backend: how a form reaches a server, how PHP handles it, and how MySQL
                    keeps the data.
                </p>
                <p class="prose mt-3">
                    This portfolio is built around that loop. The say-hi form is real, the database is real,
                    and the messages page reads back exactly what was saved.
                </p>
                <ul class="tick-list">
                    <li>Builds responsive layouts with HTML, CSS and Bootstrap.</li>
                    <li>Adds small JavaScript interactions where they help.</li>
                    <li>Writes PHP forms that validate and save to MySQL.</li>
                    <li>Keeps every page simple, clean and easy to read.</li>
                </ul>
            </div>
            <div class="col-lg-5">
                <div class="learn">
                    <div class="learn-head">Currently learning</div>
                    <div class="learn-row">
                        <span class="learn-index">01</span>
                        <div>
                            <b>Backend basics</b>
                            <p>Requests, responses and how forms send data to a server.</p>
                        </div>
                    </div>
                    <div class="learn-row">
                        <span class="learn-index">02</span>
                        <div>
                            <b>PHP</b>
                            <p>Handling form input, checking values and saving them safely.</p>
                        </div>
                    </div>
                    <div class="learn-row">
                        <span class="learn-index">03</span>
                        <div>
                            <b>MySQL</b>
                            <p>Creating tables, inserting rows and reading them back.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="block" id="skills">
    <div class="container">
        <div class="block-head">
            <span class="block-num">02</span>
            <h2>Skills</h2>
            <span class="aside">Frontend strong &middot; backend growing</span>
        </div>
        <div class="row g-5">
            <div class="col-lg-4">
                <p class="prose">
                    An honest picture of a Grade 12 student: comfortable with the frontend, and practising
                    the backend with small examples that actually run.
                </p>
            </div>
            <div class="col-lg-8">
                <div class="skills">
                    <div class="skill">
                        <span class="skill-name">HTML</span>
                        <span class="skill-track"><span class="skill-fill" style="width: 90%"></span></span>
                        <span class="skill-level">Strong</span>
                    </div>
                    <div class="skill">
                        <span class="skill-name">CSS</span>
                        <span class="skill-track"><span class="skill-fill" style="width: 85%"></span></span>
                        <span class="skill-level">Strong</span>
                    </div>
                    <div class="skill">
                        <span class="skill-name">Bootstrap</span>
                        <span class="skill-track"><span class="skill-fill" style="width: 80%"></span></span>
                        <span class="skill-level">Good</span>
                    </div>
                    <div class="skill">
                        <span class="skill-name">JavaScript</span>
                        <span class="skill-track"><span class="skill-fill" style="width: 70%"></span></span>
                        <span class="skill-level">Good</span>
                    </div>
                    <div class="skill">
                        <span class="skill-name">PHP</span>
                        <span class="skill-track"><span class="skill-fill" style="width: 55%"></span></span>
                        <span class="skill-level">Learning</span>
                    </div>
                    <div class="skill">
                        <span class="skill-name">MySQL</span>
                        <span class="skill-track"><span class="skill-fill" style="width: 50%"></span></span>
                        <span class="skill-level">Learning</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="block" id="projects">
    <div class="container">
        <div class="block-head">
            <span class="block-num">03</span>
            <h2>Projects</h2>
            <span class="aside">Two builds &middot; one idea</span>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <article class="project">
                    <div class="project-top">
                        <span class="project-num">01</span>
                        <span class="project-kind">Frontend<br>Static pages</span>
                    </div>
                    <div class="project-body">
                        <div class="chips">
                            <span class="chip">HTML</span>
                            <span class="chip">CSS</span>
                            <span class="chip">JavaScript</span>
                        </div>
                        <h3>Portfolio with HTML, CSS &amp; JS</h3>
                        <p>
                            A personal portfolio built with semantic HTML, a responsive CSS layout and a
                            little JavaScript for small interactions. This is where I practised structure,
                            spacing and readable design.
                        </p>
                        <div class="project-foot">Frontend build &middot; HTML &middot; CSS &middot; JS</div>
                    </div>
                </article>
            </div>
            <div class="col-md-6">
                <article class="project">
                    <div class="project-top">
                        <span class="project-num">02</span>
                        <span class="project-kind">Backend<br>Form &rarr; database</span>
                    </div>
                    <div class="project-body">
                        <div class="chips">
                            <span class="chip">PHP</span>
                            <span class="chip">MySQL</span>
                            <span class="chip">Bootstrap</span>
                        </div>
                        <h3>Portfolio with PHP &amp; MySQL</h3>
                        <p>
                            The same portfolio turned dynamic. A working say-hi form is checked in PHP,
                            saved into a MySQL table and read back on a separate messages page.
                        </p>
                        <div class="project-foot">Backend build &middot; PHP &middot; MySQL &middot; Bootstrap</div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="block" id="contact">
    <div class="container">
        <div class="block-head">
            <span class="block-num">04</span>
            <h2>Say hi</h2>
            <span class="aside">Saved in MySQL</span>
        </div>
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="contact-dark">
                    <span class="mono">Contact</span>
                    <h2>Send a short message.</h2>
                    <p>
                        Write a hello and it goes straight into my database. Every message shows up on the
                        messages page, so you can watch the whole loop work.
                    </p>
                    <div class="steps">
                        <div class="step"><b>01</b><span>You fill in the form.</span></div>
                        <div class="step"><b>02</b><span>PHP checks the input and saves it.</span></div>
                        <div class="step"><b>03</b><span>It appears in the message inbox.</span></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="form-card">
                    <?php if ($dbError): ?>
                        <div class="notice bad"><?= e($dbError) ?></div>
                    <?php endif; ?>

                    <?php if ($sent): ?>
                        <div class="notice ok">
                            Thanks. Your message is saved &mdash; <a href="messages.php">open the inbox</a>.
                        </div>
                    <?php endif; ?>

                    <?php if ($errors): ?>
                        <div class="notice bad">
                            Please check the form:
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= e($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="index.php#contact" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="field">
                                    <label for="name">Your name</label>
                                    <input type="text" id="name" name="name" maxlength="80" placeholder="e.g. Aayush" value="<?= e($formName) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field">
                                    <label for="email">Email address</label>
                                    <input type="email" id="email" name="email" maxlength="120" placeholder="you@example.com" value="<?= e($formEmail) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" maxlength="1000" placeholder="Hi <?= e($studentName) ?>, I liked your portfolio..."><?= e($formMessage) ?></textarea>
                            <div class="hint mt-2">Up to 1000 characters</div>
                        </div>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <button class="btn-flat" type="submit">Send message</button>
                            <span class="hint">No spam, just a hello</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="container">
        <div class="footer-in">
            <span>&copy; <?= date('Y') ?> <?= e($studentName) ?> &middot; Grade 12 portfolio</span>
            <div class="d-flex gap-4">
                <a href="messages.php">Messages</a>
                <a href="#home">Back to top</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
