document.getElementById("btnPrint").addEventListener("click", () => {
  const element = document.querySelector(".cv-wrap");
  const opt = {
    margin: 0.5,
    filename: '<?= safe($full_name ?: "cv") ?>.pdf',
    image: {
      type: "jpeg",
      quality: 0.98,
    },
    html2canvas: {
      scale: 2,
    },
    jsPDF: {
      unit: "in",
      format: "a4",
      orientation: "portrait",
    },
  };
  html2pdf().set(opt).from(element).save();
});

// theme toggle for preview page
const themeToggle = document.getElementById("themeToggle");
if (localStorage.getItem("theme") === "dark") {
  document.body.classList.add("dark-mode");
  themeToggle.textContent = "☀️";
}
themeToggle.addEventListener("click", () => {
  document.body.classList.toggle("dark-mode");
  const isDark = document.body.classList.contains("dark-mode");
  themeToggle.textContent = isDark ? "☀️" : "🌙";
  localStorage.setItem("theme", isDark ? "dark" : "light");
});
