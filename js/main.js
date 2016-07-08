window.$ = function(selektor) {
  return document.querySelector(selektor);
};

window.$$ = function(selektor) {
  return document.querySelectorAll(selektor);
};
