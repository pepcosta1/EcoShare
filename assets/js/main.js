// assets/js/main.js

let themeBtn = document.getElementById("theme-toggle");

themeBtn.addEventListener("click", function () {
  //agafa el tema actual del body
  const temaActual = document.body.getAttribute("data-theme");

  if (temaActual === "dark") {
    document.body.setAttribute("data-theme", "light");
  } else {
    document.body.setAttribute("data-theme", "dark");
  }

  //Guarda el nou tema en una cookie, dura 1any
  const nouTema = document.body.getAttribute("data-theme");
  document.cookie = `theme=${nouTema}; path=/; max-age=${60 * 60 * 24 * 365}`;
});

