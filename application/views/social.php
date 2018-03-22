<style type="text/css">
    .sticky-container{
    padding:0px;
    margin:0px;
    position:fixed;
    right:-130px;
    top:230px;
    width:210px;
    z-index: 1100;
}
.sticky li{
    list-style-type:none;
    background-color:#fff;
    color:#efefef;
    height:43px;
    padding:0px;
    margin:0px 0px 1px 0px;
    -webkit-transition:all 0.25s ease-in-out;
    -moz-transition:all 0.25s ease-in-out;
    -o-transition:all 0.25s ease-in-out;
    transition:all 0.25s ease-in-out;
    cursor:pointer;
}
.sticky li:hover{
    margin-left:-115px;
}
.sticky li img{
    float:left;
    margin:5px 4px;
    margin-right:5px;
}
.sticky li p{
    padding-top:5px;
    margin:0px;
    line-height:16px;
    font-size:11px;
}
.sticky li p a{
    text-decoration:none;
    color:#2C3539;
}
.sticky li p a:hover{
    text-decoration:underline;
}
</style>

<div class="sticky-container">
    <ul class="sticky">
        <li>
            <img src="<?php echo base_url('assets/images/logo_facebook.png');?>" width="32" height="32">
            <p><a href="https://www.facebook.com/" target="_blank">Like Us on<br>Facebook</a></p>
        </li>
        <li>
            <img src="<?php echo base_url('assets/images/logo_twitter.png');?>" width="32" height="32">
            <p><a href="https://twitter.com/" target="_blank">Follow Us on<br>Twitter</a></p>
        </li>
        <li>
            <img src="<?php echo base_url('assets/images/logo_google_plus.png');?>" width="32" height="32">
            <p><a href="https://plus.google.com/" target="_blank">Follow Us on<br>Google+</a></p>
        </li>
        <li>
            <img src="<?php echo base_url('assets/images/logo_linked_in.png');?>" width="32" height="32">
            <p><a href="https://www.linkedin.com/company/" target="_blank">Follow Us on<br>LinkedIn</a></p>
        </li>
        <li>
            <img src="<?php echo base_url('assets/images/logo_you_tube.png');?>" width="32" height="32">
            <p><a href="http://www.youtube.com/" target="_blank">Subscribe on<br>YouTube</a></p>
        </li>
    </ul>
</div>