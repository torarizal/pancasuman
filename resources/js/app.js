// UI Micro-interactions & Helpers
document.addEventListener('DOMContentLoaded', () => {
    // 1. Mobile Navigation Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            const isExpanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
            mobileMenuBtn.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('hidden');
        });
    }

    // 2. Share / Copy Link Helper
    window.copyArticleLink = async function(button) {
        try {
            const url = window.location.href;
            await navigator.clipboard.writeText(url);
            
            // Show feedback
            const originalHTML = button.innerHTML;
            button.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-emerald-700 font-semibold">Tersalin!</span>
            `;
            button.classList.add('bg-emerald-50', 'border-emerald-200');

            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.remove('bg-emerald-50', 'border-emerald-200');
            }, 2500);
        } catch (err) {
            console.error('Failed to copy: ', err);
        }
    };

    // 3. Back to Top Button
    const backToTopBtn = document.getElementById('back-to-top');
    if (backToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backToTopBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
                backToTopBtn.classList.add('opacity-100', 'translate-y-0');
            } else {
                backToTopBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
                backToTopBtn.classList.remove('opacity-100', 'translate-y-0');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});

