import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/* =========================
   BURGER MENU
========================= */

document.addEventListener("DOMContentLoaded", () => {
  setupBurgerMenu();
});

const setupBurgerMenu = () => {
  const menuToggle = document.getElementById("menuToggle");
  const navMenu = document.getElementById("navMenu");

  if (!menuToggle || !navMenu) return;

  menuToggle.addEventListener("click", (event) => {
    event.stopPropagation();
    menuToggle.classList.toggle("active");
    navMenu.classList.toggle("show");
  });

  navMenu.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", () => {
      menuToggle.classList.remove("active");
      navMenu.classList.remove("show");
    });
  });

  document.addEventListener("click", (event) => {
    const isClickInsideMenu = navMenu.contains(event.target);
    const isClickToggle = menuToggle.contains(event.target);

    if (!isClickInsideMenu && !isClickToggle) {
      menuToggle.classList.remove("active");
      navMenu.classList.remove("show");
    }
  });
};

/* =========================
   COOKIE HELPER
========================= */

window.setCookie = function (name, value, days = 30) {
  const date = new Date();
  date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);

  const expires = "expires=" + date.toUTCString();

  document.cookie =
    name + "=" + encodeURIComponent(value) + ";" + expires + ";path=/";
};

window.getCookie = function (name) {
  const cookieName = name + "=";
  const decodedCookie = decodeURIComponent(document.cookie);
  const cookieArray = decodedCookie.split(";");

  for (let i = 0; i < cookieArray.length; i++) {
    let cookie = cookieArray[i].trim();

    if (cookie.indexOf(cookieName) === 0) {
      return cookie.substring(cookieName.length, cookie.length);
    }
  }

  return "";
};

window.deleteCookie = function (name) {
  document.cookie =
    name + "=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;";
};

/* =========================
   THEME TOGGLE BUTTON
========================= */

document.addEventListener("DOMContentLoaded", () => {
  const themeToggleButton = document.getElementById("themeToggleButton");
  const themeToggleIcon = document.getElementById("themeToggleIcon");

  if (!themeToggleButton || !themeToggleIcon) return;

  function updateThemeIcon() {
    const isDark = document.documentElement.classList.contains("dark");
    themeToggleIcon.textContent = isDark ? "☀️" : "🌙";
  }

  themeToggleButton.addEventListener("click", () => {
    const htmlElement = document.documentElement;

    htmlElement.classList.toggle("dark");

    if (htmlElement.classList.contains("dark")) {
      setCookie("theme", "dark", 30);
    } else {
      setCookie("theme", "light", 30);
    }

    updateThemeIcon();
  });

  updateThemeIcon();
});

/* =========================
   DISPLAY PREFERENCE PAGE
========================= */

document.addEventListener("DOMContentLoaded", () => {
  const preferenceForm = document.getElementById("preferenceForm");
  const themePreference = document.getElementById("themePreference");
  const fontPreference = document.getElementById("fontPreference");
  const preferenceMessage = document.getElementById("preferenceMessage");
  const resetPreferenceButton = document.getElementById("resetPreferenceButton");

  function applyTheme(theme) {
    const htmlElement = document.documentElement;

    htmlElement.classList.remove("dark");

    if (theme === "dark") {
      htmlElement.classList.add("dark");
    }

    if (theme === "system") {
      const systemDark = window.matchMedia("(prefers-color-scheme: dark)").matches;

      if (systemDark) {
        htmlElement.classList.add("dark");
      }
    }
  }

  function applyFontSize(fontSize) {
    const htmlElement = document.documentElement;

    htmlElement.classList.remove("font-small", "font-normal", "font-large");

    if (fontSize === "small") {
      htmlElement.classList.add("font-small");
    } else if (fontSize === "large") {
      htmlElement.classList.add("font-large");
    } else {
      htmlElement.classList.add("font-normal");
    }
  }

  function syncPreferenceForm() {
    const savedTheme = getCookie("theme") || "light";
    const savedFontSize = getCookie("font_size") || "normal";

    if (themePreference) {
      themePreference.value = savedTheme;
    }

    if (fontPreference) {
      fontPreference.value = savedFontSize;
    }

    applyTheme(savedTheme);
    applyFontSize(savedFontSize);
  }

  syncPreferenceForm();

  if (themePreference) {
    themePreference.addEventListener("change", () => {
      applyTheme(themePreference.value);
    });
  }

  if (fontPreference) {
    fontPreference.addEventListener("change", () => {
      applyFontSize(fontPreference.value);
    });
  }

  if (preferenceForm) {
    preferenceForm.addEventListener("submit", async (event) => {
      event.preventDefault();

      const selectedTheme = themePreference.value;
      const selectedFontSize = fontPreference.value;

      applyTheme(selectedTheme);
      applyFontSize(selectedFontSize);

      setCookie("theme", selectedTheme, 30);
      setCookie("font_size", selectedFontSize, 30);

      const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

      if (preferenceMessage) {
        preferenceMessage.textContent = "Menyimpan preferensi...";
      }

      try {
        const response = await fetch("/preferensi/simpan", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
            Accept: "application/json",
          },
          body: JSON.stringify({
            theme: selectedTheme,
            font_size: selectedFontSize,
          }),
        });

        if (!response.ok) {
          throw new Error("Gagal menyimpan preferensi.");
        }

        const result = await response.json();

        const savedTheme =
          result.data?.theme_baru || result.data?.theme || selectedTheme;

        const savedFontSize =
          result.data?.font_size_baru || result.data?.font_size || selectedFontSize;

        setCookie("theme", savedTheme, 30);
        setCookie("font_size", savedFontSize, 30);

        applyTheme(savedTheme);
        applyFontSize(savedFontSize);

        if (themePreference) {
          themePreference.value = savedTheme;
        }

        if (fontPreference) {
          fontPreference.value = savedFontSize;
        }

        if (preferenceMessage) {
          preferenceMessage.textContent =
            result.message || "Preferensi berhasil disimpan.";
        }
      } catch (error) {
        if (preferenceMessage) {
          preferenceMessage.textContent =
            "Preferensi tetap diterapkan, tetapi gagal disimpan ke server.";
        }
      }
    });
  }

  if (resetPreferenceButton) {
    resetPreferenceButton.addEventListener("click", () => {
      setCookie("theme", "light", 30);
      setCookie("font_size", "normal", 30);

      if (themePreference) {
        themePreference.value = "light";
      }

      if (fontPreference) {
        fontPreference.value = "normal";
      }

      applyTheme("light");
      applyFontSize("normal");

      if (preferenceMessage) {
        preferenceMessage.textContent =
          "Preferensi berhasil direset ke pengaturan awal.";
      }
    });
  }

  window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", () => {
    const savedTheme = getCookie("theme") || "light";

    if (savedTheme === "system") {
      applyTheme("system");
    }
  });
});
