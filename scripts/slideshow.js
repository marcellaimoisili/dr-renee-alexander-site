//Source: https://www.w3schools.com/howto/howto_js_quotes_slideshow.asp
$(document).ready(function() {

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("slideshowImage");
        if (n > slides.length) { slideIndex = 1 }
        if (n < 1) { slideIndex = slides.length }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slides[slideIndex - 1].style.display = "flex";
    }

    var slideIndex = 1;
    showSlides(slideIndex);

    window.plusSlides = function(n) {
        showSlides(slideIndex += n);
    }

    // function currentSlide(n) {
    //     showSlides(slideIndex = n);
    // }

    // When the next button is clicked
    // $("#slideshowNext").click(function() {
    //     slideIndex = slideIndex + 1
    // });

    // $("#slideshowPrevious").click(function() {
    //     slideIndex = slideIndex - 1

    //     //   if(slideIndex > 0){
    //     //     slideIndex = slideIndex -1
    //     //   }

    //     //  else{
    //     //     slideIndex = 1;
    //     //   }


    // });


    // setInterval(function() {}, 3000);


    // var slideIndex = 0;
    // carousel();

    // function carousel() {
    //     var i;
    //     var x = document.getElementsByClassName("slideshowImage");
    //     for (i = 0; i < x.length; i++) {
    //         x[i].style.display = "none";
    //     }
    //     slideIndex++;
    //     if (slideIndex > x.length) { slideIndex = 1 }
    //     x[slideIndex - 1].style.display = "block";
    //     setTimeout(carousel, 2000); // Change image every 2 seconds
    // }

    //attempt to make images slide
    // var $slider = document.getElementById('slider');
    // var $slideshowNext = document.getElementById('slideshowNext');
    // // var $slideshowPrevious = document.getElementById('slideshowPrevious');


    // $slideshowNext.addEventListener('click', function() {
    // var isOpen = $slider.classList.contains('slide-in');

    // $slider.setAttribute('class', isOpen ? 'slide-out' : 'slide-in');

});


// $(document).ready(function() {
//     var images = [
//       // Image source: Renee Alexander (Client)
//       "images/about_images/1.jpg",
//       "images/about_images/2.jpg",
//       "images/about_images/3.jpg",
//       "images/about_images/4.jpg",
//       "images/about_images/5.PNG",
//       "images/about_images/6.jpg",
//     ];

//     var currentIndex = 0;


//     // When the next button is clicked
//     $("#slideshowNext").click(function () {
//       currentIndex = (currentIndex+1)%(images.length);
//       document.getElementById("slideshowImage").src=images[currentIndex];
//     });

//     $("#slideshowPrevious").click(function () {

//       if(currentIndex > 0){
//         currentIndex = (currentIndex-1)%(-(images.length));
//       }

//       else{
//         currentIndex = images.length-1;
//       }

//       document.getElementById("slideshowImage").src=images[currentIndex];
//     });
//   //
//   //
//   //   function slideshowing ()  {
//   //     currentIndex = (currentIndex+1)%(images.length);
//   //     $("#slideshowImage").attr('src',images[currentIndex]);
//   // }
//   //
//   //
//   // setInterval(function(){slideshowing();}, 3000);
//   //
//   });