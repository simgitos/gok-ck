<form action="user.php?cmd=update" method="post" enctype="multipart/form-data" class="col-md-8">

    <div class="mb-3">
        <label>Login</label>
        <input type="text" name="login" value="<?= $_SESSION['login_strona'] ?>" readonly="readonly" class="form-control" />
    </div>
    <div class="mb-3">
        <label>Hasło</label>
        <input type="password" name="haslo" value="" class="form-control" required/>
    </div>
    <div class="mb-3">
        <label>powtórz hasło</label>
        <input type="password" name="haslo2" value="" class="form-control" required/>
    </div>

    <input type="submit" value="Zmień hasło" class="btn btn-dark" />

</form>