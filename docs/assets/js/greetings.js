document.addEventListener("DOMContentLoaded", function() {
  const oraCorrente = new Date().getHours();
  const salutoUtente = document.getElementById("saluto");
  let saluto;
  if (oraCorrente >= 5 && oraCorrente < 12) {
    saluto = "Buongiorno";
  } else if (oraCorrente >= 12 && oraCorrente < 18) {
    saluto = "Buon pomeriggio";
  } else {
    saluto = "Buonasera";
  }
  salutoUtente.textContent = `${saluto}`;
});