<div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
        <li data-target="#myCarousel" data-slide-to="4"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="/img/111.jpg" width="1200" height="700">
          <div class="carousel-caption">
            <h3>SWEDEN</h3>
          </div>
        </div>

        <div class="item">
          <img src="/img/222.jpg" width="1200" height="700">
          <div class="carousel-caption">
            <h3>SWEDEN</h3>
          </div>
        </div>

        <div class="item">
          <img src="/img/333.jpg" width="1200" height="700">
          <div class="carousel-caption">
            <h3>SWEDEN</h3>
          </div>
        </div>
        <div class="item">
          <img src="/img/444.jpg" width="1200" height="700">
          <div class="carousel-caption">
            <h3>SWEDEN</h3>
          </div>
        </div>
        <div class="item">
          <img src="/img/555.jpg" width="1200" height="700">
          <div class="carousel-caption">
            <h3>SWEDEN</h3>
          </div>
        </div>
      </div>

      <!-- Left and right controls -->
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
  </div>
  <!-- Footer -->
  <footer class="text-center">
    <a class="up-arrow" href="#myPage" data-toggle="tooltip" title="TO TOP">
      <span class="glyphicon glyphicon-chevron-up"></span>
    </a><br><br>
    <p>Made By <a href="#" data-toggle="tooltip" title="Visit golfskiworld">www.golfskiworld.com</a></p>
  </footer>

  <script>
  $(document).ready(function(){
    // Initialize Tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // Add smooth scrolling to all links in navbar + footer link
    $(".navbar a, footer a[href='#myPage']").on('click', function(event) {

      // Make sure this.hash has a value before overriding default behavior
      if (this.hash !== "") {

        // Prevent default anchor click behavior
        event.preventDefault();

        // Store hash
        var hash = this.hash;

        // Using jQuery's animate() method to add smooth page scroll
        // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
        $('html, body').animate({
          scrollTop: $(hash).offset().top
        }, 900, function(){

          // Add hash (#) to URL when done scrolling (default click behavior)
          window.location.hash = hash;
        });
      } // End if
    });
  })
  </script>