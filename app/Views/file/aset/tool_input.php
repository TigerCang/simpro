<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="page-body">
    <?= form_open('', ['class' => 'formfile']) ?>
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= ($alat ? lang('app.bgDetil') : lang('app.bgInput')) ?>">
                    <h5><?= ($alat ? lang('app.detildata') : lang('app.inputdata')) ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <input type="hidden" class="form-control" name="idunik" value="<?= $idunik ?>">
                    <input type="hidden" class="form-control" id="niaktif" name="niaktif" value="<?= (($alat && $alat[0]->is_aktif == '0') ? '1' : '0') ?>">
                    <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan" value="<?= ($alat[0]->perusahaan_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="idwilayah" name="idwilayah" value="<?= ($alat[0]->wilayah_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="iddivisi" name="iddivisi" value="<?= ($alat[0]->divisi_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="idwilayahlama" name="idwilayahlama" value="<?= ($alat[0]->wilayah_id ?? '') ?>">
                    <input type="hidden" class="form-control" name="gambarlama" value="<?= ($alat[0]->gambar ?? 'default.png') ?>">
                    <div class="form-group row">
                        <label for="kode" class="col-sm-1 col-form-label"><?= lang('app.kode') ?></label>
                        <div class="col-sm-4">
                            <input type="text" harusisi <?= (($alat && $alat[0]->is_confirm != '0') ? 'readonly' : '') ?> class="form-control text-uppercase" id="kode" name="kode" maxlength="10" placeholder="<?= lang('app.min10kar') ?>" value="<?= ($alat[0]->kode ?? '') ?>">
                            <div id="error" class="invalid-feedback errkode"></div>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-1 col-form-label"><?= lang('app.deskripsi') ?></label>
                        <div class="col-sm-11">
                            <input type="text" harusisi class="form-control" id="nama" name="nama" placeholder="<?= lang('app.harusisi') ?>" value="<?= ($alat[0]->nama ?? '') ?>">
                            <div id="error" class="invalid-feedback errnama"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                        <div class="col-sm-11">
                            <select id="perusahaan" class="js-example-basic-single" name="perusahaan" <?= (($alat && $alat[0]->is_confirm != '0') ? 'disabled' : '') ?>>
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (($alat && $alat[0]->perusahaan_id == $db->id) ? 'selected' : '') . ($tuser['act_perusahaan'] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['perusahaan']) ? '' : 'disabled') ?>><?= "{$db->kode} => {$db->nama}" ?></option>
                                <?php endforeach ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errperusahaan"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                        <div class="col-sm-4">
                            <select id="wilayah" class="js-example-basic-single" name="wilayah" <?= ($alat && $alat[0]->is_confirm != '0' && $tuser['act_super'] == '0' ? 'disabled' : '') ?>>
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($wilayah as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (($alat && $alat[0]->wilayah_id == $db->id) ? 'selected' : '') . ($tuser['act_wilayah'] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['wilayah']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errwilayah"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                        <div class="col-sm-4">
                            <select id="divisi" class="js-example-basic-single" name="divisi" <?= (($alat && $alat[0]->is_confirm != '0') ? 'disabled' : '') ?>>
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (($alat && $alat[0]->divisi_id == $db->id) ? 'selected' : '') . ($tuser['act_divisi'] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['divisi']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errdivisi"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kbli" class="col-sm-1 col-form-label"><?= lang('app.kbli') ?></label>
                        <div class="col-sm-11">
                            <select id="kbli" class="js-example-data-ajax" name="kbli">
                                <option value=""><?= lang('app.pilihsr') ?></option>
                                <?php if ($kbli1) : ?> <option value="<?= $kbli1[0]->id ?>" selected><?= "{$kbli1[0]->kode} => {$kbli1[0]->nama}" ?></option><?php endif; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errkbli"></div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

        </div>
    </div>
    <div class="row">
        <div class="col-sm-9">

            <div class="card">
                <div class="card-header <?= ($alat ? lang('app.bgDetil') : lang('app.bgInput')) ?>">
                    <h5><?= lang('app.keuangan') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="faktur" class="col-sm-2 col-form-label"><?= lang('app.faktur') ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="faktur" name="faktur" value="<?= ($alat[0]->bukti ?? '') ?>">
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="tglbeli" class="col-sm-1 col-form-label"><?= lang('app.tanggal') ?></label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="tglbeli" name="tglbeli" value="<?= ($alat[0]->tgl_beli ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nibeli" class="col-sm-2 col-form-label"><?= lang('app.akuisisi') ?></label>
                        <div class="col-sm-4">
                            <input type="text" harusisi class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="nibeli" name="nibeli" placeholder="<?= lang('app.harusisi') ?>" value="<?= ($alat[0]->ni_beli ?? '') ?>" onchange="hitungsusut()" />
                            <div id="error" class="invalid-feedback errnibeli"></div>
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="nisewa" class="col-sm-1 col-form-label"><?= lang('app.sewa') ?></label>
                        <div class="col-sm-4">
                            <input type="text" harusisi class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="nisewa" name="nisewa" placeholder="<?= lang('app.harusisi') ?>" value="<?= ($alat[0]->ni_sewa ?? '') ?>">
                            <div id="error" class="invalid-feedback errnisewa"></div>
                        </div>
                    </div>
                </div>
            </div> <!-- Akhir card -->

            <div class="card">
                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="linkpo" class="col-sm-2 col-form-label"><?= lang('app.linkpo') ?></label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="linkpo" name="linkpo" value="<?= ($alat[0]->nolink ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div> <!-- Akhir card -->

        </div>
        <div class="col-sm-3">

            <div class="card">
                <div class="card-header <?= ($alat ? lang('app.bgDetil') : lang('app.bgInput')) ?>">
                    <h5><?= lang('app.gambar') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <img src="/assets/fileimg/alat/<?= ($alat[0]->gambar ?? 'default.png') ?>" class="img-thumbnail img-preview mx-auto my-auto d-block">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="file" class="form-control" id="gambar" name="gambar" onchange="previewImage()" />
                            <div id="error" class="invalid-feedback errgambar"></div>
                        </div>
                    </div>
                </div>
            </div> <!-- Akhir card -->

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= ($alat ? lang('app.bgDetil') : lang('app.bgInput')) ?>">
                    <h5><?= lang('app.data+') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="biaya" class="col-sm-1 col-form-label"><?= lang('app.sumberdaya') ?></label>
                        <div class="col-sm-11">
                            <select id="biaya" class="js-example-data-ajax" name="biaya">
                                <option value=""><?= lang('app.pilihsr') ?></option>
                                <?php if ($biaya1) : ?> <option value="<?= $biaya1[0]->id ?>" selected><?= "{$biaya1[0]->kode} => {$biaya1[0]->nama}" ?></option><?php endif; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errbiaya"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kategori" class="col-sm-1 col-form-label"><?= lang('app.kategori') ?></label>
                        <div class="col-sm-4">
                            <select id="kategori" class="js-example-tokenizer" name="kategori">
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($katalat as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (($alat && $alat[0]->kategori_id == $db->id) ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errkategori"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis" class="col-sm-1 col-form-label"><?= lang('app.jenis') ?></label>
                        <div class="col-sm-4">
                            <select id="jenis" class="js-example-tokenizer" name="jenis">
                                <option value=""><?= lang('app.pilihcr') ?></option>
                                <?php foreach ($tipealat as $db) : ?>
                                    <option value="<?= $db->jenis ?>" <?= (($alat && $alat[0]->jenis == $db->jenis) ? 'selected' : '') ?>><?= $db->jenis ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="merk" class="col-sm-1 col-form-label"><?= lang('app.merk') ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="merk" name="merk" value="<?= ($alat[0]->merk ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                        <div class="col-sm-11">
                            <textarea harusisi class="form-control" rows="3" id="catatan" name="catatan" placeholder="<?= lang('app.harusisi') ?>"><?= ($alat[0]->catatan ?? '') ?></textarea>
                            <div id="error" class="invalid-feedback errcatatan"></div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="card-footer" <?= ($alat && $alat[0]->is_jual == '1' ? 'hidden' : '') ?>>
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn <?= lang('app.btncLampir') . $actcreate ?> tambahlampiran" <?= $btnlam ?>><?= lang('app.btnLampir') ?></button>
                        </div>
                        <div>
                            <button type="reset" class="btn <?= lang('app.btncReset') ?>" <?= $btnhid ?>><?= lang('app.btnReset') ?></button>
                            <button type="button" name="action" value="aktif" class="btn <?= $btnclas2 ?> btnsave" <?= $actaktif ?>><?= $btntext2 ?></button>
                            <button type="button" name="action" value="confirm" class="btn <?= lang('app.btncConfirm') ?> btnsave" <?= $btnsama . $actconf ?>><?= lang('app.btnConfirm') ?></button>
                            <button type="button" name="action" value="save" class="btn <?= $btnclas1 ?> btnsave" <?= $actcreate ?>><?= $btntext1 ?></button>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="col-3">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <span><?= lang("app.upby") . ' : ' . ($alat[0]->upby ?? '') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <span><?= lang("app.confby") . ' : ' . ($alat[0]->coby ?? '') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <span><?= lang("app.acby") . ' : ' . ($alat[0]->akby ?? '') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Akhir card -->

        </div>
    </div>
    </form>
    <div class="row" <?= ($alat ? '' : 'hidden') ?>>
        <div class="col-sm-12">
            <div class="dt-responsive table-responsive tabellampiran"></div>
        </div>
    </div>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    $("#perusahaan").on("change", () => $("#idperusahaan").val($("#perusahaan").val()));
    $("#wilayah").on("change", () => $("#idwilayah").val($("#wilayah").val()));
    $("#divisi").on("change", () => $("#iddivisi").val($("#divisi").val()));

    function datalampiran() {
        var getIDU = "<?= $idunik ?>";
        $.ajax({
            url: "/tool/tablampir",
            data: {
                idunik: getIDU,
                xpilih: 'alat',
            },
            dataType: "json",
            success: function(response) {
                $('.tabellampiran').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        datalampiran();

        $('.tambahlampiran').click(function(e) {
            e.preventDefault();
            var getIDU = "<?= $idunik ?>";
            $.ajax({
                url: "/tool/modallampir",
                data: {
                    idunik: getIDU,
                    xpilih: 'alat',
                },
                dataType: "json",
                success: function(response) {
                    $('.modallampiran').html(response.data).show();
                    $('#modal-lampiran').modal('show')
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
        })

        $("#kbli").select2({
            ajax: {
                url: "/tool/kbli",
                type: "post",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilihan: 'kbli',
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= lang("app.inputminimum") ?>,
        });

        $("#biaya").select2({
            ajax: {
                url: "/tool/biaya",
                type: "post",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: 'sumberdaya',
                        ruas: '0000',
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= lang("app.inputminimum") ?>,
        });

        $('.btnsave').click(function(e) {
            e.preventDefault();
            var form = $('.formfile')[0];
            var formData = new FormData(form);
            var getAction = $(this).val();
            var url = '/tool/save';
            formData.append('postaction', getAction);
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnsave').attr('disabled', 'disabled');
                    $('.btnsave').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnsave').removeAttr('disabled');
                    $('.btnsave').each(function() {
                        var value = $(this).val();
                        if (value === 'aktif') {
                            $(this).html('<?= $btntext2 ?>');
                        } else if (value === 'confirm') {
                            $(this).html('<?= lang("app.btnConfirm") ?>');
                        } else if (value === 'save') {
                            $(this).html('<?= $btntext1 ?>');
                        }
                        $(this).attr('name', 'action');
                    });
                },
                success: function(response) {
                    $('#kode, #nama, #perusahaan, #wilayah, #divisi, #kbli, #nibeli, #nisewa, #biaya, #kategori, #catatan, #gambar').removeClass('is-invalid');
                    $('.errkode, .errnama, .errperusahaan, .errwilayah, .errdivisi, .errkbli, .errnibeli, .errnisewa, .errbiaya, .errkategori, .errcatatan, .errgambar').html('');
                    if (response.error) {
                        handleFieldError('kode', response.error.kode);
                        handleFieldError('nama', response.error.nama);
                        handleFieldError('perusahaan', response.error.perusahaan);
                        handleFieldError('wilayah', response.error.wilayah);
                        handleFieldError('divisi', response.error.divisi);
                        handleFieldError('kbli', response.error.kbli);
                        handleFieldError('nibeli', response.error.nibeli);
                        handleFieldError('nisewa', response.error.nisewa);
                        handleFieldError('biaya', response.error.biaya);
                        handleFieldError('kategori', response.error.kategori);
                        handleFieldError('catatan', response.error.catatan);
                        handleFieldError('gambar', response.error.gambar);
                    } else {
                        window.location.href = response.redirect;
                    }

                    function handleFieldError(field, error) {
                        if (error) {
                            $('#' + field).addClass('is-invalid');
                            $('.err' + field).html(error);
                        } else {
                            $('#' + field).removeClass('is-invalid');
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
            return false;
        })
    });
</script>

<?= $this->endSection() ?>