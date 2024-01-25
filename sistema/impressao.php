<?php

include 'cabecalho.php';            


?>   



<link rel="stylesheet" href="./chosen/chosen.css">

 <script src="./chosen/chosen.jquery.js" type="text/javascript"></script>

  <script src="./chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>



          

<div class="main-container" id="main-container">



    <?php include 'menu.php'; ?>



    <div class="main-content">

        <div class="main-content-inner">

            <div class="breadcrumbs" id="breadcrumbs">

                <ul class="breadcrumb">

                    <li>

                        <i class="ace-icon fa fa-home home-icon"></i>

                        <a href="index.php">Home</a>

                    </li>

                    <li>

                        <i class="ace-icon fa fa-file-o home-icon"></i>

                        <a href="empresa.php">Fazer pedido</a>

                    </li>

                    <li class="active">Fazer pedido - Cadastro</li>

                </ul>

            </div>



            <div class="page-content">

                <div class="row">

                    <div class="col-lg-12">

                        <h1 class="page-header">Impressão</h1>

                    </div>

                </div>



                <div class="row">

                    <div class="col-lg-12">

                        <div class="panel panel-default" style="margin-bottom: 0; border-bottom: 0; border-radius: 0">

                            <div class="panel-heading">

                                <p><strong style="color: #707070;">Dados do Solicitante</strong></p>

                            </div>

                            <div class="panel-body">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="row">                                                      
                                        <p><strong style="color: #707070;">Razão Social</strong><br>
                                        <span>Fulano de tal</span>
                                        </p>
                                    </div>
                                    <div class="row">                                                      
                                        <p><strong style="color: #707070;">Endereço</strong><br>
                                        <span>Endereço, Cidade - Estado</span>
                                        </p>
                                    </div>
                                    <div class="row">                                                      
                                        <p><strong style="color: #707070;">CNPJ</strong><br>
                                        <span>Fulano de tal</span>
                                        </p>
                                    </div>
                                    <div class="row">                                                      
                                        <p><strong style="color: #707070;">Inscrição Estadual</strong><br>
                                        <span>Fulano de tal</span>
                                        </p>
                                    </div>
                                    <div class="row">                                                      
                                        <p><strong style="color: #707070;">Condição de pagamento</strong><br>
                                        <span>Fulano de tal</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">                                                      
                                        <p><strong style="color: #707070;">Email</strong><br>
                                        <span>Fulano de tal</span>
                                        </p>
                                    </div>
                                    <div class="row">                                                      
                                        <p><strong style="color: #707070;">Telefone</strong><br>
                                        <span>15 1 1111 1111</span>
                                        </p>
                                    </div>
                                    <div class="row">                                                      
                                        <p><strong style="color: #707070;">Endereço para entrega</strong><br>
                                        <span>Fulano de tal</span>
                                        </p>
                                    </div>
                                    <div class="row">                                                      
                                        <p><strong style="color: #707070;">Transportadora</strong><br>
                                        <span>Fulano de tal - Telefone</span>
                                        </p>
                                    </div>                                    
                                    <div class="row">                                                      
                                        <p><strong style="color: #707070;">Nome do comprador</strong><br>
                                        <span>Fulano de tal</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            

                                
                            </div>

                        </div>



                        <div class="panel panel-default" style="margin-top: 0; border-radius: 0">

                            <div class="panel-heading" style="margin-top: 0; margin-bottom: 0">

                                <p><strong style="color: #707070;">Dados do Produto</strong></p>

                            </div>

                            <div class="panel-body">
                            <div class="col-md-12">
                                
                                <table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="dynamic-table_info">
                                    <thead>
                                        <tr role="row">
                                            <th  tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" aria-label="Título produto">Título produto</th>                                            
                                            <th  tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" aria-label="Cor">Cor</th>
                                            <th  tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" aria-label="Quantidade">Quantidade</th>
                                            <th  tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" aria-label="Acessórios">Acessórios</th>
                                            <th  tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" aria-label="Valor Unitátio">Valor unitário</th>
                                            <th  tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" aria-label="Valor Total" style="border-right-color: #ddd;">Valor Total</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr class="odd" role="row">
                                            <td>Título do Produto</td>
                                            <td>Cor</td>
                                            <td>Quantidade</td>
                                            <td>Acessórios</td>
                                            <td>Valor Unitário</td>
                                            <td>Valor Total</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>                          
                                
                            </div>

                        </div>

                    </div>

                </div>                        

            </div>

        </div>

    </div>

    <?php include 'rodape.php' ?>