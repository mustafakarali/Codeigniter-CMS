<div class="row">

    <div class="col-md-12">
        <div class="widget">
            <header class="widget-header">
                <h4 class="widget-title">
                    Portfolyo Kategoriler Listesi
                    <a href="<?php echo base_url("portfolio_categories/new_portfolio_category"); ?>" class="btn btn-info pull-right btn-xs"><i class="fa fa-plus"></i> Yeni Ekle </a>
                </h4>
            </header><!-- .widget-header -->
            <hr class="widget-separator">


            <div class="widget-body">
                <?php if (empty($items)) { ?>
                <div class="alert alert-info alert-dismissible text-center">
                    <p>Burada herhangi bir kayıt bulunamadı. Eklemek için lütfen <a href="<?php echo base_url("portfolio_categories/new_portfolio_category"); ?>">tıklayınız.</a></p>
                </div>
                        <?php } else { ?>
                <div class="table-responsive content-container">
                    <table class="table table-bordered table-hover table-condensed">
                        <thead class="text-secondary bg-inverse">
                        <tr>
                            <th>#id</th>
                            <th>Başlık</th>
                            <th>Durum</th>
                            <th>İşlem</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">

                        <?php foreach ($items as $item){ ?>
                        <tr>
                            <td class="w50 text-center">#<?php echo $item->id; ?></td>
                            <td><?php echo $item->title; ?></td>
                            <td class="w100">
                                <input
                                        data-url = "<?php echo base_url("portfolio_categories/isActiveSetter/$item->id"); ?>";
                                        type="checkbox"
                                        class="isActive"
                                        data-switchery="true"
                                        data-color="#10c469"
                                        <?php echo ($item->isActive) ? "checked": ""  ?>
                                >
                            </td>
                            <td class="w150">
                                <button
                                        data-url="<?php echo base_url("portfolio_categories/delete/$item->id")?>"
                                        class="btn btn-danger mw-xs remove-btn">
                                        <i class="fa fa-trash-o"></i></button>
                                <a href="<?php echo base_url("portfolio_categories/update_portfolio_category/$item->id"); ?>" class="btn btn-info mw-xs"><i class="fa fa-pencil-square-o"></i></a>
                            </td>
                        </tr>

                        <?php } ?>

                        </tbody>
                    </table>
                </div>

                    <?php   } ?>

            </div><!-- .widget-body -->
        </div><!-- .widget -->
    </div><!-- END column -->

</div>