<aside class="col-lg-4 col-xl-3 ml-xl-auto">
    <div class="sidebar">
        <div class="block clearfix">
            <nav>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url("anasayfa");?>">Anasayfa</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url("urun-listesi");?>">Ürünler</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url("portfolyo-listesi");?>">Portfolyo</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url("egitim-listesi");?>">Eğitimler</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url("iletisim-sayfasi");?>">İletişim</a></li>
                </ul>
            </nav>
        </div>
        <div class="block clearfix">
            <h3 class="title">Son Haberler</h3>
            <div class="separator-2"></div>

            <?php foreach ($other_news as $other_new){ ?>
                <?php if($other_new->news_type == 'image'){ ?>
                    <div class="media margin-clear">
                        <div class="d-flex pr-3">
                            <div class="overlay-container">
                                <img src="<?php echo get_image("news_v",$other_new->img_url,"60x37");?>" alt="">
                                <a class="overlay-link" href="<?php echo base_url("haber-detayi/$other_new->url") ?>"><i class="fa fa-link"></i></a>
                            </div>
                    </div>
                    <div class="media-body">
                        <h6 class="media-heading"><a href="<?php echo base_url("haber-detayi/$other_new->url");?>"><?php echo $other_new->title;?></a></h6>
                        <p class="small margin-clear"><i class="fa fa-calendar pr-10"></i><?php echo get_readable_date($other_new->createdAt);?></p>
                    </div>
                    </div>



                        <?php }else if($other_new->news_type == 'video'){ ?>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="image-box shadow bordered text-center mb-20">
                                    <div class="overlay-container">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $other_new->video_url?>" allowfullscreen></iframe>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><a href="<?php echo base_url("haber-detayi/$other_new->url");?>"><?php echo $other_new->title;?></a></h6>
                                            <p class="small margin-clear"><i class="fa fa-calendar pr-10"></i><?php echo get_readable_date($other_new->createdAt);?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <?php } ?>
                <hr>
            <?php } ?>




            <div class="text-right space-top">
                <a href="<?php echo base_url("haberler-listeleniyor");?>" class="link-dark"><i class="fa fa-plus-circle pl-1 pr-1"></i> Diğer Haberler</a>
            </div>
        </div>
    </div>
</aside>

