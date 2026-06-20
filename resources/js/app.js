const themeStorageKey = "autoshop-theme";

const applyTheme = (theme) => {
    document.documentElement.classList.toggle("dark", theme === "dark");
    document.documentElement.dataset.theme = theme;
    localStorage.setItem(themeStorageKey, theme);
};

const initializeTheme = () => {
    const storedTheme = localStorage.getItem(themeStorageKey);
    const preferredTheme = window.matchMedia("(prefers-color-scheme: dark)")
        .matches
        ? "dark"
        : "light";
    applyTheme(storedTheme || preferredTheme);
};

const initializeSidebar = () => {
    const sidebar = document.querySelector("[data-sidebar]");
    const backdrop = document.querySelector("[data-sidebar-backdrop]");
    const toggle = document.querySelector("[data-sidebar-toggle]");

    if (!sidebar || !backdrop || !toggle) return;

    const setOpenState = (isOpen) => {
        sidebar.dataset.open = isOpen ? "true" : "false";
        sidebar.classList.toggle("translate-x-0", isOpen);
        sidebar.classList.toggle("-translate-x-full", !isOpen);
        backdrop.classList.toggle("pointer-events-none", !isOpen);
        backdrop.classList.toggle("opacity-0", !isOpen);
    };

    toggle.addEventListener("click", () =>
        setOpenState(sidebar.dataset.open !== "true"),
    );
    backdrop.addEventListener("click", () => setOpenState(false));
    setOpenState(false);
};

const initializeThemeToggle = () => {
    const toggle = document.querySelector("[data-theme-toggle]");
    if (!toggle) return;

    toggle.addEventListener("click", () => {
        const nextTheme = document.documentElement.classList.contains("dark")
            ? "light"
            : "dark";
        applyTheme(nextTheme);
    });
};

// Apply theme immediately to avoid flash
initializeTheme();

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", () => {
        initializeSidebar();
        initializeThemeToggle();
    });
} else {
    initializeSidebar();
    initializeThemeToggle();
}
