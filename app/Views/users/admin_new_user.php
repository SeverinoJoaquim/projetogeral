<?php
$this->extend('layouts/layout_users');
$s = session();
?>
<?php $this->section('conteudo') ?>

<!-- Erro -->
<?php if (isset($error)) : ?>
  <div class="alert alert-danger">
    <?php echo $error ?>
  </div>
<?php endif; ?>

<!-- Formulário para novo utilizador -->
<form action="">
  <h2>Adicionar novo usuário</h2>
  <p><input type="text" name="text_username" placeholder="Username" required></p>
  <p><input type="text" name="text_password" placeholder="Password" required></p>
  <p><input type="text" name="text_password_repetir" placeholder="Repetir password" required></p>

  <button id="btn-password" class="btn btn-primary btn-sm" type="button">Gerar password</button>

  <p><input type="text" name="text_name" placeholder="Name" required></p>
  <p><input type="email" name="text_email" placeholder="E-mail" required></p>

  <!-- Profile -->
  <p>Profile</p>
  <label><input type="checkbox" name="text_admin">Admin</label><br>
  <label><input type="checkbox" name="text_moderator">Moderator</label><br>
  <label><input type="checkbox" name="text_user">User</label><br>

  <div>
    <a href="<?php echo site_url('users/admin_users') ?>" class="btn btn-secondary">Cancelar</a>
    <button class="btn btn-primary">Salvar</button>
  </div>
</form>

<?php $this->endsection() ?>