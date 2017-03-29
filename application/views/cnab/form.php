<div class="container">

    <?php echo form_open_multipart('cnab/controll', 'class="form_cnab" onsubmit="overlay(true);"'); ?>
    <fieldset>
        <legend>Defina os parâmetros para gerar o CNAB</legend>
        <div class="row">
            <div class="col-md-5 center">
                <div class="form-group">
                    <label for="empresa_cnab" class="control-label">Empresa</label>
                    <select name="<?php echo Model_Processo::EMPRESA; ?>" id="empresa_cnab" class="form-control" required>
                        <option value="">Defina a Empresa</option>
                        <?php foreach ($empresa as $row): ?>
                            <option value="<?php echo strtoupper($row[Model_Empresa::ID]) ?>"><?php echo $row[Model_Empresa::COLIGADA], ' - ', $row[Model_Empresa::NOME] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tipo_operacao" class="control-label">Tipo de Pagamento</label>
                    <select name="<?php echo Model_Processo::OPERACAO; ?>" id="tipo_operacao" class="form-control" required>
                        <option value="">Defina o Tipo de Pagamento</option>
                        <?php foreach ($tipo_operacao as $row): ?>
                            <option value="<?php echo $row[Model_Tipo_Operacao::ID] ?>"><?php echo $row[Model_Tipo_Operacao::NOME] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="competencia" class="control-label">Competência</label>
                    <input type="month" name="competencia" id="competencia" class="form-control" required maxlength="4" />
                </div>

                <div class="form-group">
                    <label for="data_pagto" class="control-label">Data Prevista de Pagamento</label>
                    <input type="date" name="<?php echo Model_Processo::DATAPAG; ?>" id="data_pagto" class="form-control" required />
                </div>
            </div>
            <div class="col-md-5 center col-md-offset-2">

                <div class="form-group">
                    <label for="gerar1" class="control-label">O que deseja fazer?</label>
                    <br />
                    <ul class="list-group">
                        <li class="list-group-item">
                            <label class="radio-inline">
                                <input type="radio" name="gerar" id="gerar1" value="cnab" checked />
                                Gerar novo CNAB
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gerar" id="gerar2" value="xls" />
                                Ler CNAB
                            </label>
                        </li>
                        <li class="list-group-item">
                            <label class="radio-inline">
                                <input type="radio" name="forma_pagto" id="forma_pagto1" value="01" checked />
                                Crédito Conta Corrente
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="forma_pagto" id="forma_pagto2" value="10" />
                                OP à Disposição
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="form-group hidden">
                    <label for="empresa_cnab" class="control-label">Banco</label>
                    <select name="<?php echo Model_Processo::BANCO; ?>" id="banco_cnab" class="form-control">
                        <option value="">Defina o Banco para o OP</option>
                        <?php foreach ($banco as $row): ?>
                            <option value="<?php echo strtoupper($row[Model_Banco::ID]) ?>"><?php echo $row[Model_Banco::NOME], ' - ', $row[Model_Empresa::NOME] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nome_arquivo" class="control-label">Nome do Arquivo</label>
                    <input type="text" name="nome_arquivo" id="nome_arquivo" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="xls" class="control-label">Enviar Arquivo</label>
                    <input type="file" name="xls" id="xls" class="form-control" required />
                </div>
            </div>
        </div>
        <div class="col-md-1 center col-md-offset-11">
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Processar</button>
            </div>
        </div>
    </fieldset>
</form>

</div> <!-- /container -->