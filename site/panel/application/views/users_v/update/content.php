<div class="row">

<div class="col-md-12">
    <div class="widget">
        <header class="widget-header">
            <h4 class="widget-title">
                <?php echo $item->user_name;?> Kayıtlı Kullanıcı Güncelleniyor
            </h4>
        </header><!-- .widget-header -->
        <hr class="widget-separator">

        <div class="widget-body">
            <form action="<?php echo base_url("users/update/$item->id"); ?>" method="post">
                <div class="form-group">
                    <label >Kullanıcı Adı</label>
                    <input type="text" class="form-control" value="<?php echo isset($form_error) ? set_value("user_name") : $item->user_name; ?>"  placeholder="Kullanıcı Adı" name="user_name">
                    <?php if(isset($form_error)){ ?>
                        <small class="pull-right input-form-error"><?php echo form_error( "user_name");?></small>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label >Ad Soyad</label>
                    <input type="text" class="form-control" value="<?php echo isset($form_error) ? set_value("full_name") : $item->full_name; ?>"  placeholder="Ad Soyad" name="full_name">
                    <?php if(isset($form_error)){ ?>
                        <small class="pull-right input-form-error"><?php echo form_error( "full_name");?></small>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label >E-Posta Adresi</label>
                    <input type="email" class="form-control" value="<?php echo isset($form_error) ? set_value("email") : $item->email; ?>"  placeholder="E-Posta Adresi" name="email">
                    <?php if(isset($form_error)){ ?>
                        <small class="pull-right input-form-error"><?php echo form_error( "email");?></small>
                    <?php } ?>
                </div>

                <button type="submit" class="btn btn-primary btn-md btn-outline"><i class="fa fa-save"></i> Güncelle</button>
                <a href="<?php echo base_url("users"); ?>" class="btn btn-danger btn-md"><i class="fa fa-close"></i> İptal</a>
            </form>
        </div><!-- .widget-body -->
    </div><!-- .widget -->
</div><!-- END column -->

</div>