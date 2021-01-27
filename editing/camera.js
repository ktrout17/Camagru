"use strict";
var width = 420;
var height = 340;
const video = document.getElementById("vid");
const canvas = document.getElementById("canvas");
const snap = document.getElementById("capture");

var ctx = canvas.getContext("2d");
var save_canvas;

// Display webcam
navigator.mediaDevices
  .getUserMedia({ video: { width: 320, height: 240 }, audio: false })
  .then(function (stream) {
    video.srcObject = stream;
    video.play();
  })
  .catch(function (err) {
    console.log("An error occurred! " + err);
  });

// Draw image of webcam on canvas
snap.addEventListener("click", function () {
  ctx.drawImage(video, 0, 0, width, height);
  // ctx.save();
  save();
});

// Draw image of sticker on canvas
function merge(url) {
  // ctx.clearRect(0,0,width,height);
  var image = new Image();
  image.onload = function () {
    ctx.drawImage(image, 0, 0, 200, 200);
  };
  image.src = url;
  // img.src = strDataURI
}

// Save image Data into button value
function save_image() {
  var img = new Image();
  img.src = canvas.toDataURL();
  var btn = document.getElementById("upload");
  btn.value = img.src;
}

function save() {
  save_canvas = canvas.toDataURL("image/jpeg", 1.0);
}

function remove() {
  if (save_canvas) {
    var img = new Image();
    img.onload = function () {
      ctx.drawImage(img, 0, 0, width, height);
    }
    img.src = save_canvas;
  }

}



  // Load image from input field onto canvas
  function load_image() {
    // canvas
    var fileinput = document.getElementById('file'); // input file
    var img = new Image();

    fileinput.onchange = function (evt) {
      var files = evt.target.files; // FileList object
      var file = files[0];
      if (file.type.match('image.*')) {
        var reader = new FileReader();
        // Read in the image file as a data URL.
        reader.readAsDataURL(file);
        reader.onload = function (evt) {
          if (evt.target.readyState == FileReader.DONE) {
            img.src = evt.target.result;
            ctx.clearRect(0, 0, width, height);
            img.onload = () => ctx.drawImage(img, 0, 0, width, height);
          }
        }
      } else {
        alert("not an image");
      }
    };
  }