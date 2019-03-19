<?php if(!class_exists('Rain\Tpl')){exit;}?>

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Minha Conta</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">                
            <div class="col-md-3">
                <?php require $this->checkTemplate("profile-menu");?>

            </div>
            <div class="col-md-9">
                
                <div class="cart-collaterals">
                    <h2>Meus Pedidos</h2>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Valor Total</th>
                            <th>Status</th>
                            <th>Endereço</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter1=-1;  if( isset($orders) && ( is_array($orders) || $orders instanceof Traversable ) && sizeof($orders) ) foreach( $orders as $key1 => $value1 ){ $counter1++; ?>

                        <tr>
                            <th scope="row"><?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                            <td>R$<?php echo formatPrice($value1["vltotal"]); ?></td>
                            <td><?php echo htmlspecialchars( $value1["desstatus"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                            <td><?php echo htmlspecialchars( $value1["desaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>, <?php echo htmlspecialchars( $value1["desdistrict"], ENT_COMPAT, 'UTF-8', FALSE ); ?>, <?php echo htmlspecialchars( $value1["descity"], ENT_COMPAT, 'UTF-8', FALSE ); ?> - , <?php echo htmlspecialchars( $value1["desstate"], ENT_COMPAT, 'UTF-8', FALSE ); ?> CEP: <?php echo htmlspecialchars( $value1["deszipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                            <td style="width:222px;">
                                <a class="btn btn-success" href="/order/<?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" role="button">Imprimir Boleto</a>
                                <a class="btn btn-default" href="/profile/orders/<?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" role="button">Detalhes</a>
                            </td>
                        </tr>
                        <?php }else{ ?>

                        <div class="alert alert-info">
                            Nenhum pedido foi encontrado.
                        </div>
                        <?php } ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>