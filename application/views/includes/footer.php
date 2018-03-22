<!-- Container (Contact Section) -->
<div id="contact" class="container-fluid bg-grey">
  <h2 class="text-center">CONTACT</h2>
  <div class="row">
    <div class="col-sm-5">
      <p>Contact us and we'll get back to you within 24 hours.</p>
      <p><span class="glyphicon glyphicon-map-marker"></span> Nairobi, Kenya</p>
      <p><span class="glyphicon glyphicon-phone"></span> +254714593171</p>
      <p><span class="glyphicon glyphicon-envelope"></span>polycarpmoka16@gmail.com</p>
    </div>
    <div class="col-sm-7 slideanim">
      <div class="row">
        <div class="col-sm-6 form-group">
          <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
        </div>
        <div class="col-sm-6 form-group">
          <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
        </div>
      </div>
      <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea><br>
      <div class="row">
        <div class="col-sm-12 form-group">
          <button class="btn btn-default pull-right" type="submit">Send</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Google Maps -->
<div id="googleMap" style="height:400px;width:100%;"></div>
<script>
function myMap() {
var myCenter = new google.maps.LatLng(-1.0969, 37.0154);
var mapProp = {center:myCenter, zoom:12, scrollwheel:false, draggable:false, mapTypeId:google.maps.MapTypeId.ROADMAP};
var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
var marker = new google.maps.Marker({position:myCenter});
marker.setMap(map);
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key= AIzaSyDls_wWfq4tUJDqvmxmwuKB8R0Lkgu0twE&amp;callback=myMap"></script>

<?php
$CI =& get_instance();
$CI->load->view('tawk');
$CI->load->view('social');
?>

<footer class="container-fluid text-center">
  <a href="#homePage" title="To Top">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a>
  <p>Designed and developed By <a href="http://Mogaka1994.github.io" title="Visit w3schools">Moha$Polycarp</a></p>
</footer>

<script type="text/javascript" src="<?php echo base_url('assets/js/script.js');?>"></script>

<script type="text/javascript">
  $("#donateLink").on('click', function(){
    window.location = "<?php echo site_url('donations/projects');?>";
  });
  $("#homePageLink").on('click', function(){
    window.location = "<?php echo site_url('');?>";
  });
</script>

</body>

</html>