<?php
// preview_cv.php
// Render ATS-friendly CV from POST data. Simple sanitization with htmlspecialchars.
function safe($v)
{
    return htmlspecialchars(trim((string)$v));
}

$post = $_POST; // shorthand

// Helper to map arrays safely
function getArr($key)
{
    global $post;
    if (!isset($post[$key])) return [];
    return $post[$key];
}

$full_name = safe($post['full_name'] ?? '');
$job_title = safe($post['job_title'] ?? '');
$email = safe($post['email'] ?? '');
$phone = safe($post['phone'] ?? '');
$location = safe($post['location'] ?? '');
$linkedin = safe($post['linkedin'] ?? '');
$github = safe($post['github'] ?? '');
$summary = safe($post['summary'] ?? '');

// arrays:
$skills = array_filter(array_map('trim', getArr('skills')));
$exp_company = getArr('exp_company'); // arrays parallel
$exp_title = getArr('exp_title');
$exp_start = getArr('exp_start');
$exp_end = getArr('exp_end');
$exp_location = getArr('exp_location');
$exp_description = getArr('exp_description');

$edu_degree = getArr('edu_degree');
$edu_school = getArr('edu_school');
$edu_start = getArr('edu_start');
$edu_end = getArr('edu_end');
$edu_location = getArr('edu_location');

$proj_name = getArr('proj_name');
$proj_tech = getArr('proj_tech');
$proj_desc = getArr('proj_desc');
$proj_link = getArr('proj_link');

$certs = getArr('cert_name');
$langs = getArr('lang_name');
$lang_levels = getArr('lang_level');

$ach = getArr('ach_name');
$ints = getArr('interest');

$ref_name = getArr('ref_name');
$ref_position = getArr('ref_position');
$ref_contact = getArr('ref_contact');

$custom_titles = getArr('custom_title');
$custom_content = getArr('custom_content');

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= safe($full_name ?: 'Generated CV') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= '../assets/css/preview_cv.css' ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

</head>

<body>
    <div class="d-flex justify-content-between mb-3 no-print">
        <div>
            <a href="./home.php" class="btn btn-outline-secondary btn-sm">↩ Back to editor</a>
        </div>
        <div>
            <button id="btnPrint" class="btn btn-primary btn-sm">Download / Print PDF</button>
            <button id="themeToggle" class="btn btn-light btn-sm">🌙</button>
        </div>
    </div>
    <div class="cv-wrap">
        <div class="header">
            <div>
                <div class="name"><?= safe($full_name) ?></div>
                <?php if ($job_title): ?><div class="title"><?= safe($job_title) ?></div><?php endif; ?>
            </div>
            <div class="text-end contact">
                <?php if ($email): ?><?= safe($email) ?><br><?php endif; ?>
            <?php if ($phone): ?><?= safe($phone) ?><br><?php endif; ?>
        <?php if ($location): ?><?= safe($location) ?><br><?php endif; ?>
    <?php if ($linkedin): ?><a href="<?= safe($linkedin) ?>" target="_blank"><?= safe($linkedin) ?></a><br><?php endif; ?>
    <?php if ($github): ?><a href="<?= safe($github) ?>" target="_blank"><?= safe($github) ?></a><?php endif; ?>
            </div>
        </div>

        <hr>

        <?php if ($summary): ?>
            <div class="section">
                <h3>Professional Summary</h3>
                <div class="muted"><?= nl2br(safe($summary)) ?></div>
            </div>
        <?php endif; ?>

        <?php if (count($skills)): ?>
            <div class="section">
                <h3>Skills</h3>
                <div class="muted"><?= implode(', ', array_map('htmlspecialchars', $skills)) ?></div>
            </div>
        <?php endif; ?>

        <?php
        // EXPERIENCE — list only non-empty roles
        $hasExp = false;
        foreach ($exp_title as $i => $_) {
            $c = trim($exp_title[$i] ?? '') . trim($exp_company[$i] ?? '');
            if ($c != '') {
                $hasExp = true;
                break;
            }
        }
        if ($hasExp): ?>
            <div class="section">
                <h3>Experience</h3>
                <?php
                for ($i = 0; $i < count($exp_title); $i++):
                    $title = safe($exp_title[$i] ?? '');
                    $company = safe($exp_company[$i] ?? '');
                    $start = safe($exp_start[$i] ?? '');
                    $end = safe($exp_end[$i] ?? '');
                    $loc = safe($exp_location[$i] ?? '');
                    $desc = safe($exp_description[$i] ?? '');
                    if (!$title && !$company) continue;
                ?>
                    <div class="mb-2">
                        <div style="font-weight:600;"><?= $title ?><?= $company ? " — $company" : '' ?></div>
                        <div class="muted" style="font-size:13px"><?= $start ?> <?= $start || $end ? "•" : "" ?> <?= $end ?> <?= $loc ? "• $loc" : "" ?></div>
                        <?php if ($desc):
                            // support semicolon separated bullets
                            $bullets = array_filter(array_map('trim', explode(';', $desc)));
                        ?>
                            <ul>
                                <?php foreach ($bullets as $b): ?>
                                    <li><?= safe($b) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

        <?php
        // EDUCATION
        $hasEdu = false;
        foreach ($edu_degree as $i => $v) {
            if (trim($v) != '' || trim($edu_school[$i] ?? '') != '') {
                $hasEdu = true;
                break;
            }
        }
        if ($hasEdu): ?>
            <div class="section">
                <h3>Education</h3>
                <?php for ($i = 0; $i < count($edu_degree); $i++):
                    $deg = safe($edu_degree[$i] ?? '');
                    $sch = safe($edu_school[$i] ?? '');
                    $st = safe($edu_start[$i] ?? '');
                    $en = safe($edu_end[$i] ?? '');
                    if (!$deg && !$sch) continue;
                ?>
                    <div class="mb-2">
                        <div style="font-weight:600;"><?= $deg ?><?= $sch ? " — $sch" : '' ?></div>
                        <div class="muted"><?= $st ?> <?= $st || $en ? "•" : "" ?> <?= $en ?></div>
                    </div>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

        <?php
        // PROJECTS
        $hasProj = false;
        foreach ($proj_name as $i => $v) {
            if (trim($v) != '') {
                $hasProj = true;
                break;
            }
        }
        if ($hasProj): ?>
            <div class="section">
                <h3>Projects</h3>
                <?php for ($i = 0; $i < count($proj_name); $i++):
                    $pn = safe($proj_name[$i] ?? '');
                    if (!$pn) continue;
                    $pt = safe($proj_tech[$i] ?? '');
                    $pd = safe($proj_desc[$i] ?? '');
                    $pl = safe($proj_link[$i] ?? '');
                ?>
                    <div class="mb-2">
                        <div style="font-weight:600;"><?= $pn ?> <?= $pl ? "• <a href='$pl' target='_blank'>$pl</a>" : '' ?></div>
                        <div class="muted"><?= $pt ?></div>
                        <?php if ($pd): ?><div><?= nl2br($pd) ?></div><?php endif; ?>
                    </div>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

        <?php if (count(array_filter($certs))): ?>
            <div class="section">
                <h3>Certifications</h3>
                <ul>
                    <?php foreach ($certs as $c) {
                        if (trim($c) == '') continue;
                        echo "<li>" . safe($c) . "</li>";
                    } ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php
        // LANGUAGES
        $langsList = [];
        for ($i = 0; $i < count($langs); $i++) {
            $n = trim($langs[$i] ?? '');
            $lev = trim($lang_levels[$i] ?? '');
            if ($n === '') continue;
            $langsList[] = safe($n) . ($lev ? " ($lev)" : "");
        }
        if (count($langsList)):
        ?>
            <div class="section">
                <h3>Languages</h3>
                <div class="muted"><?= implode(', ', $langsList) ?></div>
            </div>
        <?php endif; ?>

        <?php if (count(array_filter($ach))): ?>
            <div class="section">
                <h3>Achievements</h3>
                <ul><?php foreach ($ach as $a) {
                        if (trim($a) == '') continue;
                        echo "<li>" . safe($a) . "</li>";
                    } ?></ul>
            </div>
        <?php endif; ?>

        <?php if (count(array_filter($ints))): ?>
            <div class="section">
                <h3>Interests</h3>
                <div class="muted"><?= implode(', ', array_map('htmlspecialchars', array_filter($ints))) ?></div>
            </div>
        <?php endif; ?>

        <?php
        if (count(array_filter($ref_name))):
        ?>
            <div class="section">
                <h3>References</h3>
                <?php for ($i = 0; $i < count($ref_name); $i++) {
                    if (trim($ref_name[$i]) == '') continue;
                    echo "<div style='margin-bottom:8px;'><strong>" . safe($ref_name[$i]) . "</strong> — " . safe($ref_position[$i] ?? '') . " • " . safe($ref_contact[$i] ?? '') . "</div>";
                } ?>
            </div>
        <?php endif; ?>

        <?php
        // Custom sections
        for ($i = 0; $i < count($custom_titles); $i++) {
            $t = trim($custom_titles[$i] ?? '');
            $c = trim($custom_content[$i] ?? '');
            if ($t == '' && $c == '') continue;
            echo "<div class='section'><h3>" . safe($t ?: 'Additional') . "</h3><div class='muted'>" . nl2br(safe($c)) . "</div></div>";
        }
        ?>

    </div>
    <script src="../assets/scripts/cv_preview.js"></script>
</body>

</html>