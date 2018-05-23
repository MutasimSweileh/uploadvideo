    <div class="<?=($Gapp == "video"?"container":"")?>">
      <div class="color-fff">
         <section class="footer-section text-center">
            <ul>
              <li><a href="home.html">Home </a></li>
              <li><a href="about.html">About</a></li>
              <img src="images/logofooter.png">
              <li><a href="privacy.html">Privacy</a></li>
              <li><a href="contact.html">Contact</a></li>
            </ul>
            <p>All right reserved . built by <a href="#">Mohtasm Mohamed</a></p>
            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
       </section>
       </div>
                               <div id="myOffer" class="modal fade text-center" role="dialog">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                              <div class="modal-body">
                                <div id="content">
                                  <div class="header-login">
                                  <div class="loadr" style="display: none" ></div>
                                    <h2>Complete one offer to Watch Video.</h2>
                                  </div>
                                   <div class="form_section">
<!--                                    <div class="form-group">
                                      <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Username" required="">
                                    </div>
                                    <div class="form-group">
                                      <input type="password" class="form-control" name="email" id="email" placeholder="Password" required="">
                                    </div>-->
                                  <button> <a href="#" target="_blank" >To download complete offer one</a></button>
                                  <button> <a href="#" target="_blank" >To download complete offer two</a></button>
                                  <button> <a href="#" target="_blank" >To download complete offer three</a></button>

                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
    </div>
        <script src="js/jquery-2.1.4.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/menu.js"></script>
        <script src="js/plagn.js"></script>
        <script src="js/flowplayer.min.js"></script>
        <script>$('.dropdown-toggle').dropdown()</script>
        <script>
           flowplayer("#player", {
    clip: {
        title: "Friends Bein Sport 1 :)",

        // VOD quality selector plugin configuration
        qualities: ["160p", "260p", "530p", "800p"],
        defaultQuality: "260p",

        sources: [
            // HLS for automatic quality selection
           { type: "application/x-mpegurl",
              src:  "http://167.99.232.44:8000/hls/bein.m3u8" },

            /* manual selection */

           /* // default VOD resolution in 2 formats
            { type: "video/webm",
              src:  "//cdn.flowplayer.org/202777/84049-bauhaus.webm" },
            { type: "video/mp4",
              src:  "//cdn.flowplayer.org/202777/84049-bauhaus.mp4" },*/

            // default VOD resolution via RTMP for Flash in old browsers
          /* { type: "video/flash",
              src:  "bein" }*/
        ]
    },
    //rtmp: "rtmp://167.99.232.44/live",
    //splash: "//drive.cdn.flowplayer.org/202777/84049-snap.jpg",
    ratio: 5/12,
    live: true,
    twitter: "https://www.facebook.com/mohtasm.sawilh",
    facebook: "https://www.facebook.com/mohtasm.sawilh",
    embed: {
        iframe: "https://www.facebook.com/mohtasm.sawilh"
    }
});
        $(function () {

        var api = flowplayer(".flowplayer",{});
        api.on("pause", function (e, api) {
        }).on("resume", function (e, api) {
        }).on("progress", function (e, api) {
        var pos =  checkVideoProgress();
        if(pos >= 5){
        api.toggle();
        $("#myOffer").modal("show");
        }
        });

        function checkVideoProgress() {
            var time_completed = api.video.time;
            var total_time = api.video.duration;
            var percent_done = Math.floor((time_completed / total_time) * 100);
            console.log(percent_done + "% of video done");
        	return percent_done;
        }
        });
        </script>
  </body>
</html>
