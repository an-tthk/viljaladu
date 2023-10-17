<?php
    global $yhendus;

    $kask = $yhendus->prepare("SELECT id, autonr, sisenemismass, lahkumismass FROM koormad");
    $kask->bind_result($id, $autonr_, $sisenemismass, $lahkumismass);
    $kask->execute();

    $autod = array();

    while ($kask->fetch()) {
        $auto = new stdClass();
        $auto->id = $id;
        $auto->autonr = htmlspecialchars($autonr_);
        $auto->sisenemismass = $sisenemismass;
        $auto->lahkumismass = $lahkumismass;

        array_push($autod, $auto);
    }
?>

<h2 class="row g-3 mt-1 col-mb-3">Viljaladu</h2>

<!-- Buttons trigger modal -->
<div class="row g-3 my-5 col-sm-3">
    <div class="col col-auto mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#lisa-auto-modal">
            Lisa auto
        </button>
    </div>
</div>

<form method="post" action="">
    <table class="table table-striped table-hover table-responsive">
        <tr>
            <th>Auto nr.</th>
            <th>Sisenemismass</th>
            <th>Väljumismass</th>
            <th></th>
        </tr>
        <?php foreach($autod as &$auto): ?>
            <?php $modal_name = "auto". $auto->id; ?>
            <tr>
                <td><a href="#<?php echo $modal_name; ?>-modal" data-bs-toggle="modal" data-bs-target="#<?php echo $modal_name; ?>-modal"><?= $auto->autonr ?></a></td>
                <td><?= $auto->sisenemismass ?></td>
                <td><?= $auto->lahkumismass ?></td>
                <td><a href="#lisa-mass-modal" data-bs-toggle="modal" data-bs-target="#lisa-mass-modal" data-bs-auto_id="<?= $auto->id ?>">Lisa väljumismass</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</form>

<!-- Modals -->
<form class="row g-3 col-sm-3" method="post" action="">
    <div class="modal fade" id="lisa-auto-modal" tabindex="-1" aria-labelledby="lisa-auto-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="lisa-auto-modal-label">Auto lisamine</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dl>
                        <dd>
                            <div class="input-group col">
                                <span class="input-group-text">Auto number (eg. 789ZXC)</span>
                                <input class="form-control" type="text" maxlength="6" name="autonr" aria-label="Auto number" />
                            </div>
                        </dd>
                        <dd>
                            <div class="input-group col">
                                <span class="input-group-text">Sisenemismass</span>
                                <input class="form-control" type="number" name="sisenemismass" aria-label="Sisenemismass" />
                            </div>
                        </dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="autolisamine">Lisa</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="lisa-mass-modal" tabindex="-1" aria-labelledby="lisa-mass-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="lisa-mass-modal-label">Väljumismass lisamine</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group col">
                        <input type="hidden" id="auto_id" name="auto_id" />
                        <span class="input-group-text">Väljumismass</span>
                        <input class="form-control" type="number" name="valjumismass" aria-label="Väljumismass" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="masslisamine">Lisa</button>
                </div>
            </div>
        </div>
    </div>
</form>

<?php foreach($autod as &$auto): ?>
    <?php $modal_name = "auto". $auto->id; ?>
    <div class="modal fade" id="<?php echo $modal_name; ?>-modal" tabindex="-1" aria-labelledby="<?php echo $modal_name; ?>-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="<?php echo $modal_name; ?>-modal-label">Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                        $r = array_filter($autod, function($elem) use($auto) {
                            return $elem->autonr == $auto->autonr;
                        });
                    ?>
                    <div class="row">
                        Kokku reisid: <?php echo count($r); ?>
                    </div>
                    <div class="row">
                        Kokku sisenemismass: <?php echo array_sum(array_column($r, 'sisenemismass')); ?>
                    </div>
                    <div class="row">
                        Kokku väljumismass: <?php echo array_sum(array_column($r, 'lahkumismass')); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    const lisaMassMadal = document.querySelector('#lisa-mass-modal');
    lisaMassMadal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const auto_id = button.getAttribute('data-bs-auto_id');

        document.getElementById('auto_id').value = auto_id;
    });
</script>
