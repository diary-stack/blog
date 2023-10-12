const categoryInput = document.querySelector("#selected-category");
const selectedText = document.querySelector(".selected-text");
const categories = document.querySelectorAll(".categories");
const targetCategory = document.querySelector(".target-category");
const categoryList = document.querySelector(".category-list");

targetCategory.addEventListener("click", () => {
  categoryList.classList.toggle("d-none");
});

const setSelectedCategory = (name) => {
  selectedText.textContent = name;
  categoryInput.value = name;
};

categories.forEach((li) => {
  li.addEventListener("click", (e) => {
    const name = e.target.textContent;
    categoryList.classList.add("d-none");
    setSelectedCategory(name);
  });
});
