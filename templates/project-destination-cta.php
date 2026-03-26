<?php
$projectDestination = $projectDestination ?? [];
$destinationEnabled = !empty($projectDestination['href']) && empty($projectDestination['disabled']);
$destinationLabelEn = $projectDestination['label_en'] ?? 'Visit Live Website';
$destinationLabelId = $projectDestination['label_id'] ?? 'Kunjungi Website Live';
$destinationHref = $projectDestination['href'] ?? '';
$destinationTooltipEn = $projectDestination['tooltip_en'] ?? 'This deployment lives in a protected internal environment, so public access is intentionally unavailable.';
$destinationTooltipId = $projectDestination['tooltip_id'] ?? 'Deployment ini berada di lingkungan internal yang terlindungi, sehingga akses publik memang tidak tersedia.';
?>
<div class="subtitle-meta-row">
    <img class="subtitle-meta-icon" src="/assets/images/icons/globe.svg" alt="" aria-hidden="true">
    <div class="project-destination-shell">
        <?php if ($destinationEnabled): ?>
            <a
                class="project-destination-link"
                href="<?= htmlspecialchars($destinationHref, ENT_QUOTES, 'UTF-8'); ?>"
                target="_blank"
                rel="noreferrer noopener"
                data-en="<?= htmlspecialchars($destinationLabelEn, ENT_QUOTES, 'UTF-8'); ?>"
                data-id="<?= htmlspecialchars($destinationLabelId, ENT_QUOTES, 'UTF-8'); ?>"
            ><?= htmlspecialchars($destinationLabelEn, ENT_QUOTES, 'UTF-8'); ?></a>
        <?php else: ?>
            <span
                class="project-destination-button"
                tabindex="0"
                role="button"
                aria-disabled="true"
                data-en="<?= htmlspecialchars($destinationLabelEn, ENT_QUOTES, 'UTF-8'); ?>"
                data-id="<?= htmlspecialchars($destinationLabelId, ENT_QUOTES, 'UTF-8'); ?>"
            ><?= htmlspecialchars($destinationLabelEn, ENT_QUOTES, 'UTF-8'); ?></span>
            <span class="project-destination-tooltip" role="tooltip" data-en="<?= htmlspecialchars($destinationTooltipEn, ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($destinationTooltipId, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($destinationTooltipEn, ENT_QUOTES, 'UTF-8'); ?></span>
        <?php endif; ?>
    </div>
</div>

