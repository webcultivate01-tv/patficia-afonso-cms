// Mobile menu with right-side slide and overlay
const hamburger = document.getElementById("hamburger");
const mobileMenu = document.getElementById("mobileMenu");
const menuOverlay = document.createElement("div");
menuOverlay.className = "menu-overlay";
document.body.appendChild(menuOverlay);

hamburger.addEventListener("click", () => {
  mobileMenu.classList.toggle("open");
  menuOverlay.classList.toggle("active");
});

menuOverlay.addEventListener("click", () => {
  mobileMenu.classList.remove("open");
  menuOverlay.classList.remove("active");
});

// Close menu on link click
mobileMenu.querySelectorAll("a").forEach((link) => {
  link.addEventListener("click", () => {
    mobileMenu.classList.remove("open");
    menuOverlay.classList.remove("active");
  });
});
