// Ouverture des panels
document.querySelectorAll(".ajax-link").forEach((link) => {
  link.addEventListener("click", function (e) {
    e.preventDefault();

    const url = this.dataset.url;
    const targetId = this.dataset.target;
    const panel = document.getElementById(targetId);

    const isOpen = panel.classList.contains("open");

    if (isOpen) {
      panel.classList.remove("open");
      panel.innerHTML = "";
      return;
    }

    fetch(url)
      .then((res) => res.text())
      .then((html) => {
        panel.innerHTML = html;
        panel.classList.add("open");
      })
      .catch((err) => {
        panel.innerHTML = "<p>Erreur de chargement</p>";
        panel.classList.add("open");
        console.error(err);
      });
  });
});
