document.addEventListener("DOMContentLoaded", function () {
  const stack = document.querySelector(".ele-slider3 .stack");
  if (!stack) return; // <-- prevent error if not found

  const cards = Array.from(stack.children)
    .reverse()
    .filter((child) => child.classList.contains("card"));

  cards.forEach((card) => stack.appendChild(card));

  function moveCard() {
    const lastCard = stack.lastElementChild;
    if (lastCard.classList.contains("card")) {
      lastCard.classList.add("swap");

      setTimeout(() => {
        lastCard.classList.remove("swap");
        stack.insertBefore(lastCard, stack.firstElementChild);
      }, 1200);
    }
  }

  let autoplayInterval = setInterval(moveCard, 4000);

  stack.addEventListener("click", function (e) {
    const card = e.target.closest(".card");
    if (card && card === stack.lastElementChild) {
      card.classList.add("swap");

      setTimeout(() => {
        card.classList.remove("swap");
        stack.insertBefore(card, stack.firstElementChild);
      }, 1200);
    }
  });
});
