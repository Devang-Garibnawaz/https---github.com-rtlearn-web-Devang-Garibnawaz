

function formatDate(value) {
    var dt = new Date(value);
    return dt.getDate() + "-" + (dt.getMonth() + 1) + "-" + dt.getFullYear();
}

function getUserTweet(x) {
    var screen_name = x.getAttribute("id");
    if (screen_name != "") {
        $("#divFollowerTimeLine").html("");
        $.post(
            "fetchData.php", { fetch_tweets: "fetch_tweets", screen_name: screen_name },
            function(result) {
                document.getElementById("divDefaultTimeLine").style.display = "none";
                response = JSON.parse(result);
                var strData =
                    '<div class="container">' +
                    '<div class="row">' +
                    '<div class="col-6">' +
                    '<h3 class="mb-3">Top 10 posts</h3>' +
                    "</div>" +
                    '<div class="col-6 text-right">' +
                    '<a class="btn btn-primary mb-3 mr-1" href="#carouselExampleIndicators3" role="button" data-slide="prev">' +
                    '<i class="fa fa-arrow-left"></i>' +
                    "</a>" +
                    '<a class="btn btn-primary mb-3 " href="#carouselExampleIndicators3" role="button" data-slide="next">' +
                    '<i class="fa fa-arrow-right"></i>' +
                    "</a>" +
                    "</div>" +
                    '<div class="col-12">' +
                    '<div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">' +
                    '<div class="carousel-inner">' +
                    '<div class="carousel-item active">' +
                    '<div class="row">';
                for (var i = 0; i < response.length; i++) {
                    const res = response[i];
                    let imgSrc = res ?.extended_entities ?.media[0]?.media_url;
                    if(!imgSrc) {
                        imgSrc = "assets/images/404.png";
                    }
                    var text = response[i].text.includes("http") ?
                        response[i].text.substr(0, response[i].text.lastIndexOf("http")) :
                        response[i].text;
                    var link = response[i].text.includes("http") ?
                        response[i].text.substr(
                            response[i].text.lastIndexOf("http"),
                            response[i].text.length
                        ) :
                        "";
                    strData +=
                        '<div class="col-md-4 mb-3">' +
                        '<div class="card">' +
                        '<img class="post-img" alt="100%x280" src="'+imgSrc+'">' +
                        '<div class="card-body" style="min-height:250px ;">' +
                        '<h4 class="card-title">' +
                        response[i].user.name +
                        "</h4>" +
                        '<p class="card-text">' +
                        text +
                        "</p>" +
                        '<p style="display:inline">read more...</p><a target="_blankl" href="' +
                        link +
                        '">' +
                        link +
                        "</a>" +
                        "</div>" +
                        "</div>" +
                        "</div>";

                    if ((i + 1) % 3 == 0) {
                        strData +=
                            "</div>" +
                            "</div>" +
                            '<div class="carousel-item ">' +
                            '<div class="row">';
                    }
                }
                strData +=
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>";
                document.getElementById("divFollowerTimeLine").style.display = "block";
                $("#divFollowerTimeLine").append(strData);
                $("html, body").animate({
                        scrollTop: $("#divFollowerTimeLine").offset().top,
                    },
                    1000
                );
            }
        );
    }
}

function getUserTweetBySearch() {
    var screen_name = $('#txtfollower_name').val();
    if (screen_name != "") {
        $("#divFollowerTimeLine").html("");
        $.post(
            "fetchData.php", { fetch_tweets: "fetch_tweets", screen_name: screen_name },
            function(result) {
                document.getElementById("divDefaultTimeLine").style.display = "none";
                response = JSON.parse(result);
                var strData =
                    '<div class="container">' +
                    '<div class="row">' +
                    '<div class="col-6">' +
                    '<h3 class="mb-3">Top 10 posts</h3>' +
                    "</div>" +
                    '<div class="col-6 text-right">' +
                    '<a class="btn btn-primary mb-3 mr-1" href="#carouselExampleIndicators3" role="button" data-slide="prev">' +
                    '<i class="fa fa-arrow-left"></i>' +
                    "</a>" +
                    '<a class="btn btn-primary mb-3 " href="#carouselExampleIndicators3" role="button" data-slide="next">' +
                    '<i class="fa fa-arrow-right"></i>' +
                    "</a>" +
                    "</div>" +
                    '<div class="col-12">' +
                    '<div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">' +
                    '<div class="carousel-inner">' +
                    '<div class="carousel-item active">' +
                    '<div class="row">';
                for (var i = 0; i < response.length; i++) {
                    const res = response[i];
                    let imgSrc = res ?.extended_entities ?.media[0]?.media_url;
                    if(!imgSrc) {
                        imgSrc = "assets/images/404.png";
                    }
                    var text = response[i].text.includes("http") ?
                        response[i].text.substr(0, response[i].text.lastIndexOf("http")) :
                        response[i].text;
                    var link = response[i].text.includes("http") ?
                        response[i].text.substr(
                            response[i].text.lastIndexOf("http"),
                            response[i].text.length
                        ) :
                        "";
                    strData +=
                        '<div class="col-md-4 mb-3">' +
                        '<div class="card">' +
                        '<img class="post-img" alt="100%x280" src="'+imgSrc+'">' +
                        '<div class="card-body" style="min-height:250px ;">' +
                        '<h4 class="card-title">' +
                        response[i].user.name +
                        "</h4>" +
                        '<p class="card-text">' +
                        text +
                        "</p>" +
                        '<p style="display:inline">read more...</p><a target="_blankl" href="' +
                        link +
                        '">' +
                        link +
                        "</a>" +
                        "</div>" +
                        "</div>" +
                        "</div>";

                    if ((i + 1) % 3 == 0) {
                        strData +=
                            "</div>" +
                            "</div>" +
                            '<div class="carousel-item ">' +
                            '<div class="row">';
                    }
                }
                strData +=
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>";
                document.getElementById("divFollowerTimeLine").style.display = "block";
                $("#divFollowerTimeLine").append(strData);
                $("html, body").animate({
                        scrollTop: $("#divFollowerTimeLine").offset().top,
                    },
                    1000
                );
            }
        );
    }
}

function fnGetUserTweets(x){
    var screen_name = x.getAttribute("id");
    if (screen_name != ""){
       
        const url='http://localhost/twitterchallenge/fetchData.php';
        var formData = new FormData();
        formData.append("fetch_tweets","fetch_tweets");
        formData.append("screen_name",screen_name);
        fetch(url, {
            method: 'POST',
            body: formData, // The data
            headers: {
                'Content-type': 'application/json; charset=UTF-8' // The type of data you're sending
            }
        }).then(function (response) {
        });
    }
}

function fnShowMyTweets() {
    $("#divFollowerTimeLine").html("");
    document.getElementById("divDefaultTimeLine").style.display = "block";
    document.getElementById("divFollowerTimeLine").style.display = "none";
}

function fnGeneratePDF(){
    location.href= "generatepdf.php";
}