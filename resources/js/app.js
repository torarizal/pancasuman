// UI Micro-interactions & Helpers
document.addEventListener('DOMContentLoaded', () => {
    // ==========================================
    // 1. Public Mobile Navigation Toggle
    // ==========================================
    const mobileMenuBtn = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const hamburgerIcon = document.getElementById('mobile-menu-icon-hamburger');
    const closeIcon = document.getElementById('mobile-menu-icon-close');

    if (mobileMenuBtn && mobileMenu) {
        const togglePublicMenu = (expand) => {
            const shouldExpand = expand !== undefined ? expand : mobileMenu.classList.contains('hidden');
            if (shouldExpand) {
                mobileMenu.classList.remove('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'true');
                if (hamburgerIcon) hamburgerIcon.classList.add('hidden');
                if (closeIcon) closeIcon.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
                if (hamburgerIcon) hamburgerIcon.classList.remove('hidden');
                if (closeIcon) closeIcon.classList.add('hidden');
            }
        };

        mobileMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            togglePublicMenu();
        });

        // Close when clicking outside of navbar
        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                togglePublicMenu(false);
            }
        });

        // Close on window resize if viewport is desktop (>= 1024px)
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                togglePublicMenu(false);
            }
        });
    }

    // ==========================================
    // 2. Admin Panel Mobile Drawer Toggle
    // ==========================================
    const adminSidebarToggle = document.getElementById('admin-sidebar-toggle');
    const adminMobileDrawer = document.getElementById('admin-mobile-drawer');
    const adminSidebarBackdrop = document.getElementById('admin-sidebar-backdrop');
    const adminSidebarClose = document.getElementById('admin-sidebar-close');

    if (adminMobileDrawer && adminSidebarToggle) {
        const openAdminDrawer = () => {
            adminMobileDrawer.classList.remove('-translate-x-full');
            if (adminSidebarBackdrop) adminSidebarBackdrop.classList.remove('hidden');
        };

        const closeAdminDrawer = () => {
            adminMobileDrawer.classList.add('-translate-x-full');
            if (adminSidebarBackdrop) adminSidebarBackdrop.classList.add('hidden');
        };

        adminSidebarToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            openAdminDrawer();
        });

        if (adminSidebarClose) {
            adminSidebarClose.addEventListener('click', closeAdminDrawer);
        }

        if (adminSidebarBackdrop) {
            adminSidebarBackdrop.addEventListener('click', closeAdminDrawer);
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                closeAdminDrawer();
            }
        });
    }

    // ==========================================
    // 3. Developer Console Mobile Drawer Toggle
    // ==========================================
    const devSidebarToggle = document.getElementById('dev-sidebar-toggle');
    const devMobileDrawer = document.getElementById('dev-mobile-drawer');
    const devSidebarBackdrop = document.getElementById('dev-sidebar-backdrop');
    const devSidebarClose = document.getElementById('dev-sidebar-close');

    if (devMobileDrawer && devSidebarToggle) {
        const openDevDrawer = () => {
            devMobileDrawer.classList.remove('-translate-x-full');
            if (devSidebarBackdrop) devSidebarBackdrop.classList.remove('hidden');
        };

        const closeDevDrawer = () => {
            devMobileDrawer.classList.add('-translate-x-full');
            if (devSidebarBackdrop) devSidebarBackdrop.classList.add('hidden');
        };

        devSidebarToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            openDevDrawer();
        });

        if (devSidebarClose) {
            devSidebarClose.addEventListener('click', closeDevDrawer);
        }

        if (devSidebarBackdrop) {
            devSidebarBackdrop.addEventListener('click', closeDevDrawer);
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                closeDevDrawer();
            }
        });
    }

    // ==========================================
    // 4. Share / Copy Link Helper
    // ==========================================
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

    // ==========================================
    // 5. Back to Top Button
    // ==========================================
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

    // ==========================================
    // 6. Dark Mode / Theme Switcher
    // ==========================================
    const themeToggleBtn = document.getElementById('theme-toggle');
    const mobileThemeToggleBtn = document.getElementById('mobile-theme-toggle');
    const adminThemeToggleBtn = document.getElementById('admin-theme-toggle');
    const mobileThemeStatusText = document.getElementById('mobile-theme-status-text');

    const updateThemeUI = (isDark) => {
        if (mobileThemeToggleBtn) {
            mobileThemeToggleBtn.setAttribute('aria-checked', isDark ? 'true' : 'false');
        }
        if (mobileThemeStatusText) {
            mobileThemeStatusText.textContent = isDark ? 'Mode Gelap' : 'Mode Terang';
        }
        if (themeToggleBtn) {
            themeToggleBtn.setAttribute('aria-label', isDark ? 'Beralih ke mode terang' : 'Beralih ke mode gelap');
            themeToggleBtn.setAttribute('title', isDark ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap');
        }
        if (adminThemeToggleBtn) {
            adminThemeToggleBtn.setAttribute('aria-label', isDark ? 'Beralih ke mode terang' : 'Beralih ke mode gelap');
            adminThemeToggleBtn.setAttribute('title', isDark ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap');
        }
    };

    const toggleTheme = () => {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        updateThemeUI(isDark);
    };

    // Initial state sync based on active document class
    const initialIsDark = document.documentElement.classList.contains('dark');
    updateThemeUI(initialIsDark);

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            toggleTheme();
        });
    }

    if (mobileThemeToggleBtn) {
        mobileThemeToggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            toggleTheme();
        });
    }

    if (adminThemeToggleBtn) {
        adminThemeToggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            toggleTheme();
        });
    }

    // System theme change listener (only applies if no manual preference has been set)
    try {
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        mediaQuery.addEventListener('change', (e) => {
            if (!localStorage.getItem('theme')) {
                if (e.matches) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
                updateThemeUI(e.matches);
            }
        });
    } catch (err) {
        // Fallback for older browsers
    }
});
