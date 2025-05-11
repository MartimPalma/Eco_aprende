


        <!-- Form -->
        <div class="mt-5 container">
            <div class='mb-5'><a class='btn btn-info' onclick='history.back()'> Voltar</a></div>
            <h3 class="ps-2">Insere as informações do novo módulo</h3>
            <div class="d-flex  justify-content-center">



                <form class="col-12" action="../backoffice/admin_scripts/sc_inserir_modulo.php" method="post" enctype="multipart/form-data" class="was-validated">
                    <div class="mb-3 mt-3">
                        <label for="titulo" class="form-label">Título:*</label>
                        <input type="text" class="form-control" id="titulo" value="" name="titulo" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="capa" class="form-label">Capa:*</label>
                        <input type="file" class="form-control" id="capa" value="" name="capa" >
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="video" class="form-label">Vídeo:*</label>
                        <input type="file" class="form-control" id="video" value="" name="video" >
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="codigo" class="form-label">Codigo de acessso:*</label>
                        <input type="text" class="form-control" id="codigo" value="" name="codigo" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-4">
                        <label for="intro" class="form-label">Intro:*</label>
                        <textarea class="form-control" id="intro" value="" name="intro" rows="5" required></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="mb-3 mt-4">
                        <label for="sabias_que" class="form-label">Sabias que:*</label>
                        <textarea class="form-control" id="sabias_que" value="" name="sabias_que" rows="5" required></textarea>
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

