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

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#lisa-mass-modal">
            Lisa väljumismass
        </button>
    </div>
</div>

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
                    <dl>
                        <dd>
                            <div class="input-group col">
                                <span class="input-group-text">Auto</span>
                                <select name="auto_id" class="form-select col-md-3">
                                    <?php
                                        foreach ($autod as &$auto) {
                                            echo "<option value='$auto->id'>$auto->autonr</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </dd>
                        <dd>
                            <div class="input-group col">
                                <span class="input-group-text">Väljumismass</span>
                                <input class="form-control" type="number" name="valjumismass" aria-label="Väljumismass" />
                            </div>
                        </dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="masslisamine">Lisa</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form method="post" action="">
    <table class="table table-striped table-hover table-responsive">
        <tr>
            <th>Auto nr.</th>
            <th>Sisenemismass</th>
            <th>Väljumismass</th>
        </tr>
        <?php foreach($autod as &$auto): ?>
            <tr>
                <td><?= $auto->autonr ?></td>
                <td><?= $auto->sisenemismass ?></td>
                <td><?= $auto->lahkumismass ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</form>