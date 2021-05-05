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

// function getUserTweet(x) {
//     var screen_name = x.getAttribute("id");
//     if (screen_name != "") {
//         $("#divFollowerTimeLine").html("");
//         $.post(
//             "fetchData.php", { fetch_tweets: "fetch_tweets", screen_name: screen_name },
//             function(result) {
//                 document.getElementById("divDefaultTimeLine").style.display = "none";
//                 response = JSON.parse(result);
//                 var strData =
//                     '<div class="container">' +
//                     '<div class="row">' +
//                     '<div class="col-6">' +
//                     '<h3 class="mb-3">Top 10 posts</h3>' +
//                     "</div>" +
//                     '<div class="col-6 text-right">' +
//                     '<a class="btn btn-primary mb-3 mr-1" href="#carouselExampleIndicators3" role="button" data-slide="prev">' +
//                     '<i class="fa fa-arrow-left"></i>' +
//                     "</a>" +
//                     '<a class="btn btn-primary mb-3 " href="#carouselExampleIndicators3" role="button" data-slide="next">' +
//                     '<i class="fa fa-arrow-right"></i>' +
//                     "</a>" +
//                     "</div>" +
//                     '<div class="col-12">' +
//                     '<div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">' +
//                     '<div class="carousel-inner">' +
//                     '<div class="carousel-item active">' +
//                     '<div class="row">';
//                 for (var i = 0; i < response.length; i++) {
//                     const res = response[i];
//                     let imgSrc = res ?.extended_entities ?.media[0]?.media_url;
//                     if(!imgSrc) {
//                         imgSrc = "assets/images/404.png";
//                     }
//                     var text = response[i].text.includes("http") ?
//                         response[i].text.substr(0, response[i].text.lastIndexOf("http")) :
//                         response[i].text;
//                     var link = response[i].text.includes("http") ?
//                         response[i].text.substr(
//                             response[i].text.lastIndexOf("http"),
//                             response[i].text.length
//                         ) :
//                         "";
//                     strData +=
//                         '<div class="col-md-4 mb-3">' +
//                         '<div class="card">' +
//                         '<img class="post-img" alt="100%x280" src="'+imgSrc+'">' +
//                         '<div class="card-body" style="min-height:250px ;">' +
//                         '<h4 class="card-title">' +
//                         response[i].user.name +
//                         "</h4>" +
//                         '<p class="card-text">' +
//                         text +
//                         "</p>" +
//                         '<p style="display:inline">read more...</p><a target="_blankl" href="' +
//                         link +
//                         '">' +
//                         link +
//                         "</a>" +
//                         "</div>" +
//                         "</div>" +
//                         "</div>";

//                     if ((i + 1) % 3 == 0) {
//                         strData +=
//                             "</div>" +
//                             "</div>" +
//                             '<div class="carousel-item ">' +
//                             '<div class="row">';
//                     }
//                 }
//                 strData +=
//                     "</div>" +
//                     "</div>" +
//                     "</div>" +
//                     "</div>" +
//                     "</div>" +
//                     "</div>" +
//                     "</div>";
//                 document.getElementById("divFollowerTimeLine").style.display = "block";
//                 $("#divFollowerTimeLine").append(strData);
//                 $("html, body").animate({
//                         scrollTop: $("#divFollowerTimeLine").offset().top,
//                     },
//                     1000
//                 );
//             }
//         );
//     }
// }

// function getUserTweetBySearch() {
//     var screen_name = $('#txtfollower_name').val();
//     if (screen_name != "") {
//         $("#divFollowerTimeLine").html("");
//         $.post(
//             "fetchData.php", { fetch_tweets: "fetch_tweets", screen_name: screen_name },
//             function(result) {
//                 document.getElementById("divDefaultTimeLine").style.display = "none";
//                 response = JSON.parse(result);
//                 var strData =
//                     '<div class="container">' +
//                     '<div class="row">' +
//                     '<div class="col-6">' +
//                     '<h3 class="mb-3">Top 10 posts</h3>' +
//                     "</div>" +
//                     '<div class="col-6 text-right">' +
//                     '<a class="btn btn-primary mb-3 mr-1" href="#carouselExampleIndicators3" role="button" data-slide="prev">' +
//                     '<i class="fa fa-arrow-left"></i>' +
//                     "</a>" +
//                     '<a class="btn btn-primary mb-3 " href="#carouselExampleIndicators3" role="button" data-slide="next">' +
//                     '<i class="fa fa-arrow-right"></i>' +
//                     "</a>" +
//                     "</div>" +
//                     '<div class="col-12">' +
//                     '<div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">' +
//                     '<div class="carousel-inner">' +
//                     '<div class="carousel-item active">' +
//                     '<div class="row">';
//                 for (var i = 0; i < response.length; i++) {
//                     const res = response[i];
//                     let imgSrc = res ?.extended_entities ?.media[0]?.media_url;
//                     if(!imgSrc) {
//                         imgSrc = "assets/images/404.png";
//                     }
//                     var text = response[i].text.includes("http") ?
//                         response[i].text.substr(0, response[i].text.lastIndexOf("http")) :
//                         response[i].text;
//                     var link = response[i].text.includes("http") ?
//                         response[i].text.substr(
//                             response[i].text.lastIndexOf("http"),
//                             response[i].text.length
//                         ) :
//                         "";
//                     strData +=
//                         '<div class="col-md-4 mb-3">' +
//                         '<div class="card">' +
//                         '<img class="post-img" alt="100%x280" src="'+imgSrc+'">' +
//                         '<div class="card-body" style="min-height:250px ;">' +
//                         '<h4 class="card-title">' +
//                         response[i].user.name +
//                         "</h4>" +
//                         '<p class="card-text">' +
//                         text +
//                         "</p>" +
//                         '<p style="display:inline">read more...</p><a target="_blankl" href="' +
//                         link +
//                         '">' +
//                         link +
//                         "</a>" +
//                         "</div>" +
//                         "</div>" +
//                         "</div>";

//                     if ((i + 1) % 3 == 0) {
//                         strData +=
//                             "</div>" +
//                             "</div>" +
//                             '<div class="carousel-item ">' +
//                             '<div class="row">';
//                     }
//                 }
//                 strData +=
//                     "</div>" +
//                     "</div>" +
//                     "</div>" +
//                     "</div>" +
//                     "</div>" +
//                     "</div>" +
//                     "</div>";
//                 document.getElementById("divFollowerTimeLine").style.display = "block";
//                 $("#divFollowerTimeLine").append(strData);
//                 $("html, body").animate({
//                         scrollTop: $("#divFollowerTimeLine").offset().top,
//                     },
//                     1000
//                 );
//             }
//         );
//     }
// }

async function fnGetHomeTimelines() {
  const url = "http://localhost/twitterchallenge/fetchData.php?";
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
    const url = "http://localhost/twitterchallenge/fetchData.php";
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

async function fnDownload_Tweets() {
  var screen_name = document.getElementById("txtfollower_name").value;
  if (screen_name == "") {
    alert("Please select user");
    document.getElementById("txtfollower_name").focus();
    return;
  } else {
    var formData = new FormData();
    formData.append("screen_name", screen_name);
    formData.append("count", 10000);
    const url = "http://localhost/twitterchallenge/fetchData.php";
    const response = await fetch(url, {
      method: "POST",
      body: formData,
    });
    if (response.ok) {
      var obj = [];
      let data = await response.json();
      for (var i = 0; i < data.length; i++) {
        var item = data[i];
        var retweeted_item = item.retweeted_status;

        var media = [];
        var urls = [];

        if (
          item.extended_entities &&
          item.extended_entities.media &&
          item.extended_entities.media.length
        ) {
          item.extended_entities.media.forEach(function (item) {
            if (item.type == "video") {
              media[media.length] = {
                type: "video",
                source: item.video_info.variants[0].url,
              };
            } else {
              media[media.length] = {
                type: "image",
                url: item.media_url,
              };
            }
          });
        } else if (item.entities.media && item.entities.media.length) {
          item.entities.media.forEach(function (item) {
            media[media.legnth] = {
              type: "image",
              url: item.media_url,
            };
          });
        }

        if (item.entities.urls && item.entities.urls.length) {
          item.entities.urls.forEach(function (item) {
            urls[urls.length] = item.url;
          });
        }
        obj[obj.length] = {
          retweeted: retweeted_item ? "1" : "0",
          retweeted_person_name: retweeted_item ? retweeted_item.user.name : "",
          retweeted_person_screen_name: retweeted_item
            ? retweeted_item.user.screen_name
            : "",
          name: item.user.name,
          screen_name: item.user.screen_name,
          original_time: retweeted_item
            ? formatDate(retweeted_item.created_at)
            : formatDate(item.created_at),
          retweeted_time: retweeted_item ? formatDate(item.created_at) : "",
          text: retweeted_item ? retweeted_item.text : item.text,
          favorite_count: item.favorite_count,
          retweet_count: item.retweet_count,
          place: item.place ? item.place.full_name : "",
          media: media,
          links: urls,
        };
      }
      convert_data(1, obj);
    } else {
      alert("HTTP-Error: " + response.status);
    }
  }
}

async function fnDownload_Followers() {
  var formData = new FormData();
  formData.append("status", 2);
  const url = "http://localhost/twitterchallenge/fetchData.php";
  const response = await fetch(url, {
    method: "POST",
    body: formData,
  });
  if (response.ok) {
    var obj = [];
    var data = await response.json();
    for (var i = 0; i < data.users.length; i++) {
      var item = data.users[i];
      console.log(item);
      obj[obj.length] = {
        username: item.name,
        screen_name: item.screen_name,
        description: item.description,
        imageurl: item.profile_image_url,
        created_at: formatDate(item.created_at),
      };
    }
    convert_data(2, obj);
  }
}

function convert_data(type, obj) {
  var href = "";
  var filename = "";
  var extension = "";
  var no_click = 0;

  if (type == 1) {
    filename = "Tweets";
  } else {
    filename = "followers";
  }
  var result = "data:text/csv;charset=utf-8,";
  var keys = Object.keys(obj[0]);
  result += keys.join(",") + "\n";

  obj.forEach(function (item, index) {
    keys.forEach(function (key, index) {
      var temp_item = "";

      if (key == "media") {
        item[key].forEach(function (item, index) {
          if (item.type == "video") {
            temp_item += index > 0 ? "\n" + item.source : item.source;
          } else if (item.type == "image") {
            temp_item += index > 0 ? "\n" + item.url : item.url;
          }
        });
      } else if (key == "links") {
        item[key].forEach(function (item, index) {
          temp_item += index > 0 ? "\n" + item : item;
        });
      } else {
        temp_item += item[key];
      }

      temp_item = '"' + temp_item + '"';
      result += index > 0 ? "," + temp_item : temp_item;
    });

    if (index != obj.length - 1) result += "\n";
  });

  href = encodeURI(result);
  extension = "csv";

  if (!no_click) {
    var temp = document.getElementById("donwloadLink");
    temp.setAttribute("href", href);
    temp.setAttribute("download", filename + "." + extension);
    temp.click();
  }
}

function fnShowMyTweets() {
  $("#divFollowerTimeLine").html("");
  document.getElementById("divDefaultTimeLine").style.display = "block";
  document.getElementById("divFollowerTimeLine").style.display = "none";
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
  const url = "processrun.php";
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

function fnSendMail() {
  var formData = new FormData();
  formData.append("type", 2);
  const url = "http://localhost/twitterchallenge/processrun.php";
  const response = fetch(url, {
    method: "POST",
    body: formData,
  });
  console.log("You will get mail soon");
}
