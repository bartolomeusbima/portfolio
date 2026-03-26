window.addEventListener('DOMContentLoaded', function() {
    const reveal = window.PortfolioReveal;
    const heroPrimary = document.querySelector('[data-init="hero-primary"]');
    const heroSecondary = document.querySelector('[data-init="hero-secondary"]');
    const prompts = document.querySelectorAll('[data-init="prompt"]');
    const heroNote = document.querySelector('[data-init="hero-note"]');

    reveal.setInitialState(heroPrimary, 'translateY(16px) scale(0.985)');
    reveal.setInitialState(heroSecondary, 'translateY(14px)');
    prompts.forEach(function(prompt) {
        reveal.setInitialState(prompt, 'translateY(18px)');
    });
    reveal.setInitialState(heroNote, 'translateY(14px)');

    reveal.revealElement(heroPrimary, 80, {
        keyframes: [
            { opacity: 0, transform: 'translateY(16px) scale(0.985)', filter: 'blur(8px)' },
            { opacity: 1, transform: 'translateY(0) scale(1)', filter: 'blur(0px)' }
        ],
        options: {
            duration: 680
        }
    });

    reveal.revealElement(heroSecondary, 220, {
        keyframes: [
            { opacity: 0, transform: 'translateY(14px)', filter: 'blur(8px)' },
            { opacity: 1, transform: 'translateY(0)', filter: 'blur(0px)' }
        ]
    });

    prompts.forEach(function(prompt, index) {
        reveal.revealElement(prompt, 360 + (index * 90), {
            keyframes: [
                { opacity: 0, transform: 'translateY(18px)', filter: 'blur(8px)' },
                { opacity: 1, transform: 'translateY(0)', filter: 'blur(0px)' }
            ],
            options: {
                duration: 560
            }
        });
    });

    reveal.revealElement(heroNote, 700, {
        keyframes: [
            { opacity: 0, transform: 'translateY(14px)', filter: 'blur(8px)' },
            { opacity: 1, transform: 'translateY(0)', filter: 'blur(0px)' }
        ],
        options: {
            duration: 520
        }
    });
});
