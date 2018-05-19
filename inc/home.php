<div class="header-div">
      <div class="container">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
        <img src="images/home-logo.png" class="img-responsive">
          <div class="right-header">
            <h1>Share your work in seconds. Visually</h1>
            <p>The world's fastest visual sharing platform to help creatives share their work,view over 200 file formats online, and collaborate with team and clients.</p>
            <button   style=" display: none" >Start Video Upload!</button>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="left-header">
            <h2>Join Us</h2>
            <form>
              <div class="form-group">
                <input type="text" id="username" placeholder="Username">
              </div>
              <div class="form-group">
                <input type="email" id="email" placeholder="Email">
              </div>
              <div class="form-group">
                <input type="password" id="pwd" placeholder="Password">
              </div>
              <button type="submit">Sign Up</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="sections">
      <div class="container">
         <ul class="nav nav-pills">
            <li class="active">
              <a data-toggle="pill" href="#menu1"><h3>Last Video</h3></a>
            </li>
            <li>
              <a data-toggle="pill" href="#menu2"><h3>Best Video</h3></a>
            </li>
          </ul>
        </div>
      </div>
      <section class="website-sessions">
      <div class="container">
        <div class="tab-content">
             <div id="menu1" class="tab-pane fade in active">
              <?php  for($i=0;$i<6;$i++){ ?>
             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div>
                  <img src="images/html.jpg" class="img-responsive">
                    <div class="level-image"  style="display: none" >
                      <span class="color-html">HTML</span>

                    </div>
                </div>
                  <div class="boxs">
                    <div class="cours-price">
                       <h4>Forfeited you engrossed but gay sometimes explained</h4>
                      <span></span>
                    </div>
                    <p>Forfeited you engrossed but gay sometimes explained. Another as studied it to evident. Merry sense given he be arise.</p>
                    <hr>
                    <div class="explained-cours">
                     <a href="video<?=$i?>.html"><button>Watch now</button></a>
                      <div class="time-writer">
                        <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="15 minutes"><i class="fa fa-clock-o" aria-hidden="true"></i></a>
                        <a style="display: none" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="مشاهدة عرض سريع">
                        <i class="fa fa-play" aria-hidden="true"></i>
                        </a>
                      </div>
                    </div>
                </div>
              </div>
           <?php } ?>
          </div>
          <div id="menu2" class="tab-pane fade">

              <?php  for($i=0;$i<6;$i++){ ?>
             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div>
                  <img src="images/css.jpg" class="img-responsive">
                    <div class="level-image"  style="display: none" >
                      <span class="color-html">HTML</span>

                    </div>
                </div>
                  <div class="boxs">
                    <div class="cours-price">
                       <h4>Forfeited you engrossed but gay sometimes explained</h4>
                      <span></span>
                    </div>
                    <p>Forfeited you engrossed but gay sometimes explained. Another as studied it to evident. Merry sense given he be arise.</p>
                    <hr>
                    <div class="explained-cours">
                     <a href="video<?=$i?>.html"><button>Watch now</button></a>
                      <div class="time-writer">
                        <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="15 minutes"><i class="fa fa-clock-o" aria-hidden="true"></i></a>
                        <a style="display: none" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="مشاهدة عرض سريع">
                        <i class="fa fa-play" aria-hidden="true"></i>
                        </a>
                      </div>
                    </div>
                </div>
              </div>
           <?php } ?>

          </div>

      </div>
     <div class="clear" ></div>
        <div class="button-show-more text-center">
          <a href="category.html"><button type="submit">Show More Video</button></a>
        </div>
      </div>
    </section>