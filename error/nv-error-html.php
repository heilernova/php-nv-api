<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Errores del sistema</title>
</head>
<style>
    .lista-errores{
      list-style: none; padding: 0; 
    }
    .lista-errores li{
        margin: 10px 0; box-shadow: 1px 1px 1px 1px black; padding: 5px 20px;
    }
</style>
<body>
    <h1>Errores del sitema</h1>

    <ul class="lista-errores">
        <?php foreach ($list_errors as $item){ ?>

        <li>
            <h4>Información de registro</h4>
            <div>
                <span>Fecha:</span>
                <span><?php echo $item['information']['date'] ?></span>
            </div>
            <h4>Informacion del cliente</h4>
            <div>
                <span>ip:</span><span><?php echo $item['clientInformation']['ip']  ?></span>
            </div>
            <div>
                <span>Dispositivo:</span><span><?php echo $item['clientInformation']['ip'];  ?></span>
            </div>

            <h4>HTTP</h4>
            <div>
                <span>url:</span>
                <span>
                    <?php echo $item['http']['httpUrl']; ?>
                </span>
            </div>
            <div>
                <span>Metodo:</span>
                <span>
                    <?php echo $item['http']['httpRequestMethod']; ?>
                </span>
            </div>

            <!-- Mensajes dels sitema -->
            <h4>Mensajes</h4>
            <div>
                <?php foreach ($item['messages'] as $ms) {?>
                    <?php if (is_array($ms)){ ?>
                        <ul>
                            <?php foreach($ms as $ms_item){ ?>
                                <div><?php echo $ms_item ?></div>
                            <?php } ?>
                        </ul>
                    <?php }else{ ?>
                        <div><?php echo $ms ?></div>
                    <?php } ?>
                <?php } ?>
            </div>

            <h4>Error</h4>
            <div>
                <?php echo $item['throwable'] ?>
            </div>
            <br>
            <button>Eliminar</button>
        </li>

        <?php } ?>
    </ul>
</body>
</html>