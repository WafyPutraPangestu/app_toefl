import "./bootstrap";
import Alpine from "alpinejs";
import collapse from '@alpinejs/collapse'; 

Alpine.plugin(collapse);

window.Alpine = Alpine;
Alpine.start();

// Enhanced Alpine.js untuk navigation
document.addEventListener("alpine:init", () => {
    // Dark mode persistence dan system preference detection
    const theme = localStorage.getItem("theme");
    const systemPrefersDark = window.matchMedia(
        "(prefers-color-scheme: dark)"
    ).matches;

    if (theme === "dark" || (!theme && systemPrefersDark)) {
        document.documentElement.classList.add("dark");
    }

    // Listen untuk system theme changes
    window
        .matchMedia("(prefers-color-scheme: dark)")
        .addEventListener("change", (e) => {
            if (!localStorage.getItem("theme")) {
                document.documentElement.classList.toggle("dark", e.matches);
            }
        });

    // Close mobile menu on route changes (untuk SPA-like behavior)
    if (typeof window.addEventListener === "function") {
        window.addEventListener("popstate", () => {
            // Reset mobile menu state
            if (window.Alpine && window.Alpine.store) {
                const navStore = window.Alpine.store("navigation");
                if (navStore) navStore.mobileMenuOpen = false;
            }
        });
    }

    // Enhanced touch gestures untuk mobile
    let startX = 0;
    let currentX = 0;
    let menuOpen = false;

    document.addEventListener("touchstart", (e) => {
        startX = e.touches[0].clientX;
        menuOpen = document.querySelector("[x-data]").__x.$data.mobileMenuOpen;
    });

    document.addEventListener("touchmove", (e) => {
        if (!menuOpen) return;
        currentX = e.touches[0].clientX;
        const diffX = startX - currentX;

        // Close menu dengan swipe left gesture
        if (diffX > 50 && startX < 320) {
            document.querySelector("[x-data]").__x.$data.mobileMenuOpen = false;
        }
    });
});
