/* FIXED ICONS */
let fixedCart = document.getElementById("fixedCart");
let fixedProfile = document.getElementById("fixedProfile");

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
    fixedCart.style.display = "block";
    fixedProfile.style.display = "block";
  } else {
    fixedCart.style.display = "none";
    fixedProfile.style.display = "none";
  }
}

function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

/* ADMIN PANEL DATATABLES */ 
$(document).ready(function () {
    $('#myUserTable').DataTable();
});

$(document).ready(function () {
    $('#myFoodTable').DataTable();
});

$(".changeImage").click(function() {
    if ($(".imageUpload").hasClass("hide")) {
        $(".imageUpload").removeClass("hide");
    } else {
        $(".imageUpload").addClass("hide");
    }
})