import axios from "axios";

const dataContainer = document.querySelector(".data-container");
const dataLoader = document.querySelector(".data-loader");

const categoryInput = document.querySelector("#selected-category");
const selectedText = document.querySelector(".selected-text");
const categories = document.querySelectorAll(".categories");
const targetCategory = document.querySelector(".target-category");
const categoryList = document.querySelector(".category-list");

const barsBtn = document.querySelector(".bars-btn");
const navbaBars = document.querySelector(".navbar-bars");
const navbaBarsClose = document.querySelector(".navbar-bars-close");

barsBtn.addEventListener("click", () => {
  navbaBars.classList.add("navbar-bars-active");
});
navbaBarsClose.addEventListener("click", () => {
  navbaBars.classList.remove("navbar-bars-active");
  navbaBars.classList.add("navbar-bars-close");
});

let loadedPage = 1;

const createArticleBox = (data) => {
  const div = document.createElement("div");
  div.classList.add("col-lg-3");

  const content = `
    <a href="/article/${data.slug}" class="box">
        <div class="bg-image mb-2" style="background-image: url(/articles/${
          data.image
        })"></div>
        <div class="d-flex qw align-items-center">
            <div class="custom-badge me-2">
                ${data.category.name}
            </div>
            <i class="fas fa-circle me-1">
                ${data.readTime}
                min read
            </i>
        </div>
        <h3>${data.title}</h3>
        <p>${data.slug.slice(0.6)}</p>
    </a>
    `;

  div.innerHTML = content;
  dataContainer.append(div);
};

dataLoader.addEventListener("click", () => {
  axios.get(`article/pagination/${loadedPage + 1}`).then((response) => {
    const { articles } = response.data;

    loadedPage++;

    if (articles.length === 0) {
      dataLoader.remove();
    } else {
      articles.forEach((article) => createArticleBox(article));
    }
  });
});

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
