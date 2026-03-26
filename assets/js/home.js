const cards = document.querySelectorAll('[data-card]');

cards.forEach(function(card) {
    card.addEventListener('mouseenter', function() {
        cards.forEach(function(item) {
            item.classList.remove('is-active');
        });

        card.classList.add('is-active');
    });

    card.addEventListener('mouseleave', function() {
        card.classList.remove('is-active');
    });
});
