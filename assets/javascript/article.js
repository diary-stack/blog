import axios from "axios";

const dataContainer = document.querySelector(".data-container");
const dataLoader = document.querySelector(".data-loader");

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
  let i = 0;
  console.log("test");
});
