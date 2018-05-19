<?php if(!isv("id")){ ?>
 <section class="section-inside text-center">
        <div class="container">
          <div class="row">
           <?php
           function getColor($i){
           $ar = array("color-blue","dark-green","dark-pink","dark-blue","dark-red","dark-gold");
           if($i  >= count($ar))
           $i--;
           return $ar[$i];
           }
           $count = 10;
            for($i=0;$i<6;$i++){
            $count = $count+ $i;
           ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="section-curse-top <?=getColor($i)?> text-left">
                <i class="fa fa-bookmark-o" aria-hidden="true"></i>
                <span class=""><?=$count?> Video</span>

              </div>
              <div class="section-curse color-fff">
                <h2>category <?=$i?></h2>
                <p>Short description of the required classification</p>
               <a href="category<?=$i?>.html"><button class="<?=getColor($i)?>">Show</button></a>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </section>
 <?php }else { ?>

<section class="inside-section">
      <div class="container">

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
          <div class="clear" ></div>
         <div class="show-more">
         <button>Show More Video</button>
        </div>
      </div>
    </section>

 <?php } ?>
