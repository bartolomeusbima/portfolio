<article class="blog-post-copy" data-init-blog-article="content">
    <?php foreach ($sections as $section): ?>
        <section class="blog-post-copy-block">
            <h2 class="blog-post-section-title" data-en="<?php echo htmlspecialchars($section['mbd_title_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?php echo htmlspecialchars($section['mbd_title_id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($section['mbd_title_en'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <p data-en="<?php echo htmlspecialchars($section['mbd_body_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?php echo htmlspecialchars($section['mbd_body_id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($section['mbd_body_en'], ENT_QUOTES, 'UTF-8'); ?></p>
        </section>
    <?php endforeach; ?>
</article>
