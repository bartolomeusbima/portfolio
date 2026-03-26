(function () {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const defaultKeyframes = [
        { opacity: 0, transform: 'translateY(20px)', filter: 'blur(8px)' },
        { opacity: 1, transform: 'translateY(0)', filter: 'blur(0px)' }
    ];
    const defaultOptions = {
        duration: 620,
        easing: 'cubic-bezier(0.22, 1, 0.36, 1)',
        fill: 'forwards'
    };

    function resetElementStyles(element) {
        element.style.opacity = '1';
        element.style.transform = 'none';
        element.style.filter = 'none';
    }

    function setInitialState(element, transformValue) {
        if (!element) {
            return;
        }

        if (prefersReducedMotion) {
            resetElementStyles(element);
            return;
        }

        element.style.opacity = '0';
        element.style.transform = transformValue;
        element.style.filter = 'blur(8px)';
    }

    function revealElement(element, delay, config) {
        if (!element) {
            return;
        }

        if (prefersReducedMotion) {
            resetElementStyles(element);
            return;
        }

        const revealConfig = config || {};
        const keyframes = revealConfig.keyframes || defaultKeyframes;
        const options = Object.assign({}, defaultOptions, revealConfig.options || {}, { delay: delay || 0 });
        const animation = element.animate(keyframes, options);

        animation.onfinish = function () {
            resetElementStyles(element);
        };
    }

    function revealSequence(elements, baseDelay, stepDelay, config) {
        Array.from(elements || []).forEach(function (element, index) {
            revealElement(element, (baseDelay || 0) + (index * (stepDelay || 0)), config);
        });
    }

    window.PortfolioReveal = {
        prefersReducedMotion: prefersReducedMotion,
        revealElement: revealElement,
        revealSequence: revealSequence,
        setInitialState: setInitialState
    };
})();
