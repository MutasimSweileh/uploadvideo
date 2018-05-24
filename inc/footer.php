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
       <!-- <script src="js/flowplayer.min.js"></script>-->
       <script src="https://releases.flowplayer.org/7.2.6/flowplayer.min.js"></script>
        <script src="//releases.flowplayer.org/hlsjs/flowplayer.hlsjs.light.min.js"></script>
        <script>$('.dropdown-toggle').dropdown()</script>

       <script>

        flowplayer('#player', {
            live: true,  // set if it's a live stream
            ratio: 9/16, // set the aspect ratio of the stream
            clip: {
                sources: [

                   // { type: "application/x-mpegurl", src: "http://s1.electru.biz:8080/live/megolove61@gmail.com/8Pi8b62lUy/31309.m3u8"},
                    { type: "application/x-mpegurl", src: "http://s1.electru.biz:8080/live/megolove61@gmail.com/8Pi8b62lUy/49872.m3u8"}
                ]
            }
        });


     </script>


        <script>
       $(function () {

        var api = flowplayer(".flowplayer",{});
        api.load({
        sources: [
            { type: "application/x-mepgurl",
              src:  "http://s1.electru.biz:8080/live/megolove61@gmail.com/8Pi8b62lUy/49872.m3u8" }
          ]
        });
        api.on("pause", function (e, api) {
        }).on("resume", function (e, api) {
        }).on("progress", function (e, api) {
        var pos =  checkVideoProgress();
        if(pos >= 5){
        <?php if(!isv("bein")){ ?>
        api.toggle();
        $("#myOffer").modal("show");
        <?php } ?>
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
