function splitAtRoot(path) {
  const url = new URL(path, location.origin);
  const pathFromRoot = url.pathname;
  return pathFromRoot;
}

function setNav(current_path) {
  current_path = splitAtRoot(current_path);

  fetch("nav.html")
    .then(r => r.text())
    .then(html => {
      const navElement = document.getElementById("main-nav");
      navElement.innerHTML = html;
      const navLinks = navElement.querySelectorAll("a");
      for (let child of navLinks) {
        if (child instanceof HTMLAnchorElement) {
          if (splitAtRoot(child.href) === current_path) {
            child.classList.add("current_page");
          }
        }
      }
    });
}

document.addEventListener("DOMContentLoaded", () => {
  const current_path = location.pathname;
  setNav(current_path);
});