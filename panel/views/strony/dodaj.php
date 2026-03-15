<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>?cmd=dodaj_strone" class="col-md-6">
    <div class="input-group mb-3">
        <input type="text" name="name" size="50" placeholder="Tytuł podstrony" class="form-control" required>
        <input type="submit" name="dodaj_str" value="Dodaj nową podstronę" class="btn btn-dark">
    </div>
</form>
