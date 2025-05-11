<?php

include_once "cp_head.php";
include_once "cp_navbar.php"; ?>


<!-- Form -->
<div class="mt-5 container">
    <div class='mb-5'><a class='btn btn-info' onclick='history.back()'> Voltar</a></div>
    <h3 class="ps-2">Insere as informações da nova escola</h3>
    <div class="d-flex  justify-content-center">
        <form class="col-12" action="admin_scripts/sc_inserir_escola.php" method="post" class="was-validated">
            <div class="mb-3 mt-3">
                <label for="titulo" class="form-label">Nome:*</label>
                <input type="text" class="form-control" id="titulo" value="" name="titulo" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>

            <div class="mb-3 mt-5 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-lg w-25">Inserir</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
