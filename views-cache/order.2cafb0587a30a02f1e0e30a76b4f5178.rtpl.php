<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pedido N°<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/orders">Pedidos</a></li>
            <li class="active"><a href="/admin/orders/<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">Pedido N°<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
        </ol>
    </section>

    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <img src="/res/site/img/logo.png" alt="Logo">
                    <small class="pull-right">Date: <?php echo date('d/m/Y'); ?></small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                De
                <address>
                    <strong>HCODE</strong><br>
                    Rua Ademar Saraiva Leão, 234 - Alvarenga<br>
                    São Bernardo do Campo - SP<br>
                    Telefone: (11) 3171-3080<br>
                    E-mail: suporte@hcode.com.br
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                Para
                <address>
                    <strong><?php echo htmlspecialchars( $order["desperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?></strong><br>
                    <?php echo htmlspecialchars( $order["desaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>, <?php echo htmlspecialchars( $order["descomplement"], ENT_COMPAT, 'UTF-8', FALSE ); ?><br>
                    <?php echo htmlspecialchars( $order["descity"], ENT_COMPAT, 'UTF-8', FALSE ); ?> - <?php echo htmlspecialchars( $order["desstate"], ENT_COMPAT, 'UTF-8', FALSE ); ?><br>
                    <?php if( $order["nrphone"] && $order["nrphone"]!='0' ){ ?>Telefone: <?php echo htmlspecialchars( $order["nrphone"], ENT_COMPAT, 'UTF-8', FALSE ); ?><br><?php } ?>
                    E-mail: <?php echo htmlspecialchars( $order["desemail"], ENT_COMPAT, 'UTF-8', FALSE ); ?>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Pedido #<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></b><br>
                <br>
                <b>Emitido em:</b> <?php echo formatDate($order["dtregister"]); ?><br>
                <b>Pago em:</b> <?php echo formatDate($order["dtregister"]); ?>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Qtd</th>
                            <th>Produto</th>
                            <th>Código #</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
                        <tr>
                            <td><?php echo htmlspecialchars( $value1["nrqtd"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                            <td><?php echo htmlspecialchars( $value1["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                            <td><?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                            <td>R$<?php echo formatPrice($order["vltotal"]); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">

                <p class="lead">Forma de Pagamento</p>
                
                <table class="table">
                    <tbody>
                        <tr>
                            <th style="width:180px;">Método de Pagamento:</th>
                            <td>Boleto</td>
                        </tr>
                        <tr>
                            <th>Parcelas:</th>
                            <td>1x</td>
                        </tr>
                    <!--
                    <tr>
                        <th>Valor da Parcela:</th>
                        <td>R$100,00</td>
                    </tr>
                -->
            </tbody>
        </table>

    </div>
    <!-- /.col -->
    <div class="col-xs-6">
        <p class="lead">Resumo do Pedido</p>

        <div class="table-responsive">
            <table class="table">
                <tbody><tr>
                    <th style="width:50%">Subtotal:</th>
                    <td>R$<?php echo formatPrice($cart["vlsubtotal"]); ?></td>
                </tr>
                <tr>
                    <th>Frete:</th>
                    <td>R$<?php echo formatPrice($cart["vlfreight"]); ?></td>
                </tr>
                <tr>
                    <th>Total:</th>
                    <td>R$<?php echo formatPrice($cart["vltotal"]); ?></td>
                </tr>
            </tbody></table>
        </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<!-- this row will not appear when printing -->
<div class="row no-print">
    <div class="col-xs-12">
        <button type="button" onclick="window.location.href = '/admin/orders/<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/status'" class="btn btn-default pull-left" style="margin-left: 5px;">
            <i class="fa fa-pencil"></i> Editar Status
        </button>
        <button type="button" onclick="window.open('/boleto/<?php echo htmlspecialchars( $order["idstatus"], ENT_COMPAT, 'UTF-8', FALSE ); ?>')" class="btn btn-default pull-left" style="margin-left: 5px;">
         <i class="fa fa-barcode"></i> Boleto
     </button>


     <button type="button" onclick="window.print()" class="btn btn-primary pull-right" style="margin-right: 5px;">
        <i class="fa fa-print"></i> Imprimir
    </button>
</div>
</div>
</section>

<div class="clearfix"></div>

</div>
<!-- /.content-wrapper -->