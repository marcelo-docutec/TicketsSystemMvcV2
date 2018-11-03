<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href=" <?= VIEW_URL ?> ">TICKET SYSTEM</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <?php if ( $this->isLogged()) {?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $this->getToken()->getUsername(); ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#">TICKETS</a>
          <a class="dropdown-item" href="#">ARTISTAS</a>
          <a class="dropdown-item" href="#">CREAR ARTISTA</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= VIEW_URL ?>/user/logout/">SALIR</a>
      </li>
      <?php }else {?>
      <li class="nav-item">
        <a class="nav-link" href="<?= VIEW_URL ?>/default/login/">LOGIN</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= VIEW_URL ?>/default/register/">REGISTER</a>
      </li>
      <?php } ?>

      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown link
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> -->
    </ul>
  </div>
</nav>


<?php if(isset($notifiaciones)) { ?>
  <!-- Modal -->

  <div class="modal fade" id="notiModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">NOTIFICACIONES</h4>
        </div>
        <div class="modal-body">
          <?php foreach($notifiaciones as $notificacion){ ?>
            <table class="table">
              <thead>
                <tr>
                  <th>
                    MENSAJE
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-chico">
                    <?= $notificacion->getMensaje() ?>
                  </td>
                </tr>
              </tbody>
            </table>
            <form method="post" action="/notificacion/eliminar">
              <input type="hidden" name="id" value=<?= $notificacion->getId() ?>>
              <button type="submit" style="border-color: black" class="btn btn-danger">ELIMINAR NOTIFICACION</button>
            </form>
          <?php } ?>

        </div>
        <div class="modal-footer">

          <button type="button" style="border-color: black" class="btn btn-success" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>