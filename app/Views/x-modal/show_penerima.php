<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMdetil'); ?>">
                <h4 class="modal-title"><?= lang('app.detil'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-block">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><?= lang('app.kode'); ?></label>
                                <label class="col-sm-4 col-form-label">: <?= ($penerima[0]->kode ?? '') ?></label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><?= lang('app.deskripsi'); ?></label>
                                <label class="col-sm-10 col-form-label">: <?= ($penerima[0]->nama ?? '') ?></label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><?= lang('app.kategori'); ?></label>
                                <label class="col-sm-4 col-form-label">: <?= ($penerima[0]->kategori ?? '') ?></label>
                                <div class="col-sm-1"></div>
                                <label class="col-sm-2 col-form-label"><?= lang('app.rating'); ?></label>
                                <div class="col-sm-1 text-right">
                                    <div class="stars stars-example-fontawesome-o">
                                        <?= "<select id='example-fontawesome-o' name='rating'>";
                                        echo "<option value='' label='0'></option>";
                                        for ($i = 1; $i <= 5; $i++) {
                                            echo "<option value='{$i}'" . ((old('example-fontawesome-o') == $i) || ($penerima && $penerima[0]->rating == $i) ? 'selected' : '') . ">{$i}</option>";
                                        };
                                        echo "</select>"; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><?= lang('app.kontak'); ?></label>
                                <label class="col-sm-10 col-form-label">: <?= ($penerima[0]->kontak ?? '') ?></label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><?= lang('app.alamat'); ?></label>
                                <label class="col-sm-4 col-form-label">: <?= ($penerima[0]->alamat ?? '') ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript" src="<?= base_url('libraries') ?>/assets/js/rating.js"></script>