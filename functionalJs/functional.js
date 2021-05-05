let slidePosition = 0;
let slides = "";
let totalSlides = 0;

window.onload = function () {
  fnGetHomeTimelines();
};

function formatDate(value) {
  var dt = new Date(value);
  return (
    dt.getDate() +
    "-" +
    (dt.getMonth() + 1) +
    "-" +
    dt.getFullYear() +
    "  " +
    dt.getUTCHours() +
    ":" +
    dt.getMinutes()
  );
}

async function fnGetHomeTimelines() {
  const url = "fetchData.php";
  const response = await fetch(url, {
    method: "POST",
    body: "",
    headers: {
      "Content-type": "application/json; charset=UTF-8", // The type of data you're sending
    },
  });

  if (response.ok) {
    var divTimelines = document.getElementById("divTimelines");
    divTimelines.innerHTML = "";
    let json = await response.json();

    var item = "";
    var activeclass = "";
    var text = "";
    var link = "";

    for (var i = 0; i < json.length; i++) {
      text = json[i].text.includes("http")
        ? json[i].text.substr(0, json[i].text.lastIndexOf("http"))
        : json[i].text;
      link = json[i].text.includes("http")
        ? json[i].text.substr(
            json[i].text.lastIndexOf("http"),
            json[i].text.length
          )
        : "";
      let imgSrc = json[i]?.user?.profile_banner_url;
      if (!imgSrc) {
        imgSrc = "assets/images/404.png";
      }
      if (i == 0) {
        activeclass = '<div class="carousel__item carousel__item--visible">';
      } else {
        activeclass = '<div class="carousel__item">';
      }
      item +=
        activeclass +
        '<div class="card">' +
        '<img src="' +
        imgSrc +
        '" class="post" alt="Avatar" style="width:100%">' +
        '<div class="card-body-width">' +
        '<div class="card-body">' +
        '<h4 class="mr"><b>' +
        json[i].user.name +
        "</b></h4>" +
        '<p class="mt">' +
        text +
        "</p>" +
        "<p>Created At: <b>" +
        formatDate(json[i].created_at) +
        "</b></p>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>";
    }
    item +=
      '<div class="carousel__actions">' +
      '<button id="carousel__button--prev" aria-label="Previous slide"><i class="arrow left"></i></button>' +
      '<button id="carousel__button--next" aria-label="Next slide"><i class="arrow right"></i></button>' +
      "</div>";
    divTimelines.innerHTML = item;
    divTimelines.scrollIntoView();
    fnPopulateCarousel();
  } else {
    alert("HTTP-Error: " + response.status);
  }
}

async function fnGetUserTweets(x) {
  if (x == "" || x == undefined) {
    x = document.getElementById("txtfollower_name").value;
    if (x == "" || x == undefined) {
      alert("Please select usser");
      return;
    }
  }
  var screen_name = x;
  if (screen_name != "") {
    var formData = new FormData();
    formData.append("screen_name", screen_name);
    formData.append("count", 10);
    const url = "fetchData.php";
    const response = await fetch(url, {
      method: "post",
      body: formData,
    });

    if (response.ok) {
      var divTimelines = document.getElementById("divTimelines");
      divTimelines.innerHTML = "";
      let json = await response.json();
      var item = "";
      var activeclass = "";
      var text = "";
      var link = "";
      console.log(json);
      if (json.length <= 0) {
        item +=
          '<div class="carousel__item carousel__item--visible">' +
          '<div class="card">' +
          '<div class="card-body-width">' +
          '<div class="card-body">' +
          '<h4 class="mr"><b>' +
          "No Tweets Found" +
          "</b></h4>" +
          '<p class="mt">' +
          "</p>" +
          "<p><b>" +
          "</b></p>" +
          "</div>" +
          "</div>" +
          "</div>" +
          "</div>";

        divTimelines.innerHTML = item;
        divTimelines.scrollIntoView();
      }
      for (var i = 0; i < json.length; i++) {
        text = json[i].text.includes("http")
          ? json[i].text.substr(0, json[i].text.lastIndexOf("http"))
          : json[i].text;
        link = json[i].text.includes("http")
          ? json[i].text.substr(
              json[i].text.lastIndexOf("http"),
              json[i].text.length
            )
          : "";
        let imgSrc = json[i]?.extended_entities?.media[0]?.media_url;
        if (!imgSrc) {
          imgSrc = "assets/images/404.png";
        }
        if (i == 0) {
          activeclass = '<div class="carousel__item carousel__item--visible">';
        } else {
          activeclass = '<div class="carousel__item">';
        }
        item +=
          activeclass +
          '<div class="card">' +
          '<img src="' +
          imgSrc +
          '" class="post" alt="Avatar" style="width:100%">' +
          '<div class="card-body-width">' +
          '<div class="card-body">' +
          '<h4 class="mr"><b>' +
          json[i].user.name +
          "</b></h4>" +
          '<p class="mt">' +
          text +
          "</p>" +
          "<p>Created At: <b>" +
          formatDate(json[i].created_at) +
          "</b></p>" +
          "</div>" +
          "</div>" +
          "</div>" +
          "</div>";
      }
      item +=
        '<div class="carousel__actions">' +
        '<button id="carousel__button--prev" aria-label="Previous slide"><i class="arrow left"></i></button>' +
        '<button id="carousel__button--next" aria-label="Next slide"><i class="arrow right"></i></button>' +
        "</div>";
      divTimelines.innerHTML = item;
      divTimelines.scrollIntoView();
      fnPopulateCarousel();
    } else {
      alert("HTTP-Error: " + response.status);
    }
  }
}

function fnPopulateCarousel() {
  slidePosition = 0;
  slides = "";
  totalSlides = 0;

  slides = document.getElementsByClassName("carousel__item");
  totalSlides = slides.length;
  document
    .getElementById("carousel__button--next")
    .addEventListener("click", function () {
      moveToNextSlide();
    });
  document
    .getElementById("carousel__button--prev")
    .addEventListener("click", function () {
      moveToPrevSlide();
    });
}

function updateSlidePosition() {
  for (let slide of slides) {
    slide.classList.remove("carousel__item--visible");
    slide.classList.add("carousel__item--hidden");
  }
  slides[slidePosition].classList.add("carousel__item--visible");
}

function moveToNextSlide() {
  if (slidePosition === totalSlides - 1) {
    slidePosition = 0;
  } else {
    slidePosition++;
  }

  updateSlidePosition();
}

function moveToPrevSlide() {
  if (slidePosition === 0) {
    slidePosition = totalSlides - 1;
  } else {
    slidePosition--;
  }

  updateSlidePosition();
}

function fnFatchFollowers() {
  var screen_name = document.getElementById("txtfollower_name").value;
  var email = document.getElementById("txtEmail").value;
  if (screen_name == "") {
    alert("Please select user");
    document.getElementById("txtfollower_name").focus();
    return;
  }

  if (email == "") {
    alert("Please enter email address!");
    document.getElementById("txtEmail").focus();
    return;
  }
  var formData = new FormData();
  formData.append("type", 1);
  formData.append("screen_name", screen_name);
  formData.append("email", email);
  const url = "processrun.php"; //Run background process by api
  const response = fetch(url, {
    method: "POST",
    body: formData,
  });
  alert("The follower list will mail you shortly whenever process is done!");
}

function fnFetchUserTweets() {
  var screen_name = document.getElementById("txtfollower_name").value;
  var email = document.getElementById("txtEmail").value;
  if (screen_name == "") {
    alert("Please select user");
    document.getElementById("txtfollower_name").focus();
    return;
  }

  if (email == "") {
    alert("Please enter email address!");
    document.getElementById("txtEmail").focus();
    return;
  }
  var formData = new FormData();
  formData.append("type", 2);
  formData.append("screen_name", screen_name);
  formData.append("email", email);
  const url = "processrun.php";
  const response = fetch(url, {
    method: "POST",
    body: formData,
  });
  alert("The follower list will mail you shortly whenever process is done!");
}
