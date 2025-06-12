// Ouverture des panels
// Chargement des panels AJAX pour le tableau de bord
document.addEventListener("DOMContentLoaded", function () {
  // cibler les liens AJAX du dashboard
  document.querySelectorAll(".ajax-link").forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();

      const url = this.dataset.url;
      const targetId = this.dataset.target;
      const panel = document.getElementById(targetId);

      const isOpen = panel.classList.contains("open");

      // si déjà ouvert, on ferme
      if (isOpen) {
        panel.replaceChildren();
        panel.classList.remove("open");
        return;
      }

      // sinon, on charge le contenu
      fetch(url)
        .then((res) => res.text())
        .then((html) => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, "text/html");
          const content = doc.body.firstChild;

          panel.replaceChildren();
          if (content) {
            panel.appendChild(content);
          } else {
            const errorText = document.createTextNode("Aucun contenu.");
            panel.appendChild(errorText);
          }

          panel.classList.add("open");
        })
        .catch((err) => {
          panel.replaceChildren();
          const errText = document.createTextNode("Erreur de chargement");
          panel.appendChild(errText);
          panel.classList.add("open");
          console.error(err);
        });
    });
  });
});
