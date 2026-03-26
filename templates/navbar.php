<?php

$navbarActivePath = $navbarActivePath ?? '/';
$navbarBackLink = $navbarBackLink ?? null;
$navbarBackLabel = $navbarBackLabel ?? 'Go back';
$navItems = [
    [
        'path' => '/',
        'label' => 'Home',
        'icon' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4.75c-4.004 0-7.25 3.246-7.25 7.25s3.246 7.25 7.25 7.25 7.25-3.246 7.25-7.25S16.004 4.75 12 4.75Zm3.355 5.992-3.704 4.75a1 1 0 0 1-1.508.08l-1.88-1.88a1 1 0 0 1 1.414-1.414l1.085 1.085 2.98-3.823a1 1 0 0 1 1.578 1.202Z"/></svg>',
    ],
    [
        'path' => '/work',
        'label' => 'Work',
        'icon' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.25 2.75 6.75 13h4l-1 8.25L17.25 11h-4l1-8.25Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.8"/></svg>',
    ],
    [
        'path' => '/blog',
        'label' => 'Blog',
        'icon' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m4.75 16.75 8.9-8.9 3.5 3.5-8.9 8.9H4.75v-3.5Zm10-10 1.4-1.4a1.98 1.98 0 0 1 2.8 2.8l-1.4 1.4-2.8-2.8Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.8"/><path d="M4.75 20.25h14.5" stroke="currentColor" stroke-linecap="round" stroke-width="1.8"/></svg>',
    ],
    [
        'path' => '/about',
        'label' => 'About',
        'icon' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="7.25" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M9.25 13.25a3 3 0 0 0 5.5 0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.8"/><path d="M9.3 10.1h.01M14.7 10.1h.01" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2.2"/></svg>',
    ],
    [
        'path' => '/contact',
        'label' => 'Contact',
        'icon' => '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3.75" y="6.25" width="16.5" height="11.5" rx="2.25" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="m5.75 8.25 6.25 4.75 6.25-4.75" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/></svg>',
    ],
];
?>
<aside class="floating-navbar" aria-label="Quick actions">
    <?php if ($navbarBackLink): ?>
        <div class="nav-back" aria-label="Back navigation">
            <a
                class="nav-button nav-back-button"
                href="<?= htmlspecialchars($navbarBackLink, ENT_QUOTES, 'UTF-8') ?>"
                aria-label="<?= htmlspecialchars($navbarBackLabel, ENT_QUOTES, 'UTF-8') ?>"
            >
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14.75 6.75 9.5 12l5.25 5.25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/></svg>
                </span>
            </a>
        </div>
    <?php endif; ?>

    <div class="nav-track">
        <?php foreach ($navItems as $index => $item): ?>
            <?php $isActive = $item['path'] === $navbarActivePath && ($navbarActivePath !== '/' || $index === 0); ?>
            <a
                class="nav-button<?= $isActive ? ' active' : '' ?>"
                href="<?= htmlspecialchars($item['path'], ENT_QUOTES, 'UTF-8') ?>"
                aria-label="<?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?>"
            >
                <span class="nav-icon"><?= $item['icon'] ?></span>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="nav-tools" aria-label="Display controls">
        <button class="nav-button nav-control" type="button" data-lang-toggle aria-label="Toggle language">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3.75a8.25 8.25 0 1 0 0 16.5 8.25 8.25 0 0 0 0-16.5Zm5.86 7.5h-2.57a13.4 13.4 0 0 0-1.07-4.12 6.78 6.78 0 0 1 3.64 4.12ZM12 5.21c.57.73 1.48 2.58 1.79 6.04h-3.58C10.52 7.79 11.43 5.94 12 5.21Zm-2.22 1.92a13.4 13.4 0 0 0-1.07 4.12H6.14a6.78 6.78 0 0 1 3.64-4.12ZM6.14 12.75h2.57c.16 1.48.53 2.88 1.07 4.12a6.78 6.78 0 0 1-3.64-4.12Zm4.07 0h3.58c-.31 3.46-1.22 5.31-1.79 6.04-.57-.73-1.48-2.58-1.79-6.04Zm4.01 4.12c.54-1.24.91-2.64 1.07-4.12h2.57a6.78 6.78 0 0 1-3.64 4.12Z"/></svg>
            </span>
            <span class="nav-control-label" data-lang-label>EN</span>
        </button>

        <button class="nav-button nav-control" type="button" data-theme-toggle aria-label="Toggle theme">
            <span class="nav-icon" data-theme-icon>
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 6.25a.75.75 0 0 1 .75.75v1.1a.75.75 0 0 1-1.5 0V7a.75.75 0 0 1 .75-.75Zm0 9.65a.75.75 0 0 1 .75.75v1.1a.75.75 0 0 1-1.5 0v-1.1a.75.75 0 0 1 .75-.75Zm5-4.4a.75.75 0 0 1 .75-.75h1.1a.75.75 0 0 1 0 1.5h-1.1a.75.75 0 0 1-.75-.75Zm-11.85 0a.75.75 0 0 1 .75-.75H7a.75.75 0 0 1 0 1.5H5.9a.75.75 0 0 1-.75-.75Zm9.02-3.27a.75.75 0 0 1 1.06 0l.78.78a.75.75 0 1 1-1.06 1.06l-.78-.78a.75.75 0 0 1 0-1.06Zm-7.95 7.95a.75.75 0 0 1 1.06 0l.78.78A.75.75 0 1 1 6 18.02l-.78-.78a.75.75 0 0 1 0-1.06Zm0-7.95a.75.75 0 0 1 0 1.06l-.78.78a.75.75 0 0 1-1.06-1.06l.78-.78a.75.75 0 0 1 1.06 0Zm7.95 7.95a.75.75 0 0 1 0 1.06l-.78.78a.75.75 0 1 1-1.06-1.06l.78-.78a.75.75 0 0 1 1.06 0ZM12 9.1a2.9 2.9 0 1 1 0 5.8 2.9 2.9 0 0 1 0-5.8Z"/></svg>
            </span>
        </button>
    </div>
</aside>
