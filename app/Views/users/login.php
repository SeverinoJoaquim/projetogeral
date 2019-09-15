<?php 
	$this->extend('layouts/layout_users');
?>

<?php $this->section('conteudo') ?>

    <div class="row mt-3 mb-3">
        <div class="col-4 offset-4 card bg-light">            

            <form action="<?php echo site_url('users/login')?>" method="post">
                <div class="form-group mt-2">
                    <input type="text" name="text_username" class="form-control" placeholder="username">
                </div>
                <div class="form-group">
                    <input type="password" name="text_password" class="form-control" placeholder="password">
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <small><a href="<?php echo site_url('users/recover') ?>">Esqueci-me a senha</a></small>
                    </div>
                    <div class="form-group col-6 text-right">
                    <input type="submit" value="Logar" class="btn btn-primary">
                    </div>
                </div>
            </form>
            <?php if(isset($error)): ?>
                <div class="alert alert-danger text-center mt-2" id="error-message">
                    <?php echo $error ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $this->endsection() ?>
