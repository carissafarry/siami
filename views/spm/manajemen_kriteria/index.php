<?php
/**
 * @var $this \app\includes\View
 * @var $standars array \app\admin\models\Standar
 * @var $kriterias array \app\admin\models\Kriteria
 * @var $tahun string
 * @var $ami_years array \app\admin\models\Ami tahun
 */

use app\includes\App;

$this->title = 'Manajemen Kriteria | Index';
$this->breadcrumbs = 'Manajemen Kriteria';
$this->header_title = $this->breadcrumbs;
?>

<div class="row mb-4">
    <div class="col-lg-2 col-sm-2 col-md-2">
        <select class="form-select" name="tahun" id="tahun" style="outline: none;" onchange="window.location = this.value;">
            <?php foreach ($ami_years as $year): ?>
                <option value="<?= APP_PATH ?>/spm/manajemen-kriteria/<?= $year ?>" <?= ($year == $tahun) ? 'selected' : ''?>><?= $year ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-sm-6 col-4">
                        <h6>Data Kriteria</h6>
                    </div>
                    <div class="col-sm-6 col-8">
                        <a href="<?= APP_PATH ?>/spm/manajemen-kriteria/k/add" type="button" class="btn btn-md bg-gradient-default" style="float: right; margin-left: 1rem;"><i class="fas fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2 p-0 m-3">
                <div class="table-responsive">
                    <table id="TABLE_1" class="display table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                No
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Kode Standar
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Kode Kriteria
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Kriteria
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Catatan
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Keterangan Nilai
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Aksi
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $no = 1;
                            foreach ($kriterias as $kriteria):
                        ?>
                            <tr class="text-sm">
                                <td class="center-table"> <?= $no ?> </td>
                                <td class="center-table"> <?= $kriteria->standar()->kode ?> </td>
                                <td class="center-table"> <?= $kriteria->kode ?> </td>
                                <td class="center-table" style="white-space: pre-wrap; column-span: 1rem;"><?= html_entity_decode($kriteria->kriteria) ?> </td>
                                <td class="center-table" style="white-space: pre-wrap; column-span: 1rem;"><?= html_entity_decode($kriteria->catatan) ?> </td>
                                <td class="center-table" style="white-space: pre-wrap; column-span: 1rem;"><?= html_entity_decode($kriteria->ket_nilai) ?> </td>
                                <td class="center-table align-content-center">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li class="inline-icon"><a href="<?= APP_PATH ?>/spm/manajemen-kriteria/k/detail/<?= $kriteria->id ?>"><i class="fas fa-info-circle"></i></a></li>
                                        <li class="inline-icon"><a href="<?= APP_PATH ?>/spm/manajemen-kriteria/k/update/<?= $kriteria->id ?>"><i class="fas fa-pen"></i></a></li>
                                        <li class="inline-icon">
                                            <form method="post" action="<?= APP_PATH ?>/spm/manajemen-kriteria/k/delete/<?= $kriteria->id ?>" class="inline">
                                                <input type="hidden" name="delete_<?= $kriteria->id ?>" value="<?= $kriteria->id ?>">
                                                <button type="submit" class="btn-sm bg-transparent border-0 p-0">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        <?php
                            $no++;
                            endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-sm-6 col-4">
                        <h6>Data Standar</h6>
                    </div>
                    <div class="col-sm-6 col-8">
                        <a href="<?= APP_PATH ?>/spm/manajemen-kriteria/s/add" type="button" class="btn btn-md bg-gradient-default" style="float: right; margin-left: 1rem;"><i class="fas fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2 p-0 m-3">
                <div class="table-responsive">
                    <table id="TABLE_2" class="display table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                No
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Standar
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Kode
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Tahun
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Aksi
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $no = 1;
                            foreach ($standars as $standar):
                        ?>
                            <tr class="text-sm">
                                <td class="center-table"> <?= $no ?> </td>
                                <td class="center-table"> <?= $standar->standar ?> </td>
                                <td class="center-table" style="white-space: pre-wrap; column-span: 1rem;"><?= $standar->kode ?></td>
                                <td class="center-table" style="white-space: pre-wrap; column-span: 1rem;"><?= $standar->tahun ?></td>
                                <td class="center-table align-content-center">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li class="inline-icon"><a href="<?= APP_PATH ?>/spm/manajemen-kriteria/s/detail/<?= $standar->id ?>"><i class="fas fa-info-circle"></i></a></li>
                                        <li class="inline-icon"><a href="<?= APP_PATH ?>/spm/manajemen-kriteria/s/update/<?= $standar->id ?>"><i class="fas fa-pen"></i></a></li>
                                        <li class="inline-icon">
                                            <form method="post" action="<?= APP_PATH ?>/spm/manajemen-kriteria/s/delete/<?= $standar->id ?>" class="inline">
                                                <input type="hidden" name="delete_<?= $standar->id ?>" value="<?= $standar->id ?>">
                                                <button type="submit" class="btn-sm bg-transparent border-0 p-0">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        <?php
                            $no++;
                            endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function submitYear() {
        var form = $('#form_tahun');
        form.submit();
    }

    // ! Unused function
    function setStandarData(obj) {
        var tahun = $(obj).val();
        var app_path = <?= json_encode(APP_PATH) ?>;
        var url = app_path + '/spm/manajemen-kriteria/update-standar-data';

        $.post(url, {
            tahun: tahun,
        })
        .done(function(jqXHR) {
            $('#TABLE_2').DataTable({
                destroy: true,
                data: jqXHR.standars,
                columns: [
                    { data: 'standar'},
                    { data: 'kode'},
                    { data: 'tahun'},

                ]
            });
            console.log(jqXHR.standars);
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log(arguments);
        });
    }
</script>