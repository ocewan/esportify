// Newsletter form (exemple de logique front)
document.getElementById("newsletter-form").addEventListener("submit", (e) => {
  e.preventDefault();
  const email = document.getElementById("email").value;
  console.log("Inscription à la newsletter :", email);
});
